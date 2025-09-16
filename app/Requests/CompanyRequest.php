<?php

namespace App\Requests;

use App\Models\Company;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class CompanyRequest
{
    public function validate($request, $id = null)
    {
        $companyDB = Company::query()->with(['user'])->find($id);

        $validator =  Validator::validate($request, [
            'contract' => 'sometimes|nullable',
            'name' => 'required',
            'fantasy_name' => 'sometimes|nullable',
            'email' => [
                "sometimes",
                "email:rfc,dns",
                "unique:companies,email,{$id},id"
            ],
            'phone' => 'sometimes|nullable',
            'employer_number' => 'sometimes|nullable',
            'zip_code' => 'sometimes|nullable',
            'address' => 'sometimes|nullable',
            'number' => 'sometimes|nullable',
            'complement' => 'sometimes|nullable',
            'neighborhood' => 'sometimes|nullable',
            'city' => 'sometimes|nullable',
            'suggestion_contract' => 'sometimes|nullable',
            'uf' => 'sometimes|nullable',
            'status' => 'required',
            'user.name' => 'required',
            'user.email' => [
                "required",
                "email:rfc,dns",
                Rule::unique('users','email')->ignore($companyDB['user']['id'] ?? $id),
            ],
            'user.phone' => 'sometimes|nullable',
            'user.document' => 'sometimes|nullable',
            'user.status' => 'required',
            'user.password' => [
                Rule::requiredIf(fn () => $id == null),
//                'sometimes|nullable',
                'string',
//                Password::min(8)
//                    ->mixedCase()
//                    ->numbers()
//                    ->symbols()
//                    ->uncompromised(),
            ],
        ]);
        return $validator;
    }

    public function validateContract($request, $id = null)
    {
        $validator =  Validator::validate($request, [
            'name' => 'required',
            'contract' => 'required',
            'contractor_id' => 'required'
        ]);
        return $validator;
    }
}
