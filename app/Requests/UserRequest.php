<?php

namespace App\Requests;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;

class UserRequest
{
    public function validate($request, $id = null)
    {
        $validator =  Validator::validate($request, [
            'role_id' => [
                Rule::requiredIf(fn () => auth()->user()->company->type == 'admin'),
            ],
            'contract_id' => [
                Rule::excludeIf(fn () => auth()->user()->company->type == 'admin'),
                'required'
            ],
            'name' => 'required',
            'phone' => 'required',
            'document' => 'required',
            'email' =>   [
                'required',
                'email:rfc,dns',
                "unique :users,email,{$id},id"
            ],
            'password' => [
                Rule::requiredIf(fn () => $id == null),
                Rules\Password::defaults(),
            ],
            'status' => 'required',
            'notifications' => [
                Rule::excludeIf(fn () => auth()->user()->company->type == 'client'),
                'required'
            ],
        ]);
        return $validator;
    }

}
