<?php

namespace App\Repositories;

use App\Models\TrainingRoom;
use App\Requests\TrainingRoomRequest;
use Illuminate\Support\Facades\DB;
use PHPUnit\Exception;
use Spatie\Permission\Models\Role;

class TrainingRoomRepository
{
    public function index($orderBy)
    {
        try {
            $trainingRoomDB = TrainingRoom::query();

            $trainingRoomDB->orderBy($orderBy['column'], $orderBy['order']);

            $trainingRoomDB = $trainingRoomDB->get();

            return [
                'status' => 'success',
                'data' => $trainingRoomDB,
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
        $trainingRoomRequest = new TrainingRoomRequest();
        $requestValidated = $trainingRoomRequest->validate($request);

        $requestValidated['guard_name'] = 'web';

        try {
            DB::beginTransaction();

            $trainingRoomDB = TrainingRoom::query()->create($requestValidated);

            DB::commit();
            return [
                'status' => 'success',
                'data' => $trainingRoomDB,
                'code' => 200,
                'message' => 'Sala de Treinamento cadastrada com sucesso !'
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
        $trainingRoomRequest = new TrainingRoomRequest();
        $requestValidated = $trainingRoomRequest->validate($request, $id);

        try {
            DB::beginTransaction();

            $trainingRoomDB = TrainingRoom::query()->findOrFail($id);
            $trainingRoomDB->update($requestValidated);

            DB::commit();
            return [
                'status' => 'success',
                'data' => $trainingRoomDB,
                'code' => 200,
                'message' => 'Sala de Trainamento atualizada com sucesso !'
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
            $trainingRoomDB = TrainingRoom::query()->find($id);

            return [
                'status' => 'success',
                'data' => $trainingRoomDB,
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

            $trainingRoomDB = TrainingRoom::query()->findOrFail($id);
            $trainingRoomDB->delete();

            DB::commit();
            return [
                'status' => 'success',
                'data' => $trainingRoomDB,
                'code' => 200,
                'message' => 'Sala de Treinamento deletada com sucesso !'
            ];

        } catch (\Exception $exception) {
            return [
                'status' => 'error',
                'code' => 400,
                'message' => 'Erro ao deletar'
            ];
        }
    }

    public function getSelectTrainingRoom()
    {
        $trainingRoomDB = TrainingRoom::query()->whereStatus('Ativo')->orderBy('name', 'ASC')->get();

        $return = [];
        $return[0]['label'] = 'Escolha';
        $return[0]['value'] = '';

        if($trainingRoomDB->count() > 0) {
        foreach ($trainingRoomDB as $key => $itemUser) {
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
