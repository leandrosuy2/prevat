<?php

namespace App\Repositories;

use App\Models\CompaniesContracts;
use App\Models\Company;
use App\Models\Participant;
use App\Models\ScheduleCompany;
use App\Models\User;
use App\Requests\CompanyRequest;
use Illuminate\Support\Facades\DB;
use PHPUnit\Exception;

class ContractorsRepository
{
    public function index($orderBy, $filterData = null, $pageSize = null)
    {
        try {
            $companyDB = Company::query()->with(['contract_default', 'participants' => fn ($query) => $query->withoutGlobalScopes() ]);
            $companyDB->whereType('contractor');
            $companyDB->whereNot('id', 1070);

            if(isset($filterData['search']) && $filterData['search'] != null) {
                $companyDB->where('name', 'LIKE', '%'.$filterData['search'].'%');
                $companyDB->where('fantasy_name', 'LIKE', '%'.$filterData['search'].'%');
                $companyDB->orWhere('employer_number', 'LIKE', '%'.$filterData['search'].'%');
                $companyDB->orWhere('email', 'LIKE', '%'.$filterData['search'].'%');
            }

            if(isset($filterData['status']) && $filterData['status'] != null) {
                $companyDB->where('status', $filterData['status']);
            }

            $companyDB->orderBy($orderBy['column'], $orderBy['order']);

            if($pageSize) {
                $companyDB = $companyDB->paginate($pageSize);
            } else {
                $companyDB = $companyDB->get();
            }

            return [
                'status' => 'success',
                'data' => $companyDB,
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
        $companyRequest = new CompanyRequest();
        $requestValidated = $companyRequest->validate($request);

        $requestValidated['type'] = 'contractor';

        try {
            DB::beginTransaction();

            $companyDB = Company::query()->create($requestValidated);

            $userDB = User::query()->create([
                'company_id' => $companyDB['id'],
                'name' => $requestValidated['user']['name'],
                'email' => $requestValidated['user']['email'],
                'document' => $requestValidated['user']['document'],
                'phone' => $requestValidated['user']['phone'],
                'password' => $requestValidated['user']['password'],
                'status' => 'Ativo',
                'type' => 'contractor'
            ]);

            Company::query()->findOrFail($companyDB['id'])->update([
                'user_id' => $userDB['id']
            ]);

            DB::commit();
            return [
                'status' => 'success',
                'data' => $companyDB,
                'code' => 200,
                'message' => 'Empresa cadastrada com sucesso !'
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

    public function update($request, $id, $user_id = null)
    {
        $companyRequest = new CompanyRequest();
        $requestValidated = $companyRequest->validate($request, $id, $user_id);
        try {
            DB::beginTransaction();

            $companyDB = Company::query()->with(['contracts', 'contract_default', 'user'])->findOrFail($id);

            $companyDB->update($requestValidated);

            if($companyDB['user'] == null) {
                $userDB = User::query()->create([
                    'company_id' => $companyDB['id'],
                    'name' => $requestValidated['user']['name'],
                    'email' => $requestValidated['user']['email'],
                    'document' => $requestValidated['user']['document'],
                    'phone' => $requestValidated['user']['phone'],
                    'password' => $requestValidated['user']['password'],
                    'status' => 'Ativo',
                    'type' => 'client'
                ]);

                Company::query()->findOrFail($companyDB['id'])->update([
                    'user_id' => $userDB['id']
                ]);
            } else {
                $companyDB['user']->update($requestValidated['user']);
            }

            DB::commit();
            return [
                'status' => 'success',
                'data' => $companyDB,
                'code' => 200,
                'message' => 'Empresa atualizado com sucesso !'
            ];

        } catch (\Exception $exception) {
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
            $companyDB = Company::query()->with(['user', 'contract_default', 'contracts'])->find($id);

            return [
                'status' => 'success',
                'data' => $companyDB,
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

            $companyDB = Company::query()->findOrFail($id);
            $companyDB->delete();

            DB::commit();
            return [
                'status' => 'success',
                'data' => $companyDB,
                'code' => 200,
                'message' => 'Empresa apagada com sucesso !'
            ];

        } catch (\Exception $exception) {
            return [
                'status' => 'error',
                'code' => 400,
                'message' => 'Erro ao deletar'
            ];
        }
    }
    public function getSelectContractor($companies = null, $activate = null)
    {

        $companyDB = Company::query()->whereType('contractor')->orderBy('name', 'ASC');

//        if($activate) {
            $companyDB->whereNotIn('id', [1070]);
//        }
        if($companies && $companies != 1000) {
            $companyDB->whereIn('id', $companies);
        }

        $companyDB = $companyDB->get();

        $return = [];

        foreach ($companyDB as $key => $itemCompany) {
            $return[0]['label'] = 'Escolha';
            $return[0]['value'] = '';
            $return[$key + 1]['label'] = $itemCompany['name'] ?? $itemCompany['fantasy_name'];
            $return[$key + 1]['value'] = $itemCompany['id'];
        }
        return $return;
    }

    public function getCompanyActive()
    {
        $companyDB = Company::query()->whereStatus('ativo')->whereType('contractor')->orderBy('name', 'ASC')->get();
        return $companyDB;
    }
}
