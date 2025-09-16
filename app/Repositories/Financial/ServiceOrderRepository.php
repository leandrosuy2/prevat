<?php

namespace App\Repositories\Financial;

use App\Exports\ServiceOrderParticipants;
use App\Models\PaymentMethod;
use App\Models\ScheduleCompanyParticipants;
use App\Models\ServiceOrder;
use App\Models\ServiceOrdersItems;
use App\Notifications\SendOSClientNotification;
use App\Requests\PaymentMethodRequest;
use App\Requests\ServiceOrderRequest;
use App\Services\ReferenceService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use PHPUnit\Exception;

class ServiceOrderRepository
{
    public function index($orderBy = null, $filterData = null, $pageSize = null)
    {
        try {
            $serviceOrderDB = ServiceOrder::query()->with(['company', 'contract', 'status', 'user']);

            $serviceOrderDB->withoutGlobalScopes();

            if(isset($filterData['search']) && $filterData['search'] != null) {
                $serviceOrderDB->whereHas('company', function($query) use ($filterData) {
                    $query->withoutGlobalScopes()->where('name', 'LIKE', '%'.$filterData['search'].'%');
                    $query->withoutGlobalScopes()->orWhere('reference', 'LIKE', '%'.$filterData['search'].'%');
                });
            }

            if(isset($filterData['status_id']) && $filterData['status_id'] != null) {
                $serviceOrderDB->where('status_id', $filterData['status_id']);
            }

            if(isset($filterData['dates']) && $filterData['dates'] != null) {
                $dates = explode(' to ', $filterData['dates']);
                if(isset($dates[1])) {
                    $serviceOrderDB->whereBetween('due_date', [$dates[0], $dates[1]]);
                } else {
                    $serviceOrderDB->where('due_date', '=', $dates[0]);
                }
            }

            if($orderBy) {
                $serviceOrderDB->orderBy($orderBy['column'], $orderBy['order']);
            }

            if($pageSize){
                $serviceOrderDB = $serviceOrderDB->paginate($pageSize);
            } else {
                $serviceOrderDB = $serviceOrderDB->get();
            }


            return [
                'status' => 'success',
                'data' => $serviceOrderDB,
                'code' => 200
            ];

        } catch (Exception $exception) {
            return [
                'status' => 'error',
                'code' => 400,
                'message' => 'Erro ao Indexar'
            ];
        }
    }
    public function create($request , $releases)
    {

        $serviceOrderRequest = new ServiceOrderRequest();
        $requestValidated = $serviceOrderRequest->validate($request);

        if(count($releases) ==  0) {
            return [
                'status' => 'error',
                'code' => 400,
                'message' => 'Você precisa adicionar pelo menos um lançamento para o cadastro !'
            ];
        }

        try {
            DB::beginTransaction();
            $referenceService = new ReferenceService();
            $requestValidated['reference'] = $referenceService->getReference();
            $requestValidated['user_id'] = Auth::user()->id;
            $requestValidated['status_id'] = 1;

            $serviceOrderDB = ServiceOrder::query()->with(['company.user', 'contact'])->create($requestValidated);

            $serviceOrderDB->contact()->create([
                'type' => 'CNPJ',
                'name' => $serviceOrderDB['company']['name'],
                'fantasy_name' => $serviceOrderDB['company']['name'],
                'responsible' => $serviceOrderDB['company']['user']['name'] ?? '',
                'employer_number' => $serviceOrderDB['company']['employer_number'] ?? '',
                'zip_code' => $serviceOrderDB['company']['zip_code'] ,
                'address' => $serviceOrderDB['company']['address'],
                'number' => $serviceOrderDB['company']['number'],
                'neighborhood' => $serviceOrderDB['company']['neighborhood'],
                'city' => $serviceOrderDB['company']['city'],
                'uf' => $serviceOrderDB['company']['uf'],
                'phone' => $serviceOrderDB['company']['phone'],
                'email' => $serviceOrderDB['company']['email'],
            ]);

            foreach ($releases as $itemRelease) {
                ServiceOrdersItems::query()->create([
                    'service_order_id' => $serviceOrderDB['id'],
                    'schedule_company_id' => $itemRelease['id'],
                ]);
            }

            $this->calculatePrices($serviceOrderDB['id']);
            $this->generatePDF($serviceOrderDB['id']);
            $this->generateExcel($serviceOrderDB['id']);

            DB::commit();
            return [
                'status' => 'success',
                'data' => $serviceOrderDB,
                'code' => 200,
                'message' => 'Ordem de Serviço cadastrada com sucesso !'
            ];

        } catch (Exception $exception){
            DB::rollback();
            return [
                'status' => 'error',
             'code' => 400,
                'message' => 'Erro ao Cadastrar'
            ];
        }
    }
    public function update($request, $id)
    {
        $paymentMethodRequest = new PaymentMethodRequest();
        $requestValidated = $paymentMethodRequest->validate($request, $id);

        try {
            DB::beginTransaction();

            $paymentMethodDB = PaymentMethod::query()->findOrFail($id);
            $paymentMethodDB->update($requestValidated);

            DB::commit();
            return [
                'status' => 'success',
                'data' => $paymentMethodDB,
                'code' => 200,
                'message' => 'Tipo de pagamento atualizado com sucesso !'
            ];

        }catch (\Exception $exception) {
            DB::rollback();
            return [
                'status' => 'error',
                'code' => 400,
                'message' => 'Erro ao Atualizar'
            ];
        }
    }
    public function updateStatus($service_order_id, $status_id)
    {
        try {
            DB::beginTransaction();

            $serviceOrderDB  = ServiceOrder::query()->with(['releases.schedule_company' => fn($query) => $query->withoutGlobalScopes()])->withoutGlobalScopes()->findOrFail($service_order_id);

            if($status_id == 5) {
                foreach ($serviceOrderDB['releases'] as $release) {
                    $release->schedule_company->invoiced = 'Sim';
                    $release->schedule_company->save();
                }
            }

            $serviceOrderDB->update([
                'status_id' => $status_id
            ]);

            DB::commit();
            return [
                'status' => 'success',
                'data' => $serviceOrderDB,
                'code' => 200,
                'message' => 'Status atualizado com sucesso !'
            ];

        }catch (\Exception $exception) {
            DB::rollback();
            return [
                'status' => 'error',
                'code' => 400,
                'message' => 'Erro ao Atualizar'
            ];
        }
    }
    public function show($id)
    {
        try {
            $serviceOrderDB = ServiceOrder::query()->with(['contact', 'releases.schedule_company', 'payment'])->withoutGlobalScopes()->find($id);

            return [
                'status' => 'success',
                'data' => $serviceOrderDB,
                'code' => 200,

            ];
        }catch (Exception $exception){
            return [
                'status' => 'error',
                'code' => 400,
                'message' => 'Erro na requisição'
            ];
        }
    }
    public function delete($id = null)
    {
        try {
            DB::beginTransaction();

            $serviceOrderDB = ServiceOrder::query()->withoutGlobalScopes()->findOrFail($id);

            $serviceOrderDB->delete();

            DB::commit();
            return [
                'status' => 'success',
                'data' => $serviceOrderDB,
                'code' => 200,
                'message' => 'Ordem de serviço deletado com sucesso !'
            ];

        } catch (\Exception $exception) {
            return [
                'status' => 'error',
                'code' => 400,
                'message' => 'Erro ao deletar'
            ];
        }
    }
    public function getSelectServiceOrder()
    {
        $paymentMethodDB = PaymentMethod::query()->orderBy('name', 'ASC')->whereStatus('Ativo')->get();

        $return = [];

        foreach ($paymentMethodDB as $key => $itemPaymentMethod) {
            $return[0]['label'] = 'Escolha';
            $return[0]['value'] = '';
            $return[$key + 1]['label'] = $itemPaymentMethod['name'];
            $return[$key + 1]['value'] = $itemPaymentMethod['id'];
        }

        return $return;
    }

    public function calculatePrices($service_order_id)
    {
        $serviceOrderDB = ServiceOrder::query()->with([
            'releases.schedule_company' => fn($query) => $query->withoutGlobalScopes()
        ])->withoutGlobalScopes()->findOrFail($service_order_id);

        $total_releases = 0;
        $total_discounts = $serviceOrderDB['total_discounts'];
        $percentage_discount = $serviceOrderDB['percentage_discount'];

        foreach ($serviceOrderDB['releases'] as $itemRelease) {
            $total_releases += $itemRelease['schedule_company']['price_total'];
        }

        if($serviceOrderDB['percentage_discount'] != null) {
            $total_discounts = $percentage_discount / 100 * $total_releases;
        }

        $total_value = $total_releases - $total_discounts;

        $serviceOrderDB->update([
            'total_releases' => $total_releases,
            'total_value' => $total_value,
            'total_discounts' => $total_discounts
        ]);
    }

    public function generatePDF($serviceOrderID)
    {
        $serviceOrderDB = ServiceOrder::query()->with(['company','contact', 'contact', 'payment',
            'releases.schedule_company' => fn($query) => $query->withoutGlobalScopes(),
            'releases.schedule_company.schedule.training' => fn($query) => $query->withoutGlobalScopes(),
        ])->withoutGlobalScopes()
            ->findOrFail($serviceOrderID);

        $serviceOrderItemsDB = ServiceOrdersItems::query()->where('service_order_id', $serviceOrderID)->withoutGlobalScopes()->pluck('schedule_company_id');

        $scheduleCompanyParticipantsDB = ScheduleCompanyParticipants::query()->with([
            'schedule_company' => fn ($query) => $query->withoutGlobalScopes(),
            'schedule_company.schedule.training'=> fn ($query) => $query->withoutGlobalScopes(),
            'participant' => fn ($query) => $query->withoutGlobalScopes(),
            'participant.contract' => fn ($query) => $query->withoutGlobalScopes(),
            'participant.role' => fn ($query) => $query->withoutGlobalScopes()
        ]);

        $scheduleCompanyParticipantsDB->whereIn('schedule_company_id', $serviceOrderItemsDB);
        $scheduleCompanyParticipantsDB->where('presence', 1);

        $scheduleCompanyParticipantsDB = $scheduleCompanyParticipantsDB->get();

        $data = ['order' => $serviceOrderDB, 'participants' => $scheduleCompanyParticipantsDB];

        $pdf = Pdf::loadView('admin.pdf.service-order.index', $data)->setPaper('a4', 'portrait');

        Storage::disk('public')->makeDirectory('service-order/'.$serviceOrderDB['id']);

        $path = 'app/public/service-order/'.$serviceOrderDB['id'].'/lista_'.$serviceOrderDB['reference'].'.pdf';

        if(Storage::exists('public/'.$path)) {
            Storage::delete('public/'.$path);
        }

        $pdf->save(storage_path($path));

        $serviceOrderDB->update(['os_path' => $path]);
    }


    public function generateExcel($serviceOrderID)
    {

        $serviceOrderDB = ServiceOrder::query()->with(['company','contact', 'contact', 'payment',
            'releases.schedule_company' => fn($query) => $query->withoutGlobalScopes(),
            'releases.schedule_company.schedule.training' => fn($query) => $query->withoutGlobalScopes(),
        ])->withoutGlobalScopes()
            ->findOrFail($serviceOrderID);



        Storage::disk('public')->makeDirectory('service-order');

        $path = 'service-order/'.$serviceOrderDB['id'].'/participantes/lista_participantes_'.$serviceOrderDB['reference'].'.xlsx';

        if(Storage::exists('public/'.$path)) {
            Storage::delete('public/' . $path);
        }

        Excel::store(new ServiceOrderParticipants($serviceOrderID), $path, 'public');

        $serviceOrderDB->update(['participants_path' => $path]);
    }

    public function addDiscount($service_order_id, $request)
    {
        $serviceOrderRequest = new ServiceOrderRequest();
        $requestValidated = $serviceOrderRequest->validateDiscount($request);

        try {
            DB::beginTransaction();

            $serviceOrderDB = ServiceOrder::query()->with(['contact','company'])->withoutGlobalScopes()->findOrFail($service_order_id);

            $discount = 0;
            $percentage_discount = null;
            if($requestValidated['type'] == 'percentage') {
                $discount = $requestValidated['value'] / 100 * $serviceOrderDB['total_releases'];
                $percentage_discount = $requestValidated['value'];
            }
            if($requestValidated['type'] == 'value') {
                $discount = $requestValidated['value'];
            }

            if($discount > $serviceOrderDB['total_releases']) {
                return [
                    'status' => 'error',
                    'code' => 400,
                    'message' => 'Valor do desconto maior que o sub-total !'
                ];
            }

            $serviceOrderDB->update([
                'total_discounts' => $discount,
                'percentage_discount' => $percentage_discount
            ]);

            $this->calculatePrices($service_order_id);

            DB::commit();
            return [
                'status' => 'success',
                'data' => $serviceOrderDB,
                'code' => 200,
                'message' => 'Desconto adicionado com sucesso !'
            ];

        } catch (\Exception $exception) {
            return [
                'status' => 'error',
                'code' => 400,
                'message' => 'Erro no envio !'
            ];
        }
    }

    public function sendEmail($service_order_id)
    {
        try {
            DB::beginTransaction();

            $serviceOrderDB = ServiceOrder::query()->with(['contact','company'])->withoutGlobalScopes()->findOrFail($service_order_id);

            if($serviceOrderDB['contact']['email'] == null) {
                return [
                    'status' => 'error',
                    'code' => 400,
                    'message' => 'Nao exite um email cadastrar para o envio do email, por favor atualize o cadastro!'
                ];
            }

            $serviceOrderDB['contact']->notify(new SendOSClientNotification($serviceOrderDB['id']));

            $serviceOrderDB->update(['status_id' => 2]);

            DB::commit();
            return [
                'status' => 'success',
                'data' => $serviceOrderDB,
                'code' => 200,
                'message' => 'Email de notificação enviado com successo !'
            ];

        } catch (\Exception $exception) {
            return [
                'status' => 'error',
                'code' => 400,
                'message' => 'Erro no envio !'
            ];
        }
    }
}
