<?php

namespace App\Repositories;

use App\Models\TrainingsCategory;
use App\Requests\TrainingCategoryRequest;
use Illuminate\Support\Facades\DB;
use PHPUnit\Exception;

class TrainingCategoriesRepository
{

    public function index($orderBy)
    {
        try {
            $trainingCategoriesDB = TrainingsCategory::query();

            $trainingCategoriesDB->orderBy($orderBy['column'], $orderBy['order']);

            $trainingCategoriesDB = $trainingCategoriesDB->get();

            return [
                'status' => 'success',
                'data' => $trainingCategoriesDB,
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
        $trainingCategoriesRequest = new TrainingCategoryRequest();
        $requestValidated = $trainingCategoriesRequest->validate($request);

        try {
            DB::beginTransaction();

            $trainingCategoriesDB = TrainingsCategory::query()->create($requestValidated);

            DB::commit();
            return [
                'status' => 'success',
                'data' => $trainingCategoriesDB,
                'code' => 200,
                'message' => 'Categoria cadastrada com sucesso !'
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
        $trainingCategoriesRequest = new TrainingCategoryRequest();
        $requestValidated = $trainingCategoriesRequest->validate($request, $id);

        try {
            DB::beginTransaction();

            $trainingCategoriesDB = TrainingsCategory::query()->findOrFail($id);
            $trainingCategoriesDB->update($requestValidated);

            DB::commit();
            return [
                'status' => 'success',
                'data' => $trainingCategoriesDB,
                'code' => 200,
                'message' => 'Categoria atualizada com sucesso !'
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
            $trainingCategoriesDB = TrainingsCategory::query()->find($id);

            return [
                'status' => 'success',
                'data' => $trainingCategoriesDB,
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

            $trainingCategoriesDB = TrainingsCategory::query()->findOrFail($id);
            $trainingCategoriesDB->delete();

            DB::commit();
            return [
                'status' => 'success',
                'data' => $trainingCategoriesDB,
                'code' => 200,
                'message' => 'Categoria deletada com sucesso !'
            ];

        } catch (\Exception $exception) {
            return [
                'status' => 'error',
                'code' => 400,
                'message' => 'Erro ao deletar'
            ];
        }
    }

    public function getSelectTrainingCategories()
    {
        $trainingCategoriesDB = TrainingsCategory::query()->whereStatus('Ativo')->orderBy('name', 'ASC')->get();

        $return = [];

        $return[0]['label'] = 'Escolha';
        $return[0]['value'] = null;

        if($trainingCategoriesDB->count() > 0) {
            foreach ($trainingCategoriesDB as $key => $itemTime) {
                $return[$key +1]['label'] = $itemTime['name'];
                $return[$key +1]['value'] = $itemTime['id'];
            }
        } else {
            $return[0]['label'] = 'Sem Cadastro';
            $return[0]['value'] = null;
        }

        return $return;
    }
}
