<?php

namespace App\Repositories;

use App\Models\TrainingTeam;
use App\Requests\TrainingTeamRequest;
use Illuminate\Support\Facades\DB;
use PHPUnit\Exception;

class TrainingTeamRepository
{

    public function index($orderBy)
    {
        try {
            $trainingTeamDB = TrainingTeam::query();

            $trainingTeamDB->orderBy($orderBy['column'], $orderBy['order']);

            $trainingTeamDB = $trainingTeamDB->get();

            return [
                'status' => 'success',
                'data' => $trainingTeamDB,
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
        $trainingTeamRequest = new TrainingTeamRequest();
        $requestValidated = $trainingTeamRequest->validate($request);

        try {
            DB::beginTransaction();

            $trainingTeamDB = TrainingTeam::query()->create($requestValidated);

            DB::commit();
            return [
                'status' => 'success',
                'data' => $trainingTeamDB,
                'code' => 200,
                'message' => 'Turma cadastrada com sucesso !'
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
        $trainingTeamRequest = new TrainingTeamRequest();
        $requestValidated = $trainingTeamRequest->validate($request, $id);

        try {
            DB::beginTransaction();

            $trainingTeamDB = TrainingTeam::query()->findOrFail($id);
            $trainingTeamDB->update($requestValidated);

            DB::commit();
            return [
                'status' => 'success',
                'data' => $trainingTeamDB,
                'code' => 200,
                'message' => 'Turma atualizada com sucesso !'
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
            $trainingTeamDB = TrainingTeam::query()->find($id);

            return [
                'status' => 'success',
                'data' => $trainingTeamDB,
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

            $trainingTeamDB = TrainingTeam::query()->findOrFail($id);
            $trainingTeamDB->delete();

            DB::commit();
            return [
                'status' => 'success',
                'data' => $trainingTeamDB,
                'code' => 200,
                'message' => 'Turma deletada com sucesso !'
            ];

        } catch (\Exception $exception) {
            return [
                'status' => 'error',
                'code' => 400,
                'message' => 'Erro ao deletar'
            ];
        }
    }

    public function getSelectTrainingTeam()
    {
        $trainingTeamDB = TrainingTeam::query()->whereStatus('Ativo')->orderBy('name', 'ASC')->get();

        $return = [];
        $return[0]['label'] = 'Escolha';
        $return[0]['value'] = '';

        if($trainingTeamDB->count() > 0) {
            foreach ($trainingTeamDB as $key => $itemTrainingTeam) {
                $return[$key +1]['label'] = $itemTrainingTeam['name'];
                $return[$key +1]['value'] = $itemTrainingTeam['id'];
            }
        } else {
            $return[0]['label'] = 'Sem Cadastro';
            $return[0]['value'] = '';
        }

        return $return;
    }
}
