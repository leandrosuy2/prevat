<?php

namespace App\Repositories\Financial;

use App\Models\Participant;
use App\Models\ScheduleCompany;
use App\Models\ScheduleCompanyParticipants;
use App\Models\ServiceOrdersItems;
use App\Requests\ScheduleCompanyRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PHPUnit\Exception;

class ServiceOrderReleasesRepository
{
    public function index($serviceOrderID = null, $orderBy = null, $pageSize = null, $filterData = null )
    {
        try {
            $serviceOrderItemsDB = ServiceOrdersItems::query()->with([
                'service_order',
                'schedule_company' => fn ($query) => $query->withoutGlobalScopes(),
                'schedule_company.schedule.training' => fn ($query) => $query->withoutGlobalScopes(),
            ]);

            if($serviceOrderID) {
                $serviceOrderItemsDB->where('service_order_id', $serviceOrderID);
            }

            if($pageSize) {
                $serviceOrderItemsDB = $serviceOrderItemsDB->paginate($pageSize);
            } else {
                $serviceOrderItemsDB = $serviceOrderItemsDB->get();
            }


            return [
                'status' => 'success',
                'data' => $serviceOrderItemsDB,
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

    public function getParticipantsByReleases($serviceOrderID, $orderBy = null, $pageSize = null, $filterData = null)
    {
        try {
            $serviceOrderItemsDB = ServiceOrdersItems::query()->where('service_order_id', $serviceOrderID)->withoutGlobalScopes()->pluck('schedule_company_id');

            $scheduleCompanyParticipantsDB = ScheduleCompanyParticipants::query()->with([
                'schedule_company' => fn ($query) => $query->withoutGlobalScopes(),
                'schedule_company.schedule.training'=> fn ($query) => $query->withoutGlobalScopes(),
                'participant' => fn ($query) => $query->withoutGlobalScopes(),
                'participant.contract' => fn ($query) => $query->withoutGlobalScopes(),
                'participant.role' => fn ($query) => $query->withoutGlobalScopes()
            ]);


            if(isset($filterData['search']) && $filterData['search'] != null) {
                $scheduleCompanyParticipantsDB->whereHas('participant', function($query) use ($filterData){
                    $query->withoutGlobalScopes()->where('name', 'LIKE', '%'.$filterData['search'].'%');
                    $query->withoutGlobalScopes()->orWhere('taxpayer_registration', 'LIKE', '%'.$filterData['search'].'%');
                });
                $scheduleCompanyParticipantsDB->orWhereHas('schedule_company', function($query) use ($filterData){
                    $query->withoutGlobalScopes()->whereHas('schedule.training', function($q) use ($filterData) {
                        $q->where('name', 'LIKE', '%'.$filterData['search'].'%');
                    });

                });
            }

            $scheduleCompanyParticipantsDB->whereIn('schedule_company_id', $serviceOrderItemsDB);
            $scheduleCompanyParticipantsDB->where('presence', 1);

            if($orderBy){
                $scheduleCompanyParticipantsDB->orderBy($orderBy['column'], $orderBy['order']);
            }

            if($pageSize) {
                $scheduleCompanyParticipantsDB = $scheduleCompanyParticipantsDB->paginate($pageSize);
            } else {
                $scheduleCompanyParticipantsDB = $scheduleCompanyParticipantsDB->get();
            }
            return [
                'status' => 'success',
                'data' => $scheduleCompanyParticipantsDB,
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

    public function create($service_order_id, $schedule_company_id)
    {
        try {
            $serviceOrderItemsDB = ServiceOrdersItems::query()->create([
                'service_order_id' => $service_order_id,
                'schedule_company_id' => $schedule_company_id
            ]);

            $serviceOrderRepository = new ServiceOrderRepository();

            $serviceOrderRepository->calculatePrices($service_order_id);
            $serviceOrderRepository->generatePDF($service_order_id);
            $serviceOrderRepository->generateExcel($service_order_id);

            return [
                'status' => 'success',
                'data' => $serviceOrderItemsDB,
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

    public function createSelections($service_order_id, $schedule_companies)
    {

        try {
            foreach ($schedule_companies as $schedule_company_id){
                $serviceOrderItemsDB = ServiceOrdersItems::query()->create([
                    'service_order_id' => $service_order_id,
                    'schedule_company_id' => $schedule_company_id
                ]);
            }

            $serviceOrderRepository = new ServiceOrderRepository();

            $serviceOrderRepository->calculatePrices($service_order_id);
            $serviceOrderRepository->generatePDF($service_order_id);
            $serviceOrderRepository->generateExcel($service_order_id);

            return [
                'status' => 'success',
                'data' => $serviceOrderItemsDB,
                'message' => 'Treinamentos cadastrados com sucesso!',
                'code' => 200
            ];
        } catch (Exception $exception) {
            return [
                'status' => 'error',
                'code' => 400,
                'message' => 'Erro ao cadastrar'
            ];
        }
    }

    public function update($request, $id)
    {
        $scheduleCompanyRequest = new ScheduleCompanyRequest();
        $requestValidated = $scheduleCompanyRequest->validatePrice($request, $id);

        try {
            DB::beginTransaction();

            $serviceOrderItemsDB = ServiceOrdersItems::query()->with([
                'service_order' => fn($query) => $query->withoutGlobalScopes(),
                'schedule_company' => fn($query) => $query->withoutGlobalScopes(),
                'schedule_company.participantsPresent' => fn($query) => $query->withoutGlobalScopes()
            ])->withoutGlobalScopes()->findOrFail($id);


            $serviceOrderItemsDB['schedule_company']->update([
                'price' => $requestValidated['price'],
                'price_total' => $serviceOrderItemsDB['schedule_company']['participantsPresent']->count() * $requestValidated['price']
            ]);

            foreach ($serviceOrderItemsDB['schedule_company']['participantsPresent'] as $itemParticipant) {
                $itemParticipant->value = $requestValidated['price'];
                $itemParticipant->total_value = $itemParticipant['quantity'] * $requestValidated['price'];
                $itemParticipant->save();
            }

            $serviceOrderRepository = new ServiceOrderRepository();
            $serviceOrderRepository->calculatePrices($serviceOrderItemsDB['service_order']['id']);
            $serviceOrderRepository->generatePDF($serviceOrderItemsDB['service_order_id']);
            $serviceOrderRepository->generateExcel($serviceOrderItemsDB['service_order_id']);



            DB::commit();
            return [
                'status' => 'success',
                'data' => $serviceOrderItemsDB,
                'code' => 200,
                'message' => 'Valor Atualizado com sucesso !'
            ];

        } catch (\Exception $exception) {

            dd($exception);
            return [
                'status' => 'error',
                'code' => 400,
                'message' => 'Erro na requisição'
            ];
        }
    }

    public function show($id)
    {
        try {
            $serviceOrderItems = ServiceOrdersItems::query()->with(['schedule_company' => fn($query) => $query->withoutGlobalScopes()]);

            $serviceOrderItems = $serviceOrderItems->find($id);

            return [
                'status' => 'success',
                'data' => $serviceOrderItems,
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

            $serviceOrderItemsDB = ServiceOrdersItems::query()->with(['service_order' => fn($query) => $query->withoutGlobalScopes()])->findOrFail($id);

            $scheduleCompanyDB = ScheduleCompany::query()->withoutGlobalScopes()->findOrFail($serviceOrderItemsDB['schedule_company_id'])->update(['invoiced' => 'Não']);

            $serviceOrderItemsDB->delete();

            $serviceOrderRepository = new ServiceOrderRepository();
            $serviceOrderRepository->calculatePrices($serviceOrderItemsDB['service_order']['id']);
            $serviceOrderRepository->generatePDF($serviceOrderItemsDB['service_order']['id']);
            $serviceOrderRepository->generateExcel($serviceOrderItemsDB['service_order']['id']);


            DB::commit();
            return [
                'status' => 'success',
                'data' => $serviceOrderItemsDB,
                'code' => 200,
                'message' => 'Lançamento deletado com sucesso !'
            ];

        } catch (\Exception $exception) {
            return [
                'status' => 'error',
                'code' => 400,
                'message' => 'Erro ao deletar'
            ];
        }
    }
}
