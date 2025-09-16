<?php

namespace App\Repositories;

use App\Models\SchedulePrevat;
use App\Models\Training;
use App\Models\TrainingParticipations;
use App\Requests\SchedulePrevatRequest;
use App\Services\ReferenceService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use PHPUnit\Exception;

class SchedulePrevatRepository
{
    public function index($orderBy, $filterData = null, $pageSize = null)
    {
        try {
            \Log::info('=== SCHEDULE PREVAT REPOSITORY - BUSCA NO BANCO ===');
            \Log::info('Filtros aplicados:', $filterData ?? []);
            \Log::info('Ordenação: ' . $orderBy['column'] . ' ' . $orderBy['order']);
            
            $schedulePrevatDB = SchedulePrevat::query()->with(['training', 'workload', 'room', 'first_time', 'second_time', 'contractor']);

            if(isset(session('filter')['search']) && session('filter')['search'] != null) {
                $schedulePrevatDB->whereHas('training', function($query) use ($filterData){
                    $query->where('name', 'LIKE', '%'.session('filter')['search'].'%');
                    $query->orWhere('acronym', 'LIKE', '%'.session('filter')['search'].'%');
                });
                \Log::info('Filtro por busca: ' . session('filter')['search']);
            }

            if(isset(session('filter')['date_start']) && session('filter')['date_start'] != null) {
                $schedulePrevatDB->whereDate('date_event', '>=', session('filter')['date_start']);
                \Log::info('Filtro por data início: ' . session('filter')['date_start']);
            }

            if(isset(session('filter')['date_end']) && session('filter')['date_end'] != null) {
                $schedulePrevatDB->whereDate( 'date_event', '<=', session('filter')['date_end']);
                \Log::info('Filtro por data fim: ' . session('filter')['date_end']);
            }

            $schedulePrevatDB->orderBy($orderBy['column'], $orderBy['order']);

            if($pageSize) {
                $schedulePrevatDB = $schedulePrevatDB->paginate($pageSize);
                \Log::info('Paginação: ' . $pageSize . ' itens por página');
            } else {
                $schedulePrevatDB = $schedulePrevatDB->get();
                \Log::info('Busca sem paginação - Total de registros: ' . $schedulePrevatDB->count());
            }

            // Log detalhado dos dados encontrados
            \Log::info('Dados encontrados no SchedulePrevatRepository:');
            foreach ($schedulePrevatDB as $index => $item) {
                \Log::info("Item " . ($index + 1) . ":", [
                    'ID' => $item->id ?? 'N/A',
                    'Data Evento' => $item->date_event ?? 'N/A',
                    'Treinamento' => optional($item->training)->name ?? 'N/A',
                    'Empresa Contratante' => optional($item->contractor)->fantasy_name ?? 'N/A',
                    'Tipo' => $item->type ?? 'N/A',
                    'Vagas' => $item->vacancies ?? 0,
                    'Vagas Ocupadas' => $item->vacancies_occupied ?? 0,
                    'Status' => $item->status ?? 'N/A'
                ]);
            }

            return [
                'status' => 'success',
                'data' => $schedulePrevatDB,
                'code' => 200
            ];

        } catch (Exception $exception) {
            \Log::error('Erro no SchedulePrevatRepository: ' . $exception->getMessage());
            return [
                'status' => 'error',
                'code' => 400,
                'message' => 'Erro ao Indexar'
            ];
        }
    }

    public function create($request)
    {
        $schedulePrevatRequest = new SchedulePrevatRequest();
        $requestValidated = $schedulePrevatRequest->validate($request);

        $referenceService = new ReferenceService();

        $requestValidated['reference'] = $referenceService->getReference();
        $requestValidated['vacancies_available'] = $requestValidated['vacancies'];

        if($requestValidated['time02_id'] == "") {
            $requestValidated['time02_id'] = null;
        }

        try {
            DB::beginTransaction();

            $schedulePrevatDB = SchedulePrevat::query()->create($requestValidated);

            DB::commit();
            return [
                'status' => 'success',
                'data' => $schedulePrevatDB,
                'code' => 200,
                'message' => 'Agendamento cadastrado com sucesso !'
            ];

        } catch (Exception $exception){
            DB::rollback();
            return [
                'status' => 'error',
                'data' => $exception,
                'code' => 400,
                'message' => 'Erro ao Cadastrar'
            ];
        }
    }

    public function update($request, $id)
    {
        $schedulePrevatRequest = new SchedulePrevatRequest();
        $requestValidated = $schedulePrevatRequest->validate($request, $id);

        try {
            DB::beginTransaction();

            $schedulePrevatDB = SchedulePrevat::query()->findOrFail($id);

            if($requestValidated['vacancies'] < $schedulePrevatDB['vacancies_occupied']) {
                return [
                    'status' => 'error',
                    'code' => 400,
                    'message' => 'Quantidade de Vagas é menor do que a cadastrada! por favor informe um numero maior...'
                ];
            }

            if($requestValidated['vacancies'] != $schedulePrevatDB['vacancies']) {
                $requestValidated['vacancies_available'] = $requestValidated['vacancies'] - $schedulePrevatDB['vacancies_occupied'];
            }
            if($requestValidated['time02_id'] == '') {
                $requestValidated['time02_id'] = null;
            }

            if($requestValidated['team_id'] == '') {
                $requestValidated['team_id'] = null;
            }

            $schedulePrevatDB->update($requestValidated);

            DB::commit();
            return [
                'status' => 'success',
                'data' => $schedulePrevatDB,
                'code' => 200,
                'message' => 'Agendamentos atualizado com sucesso !'
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
            $schedulePrevatDB = SchedulePrevat::query()->with(['training', 'location', 'workload', 'room', 'first_time', 'second_time', 'team'])->find($id);

            return [
                'status' => 'success',
                'data' => $schedulePrevatDB,
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

            $schedulePrevatDB = SchedulePrevat::query()->findOrFail($id);
            $schedulePrevatDB->delete();

            DB::commit();
            return [
                'status' => 'success',
                'data' => $schedulePrevatDB,
                'code' => 200,
                'message' => 'Agendamento deletado com sucesso !'
            ];

        } catch (\Exception $exception) {
            return [
                'status' => 'error',
                'code' => 400,
                'message' => 'Você tem participantes cadastrados nesse agendamento por favor verifique com a empresa o remanejamento.'
            ];
        }
    }

    public function changeStatus($data)
    {
        try {
            DB::beginTransaction();

            $schedulePrevatDB = SchedulePrevat::query()->findOrFail($data['id']);
            $schedulePrevatDB->update([
                'status' => $data['status']
            ]);

            DB::commit();
            return [
                'status' => 'success',
                'data' => $schedulePrevatDB,
                'code' => 200,
                'message' => 'Agendamento atualizado com sucesso !'
            ];

        } catch (\Exception $exception) {

            return [
                'status' => 'error',
                'code' => 400,
                'message' => 'Erro na requisição !'
            ];
        }
    }

    public function changeType($data)
    {
        try {
            DB::beginTransaction();

            $schedulePrevatDB = SchedulePrevat::query()->findOrFail($data['id']);
            $schedulePrevatDB->update([
                'type' => $data['type']
            ]);

            DB::commit();
            return [
                'status' => 'success',
                'data' => $schedulePrevatDB,
                'code' => 200,
                'message' => 'Agendamento atualizado com sucesso !'
            ];

        } catch (\Exception $exception) {

            return [
                'status' => 'error',
                'code' => 400,
                'message' => 'Erro na requisição !'
            ];
        }
    }

    public function getSelectSchedulePrevat($status = null)
    {
        $schedulePrevatDB = SchedulePrevat::query()->with([
            'training',
            'workload',
            'team',
            'contractor'
        ]);

        if($status) {
            $schedulePrevatDB->whereStatus($status);
        }

        if(Auth::user()->company->type == 'client') {
            $schedulePrevatDB->where('type', 'Aberto');
        }

        if(Auth::user()->company->type == 'client' && Auth::user()->contract_default){
            $schedulePrevatDB->whereIn('contractor_id',  [Auth::user()->contract_default->contractor_id]);
        }

        $schedulePrevatDB->orderBy('date_event', 'DESC');

        $schedulePrevatDB = $schedulePrevatDB->get();

        $return = [];

        $return[0]['label'] = 'Escolha';
        $return[0]['contractor'] = '';
        $return[0]['team'] = '';
        $return[0]['value'] = '';
        $return[0]['date_event'] = '';
        $return[0]['vacancies_available'] = '';

        if($schedulePrevatDB->count() > 0) {
            foreach ($schedulePrevatDB as $key => $itemSchedulePrevat) {
                $return[$key +1]['label'] = formatDate($itemSchedulePrevat['date_event']).' - '. $itemSchedulePrevat['training']['name'];
                $return[$key +1]['team'] = $itemSchedulePrevat['team']['name'] ?? '';
                $return[$key +1]['contractor'] = $itemSchedulePrevat['contractor']['fantasy_name'] ?? '';
                $return[$key +1]['value'] = $itemSchedulePrevat['id'];
                $return[$key +1]['vacancies_available'] = $itemSchedulePrevat['vacancies_available'];
                $return[$key +1]['date_event'] = $itemSchedulePrevat['date_event'];
            }
        } else {
            $return[0]['label'] = 'Sem evento para a data selecionada';
            $return[0]['team'] = '';
            $return[0]['contractor'] = '';
            $return[0]['value'] = '';
            $return[0]['date_event'] = '';
            $return[0]['vacancies_available'] = '';

        }
        return $return;
    }

    public function decrementVacany($schedule_prevat_id, $quantity)
    {
        $schedulePrevatDB = SchedulePrevat::query()->with('training')->find($schedule_prevat_id);

        $schedulePrevatDB->increment('vacancies_occupied', $quantity);
        $schedulePrevatDB->decrement('vacancies_available', $quantity);
    }

    public function incrementVacancy($schedule_prevat_id, $quantity)
    {
        $schedulePrevatDB = SchedulePrevat::query()->with('training')->find($schedule_prevat_id);

        $schedulePrevatDB->decrement('vacancies_occupied', $quantity);
        $schedulePrevatDB->increment('vacancies_available', $quantity);
    }

    public function decrementAbsences($schedule_prevat_id, $quantity)
    {
        $schedulePrevatDB = SchedulePrevat::query()->with('training')->find($schedule_prevat_id);
        $schedulePrevatDB->decrement('absences', $quantity);
    }

    public function incrementAbsences($schedule_prevat_id, $quantity)
    {
        $schedulePrevatDB = SchedulePrevat::query()->with('training')->find($schedule_prevat_id);
        $schedulePrevatDB->increment('absences', $quantity);
    }

    public function caculateVacancies($schedule_prevat_id, $quantity)
    {
        $schedulePrevatDB = SchedulePrevat::query()->with('training')->findOrFail($schedule_prevat_id);

        $quantityAvailable = $schedulePrevatDB['vacancies_available'] - $quantity;
        $quantityOccupied = $schedulePrevatDB['vacancies_occupied'] + $quantity;

        $schedulePrevatDB->update([
            'vacancies_available' => $quantityAvailable,
            'vacancies_occupied' => $quantityOccupied,
        ]);
    }
}
