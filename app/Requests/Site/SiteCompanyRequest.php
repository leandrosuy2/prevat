<?php

namespace App\Requests\Site;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class SiteCompanyRequest
{
    public function validate($request, $id = null)
    {
        $validator =  Validator::validate($request, [
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'employer_number' => 'required|min:18|max:18',
            'zip_code' => 'required',
            'address' => 'required',
            'number' => 'sometimes|nullable',
            'complement' => 'sometimes|nullable',
            'neighborhood' => 'required',
            'city' => 'required',
            'uf' => 'required',
            'suggestion_contract' => 'sometimes|nullable',

            'user.name' => 'required',
            'user.email' => [
                'required',
                'email:rfc,dns',
                "unique :users,email,{$id},id"
            ],
//            'user.phone' => 'required',
//            'user.document' => 'required',
            'user.password' => [
                Rule::excludeIf(fn () => $id != null),
                'required',
                'string',
                Password::min(8)
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
                    ->uncompromised(),
            ],
        ]);
        return $validator;
    }
}
