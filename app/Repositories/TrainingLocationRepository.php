<?php

namespace App\Repositories;

use App\Models\Training;
use App\Models\TrainingLocation;
use App\Requests\TrainingLocationRequest;
use App\Requests\TrainingRequest;
use Illuminate\Support\Facades\DB;
use PHPUnit\Exception;

class TrainingLocationRepository
{

    public function index($orderBy)
    {
        try {
            $trainingLocationDB = TrainingLocation::query();

            $trainingLocationDB->orderBy($orderBy['column'], $orderBy['order']);

            $trainingLocationDB = $trainingLocationDB->get();

            return [
                'status' => 'success',
                'data' => $trainingLocationDB,
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
        $trainingLocationRequest = new TrainingLocationRequest();
        $requestValidated = $trainingLocationRequest->validate($request);

        try {
            DB::beginTransaction();

            $trainingLocationDB = TrainingLocation::query()->create($requestValidated);

            DB::commit();
            return [
                'status' => 'success',
                'data' => $trainingLocationDB,
                'code' => 200,
                'message' => 'Local de Treinamento cadastrado com sucesso !'
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
        $trainingLocationRequest = new TrainingLocationRequest();
        $requestValidated = $trainingLocationRequest->validate($request, $id);

        try {
            DB::beginTransaction();

            $trainingLocationDB = TrainingLocation::query()->findOrFail($id);
            $trainingLocationDB->update($requestValidated);

            DB::commit();
            return [
                'status' => 'success',
                'data' => $trainingLocationDB,
                'code' => 200,
                'message' => 'Local de Treinamento atualizado com sucesso !'
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
            $trainingLocationDB = TrainingLocation::query()->find($id);

            return [
                'status' => 'success',
                'data' => $trainingLocationDB,
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

            $trainingLocationDB = TrainingLocation::query()->findOrFail($id);
            $trainingLocationDB->delete();

            DB::commit();
            return [
                'status' => 'success',
                'data' => $trainingLocationDB,
                'code' => 200,
                'message' => 'Local de Treinamento deletado com sucesso !'
            ];

        } catch (\Exception $exception) {
            return [
                'status' => 'error',
                'code' => 400,
                'message' => 'Erro ao deletar'
            ];
        }
    }

    public function getSelectTrainingLocation()
    {
        $trainingLocationDB = TrainingLocation::query()->whereStatus('Ativo')->orderBy('name', 'ASC')->get();

        $return = [];

        $return[0]['label'] = 'Escolha';
        $return[0]['value'] = '';

        if($trainingLocationDB->count() > 0) {
        foreach ($trainingLocationDB as $key => $itemUser) {
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
