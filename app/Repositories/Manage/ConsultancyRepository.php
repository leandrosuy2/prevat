<?php

namespace App\Repositories\Manage;

use App\Models\Consultancy;
use App\Requests\ConsultancyRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use PHPUnit\Exception;

class ConsultancyRepository
{
    public function index($orderBy)
    {
        try {
            $consultanciesDB = Consultancy::query();

            $consultanciesDB->orderBy($orderBy['column'], $orderBy['order']);

            $consultanciesDB = $consultanciesDB->get();

            return [
                'status' => 'success',
                'data' => $consultanciesDB,
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
        $consultanciesRequest = new ConsultancyRequest();
        $requestValidated = $consultanciesRequest->validate($request);


        if($image != null){
            $requestValidated['image'] = $image->store('consultancies', 'public');
        }

        try {
            DB::beginTransaction();

            $consultanciesDB = Consultancy::query()->create($requestValidated);

            DB::commit();
            return [
                'status' => 'success',
                'data' => $consultanciesDB,
                'code' => 200,
                'message' => 'Consultoria cadastrada com sucesso !'
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
        $consultanciesRequest = new ConsultancyRequest();
        $requestValidated = $consultanciesRequest->validate($request);
        try{
            DB::beginTransaction();

            $consultanciesDB = Consultancy::query()->findOrFail($id);

            if(isset($image) && $image != $consultanciesDB->image){
                if(Storage::exists('public/'.$consultanciesDB->image)) {
                    Storage::delete('public/'.$consultanciesDB->image);
                }
                $requestValidated['image'] = $image->store('consultancies', 'public');
            }

            $consultanciesDB->update($requestValidated);

            DB::commit();
            return [
                'status' => 'success',
                'data' => $consultanciesDB,
                'code' => 200,
                'message' => 'Consultoria atualizada com sucesso !'
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
            $consultanciesDB = Consultancy::query()->find($id);

            return [
                'status' => 'success',
                'data' => $consultanciesDB,
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

            $consultanciesDB = Consultancy::query()->findOrFail($id);

            if(Storage::exists('public/'.$consultanciesDB->image)) {
                Storage::delete('public/'.$consultanciesDB->image);
            }

            $consultanciesDB->delete();

            DB::commit();
            return [
                'status' => 'success',
                'data' => $consultanciesDB,
                'code' => 200,
                'message' => 'Consultoria deletada com sucesso !'
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

            $consultanciesDB = Consultancy::query()->findOrFail($id);

            if(Storage::exists('public/'.$consultanciesDB->image)) {
                Storage::delete('public/'.$consultanciesDB->image);
            }

            $consultanciesDB->update([
                'image' => null
            ]);

            DB::commit();
            return [
                'status' => 'success',
                'data' => $consultanciesDB,
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

    public function getConsultanciesActive()
    {
        $consultanciesDB = Consultancy::query()->whereStatus('Ativo')->get();
        return $consultanciesDB;
    }
}
