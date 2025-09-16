<?php

namespace App\Repositories\Reports;

use App\Jobs\ExportCompaniesJob;
use App\Jobs\ExportTrainingsJob;
use App\Models\ScheduleCompany;
use Illuminate\Support\Facades\Bus;
use PHPUnit\Exception;

class TrainingReport
{
    public function index($orderBy = null, $filterData = null, $pageSize = null)
    {

        try {
            $scheduleCompanyDB = ScheduleCompany::query()->with(['company','schedule.training', 'participants'])->withoutGlobalScopes();

            if(isset($filterData['company_id']) && $filterData['company_id'] != null) {
                $scheduleCompanyDB->where('company_id', $filterData['company_id']);
            }

            if(isset($filterData['dates']) && $filterData['dates'] != null) {
                $scheduleCompanyDB->whereHas('schedule', function($query) use ($filterData){
                    $dates = explode(' to ', $filterData['dates']);
                    if(isset($dates[1])) {
                        $query->whereBetween('date_event', [$dates[0], $dates[1]]);
                    } else {
                        $query->where('date_event', '=', $dates[0]);
                    }
                });
            }

            if($orderBy) {
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
                'code' => 200,

            ];
        } catch (Exception $exception){
            return [
                'status' => 'error',
                'code' => 400,
                'message' => 'Erro na requisição'
            ];
        }
    }

    public function exportExcel($orderBy = null, $filterData = null)
    {
        try{

            sleep(1);

            $batch = Bus::batch([
                new ExportTrainingsJob($orderBy, $filterData),
            ])->dispatch();

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

}
