<?php

namespace App\Requests\Site;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class SiteAuthRequest
{
    public function validate($request)
    {
        $validator =  Validator::validate($request, [
            'email' => 'required|email',
            'password' => 'required',
            'contract' => 'required'
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
