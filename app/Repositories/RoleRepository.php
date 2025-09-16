<?php

namespace App\Repositories;

use App\Requests\RoleRequest;
use Illuminate\Support\Facades\DB;
use PHPUnit\Exception;
use Spatie\Permission\Models\Role;

class RoleRepository
{
    public function index($orderBy)
    {
        try {
            $roleDB = Role::query();

            $roleDB->orderBy($orderBy['column'], $orderBy['order']);

            $roleDB = $roleDB->get();

            return [
                'status' => 'success',
                'data' => $roleDB,
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
        $roleRequest = new RoleRequest();
        $requestValidated = $roleRequest->validate($request);

        $requestValidated['guard_name'] = 'web';

        try {
            DB::beginTransaction();

            $roleDB = Role::query()->create($requestValidated);

            DB::commit();
            return [
                'status' => 'success',
                'data' => $roleDB,
                'code' => 200,
                'message' => 'Função cadastrada com sucesso !'
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
        $roleRequest = new RoleRequest();
        $requestValidated = $roleRequest->validate($request, $id);

        try {
            DB::beginTransaction();

            $roleDB = Role::query()->findOrFail($id);
            $roleDB->update($requestValidated);

            DB::commit();
            return [
                'status' => 'success',
                'data' => $roleDB,
                'code' => 200,
                'message' => 'Função atualizada com sucesso !'
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
            $roleDB = Role::query()->with('permissions')->find($id);

            return [
                'status' => 'success',
                'data' => $roleDB,
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

            $roleDB = Role::query()->findOrFail($id);
            $roleDB->delete();

            DB::commit();
            return [
                'status' => 'success',
                'data' => $roleDB,
                'code' => 200,
                'message' => 'Função deletada com sucesso !'
            ];

        } catch (\Exception $exception) {
            return [
                'status' => 'error',
                'code' => 400,
                'message' => 'Erro ao deletar'
            ];
        }
    }

    public function getSelectRoles()
    {
        $roleDB = Role::query()->orderBy('name', 'ASC')->get();

        $return = [];

        foreach ($roleDB as $key => $itemUser) {
            $return[0]['label'] = 'Escolha';
            $return[0]['value'] = '';
            $return[$key + 1]['label'] = $itemUser['name'];
            $return[$key + 1]['value'] = $itemUser['id'];
        }

        return $return;
    }


    public function syncPermissions($id, $request)
    {
        try {
            $roleDB = Role::query()->findOrFail($id);
            $roleDB->syncPermissions($request);

            return [
                'status' => 'success',
                'data' => $roleDB,
                'code' => 200,
                'message' => 'Permissões atualizadas com sucesso !'
            ];

        }catch (\Exception $exception) {

            return [
                'status' => 'error',
                'code' => 200,
                'message' => 'Erro ao Atualizar'
            ];
        }
    }

}
