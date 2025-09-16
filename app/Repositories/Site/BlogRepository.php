<?php

namespace App\Repositories\Site;

use App\Models\Blog;
use App\Models\BlogCategories;
use App\Models\Time;
use PHPUnit\Exception;

class BlogRepository
{
    public function index($orderBy, $filterData = null, $pageSize = null)
    {
        try {
            $blogDB = Blog::query();

            if($filterData != null) {
                $blogDB->where('category_id', $filterData);
            }

            $blogDB->orderBy($orderBy['column'], $orderBy['order']);

            if($pageSize) {
                $blogDB = $blogDB->paginate($pageSize);
            } else {
                $blogDB = $blogDB->get();
            }


            return [
                'status' => 'success',
                'data' => $blogDB,
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

    public function show($id)
    {
        try {
            $blogDB = Blog::query()->find($id);

            return [
                'status' => 'success',
                'data' => $blogDB,
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

    public function getCategoriesBlogActive()
    {
        $blogCategoriesDB = BlogCategories::query()->whereStatus('Ativo')->get();
        return $blogCategoriesDB;
    }

    public function getLastFivePosts()
    {
        $blogDB = Blog::query()->orderBy('created_at', 'desc')->take(05)->get();
        return $blogDB;
    }

    public function getLastTreePosts()
    {
        $blogDB = Blog::query()->with('category')->orderBy('created_at', 'desc')->take(03)->get();
        return $blogDB;
    }
}
