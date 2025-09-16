<?php

namespace App\Repositories\Financial;

use App\Models\Countries;
use App\Models\ServiceOrdersContact;
use App\Requests\CountryRequest;
use App\Requests\ServiceOrderContactRequest;
use Illuminate\Support\Facades\DB;
use PHPUnit\Exception;

class ServiceOrderContactRepository
{
    public function index($orderBy)
    {
        try {
            $serviceOrderContactDB = ServiceOrdersContact::query();

            $serviceOrderContactDB->orderBy($orderBy['column'], $orderBy['order']);

            $serviceOrderContactDB = $serviceOrderContactDB->get();

            return [
                'status' => 'success',
                'data' => $serviceOrderContactDB,
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

    public function create($request)
    {
        $serviceOrderContactRequest = new ServiceOrderContactRequest();
        $requestValidated = $serviceOrderContactRequest->validate($request);

        try {
            DB::beginTransaction();

            $serviceOrderContactDB = ServiceOrdersContact::query()->create($requestValidated);

            DB::commit();
            return [
                'status' => 'success',
                'data' => $serviceOrderContactDB,
                'code' => 200,
                'message' => 'Dados de Faturamento cadastrados com sucesso !'
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
        $serviceOrderContactRequest = new ServiceOrderContactRequest();
        $requestValidated = $serviceOrderContactRequest->validate($request, $id);

        try {
            DB::beginTransaction();

            $serviceOrderContactDB = ServiceOrdersContact::query()->with(['order' => fn($query) => $query->withoutGlobalScopes()])->findOrFail($id);

            $serviceOrderContactDB->update($requestValidated);
            $serviceOrderContactDB['order']->update($requestValidated['order']);

            $serviceOrderRepository = new ServiceOrderRepository();
            $serviceOrderRepository->generatePDF($serviceOrderContactDB['service_order_id']);
            $serviceOrderRepository->generateExcel($serviceOrderContactDB['service_order_id']);

            DB::commit();
            return [
                'status' => 'success',
                'data' => $serviceOrderContactDB,
                'code' => 200,
                'message' => 'Dados de Faturamento atualizado com sucesso !'
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
            $serviceOrderContactDB = ServiceOrdersContact::query()->with(['order' => fn($query) => $query->withoutGlobalScopes()])->where('service_order_id', $id)->first();

            return [
                'status' => 'success',
                'data' => $serviceOrderContactDB,
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

            $serviceOrderContactDB = ServiceOrdersContact::query()->findOrFail($id);
            $serviceOrderContactDB->delete();

            DB::commit();
            return [
                'status' => 'success',
                'data' => $serviceOrderContactDB,
                'code' => 200,
                'message' => 'Dados de Faturamento deletado com sucesso !'
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
