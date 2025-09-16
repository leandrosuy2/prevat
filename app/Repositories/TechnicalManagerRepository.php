<?php

namespace App\Repositories;

use App\Models\Professional;
use App\Models\TechnicalManager;
use App\Requests\ProfessionalRequest;
use App\Requests\TechnicalManagerRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use PHPUnit\Exception;

class TechnicalManagerRepository
{
    public function index($orderBy)
    {
        try {
            $technicalManagerDB = TechnicalManager::query();

            $technicalManagerDB->orderBy($orderBy['column'], $orderBy['order']);

            $technicalManagerDB = $technicalManagerDB->get();

            return [
                'status' => 'success',
                'data' => $technicalManagerDB,
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
        $technicalManagerRequest = new TechnicalManagerRequest();
        $requestValidated = $technicalManagerRequest->validate($request);


        if($image != null){
            $requestValidated['signature_image'] = $image->store('signatures', 'public');
        }

        try {
            DB::beginTransaction();

            $technicalManagerDB = TechnicalManager::query()->create($requestValidated);

            DB::commit();
            return [
                'status' => 'success',
                'data' => $technicalManagerDB,
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

    public function update($id, $request, $image)
    {
        $technicalManagerRequest = new TechnicalManagerRequest();
        $requestValidated = $technicalManagerRequest->validate($request);
        try{
            DB::beginTransaction();

            $technicalManagerDB = TechnicalManager::query()->findOrFail($id);

            if(isset($image) && $image != $technicalManagerDB->signature_image){
                if(Storage::exists('public/'.$technicalManagerDB->signature_image)) {
                    Storage::delete('public/'.$technicalManagerDB->c);
                }
                $requestValidated['signatures'] = $image->store('signatures', 'public');
            }

            $technicalManagerDB->update($requestValidated);

            DB::commit();
            return [
                'status' => 'success',
                'data' => $technicalManagerDB,
                'code' => 200,
                'message' => 'Responsável Técnico atualizado com sucesso !'
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

    public function update_old($request, $id)
    {
        $professionalRequest = new ProfessionalRequest();
        $requestValidated = $professionalRequest->validate($request, $id);

        try {
            DB::beginTransaction();

            $technicalManagerDB = Professional::query()->findOrFail($id);
            $technicalManagerDB->update($requestValidated);

            DB::commit();
            return [
                'status' => 'success',
                'data' => $technicalManagerDB,
                'code' => 200,
                'message' => 'Profissional atualizado com sucesso !'
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
            $technicalManagerDB = TechnicalManager::query()->find($id);

            return [
                'status' => 'success',
                'data' => $technicalManagerDB,
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

            $technicalManagerDB = TechnicalManager::query()->findOrFail($id);

            if(Storage::exists('public/'.$technicalManagerDB->signature_image)) {
                Storage::delete('public/'.$technicalManagerDB->signature_image);
            }

            $technicalManagerDB->delete();

            DB::commit();
            return [
                'status' => 'success',
                'data' => $technicalManagerDB,
                'code' => 200,
                'message' => 'Responsável Técnico deletado com sucesso !'
            ];

        } catch (\Exception $exception) {
            return [
                'status' => 'error',
                'code' => 400,
                'message' => 'Erro ao deletar'
            ];
        }
    }
    public function getSelectTechnicalManager()
    {
        $technicalManagerDB = TechnicalManager::query()->orderBy('name', 'ASC')->get();

        $return = [];

        foreach ($technicalManagerDB as $key => $itemUser) {
            $return[0]['label'] = 'Escolha';
            $return[0]['value'] = '';
            $return[$key + 1]['label'] = $itemUser['name'];
            $return[$key + 1]['value'] = $itemUser['id'];
        }

        return $return;
    }
}
