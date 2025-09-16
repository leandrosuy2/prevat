<?php

namespace App\Requests\Auth;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class PasswordRequest
{
    public function validatePassword($request)
    {

        $validator =  Validator::validate($request, [

            'current_password' => ['required', 'current_password'],

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
