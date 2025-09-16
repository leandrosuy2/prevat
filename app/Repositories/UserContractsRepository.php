<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\UsersContracts;
use App\Requests\UserContractRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PHPUnit\Exception;

class UserContractsRepository
{
    public function index($user_id = null, $orderBy = null)
    {
        try {
            $userContractsDB = UsersContracts::query()->with(['contract.contractor', 'user.contract_default']);

            $userContractsDB->whereHas('user', function($query){
                $query->where('company_id', Auth::user()->company_id);
            });

            $userContractsDB->whereHas('contract', function($query){
                $query->whereStatus('Ativo');
            });

            if($user_id){
                $userContractsDB->where('user_id', $user_id);
            }

            if($orderBy) {
                $userContractsDB->orderBy($orderBy['column'], $orderBy['order']);
            }

            $userContractsDB = $userContractsDB->get();

            return [
                'status' => 'success',
                'data' => $userContractsDB,
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

    public function create($user_id, $request)
    {
        $userContractsRequest = new UserContractRequest();
        $requestValidated = $userContractsRequest->validate($request);

        try {
            DB::beginTransaction();

            $requestValidated['user_id'] = $user_id;

            $userContractsDB = UsersContracts::query()->create($requestValidated);

            $userDB = User::query()->with(['contracts','contract_default'])->find($user_id);

            if($userDB['contracts']->count() == 1) {
                $userDB->update([
                    'contract_id' => $userContractsDB['id']
                ]);
            }

            DB::commit();
            return [
                'status' => 'success',
                'data' => $userContractsDB,
                'code' => 200,
                'message' => 'Contrato cadastrado com sucesso !'
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
    public function show($id)
    {
        try {
            $userContractsDB = UsersContracts::query()->find($id);

            return [
                'status' => 'success',
                'data' => $userContractsDB,
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

            $userContractsDB = UsersContracts::query()->findOrFail($id);
            $userContractsDB->delete();

            DB::commit();
            return [
                'status' => 'success',
                'data' => $userContractsDB,
                'code' => 200,
                'message' => 'Contrato deletado com sucesso !'
            ];

        } catch (\Exception $exception) {

            return [
                'status' => 'error',
                'code' => 400,
                'message' => 'Erro ao deletar'
            ];
        }
    }

    public function getSelectContracts($user_id = null)
    {
        $userContractsDB = UsersContracts::query()->with(['contract.contractor', 'user']);

        $userContractsDB->whereHas('contract', function ($query) {
            $query->whereStatus('Ativo');
        });

        $userContractsDB->orderBy('id', 'ASC');

        if($user_id) {
            $userContractsDB->where('user_id', $user_id);
            $userContractsDB = $userContractsDB->get();
        }

        $return = [];

        $return[0]['label'] = 'Escolha';
        $return[0]['value'] = '';

        if($userContractsDB->count() == 1) {
            foreach ($userContractsDB as $key => $itemContract) {
                $return[$key +1]['label'] = $itemContract['contract']['contractor'] ? $itemContract['contract']['contractor']['fantasy_name']. ' - ' .$itemContract['contract']['contract'] : $itemContract['contract']['contract'];
                $return[$key +1]['value'] = $itemContract['contract_id'];
            }
        } elseif ($userContractsDB->count() > 1) {
            foreach ($userContractsDB as $key => $itemContract) {
                $return[$key +1]['label'] = $itemContract['contract']['contractor'] ? $itemContract['contract']['contractor']['fantasy_name']. ' - ' .$itemContract['contract']['contract'] : $itemContract['contract']['contract'];
                $return[$key +1]['value'] = $itemContract['contract_id'];
            }
        } else {
            $return[0]['label'] = 'Sem Cadastro';
            $return[0]['value'] = '';
        }

        return $return;
    }

    public function changeContract($user_id = null, $contract_id = null)
    {
        try {
            DB::beginTransaction();

            $userDB = User::query()->findOrFail($user_id);
            $userDB->update([
                'contract_id' => $contract_id,
            ]);

            DB::commit();
            return [
                'status' => 'success',
                'data' => $userDB,
                'code' => 200,
                'message' => 'Contrato alterado com sucesso !'
            ];

        } catch (\Exception $exception) {

            return [
                'status' => 'error',
                'code' => 400,
                'message' => 'Erro na requisição'
            ];
        }
    }
}
