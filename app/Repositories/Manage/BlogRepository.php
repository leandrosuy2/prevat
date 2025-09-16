<?php

namespace App\Repositories\Manage;

use App\Models\Blog;
use App\Requests\BlogRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use PHPUnit\Exception;

class BlogRepository
{
    public function index($orderBy)
    {
        try {
            $blogDB = Blog::query()->with(['category', 'user']);

            $blogDB->orderBy($orderBy['column'], $orderBy['order']);

            $blogDB = $blogDB->get();

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

    public function create($request, $image = null)
    {
        $blogRequest = new BlogRequest();
        $requestValidated = $blogRequest->validate($request);


        if($image != null){
            $requestValidated['image'] = $image->store('blog', 'public');
        }

        try {
            DB::beginTransaction();

            $blogDB = Auth::user()->posts()->create($requestValidated);

            DB::commit();
            return [
                'status' => 'success',
                'data' => $blogDB,
                'code' => 200,
                'message' => 'Responsável Técnico cadastrado com sucesso !'
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
        $blogRequest = new BlogRequest();
        $requestValidated = $blogRequest->validate($request);
        try{
            DB::beginTransaction();

            $blogDB = Blog::query()->findOrFail($id);

            if(isset($image) && $image != $blogDB->image){
                if(Storage::exists('public/'.$blogDB->image)) {
                    Storage::delete('public/'.$blogDB->image);
                }
                $requestValidated['image'] = $image->store('blog', 'public');
            }

            $blogDB->update($requestValidated);

            DB::commit();
            return [
                'status' => 'success',
                'data' => $blogDB,
                'code' => 200,
                'message' => 'Postagem do blog atualizada com sucesso !'
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

    public function delete($id = null)
    {
        try {
            DB::beginTransaction();

            $blogDB = Blog::query()->findOrFail($id);

            if(Storage::exists('public/'.$blogDB->image)) {
                Storage::delete('public/'.$blogDB->image);
            }

            $blogDB->delete();

            DB::commit();
            return [
                'status' => 'success',
                'data' => $blogDB,
                'code' => 200,
                'message' => 'Postagem do blog deletada com sucesso !'
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

            $blogDB = Blog::query()->findOrFail($id);

            if(Storage::exists('public/'.$blogDB->image)) {
                Storage::delete('public/'.$blogDB->image);
            }

            $blogDB->update([
                'image' => null
            ]);

            DB::commit();
            return [
                'status' => 'success',
                'data' => $blogDB,
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
    public function getSelectBlog()
    {
        $blogDB = Blog::query()->orderBy('name', 'ASC')->get();

        $return = [];

        foreach ($blogDB as $key => $itemUser) {
            $return[0]['label'] = 'Escolha';
            $return[0]['value'] = '';
            $return[$key + 1]['label'] = $itemUser['name'];
            $return[$key + 1]['value'] = $itemUser['id'];
        }

        return $return;
    }

}
