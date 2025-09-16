<?php

namespace App\Repositories\Reports;

use App\Jobs\ExportCompaniesJob;
use App\Models\Company;
use Illuminate\Support\Facades\Bus;
use PHPUnit\Exception;

class CompaniesReport
{
    public function index($orderBy = null, $filterData = null, $pageSize = null)
    {

        try {
            $companyDB = Company::query();

            if(isset($filterData['dates']) && $filterData['dates'] != null) {
                    $dates = explode(' to ', $filterData['dates']);
                    if(isset($dates[1])) {
                        $companyDB->whereBetween('created_at', [$dates[0], $dates[1]]);
                    } else {
                        $companyDB->where('created_at', '=', $dates[0]);
                    }
            }

            if($orderBy) {
                $companyDB->orderBy($orderBy['column'], $orderBy['order']);
            }

            if($pageSize) {
                $companyDB = $companyDB->paginate($pageSize);
            } else {
                $companyDB = $companyDB->get();
            }

            return [
                'status' => 'success',
                'data' => $companyDB,
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
                new ExportCompaniesJob($orderBy, $filterData),
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

    public function exportPDF($orderBy = null, $filterData = null)
    {
        try{

            sleep(2);

            $batch = Bus::batch([
                new ExportCompaniesJob($orderBy, $filterData),
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
