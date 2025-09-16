<?php

namespace App\Repositories\Site;

use App\Models\BlogCategories;
use App\Requests\Site\BlogCategoriesRequest;
use Illuminate\Support\Facades\DB;
use PHPUnit\Exception;

class BlogCategoriesRepository
{
    public function index($orderBy)
    {
        try {
            $blogCategoriesDB = BlogCategories::query();

            $blogCategoriesDB->orderBy($orderBy['column'], $orderBy['order']);

            $blogCategoriesDB = $blogCategoriesDB->get();

            return [
                'status' => 'success',
                'data' => $blogCategoriesDB,
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
        $blogCategoriesRequest = new BlogCategoriesRequest();
        $requestValidated = $blogCategoriesRequest->validate($request);

        try {
            DB::beginTransaction();

            $blogCategoriesDB = BlogCategories::query()->create($requestValidated);

            DB::commit();
            return [
                'status' => 'success',
                'data' => $blogCategoriesDB,
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
        $blogCategoriesRequest = new BlogCategoriesRequest();
        $requestValidated = $blogCategoriesRequest->validate($request, $id);

        try {
            DB::beginTransaction();

            $blogCategoriesDB = BlogCategories::query()->findOrFail($id);
            $blogCategoriesDB->update($requestValidated);

            DB::commit();
            return [
                'status' => 'success',
                'data' => $blogCategoriesDB,
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
            $blogCategoriesDB = BlogCategories::query()->find($id);

            return [
                'status' => 'success',
                'data' => $blogCategoriesDB,
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

            $blogCategoriesDB = BlogCategories::query()->findOrFail($id);
            $blogCategoriesDB->delete();

            DB::commit();
            return [
                'status' => 'success',
                'data' => $blogCategoriesDB,
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

    public function getSelectBlogCategories()
    {
        $blogCategoriesDB = BlogCategories::query()->whereStatus('Ativo')->orderBy('name', 'ASC')->get();

        $return = [];

        $return[0]['label'] = 'Escolha';
        $return[0]['value'] = null;

        if($blogCategoriesDB->count() > 0) {
            foreach ($blogCategoriesDB as $key => $itemTime) {
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
