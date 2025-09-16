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
            \Log::info('=== COMPANIES REPORT - BUSCA NO BANCO ===');
            \Log::info('Filtros aplicados:', $filterData ?? []);
            
            $companyDB = Company::query();

            if(isset($filterData['dates']) && $filterData['dates'] != null) {
                    $dates = explode(' to ', $filterData['dates']);
                    if(isset($dates[1])) {
                        $companyDB->whereBetween('created_at', [$dates[0], $dates[1]]);
                        \Log::info('Filtro por período de criação: ' . $dates[0] . ' a ' . $dates[1]);
                    } else {
                        $companyDB->where('created_at', '=', $dates[0]);
                        \Log::info('Filtro por data de criação específica: ' . $dates[0]);
                    }
            }

            if($orderBy) {
                $companyDB->orderBy($orderBy['column'], $orderBy['order']);
                \Log::info('Ordenação: ' . $orderBy['column'] . ' ' . $orderBy['order']);
            }

            if($pageSize) {
                $companyDB = $companyDB->paginate($pageSize);
                \Log::info('Paginação: ' . $pageSize . ' itens por página');
            } else {
                $companyDB = $companyDB->get();
                \Log::info('Busca sem paginação - Total de registros: ' . $companyDB->count());
            }

            // Log detalhado dos dados encontrados
            \Log::info('Dados encontrados no CompaniesReport:');
            foreach ($companyDB as $index => $company) {
                \Log::info("Empresa " . ($index + 1) . ":", [
                    'ID' => $company->id ?? 'N/A',
                    'Nome Fantasia' => $company->fantasy_name ?? 'N/A',
                    'Razão Social' => $company->corporate_name ?? 'N/A',
                    'CNPJ' => $company->cnpj ?? 'N/A',
                    'Email' => $company->email ?? 'N/A',
                    'Status' => $company->status ?? 'N/A',
                    'Data Criação' => $company->created_at ?? 'N/A'
                ]);
            }

            return [
                'status' => 'success',
                'data' => $companyDB,
                'code' => 200,

            ];
        } catch (Exception $exception){
            \Log::error('Erro no CompaniesReport: ' . $exception->getMessage());
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
