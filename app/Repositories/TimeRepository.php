<?php

namespace App\Repositories;

use App\Models\Time;
use App\Requests\TimeRequest;
use Illuminate\Support\Facades\DB;
use PHPUnit\Exception;

class TimeRepository
{
    public function index($orderBy)
    {
        try {
            $timeDB = Time::query();

            $timeDB->orderBy($orderBy['column'], $orderBy['order']);

            $timeDB = $timeDB->get();

            return [
                'status' => 'success',
                'data' => $timeDB,
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
        $timeRequest = new TimeRequest();
        $requestValidated = $timeRequest->validate($request);

        try {
            DB::beginTransaction();

            $timeDB = Time::query()->create($requestValidated);

            DB::commit();
            return [
                'status' => 'success',
                'data' => $timeDB,
                'code' => 200,
                'message' => 'Horário cadastrado com sucesso !'
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
        $timeRequest = new TimeRequest();
        $requestValidated = $timeRequest->validate($request, $id);

        try {
            DB::beginTransaction();

            $timeDB = Time::query()->findOrFail($id);
            $timeDB->update($requestValidated);

            DB::commit();
            return [
                'status' => 'success',
                'data' => $timeDB,
                'code' => 200,
                'message' => 'Horário atualizado com sucesso !'
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
            $timeDB = Time::query()->find($id);

            return [
                'status' => 'success',
                'data' => $timeDB,
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

            $timeDB = Time::query()->findOrFail($id);
            $timeDB->delete();

            DB::commit();
            return [
                'status' => 'success',
                'data' => $timeDB,
                'code' => 200,
                'message' => 'Horário deletado com sucesso !'
            ];

        } catch (\Exception $exception) {
            return [
                'status' => 'error',
                'code' => 400,
                'message' => 'Erro ao deletar'
            ];
        }
    }

    public function getSelectTime()
    {
        $timeDB = Time::query()->whereStatus('Ativo')->orderBy('name', 'ASC')->get();

        $return = [];

        $return[0]['label'] = 'Escolha';
        $return[0]['value'] = null;

        if($timeDB->count() > 0) {
        foreach ($timeDB as $key => $itemTime) {
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
