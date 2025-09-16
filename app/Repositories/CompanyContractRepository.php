<?php

namespace App\Repositories;

use App\Models\CompaniesContracts;
use App\Models\Company;
use App\Models\Participant;
use App\Models\ScheduleCompany;
use App\Models\User;
use App\Models\UsersContracts;
use App\Requests\CompanyContractRequest;
use Illuminate\Support\Facades\DB;
use PHPUnit\Exception;

class CompanyContractRepository
{
    public function index($company_id = null, $orderBy = null)
    {
        try {
            $companiesContractsDB = CompaniesContracts::query()->with(['company', 'contractor']);

            if($company_id){
                $companiesContractsDB->where('company_id', $company_id);
            }

            if($orderBy) {
                $companiesContractsDB->orderBy($orderBy['column'], $orderBy['order']);
            }

            $companiesContractsDB = $companiesContractsDB->get();

            return [
                'status' => 'success',
                'data' => $companiesContractsDB,
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

    public function create($company_id, $request)
    {
        $companiesContractsRequest = new CompanyContractRequest();
        $requestValidated = $companiesContractsRequest->validate($request);

        try {
            DB::beginTransaction();

            $requestValidated['company_id'] = $company_id;

            $companiesContractsDB = CompaniesContracts::query()->with(['company'])->create($requestValidated);

            $userContractsDB = UsersContracts::query()->where('user_id', $companiesContractsDB['company']['user_id'])->where('contract_id', $companiesContractsDB['id'])->first();

            if(!$userContractsDB && $companiesContractsDB['company']['user_id'] != null) {
                UsersContracts::query()->create([
                    'user_id' => $companiesContractsDB['company']['user_id'],
                    'contract_id' => $companiesContractsDB['id']
                ]);
            } else {
                return [
                    'status' => 'error',
                    'code' => 400,
                    'message' => 'Cadastro sem usuario principal, por avor atualize o cadastro da empresa selecionada.'
                ];
            }

            $companyDB = Company::query()->with(['contracts','contract_default'])->find($company_id);

            if($companyDB['contracts']->count() == 1) {
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

                $companyDB->update([
                    'contract_id' => $companiesContractsDB['id']
                ]);
            }

            DB::commit();
            return [
                'status' => 'success',
                'data' => $companiesContractsDB,
                'code' => 200,
                'message' => 'Contrato cadastrado com sucesso !'
            ];

        } catch (Exception $exception){

            DB::rollback();
            return [
                'status' => 'error',
                'code' => 400,
                'message' => 'Erro ao Cadastrar'
            ];
        }
    }

    public function update($request, $id)
    {
        $companiesContractsRequest = new CompanyContractRequest();
        $requestValidated = $companiesContractsRequest->validate($request, $id);

        try {
            DB::beginTransaction();

            $companiesContractsDB = CompaniesContracts::query()->with('company.contract_default')->findOrFail($id);

            $companiesContractsDB->update($requestValidated);

            if($companiesContractsDB['company']['contract_default'] == null) {
                $participantsDB = Participant::query()->where('company_id', $companiesContractsDB['company']['id'])->withoutGlobalScopes()->get();
                if ($participantsDB) {
                    foreach ($participantsDB as $itemParticipant) {
                        $itemParticipant->contract_id = $companiesContractsDB['id'];
                        $itemParticipant->save();
                    }
                }

                $scheduleCompaniesDB = ScheduleCompany::query()->where('company_id', $companiesContractsDB['company']['id'])->withoutGlobalScopes()->get();
                if ($scheduleCompaniesDB) {
                    foreach ($scheduleCompaniesDB as $itemScheduleCompany) {
                        $itemScheduleCompany->contract_id = $companiesContractsDB['id'];
                        $itemScheduleCompany->save();
                    }
                }

                $companiesContractsDB['company']->update([
                    'contract_id' => $companiesContractsDB['id']
                ]);
            }
            DB::commit();
            return [
                'status' => 'success',
                'data' => $companiesContractsDB,
                'code' => 200,
                'message' => 'Contrato atualizado com sucesso !'
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
            $companiesContractsDB = CompaniesContracts::query()->find($id);

            return [
                'status' => 'success',
                'data' => $companiesContractsDB,
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

            $companiesContractsDB = CompaniesContracts::query()->findOrFail($id);
            $companiesContractsDB->delete();

            DB::commit();
            return [
                'status' => 'success',
                'data' => $companiesContractsDB,
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

    public function getSelectContracts($company_id = null, $user_id = null)
    {
        $companiesContractsDB = CompaniesContracts::query()->with(['company', 'contractor'])->whereStatus('Ativo');

        $companiesContractsDB->orderBy('id', 'ASC');

        if($user_id) {
            $userContractsDB = UsersContracts::query()->where('user_id', $user_id)->pluck('contract_id');
            $companiesContractsDB->whereNotIn('id', $userContractsDB);
        }

        if($company_id) {
            $companiesContractsDB->where('company_id', $company_id);
            $companiesContractsDB = $companiesContractsDB->get();
        }

        $return = [];

        $return[0]['label'] = 'Escolha';
        $return[0]['value'] = '';

        if($companiesContractsDB->count() == 1) {
            foreach ($companiesContractsDB as $key => $itemContract) {
                $return[$key +1]['label'] = $itemContract['contractor'] ? $itemContract['contractor']['fantasy_name']. ' - ' .$itemContract['contract'] : $itemContract['contract'];
                $return[$key +1]['value'] = $itemContract['id'];
            }
        } elseif ($companiesContractsDB->count() > 1) {
            foreach ($companiesContractsDB as $key => $itemContract) {
                $return[$key +1]['label'] = $itemContract['contractor'] ? $itemContract['contractor']['fantasy_name']. ' - ' .$itemContract['contract'] : $itemContract['contract'];
                $return[$key +1]['value'] = $itemContract['id'];
            }
        } else {
            $return[0]['label'] = 'Sem Cadastro';
            $return[0]['value'] = '';
        }

        return $return;
    }

    public function changeContract($company_id = null, $contract_id = null)
    {
        try {
            DB::beginTransaction();

            $companiesContractsDB = Company::query()->findOrFail($company_id);
            $companiesContractsDB->update([
                'contract_id' => $contract_id,
            ]);

            DB::commit();
            return [
                'status' => 'success',
                'data' => $companiesContractsDB,
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
