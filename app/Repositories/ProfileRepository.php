<?php

namespace App\Repositories;

use App\Models\User;
use App\Requests\ProfileRequest;
use Illuminate\Support\Facades\DB;

class ProfileRepository
{

    public function show($id)
    {
        try {
            $userDB = User::query()->find($id);

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

    public function update($id, $request)
    {
        $profileRequest = new ProfileRequest();
        $requestValidated = $profileRequest->validate($request, $id);

        try {
            DB::beginTransaction();

            $userDB = User::query()->findOrFail($id);
            $userDB->update($requestValidated);

            DB::commit();
            return [
                'status' => 'profile-updated',
                'data' => $userDB,
                'code' => 200,
                'message' => 'Usuário atualizado com sucesso !'
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
}
