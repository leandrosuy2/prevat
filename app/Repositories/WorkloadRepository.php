<?php

namespace App\Repositories;

use App\Models\WorkLoad;
use App\Requests\WorkLoadRequest;
use Illuminate\Support\Facades\DB;
use PHPUnit\Exception;

class WorkloadRepository
{
    public function index($orderBy)
    {
        try {
            $workLoadDB = WorkLoad::query();

            $workLoadDB->orderBy($orderBy['column'], $orderBy['order']);

            $workLoadDB = $workLoadDB->get();

            return [
                'status' => 'success',
                'data' => $workLoadDB,
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
        $workLoadRequest = new WorkLoadRequest();
        $requestValidated = $workLoadRequest->validate($request);

        try {
            DB::beginTransaction();

            $workLoadDB = WorkLoad::query()->create($requestValidated);

            DB::commit();
            return [
                'status' => 'success',
                'data' => $workLoadDB,
                'code' => 200,
                'message' => 'Carga horária cadastrada com sucesso !'
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

    public function update($request, $id,)
    {
        $workLoadRequest = new WorkLoadRequest();
        $requestValidated = $workLoadRequest->validate($request, $id);

        try {
            DB::beginTransaction();

            $workLoadDB = WorkLoad::query()->findOrFail($id);
            $workLoadDB->update($requestValidated);

            DB::commit();
            return [
                'status' => 'success',
                'data' => $workLoadDB,
                'code' => 200,
                'message' => 'Carga horária atualizada com sucesso !'
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
            $workLoadDB = WorkLoad::query()->find($id);

            return [
                'status' => 'success',
                'data' => $workLoadDB,
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

            $workLoadDB = WorkLoad::query()->findOrFail($id);
            $workLoadDB->delete();

            DB::commit();
            return [
                'status' => 'success',
                'data' => $workLoadDB,
                'code' => 200,
                'message' => 'Carga horária deletada com sucesso !'
            ];

        } catch (\Exception $exception) {
            return [
                'status' => 'error',
                'code' => 400,
                'message' => 'Erro ao deletar'
            ];
        }
    }

    public function getSelectWorkLoad()
    {
        $workLoadDB = WorkLoad::query()->whereStatus('Ativo')->orderBy('name', 'ASC')->get();

        $return = [];

        $return[0]['label'] = 'Escolha';
        $return[0]['value'] = '';

        if($workLoadDB->count() > 0) {
        foreach ($workLoadDB as $key => $itemUser) {
            $return[$key +1]['label'] = $itemUser['name'];
            $return[$key +1]['value'] = $itemUser['id'];
            }
        } else {
            $return[0]['label'] = 'Sem Cadastro';
            $return[0]['value'] = '';
        }
        return $return;
    }

}
