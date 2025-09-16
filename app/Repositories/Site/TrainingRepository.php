<?php

namespace App\Repositories\Site;

use App\Models\Blog;
use App\Models\ProductCategories;
use App\Models\Products;
use PHPUnit\Exception;

class TrainingRepository
{
    public function getCategoriesProduct()
    {
        $productCategoriesDB = ProductCategories::query()->whereStatus('Ativo')->get();
        return $productCategoriesDB;
    }

    public function getTrainingsByCategory($category_id = null, $pageSize = null)
    {
        $trainingDB = Products::query()->whereStatus('Ativo');

        if($category_id) {
            $trainingDB->where('category_id', $category_id);
        }

        if($pageSize) {
            $trainingDB = $trainingDB->paginate($pageSize);
        } else {
            $trainingDB = $trainingDB->get();
        }


        return $trainingDB;
    }

    public function show($id)
    {
        try {
            $trainingDB = Products::query()->with('category')->find($id);

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

    public function getSixProductsByTraining($category_id)
    {
        $productsDB = Products::query()->where('category_id', $category_id)->whereStatus('Ativo')->inRandomOrder()->limit(6)->get();
        return $productsDB;
    }

}
