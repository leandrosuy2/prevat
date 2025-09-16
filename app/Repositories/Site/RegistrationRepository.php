<?php

namespace App\Repositories\Site;

use App\Models\UsersVerify;
use Carbon\Carbon;
use PHPUnit\Exception;

class RegistrationRepository
{
    public function verifyAccount($token)
    {
        $verifyUser = UsersVerify::with('user')->where('token', $token)->first();

        $message = 'Email nao identificado por favor verifique seu cadastro';
        $date = Carbon::now();

        try {
            if(!is_null($verifyUser) ){
                $user = $verifyUser->user;
                if(!$user->email_verified_at) {
                    $verifyUser->user->email_verified_at = $date;
                    $verifyUser->user->status = 'Ativo';
                    $verifyUser->user->save();
                    $message = "Conta Verificada com sucesso! Agora voce pode fazer seu login.";
                } else {
                    $message = "Conta já verificada, voce já pode fazer o seu login.";
                }
                return [
                    'status' => 'success',
                    'code' => 200,
                    'message' => $message
                ];
            }
        } catch (Exception $exception) {
            return [
                'status' => 'error',
                'data' => $exception,
                'code' => 400,
                'message' => 'Erro ao Cadastrar'
            ];
        }
    }
}
