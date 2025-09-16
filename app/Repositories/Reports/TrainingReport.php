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
            \Log::info('=== TRAINING REPORT - BUSCA NO BANCO ===');
            \Log::info('Filtros aplicados:', $filterData ?? []);
            
            $scheduleCompanyDB = ScheduleCompany::query()->with(['company','schedule.training', 'participants'])->withoutGlobalScopes();

            if(isset($filterData['company_id']) && $filterData['company_id'] != null) {
                $scheduleCompanyDB->where('company_id', $filterData['company_id']);
                \Log::info('Filtro por empresa ID: ' . $filterData['company_id']);
            }

            if(isset($filterData['dates']) && $filterData['dates'] != null) {
                $scheduleCompanyDB->whereHas('schedule', function($query) use ($filterData){
                    $dates = explode(' to ', $filterData['dates']);
                    if(isset($dates[1])) {
                        $query->whereBetween('date_event', [$dates[0], $dates[1]]);
                        \Log::info('Filtro por período: ' . $dates[0] . ' a ' . $dates[1]);
                    } else {
                        $query->where('date_event', '=', $dates[0]);
                        \Log::info('Filtro por data específica: ' . $dates[0]);
                    }
                });
            }

            if($orderBy) {
                $scheduleCompanyDB->orderBy($orderBy['column'], $orderBy['order']);
                \Log::info('Ordenação: ' . $orderBy['column'] . ' ' . $orderBy['order']);
            }

            if($pageSize) {
                $scheduleCompanyDB = $scheduleCompanyDB->paginate($pageSize);
                \Log::info('Paginação: ' . $pageSize . ' itens por página');
            } else {
                $scheduleCompanyDB = $scheduleCompanyDB->get();
                \Log::info('Busca sem paginação - Total de registros: ' . $scheduleCompanyDB->count());
            }

            // Log detalhado dos dados encontrados
            \Log::info('Dados encontrados no TrainingReport:');
            foreach ($scheduleCompanyDB as $index => $item) {
                \Log::info("Item " . ($index + 1) . ":", [
                    'ID' => $item->id ?? 'N/A',
                    'Data Evento' => optional($item->schedule)->date_event ?? 'N/A',
                    'Treinamento' => optional($item->schedule->training)->name ?? 'N/A',
                    'Empresa' => optional($item->company)->fantasy_name ?? 'N/A',
                    'Participantes' => $item->participants->count() ?? 0
                ]);
            }

            return [
                'status' => 'success',
                'data' => $scheduleCompanyDB,
                'code' => 200,

            ];
        } catch (Exception $exception){
            \Log::error('Erro no TrainingReport: ' . $exception->getMessage());
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
