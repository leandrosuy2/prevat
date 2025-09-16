<?php

namespace App\Repositories\Financial;

use App\Jobs\ExportScheduleCompaniesByParticipants;
use App\Jobs\ExportScheduleCompaniesJob;
use App\Models\ScheduleCompany;
use App\Models\ScheduleCompanyParticipants;
use Illuminate\Support\Facades\Bus;
use PHPUnit\Exception;

class FinancialRepository
{
    public function index($orderBy = null, $filterData = null, $pageSize = null)
    {
        try {
            $scheduleCompanyDB = ScheduleCompany::query()->with(['schedule.training', 'schedule.location', 'schedule.room', 'schedule.first_time', 'schedule.second_time', 'company',
                'participantsPresent', 'participantsAusent']);

            $scheduleCompanyDB->withoutGlobalScopes();

            $scheduleCompanyDB->whereHas('schedule', function ($query) {
                $query->whereStatus('Concluído');
            });

            if(isset($filterData['company_id']) && $filterData['company_id'] != null) {
                $scheduleCompanyDB->where('company_id', $filterData['company_id']);
            }

            if(isset($filterData['schedule_prevat_id']) && $filterData['schedule_prevat_id'] != null) {
                $scheduleCompanyDB->where('schedule_prevat_id', $filterData['schedule_prevat_id']);
            }

            if(isset($filterData['dates']) && $filterData['dates'] != null) {
                $scheduleCompanyDB->whereHas('schedule', function($query) use ($filterData) {
                    $dates = explode(' to ', $filterData['dates']);
                    if(isset($dates[1])) {
                        $query->whereBetween('date_event', [$dates[0], $dates[1]]);
                    } else {
                        $query->where('date_event', '=', $dates[0]);
                    }
                });
            }

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

    public function exportExcel($orderBy = null, $filterData = null, $type)
    {

        try{

            sleep(1);

            if($type == 'company') {
                $batch = Bus::batch([
                    new ExportScheduleCompaniesJob($orderBy, $filterData),
                ])->dispatch();
            } elseif($type == 'participant') {
                $batch = Bus::batch([
                    new ExportScheduleCompaniesByParticipants($orderBy, $filterData),
                ])->dispatch();
            }


            return [
                'status' => 'success',
                'data' => $batch,
                'code' => 200,
                'message' => 'Exportação feita com sucesso !'
            ];

        } catch (Exception $exception) {
            return [
                'status' => 'error',
                'code' => 400,
                'message' => 'Erro ao exportar'
            ];
        }
    }

    public function exportPDF($orderBy = null, $filterData = null, $pageSize = null)
    {
        try {

        $scheduleCompanyParticipantsDB = ScheduleCompanyParticipants::query()->with([
            'schedule_company'  => fn ($query) => $query->withoutGlobalScopes(),
            'schedule_company.schedule'  => fn ($query) => $query->withoutGlobalScopes(),
            'schedule_company.schedule.training'  => fn ($query) => $query->withoutGlobalScopes(),
            'participant'=> fn ($query) => $query->withoutGlobalScopes()
        ])->where('presence', 1);

        $scheduleCompanyParticipantsDB->withoutGlobalScopes();

        $scheduleCompanyParticipantsDB->whereHas('schedule_company', function ($query) {
            $query->withoutGlobalScopes()->whereHas('schedule', function ($q){
                $q->whereStatus('Concluído');
            });
        });

        if($orderBy) {
            $scheduleCompanyParticipantsDB->orderBy($orderBy['column'], $orderBy['order']);
        }

        if(isset($filterData['company_id']) && $filterData['company_id'] != null) {
            $scheduleCompanyParticipantsDB->whereHas('schedule_company', function($query) use ($filterData) {
                $query->withoutGlobalScopes()->where('company_id', $filterData['company_id']);
            });
        }

        if(isset($filterData['schedule_prevat_id']) && $filterData['schedule_prevat_id'] != null) {
            $scheduleCompanyParticipantsDB->whereHas('schedule_company', function($query) use($filterData){
                $query->withoutGlobalScopes()->where('schedule_prevat_id', $filterData['schedule_prevat_id']);
            });
        }

        if(isset($filterData['dates']) && $filterData['dates'] != null) {
            $scheduleCompanyParticipantsDB->whereHas('schedule_company.schedule', function($query) use ($filterData){
                $dates = explode(' to ', $filterData['dates']);
                if(isset($dates[1])) {
                    $query->withoutGlobalScopes()->whereBetween('date_event', [$dates[0], $dates[1]]);
                } else {
                    $query->withoutGlobalScopes()->where('date_event', '=', $dates[0]);
                }
            });
        }

        $scheduleCompanyParticipantsDB = $scheduleCompanyParticipantsDB->get();

            return [
                'status' => 'success',
                'data' => $scheduleCompanyParticipantsDB,
                'code' => 200,
                'message' => 'Exportação feita com sucesso !'
            ];

        } catch (Exception $exception) {
            return [
                'status' => 'error',
                'code' => 400,
                'message' => 'Erro ao exportar'
            ];
        }
    }

    public function getReleasesByCompany($company_id = null, $contract_id = null, $releases, $filterData)
    {
        $scheduleCompanyDB = ScheduleCompany::query()->with(['schedule.training', 'schedule.location', 'schedule.room', 'schedule.first_time', 'schedule.second_time', 'company',
            'participantsPresent', 'participantsAusent']);
        $scheduleCompanyDB->withoutGlobalScopes();

        $scheduleCompanyDB->whereNotIn('id', $releases);

        if($company_id) {
            $scheduleCompanyDB->where('company_id', $company_id);
        }

        if($contract_id) {
            $scheduleCompanyDB->where('contract_id', $contract_id);
        }

        $scheduleCompanyDB->where('invoiced', 'Não');

        if(isset($filterData['search']) && $filterData['search'] != null){
            $scheduleCompanyDB->whereHas('schedule.training' , function($query) use ($filterData){
                $query->where('name', 'LIKE', '%'.$filterData['search'].'%');
            });
        }
        if(isset($filterData['start_date']) && $filterData['start_date'] != null && $filterData['end_date'] == null){
            $scheduleCompanyDB->whereHas('schedule' , function($query) use ($filterData){
                $query->whereDate('date_event', '=', $filterData['start_date']);

            });
        }

        if(isset($filterData['start_date']) && $filterData['start_date'] != null &&  $filterData['end_date'] != null){
            $scheduleCompanyDB->whereHas('schedule' , function($query) use ($filterData){
                $query->whereBetween('date_event',  [$filterData['start_date'], $filterData['end_date']]);
            });
        }

        if(isset($filterData['end_date']) && $filterData['end_date'] != null && $filterData['start_date'] == null){
            $scheduleCompanyDB->whereHas('schedule' , function($query) use ($filterData){
                $query->whereDate( 'date_event', '=', $filterData['end_date']);
            });
        }

        $scheduleCompanyDB->whereHas('schedule', function ($query) {
            $query->whereStatus('Concluído');
        });

        $scheduleCompanyDB = $scheduleCompanyDB->get();

        return $scheduleCompanyDB;
    }
}
