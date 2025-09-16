<?php

namespace App\Repositories;

use App\Models\Company;
use App\Models\Participant;
use App\Models\ScheduleCompany;
use App\Models\ScheduleCompanyParticipants;
use App\Models\SchedulePrevat;
use App\Models\TrainingParticipants;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class ScheduleCompanyParticipantsRepository
{
    public function getParticipantsScheduleByCompany($company_id = null, $orderBy = null, $filterData = null, $pageSize = null)
    {
        try {
            DB::beginTransaction();

            $scheduleCompanyParticpantsDB = ScheduleCompanyParticipants::query()->with([
                'schedule_company',
                'participant' => fn ($query) => $query->withoutGlobalScopes(),
                'participant.contract' => fn ($query) => $query->withoutGlobalScopes(),
                'participant.role' => fn ($query) => $query->withoutGlobalScopes()
            ]);

            if(isset($filterData['search']) && $filterData['search'] != null){
                $scheduleCompanyParticpantsDB->whereHas('participant', function($query) use ($filterData){
                    $query->withoutGlobalScopes()->where('name', 'LIKE', '%'.$filterData['search'].'%');
                    $query->withoutGlobalScopes()->orWhere('taxpayer_registration', 'LIKE', '%'.$filterData['search'].'%');
                });
            }

            if($orderBy) {
                $scheduleCompanyParticpantsDB->whereHas('participant', function($query) use ($orderBy){
                    $query->withoutGlobalScopes()->orderBy($orderBy['column'], $orderBy['order']);
                });
            }

            if($company_id) {
                $scheduleCompanyParticpantsDB->where('schedule_company_id', $company_id);
            }

            if($pageSize) {
               $scheduleCompanyParticpantsDB = $scheduleCompanyParticpantsDB->paginate($pageSize);
            } else {
               $scheduleCompanyParticpantsDB = $scheduleCompanyParticpantsDB->get();
            }


            DB::commit();
            return [
                'status' => 'success',
                'data' => $scheduleCompanyParticpantsDB,
                'code' => 200,

            ];

        } catch (\Exception $exception) {

            return [
                'status' => 'error',
                'code' => 400,
                'message' => 'Erro na requisição'
            ];
        }
    }

    public function getParticipantsSchedulePrevat($schedule_id, $orderBy = null, $filterData = null, $pageSize = null)
    {
        try {
            DB::beginTransaction();

            $scheduleCompanyParticpantsDB = ScheduleCompanyParticipants::with([
                'schedule_company' => fn ($query) => $query->withoutGlobalScopes(),
                'schedule_company.company',
                'schedule_company.schedule',
                'participant' => fn ($query) => $query->withoutGlobalScopes(),
                'participant.company' => fn ($query) => $query->withoutGlobalScopes(),
            ]);


            $scheduleCompanyParticpantsDB->whereHas('participant', function ($query) {
                $query->withoutGlobalScopes()->whereHas('company', function ($q) {
                    $q->orderBy('name', 'ASC');
                });
            });

            if(isset($filterData['search']) && $filterData['search'] != null) {
                $scheduleCompanyParticpantsDB->whereHas('participant', function($query) use ($filterData){
                    $query->withoutGlobalScopes()->where('name', 'LIKE', '%'.$filterData['search'].'%');
                });
            }

            if(isset($filterData['company_id']) && $filterData['company_id'] != null) {
                $scheduleCompanyParticpantsDB->whereHas('participant', function($query) use ($filterData){
                    $query->withoutGlobalScopes()->where('company_id', $filterData['company_id']);
                });
            }

            $scheduleCompanyParticpantsDB->whereHas('schedule_company', function($query) use ($schedule_id){
                $query->withoutGlobalScopes()->where('schedule_prevat_id', $schedule_id);
            });

            if($pageSize) {
                $scheduleCompanyParticpantsDB = $scheduleCompanyParticpantsDB->paginate($pageSize);
            } else {
                $scheduleCompanyParticpantsDB = $scheduleCompanyParticpantsDB->get();
            }

            DB::commit();
            return [
                'status' => 'success',
                'data' => $scheduleCompanyParticpantsDB,
                'code' => 200,

            ];

        } catch (\Exception $exception) {

            return [
                'status' => 'error',
                'code' => 400,
                'message' => 'Erro na requisição'
            ];
        }
    }

    public function create($schedule_id, $participant_id)
    {
        try {
            DB::beginTransaction();
            $scheduleCompanyDB = ScheduleCompany::query()->with(['schedule', 'participants'])->withoutGlobalScopes()->findOrFail($schedule_id);

            if($scheduleCompanyDB['schedule']['vacancies_available'] == 0) {
                return [
                    'status' => 'error',
                    'message' => 'Quantidade de vagas disponiveis do treinamento foi atingido'
                ];
            }

            $scheduleCompanyParticpantsDB = ScheduleCompanyParticipants::query()->create([
                'schedule_company_id' => $schedule_id,
                'participant_id' => $participant_id,
                'presence' => true
            ]);

            $scheduleCompanyDB->fresh();

            $scheduleCompanyDB->update([
                'total_participants' => $scheduleCompanyDB['participants']->count() + 1,
            ]);


            $schedulePrevatRepository = new SchedulePrevatRepository();
            $schedulePrevatRepository->decrementVacany($scheduleCompanyDB['schedule_prevat_id'], 1);

            $participantRepository = new ParticipantRepository();
            $participantRepository->generateListPDF($scheduleCompanyDB['id']);

            DB::commit();
            return [
                'status' => 'success',
                'data' => $scheduleCompanyParticpantsDB,
                'code' => 200,
                'message' => 'Participante adicionado com sucesso !'
            ];

        } catch (\Exception $exception) {

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

            $scheduleCompanyParticpantsDB = ScheduleCompanyParticipants::query()->with(['schedule_company' => fn ($query) => $query->withoutGlobalScopes()])->findOrFail($id);

            $schedulePrevatRepository = new SchedulePrevatRepository();

            if($scheduleCompanyParticpantsDB['presence'] == true) {
                $schedulePrevatRepository->incrementVacancy($scheduleCompanyParticpantsDB['schedule_company']['schedule_prevat_id'], 1);
            } elseif ($scheduleCompanyParticpantsDB['presence'] == false) {
                $schedulePrevatDB = SchedulePrevat::query()->find($scheduleCompanyParticpantsDB['schedule_company']['schedule_prevat_id']);
                $schedulePrevatDB->decrement('absences', 1);
            }

            $scheduleCompanyParticpantsDB['schedule_company']->decrement('total_participants', 1);

            $scheduleCompanyParticpantsDB->delete();

            $participantRepository = new ParticipantRepository();
            $participantRepository->generateListPDF($scheduleCompanyParticpantsDB['schedule_company']['id']);

            $scheduleCompanyDB = ScheduleCompany::query()->with(['participantsPresent'])->withoutGlobalScopes()->findOrFail($scheduleCompanyParticpantsDB['schedule_company_id']);
            $scheduleCompanyDB->update([
                'price_total' => $scheduleCompanyDB['participantsPresent']->sum('value')
            ]);

            DB::commit();
            return [
                'status' => 'success',
                'data' => $scheduleCompanyParticpantsDB,
                'code' => 200,
                'message' => 'Participante deletado com sucesso !'
            ];

        } catch (\Exception $exception) {
            return [
                'status' => 'error',
                'code' => 400,
                'message' => 'Erro ao deletar'
            ];
        }
    }

    public function validatePresence($id, $presence)
    {
        $scheduleCompanyParticipantsDB = ScheduleCompanyParticipants::query()->with(['schedule_company' => fn ($query) => $query->withoutGlobalScopes()])->find($id);

        $schedulePrevatDB = SchedulePrevat::query()->findOrFail($scheduleCompanyParticipantsDB['schedule_company']['schedule_prevat_id']);

        if($presence == false) {
            $schedulePrevatDB->increment('vacancies_available', 1);
            $schedulePrevatDB->increment('absences', 1);
            $schedulePrevatDB->decrement('vacancies_occupied', 1);
        } else {
            $schedulePrevatDB->decrement('vacancies_available', 1);
            $schedulePrevatDB->decrement('absences', 1);
            $schedulePrevatDB->increment('vacancies_occupied', 1);
        }

        $scheduleCompanyParticipantsDB->update([
            'presence' => $presence,
        ]);

        $scheduleCompanyDB = ScheduleCompany::with(['participantsPresent'])->withoutGlobalScopes()->findOrFail($scheduleCompanyParticipantsDB['schedule_company_id']);

        $scheduleCompanyDB->update([
            'price_total' => $scheduleCompanyDB['participantsPresent']->sum('value')
        ]);

    }

    public function calculateTotalValueByQuanity($id, $quantity)
    {
        $scheduleCompanyParticipantsDB = ScheduleCompanyParticipants::query()->with('schedule_company')->find($id);

        $scheduleCompanyParticipantsDB->update([
            'quantity' => $quantity,
            'total_value' => $quantity * $scheduleCompanyParticipantsDB['value'],
        ]);

        $scheduleCompanyDB = ScheduleCompany::query()->with(['participants'])->withoutGlobalScopes()->findOrFail($scheduleCompanyParticipantsDB['schedule_company_id']);
        $scheduleCompanyDB->update([
            'price_total' => $scheduleCompanyDB['participants']->sum('total_value')
        ]);
    }

    public function calculateTotalValueByValue($id, $value)
    {
        $scheduleCompanyParticipantsDB = ScheduleCompanyParticipants::query()->with('schedule_company')->find($id);

        $scheduleCompanyParticipantsDB->update([
            'value' => formatDecimal($value),
            'total_value' => $scheduleCompanyParticipantsDB['quanity'] * formatDecimal($value),
        ]);

        $scheduleCompanyDB = ScheduleCompany::query()->with(['participants'])->withoutGlobalScopes()->findOrFail($scheduleCompanyParticipantsDB['schedule_company_id']);
        $scheduleCompanyDB->update([
            'price_total' => $scheduleCompanyDB['participants']->sum('total_value')
        ]);
    }
}
