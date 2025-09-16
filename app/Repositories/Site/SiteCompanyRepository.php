<?php

namespace App\Repositories\Site;

use App\Models\Company;
use App\Models\User;
use App\Models\UsersVerify;
use App\Notifications\NewRegisterNotification;
use App\Notifications\SendAdminNewRegisterNotification;
use App\Requests\CompanyRequest;
use App\Requests\Site\SiteCompanyRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use PHPUnit\Exception;

class SiteCompanyRepository
{
    public function index($orderBy)
    {
        try {
            $companyDB = Company::query();
            $companyDB->whereType('client');

            $companyDB->orderBy($orderBy['column'], $orderBy['order']);

            $companyDB = $companyDB->get();

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
        $companyRequest = new SiteCompanyRequest();
        $requestValidated = $companyRequest->validate($request);

        try {
            DB::beginTransaction();

            $companyDB = Company::query()->where('employer_number', $requestValidated['employer_number'])->first();

            if($companyDB) {
                return [
                    'status' => 'error',
                    'data' => $companyDB,
                    'code' => 333,
                ];
            }

            $requestValidated['status'] = 'Inativo';

            $companyDB = Company::query()->create($requestValidated);

            $userDB = User::query()->create([
                'company_id' => $companyDB['id'],
                'name' => $requestValidated['user']['name'],
                'email' => $requestValidated['user']['email'],
                'password' => $requestValidated['user']['password'],
                'status' => 'Inativo',
                'type' => 'client'
            ]);

            Company::query()->findOrFail($companyDB['id'])->update([
                'user_id' => $userDB['id']
            ]);

            $admin = User::query()->findOrFail(17);

//            $token = Str::random(64);
//
//            $userVerify = UsersVerify::query()->create([
//                'user_id' => $userDB->id,
//                'token' => $token
//            ]);

            $admin->notify(new SendAdminNewRegisterNotification($admin['id']));
            $userDB->notify(new NewRegisterNotification($userDB['id']));

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

            $companyDB = Company::query()->findOrFail($id);
            $companyDB->update($requestValidated);

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
            $companyDB = Company::query()->with(['user'])->find($id);

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
    public function getSelectCompany()
    {
        $companyDB = Company::query()->whereStatus('Ativo')->orderBy('name', 'ASC')->get();

        $return = [];

        foreach ($companyDB as $key => $itemUser) {
            $return[0]['label'] = 'Escolha';
            $return[0]['value'] = '';
            $return[$key + 1]['label'] = $itemUser['name'];
            $return[$key + 1]['value'] = $itemUser['id'];
        }

        return $return;
    }

    public function getCompanyActive()
    {
        $companyDB = Company::query()->whereStatus('ativo')->orderBy('name', 'ASC')->get();
        return $companyDB;
    }

}
