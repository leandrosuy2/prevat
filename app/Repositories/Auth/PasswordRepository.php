<?php

namespace App\Repositories\Auth;

use App\Models\User;
use App\Requests\Auth\PasswordRequest;
use Illuminate\Support\Facades\Auth;

class PasswordRepository
{
    public function update($request)
    {
        $passwordRequest = new PasswordRequest();
        $requestValidated = $passwordRequest->validatePassword($request);

        try {
            $userDB = User::query()->findOrFail(Auth::user()->id);

            $userDB->update($requestValidated);
            $userDB->fresh();

            return [
                'status' => 'password-updated',
                'data' => $userDB,
                'code' => 200,
                'message' => 'Senha atualizada com sucesso !'
            ];

        }catch (\Exception $exception) {
            return [
                'status' => 'error',
                'code' => 400,
                'message' => 'Erro ao Atualizar'
            ];
        }


//        $validated = $request->validateWithBag('updatePassword', [
//            'current_password' => ['required', 'current_password'],
//            'password' => ['required', Password::defaults(), 'confirmed'],
//        ]);
//
//        $request->user()->update([
//            'password' => Hash::make($validated['password']),
//        ]);
//
//        return back()->with('status', 'password-updated');
    }
}
