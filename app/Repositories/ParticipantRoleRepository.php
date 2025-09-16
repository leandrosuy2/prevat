<?php

namespace App\Repositories;

use App\Models\ParticipantRole;
use App\Requests\ParticipantRoleRequest;
use Illuminate\Support\Facades\DB;
use PHPUnit\Exception;

class ParticipantRoleRepository
{
    public function index($orderBy)
    {
        try {
            $participantRoleDB = ParticipantRole::query();

            $participantRoleDB->orderBy($orderBy['column'], $orderBy['order']);

            $participantRoleDB = $participantRoleDB->get();

            return [
                'status' => 'success',
                'data' => $participantRoleDB,
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
        $participantRoleRequest = new ParticipantRoleRequest();
        $requestValidated = $participantRoleRequest->validate($request);

        try {
            DB::beginTransaction();

            $participantRoleDB = ParticipantRole::query()->create($requestValidated);

            DB::commit();
            return [
                'status' => 'success',
                'data' => $participantRoleDB,
                'code' => 200,
                'message' => 'Função do Participante cadastrado com sucesso !'
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
        $participantRoleRequest = new ParticipantRoleRequest();
        $requestValidated = $participantRoleRequest->validate($request, $id);

        try {
            DB::beginTransaction();

            $participantRoleDB = ParticipantRole::query()->findOrFail($id);
            $participantRoleDB->update($requestValidated);

            DB::commit();
            return [
                'status' => 'success',
                'data' => $participantRoleDB,
                'code' => 200,
                'message' => 'Função do participante atualizada com sucesso !'
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
            $participantRoleDB = ParticipantRole::query()->find($id);

            return [
                'status' => 'success',
                'data' => $participantRoleDB,
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

            $participantRoleDB = ParticipantRole::query()->findOrFail($id);
            $participantRoleDB->delete();

            DB::commit();
            return [
                'status' => 'success',
                'data' => $participantRoleDB,
                'code' => 200,
                'message' => 'Função do participante deletada com sucesso !'
            ];

        } catch (\Exception $exception) {
            return [
                'status' => 'error',
                'code' => 400,
                'message' => 'Erro ao deletar'
            ];
        }
    }

    public function getSelectParticipantRole()
    {
        $participantRoleDB = ParticipantRole::query()->whereStatus('Ativo')->orderBy('name', 'ASC')->get();

        $return = [];

        foreach ($participantRoleDB as $key => $itemParticipant) {
            $return[0]['label'] = 'Escolha';
            $return[0]['value'] = '';
            $return[$key + 1]['label'] = $itemParticipant['name'];
            $return[$key + 1]['value'] = $itemParticipant['id'];
        }

        return $return;
    }

}
