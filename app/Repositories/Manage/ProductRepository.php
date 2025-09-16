<?php

namespace App\Repositories\Manage;

use App\Models\Blog;
use App\Models\ProductCategories;
use App\Models\Products;
use App\Models\ProductsImages;
use App\Requests\BlogRequest;
use App\Requests\ProductRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use PHPUnit\Exception;

class ProductRepository
{
    public function index($orderBy)
    {
        try {
            $productDB = Products::query()->with(['category']);

            $productDB->orderBy($orderBy['column'], $orderBy['order']);

            $productDB = $productDB->get();

            return [
                'status' => 'success',
                'data' => $productDB,
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

    public function create($request, $image = null)
    {
        $productRequest = new ProductRequest();
        $requestValidated = $productRequest->validate($request);

        if($image != null){
            $requestValidated['image'] = $image->store('products', 'public');
        }

        try {
            DB::beginTransaction();

            $productDB = Products::query()->create($requestValidated);

            DB::commit();
            return [
                'status' => 'success',
                'data' => $productDB,
                'code' => 200,
                'message' => 'Produto cadastrado com sucesso !'
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

    public function update($request, $id, $image = null)
    {
        $productRequest = new ProductRequest();
        $requestValidated = $productRequest->validate($request);
        try{
            DB::beginTransaction();

            $productDB = Products::query()->findOrFail($id);

            if(isset($image) && $image != $productDB->image){
                if(Storage::exists('public/'.$productDB->image)) {
                    Storage::delete('public/'.$productDB->image);
                }
                $requestValidated['image'] = $image->store('products', 'public');
            }

            $productDB->update($requestValidated);

            DB::commit();
            return [
                'status' => 'success',
                'data' => $productDB,
                'code' => 200,
                'message' => 'Produto atualizado com sucesso !'
            ];

        } catch (Exception $exception) {
            DB::rollback();
            return [
                'status' => 'error',
                'data' => $exception,
                'code' => 400,
                'message' => 'Erro ao atualizar'
            ];
        }
    }
    public function show($id)
    {
        try {
            $productDB = Products::query()->find($id);

            return [
                'status' => 'success',
                'data' => $productDB,
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

            $productDB = Products::query()->findOrFail($id);

            if(Storage::exists('public/'.$productDB->image)) {
                Storage::delete('public/'.$productDB->image);
            }

            $productDB->delete();

            DB::commit();
            return [
                'status' => 'success',
                'data' => $productDB,
                'code' => 200,
                'message' => 'Produto deletado com sucesso !'
            ];

        } catch (\Exception $exception) {
            return [
                'status' => 'error',
                'code' => 400,
                'message' => 'Erro ao deletar'
            ];
        }
    }

    public function deleteImage($id = null)
    {
        try {
            DB::beginTransaction();

            $productDB = Products::query()->findOrFail($id);

            if(Storage::exists('public/'.$productDB->image)) {
                Storage::delete('public/'.$productDB->image);
            }

            $productDB->update([
                'image' => null
            ]);

            DB::commit();
            return [
                'status' => 'success',
                'data' => $productDB,
                'code' => 200,
                'message' => 'Imagem removida com sucesso !'
            ];

        } catch (\Exception $exception) {
            return [
                'status' => 'error',
                'code' => 400,
                'message' => 'Erro ao deletar'
            ];
        }
    }

    public function getSelectProduct()
    {
        $productDB = Products::query()->orderBy('name', 'ASC')->get();

        $return = [];

        foreach ($productDB as $key => $itemUser) {
            $return[0]['label'] = 'Escolha';
            $return[0]['value'] = '';
            $return[$key + 1]['label'] = $itemUser['name'];
            $return[$key + 1]['value'] = $itemUser['id'];
        }

        return $return;
    }

    public function getSixProductsRandom()
    {
        $productsCaregoriestDB = ProductCategories::query()->inRandomOrder()->limit(6)->get();
        return $productsCaregoriestDB;
    }
}
