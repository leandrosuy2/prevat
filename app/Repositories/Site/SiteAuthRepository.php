<?php

namespace App\Repositories\Site;

use App\Models\User;
use App\Notifications\ResetPasswordNotification;
use App\Requests\Auth\AuthRequest;
use App\Requests\Site\SiteAuthRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use PHPUnit\Exception;

class SiteAuthRepository
{
    public function login($request)
    {
        $authRequest = new AuthRequest();
        $requestValidated = $authRequest->validate($request);

        $user = User::query()->with('company')->where('email', '=', $requestValidated['email'])->whereStatus('Ativo')
            ->first();

        if ($user && Auth::attempt(['email' => $user['email'], 'password' => $requestValidated['password']])) {
//            $this->setSession($user->tenant->only('name', 'color', 'bg_color_primary', 'scope', 'logo'));
            return [
                'status' => 'success',
                'data' => $user,
                'code' => 200,
                'message' => 'Login efetuado com sucesso, Seja Bem Vindo'
            ];
        } else {
            return [
                'status' => 'error',
                'code' => 400,
                'message' => 'Usuários e senha inválidos'
            ];
        }
    }

    public function passwordRecovery($request)
    {
        Log::info('Site password recovery request started', ['email' => $request['email']]);

        $authRequest = new AuthRequest();
        $requestValidated = $authRequest->validateEmail($request);
        Log::info('Site password recovery request validated', ['email' => $requestValidated['email']]);

        $user = User::query()->where('email', '=', $requestValidated['email'])->whereStatus('Ativo')
            ->first();

        if(!$user){
            Log::warning('Site password recovery failed - User not found or inactive', ['email' => $requestValidated['email']]);
            return [
                'status' => 'error',
                'code' => 400,
                'message' => 'Usuáro Inativo ou Inexistente'
            ];
        }

        try {
            Log::info('Site checking for existing password reset token', ['user_id' => $user->id]);
            $tokenData = DB::table('password_reset_tokens')
                ->where('email', $user['email'])->first();

            if($tokenData){
                Log::warning('Site password recovery failed - Token already exists', ['user_id' => $user->id]);
                return [
                    'status' => 'error',
                    'code' => 400,
                    'message' => 'Voce já fez uma requisição para alterar a senha por favor veja em seu email as instruções para alterar a sua senha.'
                ];
            } else {
                Log::info('Site creating new password reset token', ['user_id' => $user->id]);
                DB::table('password_reset_tokens')->insert([
                    'email' => $requestValidated['email'],
                    'token' => Str::random(60),
                    'created_at' => Carbon::now()
                ]);
            }

            $tokenData = DB::table('password_reset_tokens')
                ->where('email', $requestValidated['email'])->first();

            Log::info('Site attempting to send reset email', ['user_id' => $user->id]);
            if ($this->sendResetEmail($requestValidated['email'], $tokenData->token)) {
                Log::info('Site password reset email sent successfully', ['user_id' => $user->id]);
                return [
                    'status' => 'success',
                    'code' => 504,
                    'message' => 'Senha Enviada com sucesso, por favor veja seu email as instruções para cadastrar uma nova senha'
                ];
            }
        }catch (\PHPUnit\Util\Exception $exception) {
            Log::error('Site password recovery error', [
                'user_id' => $user->id,
                'error' => $exception->getMessage()
            ]);
            return [
                'status' => 'error',
                'code' => 400,
                'message' => 'Houve um erro no sistema, por favor tente novamente.'
            ];
        }
    }

    public function changePassword($request)
    {
        Log::info('Site password change attempt started', ['token' => $request['token']]);

        $authRequest = new AuthRequest();
        $requestValidated = $authRequest->validatePassword($request);
        Log::info('Site password change request validated');

        $tokenData = DB::table('password_reset_tokens')
            ->where('token', $requestValidated['token'])->first();

        if (!$tokenData) {
            Log::warning('Site password change failed - Invalid or expired token');
            return [
                'status' => 'error',
                'code' => 400,
                'message' => 'Voce nao fez requisição para mudar a senha ou o seu token expirou preencha seu email abaixo'
            ];
        }

        $user = User::where('email', $tokenData->email)->first();

        if (!$user){
            Log::warning('Site password change failed - User not found', ['email' => $tokenData->email]);
            return [
                'status' => 'error',
                'code' => 504,
                'message' => 'Email não encontrado, por favor refaça sua requisição de nova senha com um email válido.'
            ];
        }

        try{
            Log::info('Site updating user password', ['user_id' => $user->id]);
            $user->password = $requestValidated['password'];
            $user->update();

            Auth::login($user);
            Log::info('Site user logged in after password change', ['user_id' => $user->id]);

            DB::table('password_reset_tokens')->where('email', $user->email)
                ->delete();
            Log::info('Site password reset token deleted', ['user_id' => $user->id]);

            return [
                'status' => 'success',
                'code' => 504,
                'message' => 'Senha Alterada com sucesso por favor faça o seu login'
            ];

        }catch (Exception $exception) {
            Log::error('Site password change error', [
                'user_id' => $user->id,
                'error' => $exception->getMessage()
            ]);
            return [
                'status' => 'error',
                'code' => 400,
                'message' => 'Houve um erro no sistema, por favor tente novamente.'
            ];
        }
    }

    private function sendResetEmail($email, $token)
    {
        Log::info('Site sending password reset email', ['email' => $email]);
        
        $user = User::query()->where('email', $email)->first();
        $link = route('password.reset') . '?token=' . $token . '&email=' . urlencode($user->email);

        try {
            $user->notify(new ResetPasswordNotification($link));
            Log::info('Site password reset email sent successfully', ['user_id' => $user->id]);
            return true;
        } catch (\Exception $exception) {
            Log::error('Site failed to send password reset email', [
                'user_id' => $user->id,
                'error' => $exception->getMessage()
            ]);
            return false;
        }
    }
}
