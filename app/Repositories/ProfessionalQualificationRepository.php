<?php

namespace App\Repositories;

use App\Models\ProfessionalQualifications;
use App\Requests\ProfessionalQualificationRequest;
use Illuminate\Support\Facades\DB;
use PHPUnit\Exception;

class ProfessionalQualificationRepository
{

    public function index($orderBy)
    {
        try {
            $professionalQualificationDB = ProfessionalQualifications::query();

            $professionalQualificationDB->orderBy($orderBy['column'], $orderBy['order']);

            $professionalQualificationDB = $professionalQualificationDB->get();

            return [
                'status' => 'success',
                'data' => $professionalQualificationDB,
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
        $professionalQualificationRequest = new ProfessionalQualificationRequest();
        $requestValidated = $professionalQualificationRequest->validate($request);

        try {
            DB::beginTransaction();

            $professionalQualificationDB = ProfessionalQualifications::query()->create($requestValidated);

            DB::commit();
            return [
                'status' => 'success',
                'data' => $professionalQualificationDB,
                'code' => 200,
                'message' => 'Formação profissional cadastrada com sucesso !'
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
        $professionalQualificationRequest = new ProfessionalQualificationRequest();
        $requestValidated = $professionalQualificationRequest->validate($request, $id);

        try {
            DB::beginTransaction();

            $professionalQualificationDB = ProfessionalQualifications::query()->findOrFail($id);
            $professionalQualificationDB->update($requestValidated);

            DB::commit();
            return [
                'status' => 'success',
                'data' => $professionalQualificationDB,
                'code' => 200,
                'message' => 'Formação profissional atualizada com sucesso !'
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
            $professionalQualificationDB = ProfessionalQualifications::query()->find($id);

            return [
                'status' => 'success',
                'data' => $professionalQualificationDB,
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

            $professionalQualificationDB = ProfessionalQualifications::query()->findOrFail($id);
            $professionalQualificationDB->delete();

            DB::commit();
            return [
                'status' => 'success',
                'data' => $professionalQualificationDB,
                'code' => 200,
                'message' => 'Formação do profissional deletada com sucesso !'
            ];

        } catch (\Exception $exception) {
            return [
                'status' => 'error',
                'code' => 400,
                'message' => 'Erro ao deletar'
            ];
        }
    }
    public function getSelectProfessionaQualification()
    {
        $professionalQualificationDB = ProfessionalQualifications::query()->whereStatus('Ativo')->orderBy('name', 'ASC')->get();

        $return = [];

        foreach ($professionalQualificationDB as $key => $itemUser) {
            $return[0]['label'] = 'Escolha';
            $return[0]['value'] = '';
            $return[$key + 1]['label'] = $itemUser['name'];
            $return[$key + 1]['value'] = $itemUser['id'];
        }

        return $return;
    }

    public function getProfessionalQualificationActive()
    {
        $professionalQualificationDB = ProfessionalQualifications::query()->whereStatus('Ativo')->orderBy('name', 'ASC')->get();
        return $professionalQualificationDB;
    }

}
