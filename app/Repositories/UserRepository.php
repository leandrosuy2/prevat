<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\UsersContracts;
use App\Requests\UserRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use PHPUnit\Exception;

class UserRepository
{
    public function index($orderBy, $filterData = null, $pageSize = null)
    {
        try {
            $userDB = User::query();

            $userDB->where('company_id', Auth::user()->company->id);

            $userDB->orderBy($orderBy['column'], $orderBy['order']);

            if(isset($filterData['search']) && $filterData['search'] != null) {
                $userDB->where('name', 'LIKE', '%'.$filterData['search'].'%');
                $userDB->orWhere('email', 'LIKE', '%'.$filterData['search'].'%');
                $userDB->orWhere('document', 'LIKE', '%'.$filterData['search'].'%');
            }

            if(isset($filterData['status']) && $filterData['status'] != null) {
                $userDB->where('status', $filterData['status']);
            }

            if($pageSize) {
                $userDB = $userDB->paginate($pageSize);
            } else {
                $userDB = $userDB->get();
            }

            return [
                'status' => 'success',
                'data' => $userDB,
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
        $userRequest = new UserRequest();
        $requestValidated = $userRequest->validate($request);

        if($image != null){
            $requestValidated['profile_photo_path'] = $image->store('users', 'public');
        }

        if(Auth::user()->company->type == 'cliente') {
            $requestValidated['notifications'] == 'Inativo';
        }

        try {
            DB::beginTransaction();

            $userDB = User::query()->create($requestValidated);

            if(Auth::user()->company->type == 'client') {
                UsersContracts::query()->create([
                    'user_id' => $userDB['id'],
                    'contract_id' => $userDB['contract_id']
                ]);
            }

            if(Auth::user()->company->type == 'admin') {
                $userDB->assignRole($userDB['role']['name']);
            }

            DB::commit();
            return [
                'status' => 'success',
                'data' => $userDB,
                'code' => 200,
                'message' => 'Usuário cadastrado com sucesso !'
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

    public function update($request, $id, $image = null)
    {
        $userRequest = new UserRequest();
        $requestValidated = $userRequest->validate($request, $id);



        try {
            DB::beginTransaction();

            $userDB = User::query()->with(['role'])->findOrFail($id);

            if(isset($image) && $image != $userDB->profile_photo_path){
                if(Storage::exists('public/'.$userDB->profile_photo_path)) {
                    Storage::delete('public/'.$userDB->profile_photo_path);
                }
                $requestValidated['profile_photo_path'] = $image->store('users', 'public');
            }


            $userDB->update($requestValidated);
            $userDB =  $userDB->fresh();

            if($userDB['role_id'] != $requestValidated['role_id'] && Auth::user()->company->type == 'admin') {
                $userDB->removeRole($userDB['role']['name']);
                $userDB->assignRole($userDB['role']['name']);
            } else {
                $userDB->assignRole($userDB['role']['name']);
            }

            DB::commit();

            return [
                'status' => 'success',
                'data' => $userDB,
                'code' => 200,
                'message' => 'Colaborador atualizado com sucesso !'
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
            $userDB = User::query()->with(['contracts', 'contract_default'])->find($id);

            if($userDB && Auth::user()->company->type == 'client' && $userDB['company_id'] != Auth::user()->company_id) {
                abort(404);
            }

            return [
                'status' => 'success',
                'data' => $userDB,
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

            $userDB = User::query()->findOrFail($id);

            if($userDB['profile_photo_path']){
                if(Storage::exists('public/'.$userDB['profile_photo_path'])) {
                    Storage::delete('public/'.$userDB['profile_photo_path']);
                }
            }

            $userDB->delete();

            DB::commit();
            return [
                'status' => 'success',
                'data' => $userDB,
                'code' => 200,
                'message' => 'Usuario deletado com sucesso !'
            ];

        } catch (\Exception $exception) {
            return [
                'status' => 'error',
                'code' => 400,
                'message' => 'Erro ao deletar'
            ];
        }
    }
    public function getSelectUsers()
    {
        $userDB = User::query()->orderBy('name', 'ASC')->get();

        $return = [];

        foreach ($userDB as $key => $itemUser) {
            $return[0]['label'] = 'Escolha';
            $return[0]['value'] = '';
            $return[$key + 1]['label'] = $itemUser['name'];
            $return[$key + 1]['value'] = $itemUser['id'];
        }

        return $return;
    }

    public function getUsersByActive()
    {
        $userDB = User::query()->orderBy('name', 'ASC')->get();
        return $userDB;
    }

    public function uploadImage($id, $image)
    {
        try {
            $userDB = User::query()->findOrFail($id);

            if(isset($image) && $image != $userDB->profile_photo_path){
                if(Storage::exists('public/'.$userDB->profile_photo_path)) {
                    Storage::delete('public/'.$userDB->profile_photo_path);
                }
                $requestValidated['profile_photo_path'] = $image->store('users/image', 'public');
            } else {
                $requestValidated['profile_photo_path'] = $userDB->profile_photo_path;
            }


            $userDB->update($requestValidated);
            $userDB->fresh();

            return [
                'status' => 'success-image',
                'data' => $userDB,
                'code' => 202,
                'message' => 'Imagem atualizada com sucesso !'
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
