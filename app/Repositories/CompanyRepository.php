<?php

namespace App\Repositories;

use App\Models\CompaniesContracts;
use App\Models\Company;
use App\Models\Participant;
use App\Models\ScheduleCompany;
use App\Models\User;
use App\Models\UsersContracts;
use App\Requests\CompanyRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PHPUnit\Exception;

class CompanyRepository
{
    public function index($orderBy, $filterData = null, $pageSize = null)
    {
        try {
            $companyDB = Company::query()->with(['contract_default', 'participants' => fn ($query) => $query->withoutGlobalScopes() ]);

            $companyDB->whereType('client');

            if(isset($filterData['search']) && $filterData['search'] != null) {
                $companyDB->where('name', 'LIKE', '%'.$filterData['search'].'%');
                $companyDB->orWhere('fantasy_name', 'LIKE', '%'.$filterData['search'].'%');
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
                'type' => 'client'
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

    public function update($request, $id)
    {
        $companyRequest = new CompanyRequest();
        $requestValidated = $companyRequest->validate($request, $id);

        try {
            DB::beginTransaction();

            $companyDB = Company::query()->with(['contracts', 'contract_default', 'user'])->findOrFail($id);

            $companyDB->update($requestValidated);

            if($companyDB['user'] === null && Auth::user()->company->type == 'admin') {

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

                $companyDB->update([
                    'user_id' => $userDB['id']
                ]);

                if($companyDB['contracts']->count() > 0) {
                    foreach ($companyDB['contracts'] as $itemContract) {
                        UsersContracts::query()->create([
                            'user_id' => $userDB['id'],
                            'contract_id' => $itemContract['id']
                        ]);
                    }

                    Company::query()->findOrFail($companyDB['id'])->update([
                        'user_id' => $userDB['id']
                    ]);
                }
//                else {
//                    return [
//                        'status' => 'error',
//                        'code' => 400,
//                        'message' => 'Empresa sem contrato cadastrados por favor cadastre os contratos para atualizar a empresa.'
//                    ];
//                }
            } else {
//                dd($requestValidated['user']);
                $companyDB['user']->update($requestValidated['user']);
                if( $companyDB['user']['contracts']->count() == 0 && $companyDB['contracts']->count() > 0) {
                    foreach ($companyDB['contracts'] as $itemContract) {
                        UsersContracts::query()->create([
                            'user_id' => $companyDB['user']['id'],
                            'contract_id' => $itemContract['id']
                        ]);
                    }
                }
            }

            DB::commit();
            return [
                'status' => 'success',
                'data' => $companyDB,
                'code' => 200,
                'message' => 'Empresa atualizado com sucesso !'
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
            $companyDB = Company::query()->with(['user', 'contract_default', 'contracts', 'user'])->find($id);

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
    public function getSelectCompany($companies = null)
    {
        $companyDB = Company::query()->orderBy('name', 'ASC');

        // Filtrar pelas empresas do usuário logado se for funcionário
        if (auth()->user()->type == 'funcionario') {
            $companyDB->whereHas('participants', function($query) {
                $query->where('user_id', auth()->id());
            });
        }

        if($companies) {
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
        $companyDB = Company::query()->whereStatus('ativo')->orderBy('name', 'ASC')->get();
        return $companyDB;
    }

    public function activate($company_id, $request)
    {
        $companyRequest = new CompanyRequest();
        $requestValidated = $companyRequest->validateContract($request);

        try {
            DB::beginTransaction();

            $requestValidated['company_id'] = $company_id;
            $requestValidated['default'] = 1;

            $companiesContractsDB = CompaniesContracts::query()->create($requestValidated);

            $participantsDB = Participant::query()->where('company_id', $company_id)->withoutGlobalScopes()->get();
            if($participantsDB) {
                foreach ($participantsDB as $itemParticipant){
                    $itemParticipant->contract_id = $companiesContractsDB['id'];
                    $itemParticipant->save();
                }
            }

            $scheduleCompaniesDB = ScheduleCompany::query()->where('company_id', $company_id)->withoutGlobalScopes()->get();
            if($scheduleCompaniesDB){
                foreach ($scheduleCompaniesDB as $itemScheduleCompany) {
                    $itemScheduleCompany->contract_id = $companiesContractsDB['id'];
                    $itemScheduleCompany->save();
                }
            }

            $companyDB = Company::query()->withoutGlobalScopes()->findOrFail($company_id);

            $companyDB->update([
                'status' => 'Ativo',
                'contract_id' => $companiesContractsDB['id']
            ]);

            $userDB = User::query()->find($companyDB['user_id']);

            if($userDB) {
                $userDB->update([
                    'status' => 'Ativo'
                ]);
            }

            DB::commit();
            return [
                'status' => 'success',
                'data' => $companyDB,
                'code' => 200,
                'message' => 'Empresa Ativada com sucesso !'
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
