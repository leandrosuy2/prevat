<?php

namespace App\Requests;

use App\Models\Company;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ServiceOrderContactRequest
{
    public function validate($request, $id = null)
    {
        $validator =  Validator::validate($request, [
            'type' => 'required',
            'name' => [
                Rule::requiredIf(fn () => $request['type'] == 'CNPJ'),
            ],
            'fantasy_name' => [
                Rule::requiredIf(fn () => $request['type'] == 'CNPJ'),
            ],
            'email' => [
                "required",
                "email:rfc,dns",
            ],
            'responsible' => [
                Rule::requiredIf(fn () => $request['type'] == 'CNPJ'),
            ],
            'taxpayer_registration' => [
                Rule::requiredIf(fn () => $request['type'] == 'CPF'),
            ],
            'contact_name' => [
                Rule::requiredIf(fn () => $request['type'] == 'CPF'),
            ],
            'phone' => 'required',
            'employer_number' => [
                Rule::requiredIf(fn () => $request['type'] == 'CNPJ'),
            ],
            'zip_code' => 'required',
            'address' => 'required',
            'number' => 'sometimes|nullable',
            'complement' => 'sometimes|nullable',
            'neighborhood' => 'required',
            'city' => 'required',
            'uf' => 'required',
            'observations' => 'sometimes|nullable',
            'order.due_date' => 'required',
            'order.payment_method_id' => 'required',
        ]);
        return $validator;
    }
}
