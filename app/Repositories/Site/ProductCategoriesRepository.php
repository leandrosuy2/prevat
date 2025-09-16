<?php

namespace App\Repositories\Site;

use App\Models\ProductCategories;
use App\Requests\Site\ProductCategoriesRequest;
use Illuminate\Support\Facades\DB;
use PHPUnit\Exception;

class ProductCategoriesRepository
{

    public function index($orderBy)
    {
        try {
            $productCategoriesDB = ProductCategories::query();

            $productCategoriesDB->orderBy($orderBy['column'], $orderBy['order']);

            $productCategoriesDB = $productCategoriesDB->get();

            return [
                'status' => 'success',
                'data' => $productCategoriesDB,
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
        $productCategoriesRequest = new ProductCategoriesRequest();
        $requestValidated = $productCategoriesRequest->validate($request);

        try {
            DB::beginTransaction();

            $productCategoriesDB = ProductCategories::query()->create($requestValidated);

            DB::commit();
            return [
                'status' => 'success',
                'data' => $productCategoriesDB,
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
        $productCategoriesRequest = new ProductCategoriesRequest();
        $requestValidated = $productCategoriesRequest->validate($request, $id);

        try {
            DB::beginTransaction();

            $productCategoriesDB = ProductCategories::query()->findOrFail($id);
            $productCategoriesDB->update($requestValidated);

            DB::commit();
            return [
                'status' => 'success',
                'data' => $productCategoriesDB,
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
            $productCategoriesDB = ProductCategories::query()->find($id);

            return [
                'status' => 'success',
                'data' => $productCategoriesDB,
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

            $productCategoriesDB = ProductCategories::query()->findOrFail($id);
            $productCategoriesDB->delete();

            DB::commit();
            return [
                'status' => 'success',
                'data' => $productCategoriesDB,
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

    public function getSelectProductCategories()
    {
        $productCategoriesDB = ProductCategories::query()->whereStatus('Ativo')->orderBy('name', 'ASC')->get();

        $return = [];

        $return[0]['label'] = 'Escolha';
        $return[0]['value'] = null;

        if($productCategoriesDB->count() > 0) {
            foreach ($productCategoriesDB as $key => $itemTime) {
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
