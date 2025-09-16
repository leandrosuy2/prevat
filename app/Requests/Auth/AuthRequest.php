<?php

namespace App\Requests\Auth;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class AuthRequest
{
    public function validate($request)
    {
        $validator =  Validator::validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        return $validator;
    }

    public function validateEmail($request)
    {
        $validator =  Validator::validate($request, [
            'email' => 'required|email|exists:users',
        ]);

        return $validator;
    }

    public function validatePassword($request, $id = null)
    {

        $validator =  Validator::validate($request, [
            'token' => 'sometimes',
            'email' => 'sometimes|email',
            'password' => [
                'required',
                'string',
                Password::min(8)
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
                    ->uncompromised(),
                'confirmed',
            ],
        ]);

        return $validator;
    }
}
