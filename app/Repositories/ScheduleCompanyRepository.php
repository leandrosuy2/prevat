<?php

namespace App\Repositories;

use App\Models\ScheduleCompany;
use App\Models\ScheduleCompanyParticipants;
use App\Models\SchedulePrevat;
use App\Models\User;
use App\Notifications\SendNewScheduleCompanyNotification;
use App\Repositories\Financial\ServiceOrderRepository;
use App\Requests\ScheduleCompanyRequest;
use App\Services\ReferenceService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use PHPUnit\Exception;

class ScheduleCompanyRepository
{
    public function index($orderBy = null, $filterData = null, $pageSize = null)
    {
        try {
            $scheduleCompanyDB = ScheduleCompany::query()->with(['schedule.training', 'schedule.location', 'schedule.room', 'schedule.first_time', 'schedule.second_time', 'company', 'participants.participant']);

            // Apenas admins podem ver todas as agendas
            if(Auth::user()->company->type == 'admin') {
                $scheduleCompanyDB->withoutGlobalScopes();
            } else {
                // Para usuários client/contractor: garantir que vejam apenas suas próprias agendas
                $scheduleCompanyDB->where('company_id', Auth::user()->company->id);
                
                // Se o usuário tem contract_id, filtrar também por contrato
                if(Auth::user()->contract_id) {
                    $scheduleCompanyDB->where('contract_id', Auth::user()->contract_id);
                }
            }

            // CORRIGIDO: Agrupar busca textual em um único where aninhado para funcionar junto com o filtro de empresa
            if(isset($filterData['search']) && $filterData['search'] != null) {
                $scheduleCompanyDB->where(function($query) use ($filterData) {
                    $query->whereHas('schedule.training', function($q) use ($filterData){
                        $q->where('name', 'LIKE', '%'.$filterData['search'].'%')
                          ->orWhere('acronym', 'LIKE', '%'.$filterData['search'].'%');
                    })
                    ->orWhereHas('participants', function($q) use ($filterData){
                        $q->whereHas('participant', function($subQ) use ($filterData){
                            $subQ->withoutGlobalScopes()->where('name', 'LIKE', '%'.$filterData['search'].'%');
                        });
                    })
                    ->orWhereHas('company', function($q) use ($filterData){
                        $q->where('name', 'LIKE', '%'.$filterData['search'].'%')
                          ->orWhere('fantasy_name', 'LIKE', '%'.$filterData['search'].'%');
                    });
                });
            }

            if(isset($filterData['company_id']) && $filterData['company_id'] != null) {
                $scheduleCompanyDB->where('company_id', $filterData['company_id']);
            }

            if(isset($filterData['schedule_prevat_id']) && $filterData['schedule_prevat_id'] != null) {
                $scheduleCompanyDB->where('schedule_prevat_id', $filterData['schedule_prevat_id']);
            }

            if(isset($filterData['date_event']) && $filterData['date_event'] != null) {
                $scheduleCompanyDB->whereHas('schedule', function($query) use ($filterData) {
                    $query->whereDate('date_event', '=', $filterData['date_event']);
                });
            }

//            if(isset($filterData['date_end']) && $filterData['date_end'] != null) {
//                $scheduleCompanyDB->whereHas('schedule', function($query) use ($filterData) {
//                    $query->whereDate( 'date_event', '<=', $filterData['date_end']);
//                });
//            }

            if($orderBy)  {
                $scheduleCompanyDB->orderBy($orderBy['column'], $orderBy['order']);
            }


            if($pageSize) {
                $scheduleCompanyDB = $scheduleCompanyDB->paginate($pageSize);
            } else {
                $scheduleCompanyDB = $scheduleCompanyDB->get();
            }


            return [
                'status' => 'success',
                'data' => $scheduleCompanyDB,
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

    public function create($request, $participants)
    {
        $scheduleCompanyRequest = new ScheduleCompanyRequest();
        $requestValidated = $scheduleCompanyRequest->validate($request);

        $referenceService = new ReferenceService();

        $schedulePrevatRepository = new SchedulePrevatRepository();
        $schedulePrevatReturnDB = $schedulePrevatRepository->show($requestValidated['schedule_prevat_id'])['data'];

        $scheduleCompany = ScheduleCompany::query()->where('schedule_prevat_id', $requestValidated['schedule_prevat_id'])->first();

        if($scheduleCompany)  {
            return [
                'status' => 'error',
                'code' => 400,
                'message' => 'Voce já tem um agendamento no treinamento selecionado, por favor adicione os participantes editando o evento selecionado.'
            ];
        }

        $requestValidated['total_participants'] = count($participants);

        if(count($participants) > $schedulePrevatReturnDB['vacancies_available']) {
            return [
                'status' => 'error',
                'code' => 400,
                'message' => 'A Quantidade de participantes é maior do que a quantidade de vagas disponíveis !'
            ];
        }

        if(count($participants) ==  0) {
            return [
                'status' => 'error',
                'code' => 400,
                'message' => 'Você precisa cadastrar pelo menos um participante !'
            ];
        }
        try {
            DB::beginTransaction();

            $requestValidated['reference'] = $referenceService->getReference();
            $scheduleCompany = ScheduleCompany::query()->with(['schedule.training'])->create($requestValidated);

            foreach($participants as $participant) {
                ScheduleCompanyParticipants::query()->create([
                    'schedule_company_id' => $scheduleCompany['id'],
                    'participant_id' => $participant['id'],
                    'quantity' => 1,
                    'value' => $scheduleCompany['schedule']['training']['value'],
                    'presence' => true
                ]);
            }

            $schedulePrevatRepository = new SchedulePrevatRepository();
            $schedulePrevatRepository->decrementVacany($scheduleCompany['schedule_prevat_id'], $scheduleCompany['total_participants']);

            $participantRepository = new ParticipantRepository();
            $participantRepository->generateListPDF($scheduleCompany['id']);


            $scheduleCompany->update([
                'price' => $scheduleCompany['schedule']['training']['value'],
                'price_total' => $scheduleCompany['participants']->sum('value')
            ]);

            if(Auth::user()->company->type == 'client') {
                $usersNotifications = User::query()->where('notifications', 'Ativo')->where('company_id', 1000)->get();
                Notification::send($usersNotifications, new SendNewScheduleCompanyNotification($scheduleCompany['id']));
            }

            DB::commit();
            return [
                'status' => 'success',
                'data' => $scheduleCompany,
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

    public function update($id, $request, $participants, $participantsDelete)
    {
        $scheduleCompanyRequest = new ScheduleCompanyRequest();
        $requestValidated = $scheduleCompanyRequest->validate($request, $id);

        try {
            DB::beginTransaction();

            $schedulePrevatRepository = new SchedulePrevatRepository();

            $scheduleCompanyDB = ScheduleCompany::query()->with(['participants', 'participantsPresent', 'participantsAusent'])->withoutGlobalScopes()->findOrFail($id);

            $requestValidated['total_participants'] = $participants->count();

            $schedulePrevatReturnDB = $schedulePrevatRepository->show($scheduleCompanyDB['schedule_prevat_id'])['data'];

            $newparticipants = 0;
            foreach($participants as $participant) {
                if(isset($participant['new'])) {
                    $newparticipants ++;
                    }
                }
                if($newparticipants > $schedulePrevatReturnDB['vacancies_available']) {
                    return [
                        'status' => 'error',
                        'code' => 400,
                        'message' => 'A Quantidade de participantes é maior que a quantidade de vagas disponivels no treinamento'
                    ];
                } else {
                    foreach($participants as $participant) {
                        if (isset($participant['new'])) {
                            $scheduleParticipants = ScheduleCompanyParticipants::query()->create([
                                'schedule_company_id' => $scheduleCompanyDB['id'],
                                'participant_id' => $participant['id'],
                            ]);
                            $schedulePrevatRepository->decrementVacany($scheduleCompanyDB['schedule_prevat_id'], 1);
                        }
                    }
                }

            foreach($participantsDelete as $participantDeleteID) {
                $scheduleCompanyParticipant = ScheduleCompanyParticipants::query()->find($participantDeleteID);
                if($scheduleCompanyParticipant['presence'] == 0) {
                    $schedulePrevatRepository->decrementAbsences($scheduleCompanyDB['schedule_prevat_id'], 1);
                } else {
                    $schedulePrevatRepository->incrementVacancy($scheduleCompanyDB['schedule_prevat_id'], 1);
                }
                $scheduleCompanyParticipant->delete();
            }

            $scheduleOldPrevatDB = SchedulePrevat::query()->find($scheduleCompanyDB['schedule_prevat_id']);

            if($requestValidated['schedule_prevat_id'] != $scheduleCompanyDB['schedule_prevat_id'] ) {

                $scheduleOldPrevatDB->decrement('vacancies_occupied', $scheduleCompanyDB['participantsPresent']->count());
                $scheduleOldPrevatDB->increment('vacancies_available', $scheduleCompanyDB['participantsPresent']->count());
                $scheduleOldPrevatDB->decrement('absences', $scheduleCompanyDB['participantsAusent']->count());

                $scheduleNewPrevatDB = SchedulePrevat::query()->find($requestValidated['schedule_prevat_id']);

                if($scheduleCompanyDB['participants']->count() > $scheduleNewPrevatDB['vacancies_available']) {
                    return [
                        'status' => 'error',
                        'code' => 400,
                        'message' => 'A Quantidade de participantes é maior que a quantidade de vagas disponivels no treinamento'
                    ];
                }

                $scheduleNewPrevatDB->increment('vacancies_occupied', $scheduleCompanyDB['participantsPresent']->count());
                $scheduleNewPrevatDB->decrement('vacancies_available', $scheduleCompanyDB['participantsPresent']->count());
                $scheduleNewPrevatDB->increment('absences', $scheduleCompanyDB['participantsAusent']->count());

            }

            $scheduleCompanyDB->update($requestValidated);

            $scheduleCompanyDB = $scheduleCompanyDB->fresh();

            $participantRepository = new ParticipantRepository();
            $participantRepository->generateListPDF($scheduleCompanyDB['id']);

            DB::commit();
            return [
                'status' => 'success',
                'data' => $scheduleCompanyDB,
                'code' => 200,
                'message' => 'Agendamento atualizado com sucesso !'
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
            $scheduleCompanyDB = ScheduleCompany::query()->with([
                'participantsPresent',
                'participantsAusent',
                'schedule.training',
                'participants.participant' => fn ($query) => $query->withoutGlobalScopes(),
                'company'
            ]);

            if(Auth::user()->company->type == 'admin' || Auth::user()->company->type == 'contrator') {
                $scheduleCompanyDB->withoutGlobalScopes();
            }

            $scheduleCompanyDB = $scheduleCompanyDB->find($id);

            return [
                'status' => 'success',
                'data' => $scheduleCompanyDB,
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

    public function showByReference($reference)
    {
        try {
            $scheduleCompanyDB = ScheduleCompany::query()->with(['participants.participant' => fn ($query) => $query->withoutGlobalScopes(), 'company', 'schedule']);

            if(Auth::user()->company->type == 'admin' || Auth::user()->company->type == 'contractor') {
                $scheduleCompanyDB->withoutGlobalScopes();
            }

            $scheduleCompanyDB->where('reference', $reference);

            $scheduleCompanyDB = $scheduleCompanyDB->first();

            return [
                'status' => 'success',
                'data' => $scheduleCompanyDB,
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

            $scheduleCompanyDB = ScheduleCompany::query()
                ->with(['participants'])
                ->withCount([
                    'participants as totalPresences' => function ($query) {
                    $query->where('presence', true);
                },
                    'participants as totalAbsent' => function ($query) {
                        $query->where('presence', false);
                    }
                ])
                ->withoutGlobalScopes()
                ->findOrFail($id);

            $schedulePrevatRepository = new SchedulePrevatRepository();

            $schedulePrevatRepository->incrementVacancy($scheduleCompanyDB['schedule_prevat_id'], $scheduleCompanyDB['totalPresences']);
            $schedulePrevatDB = SchedulePrevat::query()->find($scheduleCompanyDB['schedule_prevat_id']);
            $schedulePrevatDB->decrement('absences',  $scheduleCompanyDB['totalAbsent']);

            $scheduleCompanyDB->delete();

            DB::commit();
            return [
                'status' => 'success',
                'data' => $scheduleCompanyDB,
                'code' => 200,
                'message' => 'Agendamento deletado com sucesso !'
            ];

        } catch (\Exception $exception) {

            return [
                'status' => 'error',
                'code' => 400,
                'message' => 'Erro ao deletar'
            ];
        }
    }

    public function getSelectScheduleCompany($company_id = null)
    {
        $scheduleCompanyDB = ScheduleCompany::query()->with(['schedule.training', 'company']);

        $scheduleCompanyDB->withoutGlobalScopes();

        $scheduleCompanyDB->whereHas('company', function($query){
            $query->orderBy('name', 'ASC');
        });

        if($company_id) {
            $scheduleCompanyDB->where('company_id', $company_id);
        }

        $scheduleCompanyDB = $scheduleCompanyDB->get();

        $return = [];

        foreach ($scheduleCompanyDB as $key => $itemUser) {
            $return[0]['label'] = 'Escolha';
            $return[0]['value'] = '';
            $return[$key + 1]['label'] = $itemUser['schedule']['training']['name'];
            $return[$key + 1]['value'] = $itemUser['id'];
        }

        return $return;
    }

    public function getParticipantsBySchedule($schedule_prevat_id = null)
    {
        try {
            $scheduleCompanyParticipants = ScheduleCompanyParticipants::query()->with([
                'schedule_company'=> fn ($query) => $query->withoutGlobalScopes(),
                'participant' => fn ($query) => $query->withoutGlobalScopes(),
                'participant.role', 'schedule_company.company', 'schedule_company.schedule.training'])
                ->where('presence',1)
                ->whereHas('schedule_company', function($query) use ($schedule_prevat_id){
                    $query->withoutGlobalScopes()->where('schedule_prevat_id', $schedule_prevat_id);
                })->get();

            $participants = [];

            foreach ($scheduleCompanyParticipants as $key => $itemParticipant) {
                $participants[$key] = [
                    "id" => $itemParticipant['participant_id'],
                    "name" => $itemParticipant['participant']['name'],
                    "taxpayer_registration" => $itemParticipant['participant']['taxpayer_registration'],
                    "role" => $itemParticipant['participant']['role']['name'],
                    "company" => $itemParticipant['participant']['company']['name'] ?? $itemParticipant['participant']['company']['fantasy_name'],
                    "company_id" => $itemParticipant['participant']['company']['id'],
                    "contract_id" => $itemParticipant['participant']['contract_id'],
                    "quantity" => 1,
                    "value" => $itemParticipant['schedule_company']['schedule']['training']['value'],
                    "total_value" => $itemParticipant['schedule_company']['schedule']['training']['value'] * 1,
                    "note" => null,
                    'status' => 'Reprovado',
                    "table" => 'table-default',
                    "presence" => $itemParticipant['presence'],
                    "icon" => '',
                ];
            }

            return [
                'status' => 'success',
                'data' => $participants,
                'code' => 200
            ];
        } catch (\Exception $exception) {
            return [
                'status' => 'error',
                'code' => 400,
                'message' => 'Erro na requisição'
            ];
        }
    }

    public function calculateTotalValue($key, $quantity)
    {
        $participants = session()->get('participants');

        $participants[$key]['quantity'] = $quantity ;
        $participants[$key]['total_value'] = $quantity * $participants[$key]['value'];

        session()->put('participants', $participants);
    }

    public function addNote($key, $value)
    {
        if($value > 7) {
            $table = 'table-primary';
            $status = 'Aprovado';
        } else {
            $table = 'table-danger';
            $status = 'Reprovado';
        }

        $participants = session()->get('participants');

        $participants[$key]['note'] = $value;
        $participants[$key]['table'] = $table;
        $participants[$key]['status'] = $status;

        session()->put('participants', $participants);
    }

    public function validatePresence($key, $value)
    {
        if($value) {
            $presence = true;
        } else {
            $presence = false;
        }

        $participants = session()->get('participants');

        $participants[$key]['presence'] = $presence;

        session()->put('participants', $participants);
    }



    public function calculatePriceTotal($schedule_company_id)
    {
        $scheduleCompanyDB = ScheduleCompany::query()-with(['participants'])->findOrFail($schedule_company_id);
        $scheduleCompanyDB->update([
            'price_total' => $scheduleCompanyDB['participants']->sum('value')
        ]);
    }
}
