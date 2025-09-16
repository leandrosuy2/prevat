<?php

namespace App\Repositories;

use App\Models\Training;
use App\Requests\TrainingRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use PHPUnit\Exception;

class TrainingRepository
{
    public function index($orderBy, $filterData = null, $pageSize = null)
    {
        try {
            $trainingDB = Training::query();

            if(isset($filterData['search']) && $filterData['search'] != null) {
                $trainingDB->where('name', 'LIKE', '%'.$filterData['search'].'%');;
            }

            if(isset($filterData['status']) && $filterData['status'] != null) {
                $trainingDB->where('status', $filterData['status']);
            }

            if(isset($filterData['category_id']) &&  $filterData['category_id'] != null) {
                $trainingDB->where('category_id', $filterData['category_id']);
            }

            $trainingDB->orderBy($orderBy['column'], $orderBy['order']);

            if($pageSize) {
                $trainingDB = $trainingDB->paginate($pageSize);
            } else {
                $trainingDB = $trainingDB->get();
            }

            return [
                'status' => 'success',
                'data' => $trainingDB,
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

    public function create($request, $image)
    {
        $trainingRequest = new TrainingRequest();
        $requestValidated = $trainingRequest->validate($request);

        if($image != null){
            $requestValidated['image'] = $image->store('trainings', 'public');
        }

        if($requestValidated['category_id'] == '') {
            $requestValidated['category_id'] = null;
        }

        try {
            DB::beginTransaction();

            $trainingDB = Training::query()->create($requestValidated);

            DB::commit();
            return [
                'status' => 'success',
                'data' => $trainingDB,
                'code' => 200,
                'message' => 'Treinamento cadastrado com sucesso !'
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

    public function update($request, $id, $image)
    {
        $trainingRequest = new TrainingRequest();
        $requestValidated = $trainingRequest->validate($request, $id);

        try {
            DB::beginTransaction();

            $trainingDB = Training::query()->findOrFail($id);

            if(isset($image) && $image != $trainingDB->image){
                if(Storage::exists('public/'.$trainingDB->image)) {
                    Storage::delete('public/'.$trainingDB->image);
                }
                $requestValidated['image'] = $image->store('trainings', 'public');
            }

            $trainingDB->update($requestValidated);

            DB::commit();
            return [
                'status' => 'success',
                'data' => $trainingDB,
                'code' => 200,
                'message' => 'Treinamento atualizado com sucesso !'
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
            $trainingDB = Training::query()->find($id);

            return [
                'status' => 'success',
                'data' => $trainingDB,
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

            $trainingDB = Training::query()->findOrFail($id);

            if(Storage::exists('public/'.$trainingDB->image)) {
                Storage::delete('public/'.$trainingDB->image);
            }

            $trainingDB->delete();

            DB::commit();
            return [
                'status' => 'success',
                'data' => $trainingDB,
                'code' => 200,
                'message' => 'Treinamento deletado com sucesso !'
            ];

        } catch (\Exception $exception) {
            return [
                'status' => 'error',
                'code' => 400,
                'message' => 'Erro ao deletar'
            ];
        }
    }

    public function getSelectTraining()
    {
        $trainingDB = Training::query()->whereStatus('Ativo')->orderBy('name', 'ASC')->get();

        $return = [];

        foreach ($trainingDB as $key => $itemTraining) {
            $return[0]['label'] = 'Escolha';
            $return[0]['value'] = '';
            $return[$key + 1]['label'] = $itemTraining['acronym'].' - '. $itemTraining['name'];
            $return[$key + 1]['value'] = $itemTraining['id'];
        }

        return $return;
    }

}
