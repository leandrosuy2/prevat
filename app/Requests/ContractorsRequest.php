<?php

namespace App\Requests;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ContractorsRequest
{
    public function validate($request, $id = null)
    {
        $validator =  Validator::validate($request, [
            'contract' => 'required',
            'name' => 'required',
            'email' => 'required|email:rfc,dns',
            'phone' => 'required',
            'employer_number' => 'sometimes|nullable',
            'zip_code' => 'sometimes|nullable',
            'address' => 'sometimes|nullable',
            'number' => 'sometimes|nullable',
            'complement' => 'sometimes|nullable',
            'neighborhood' => 'sometimes|nullable',
            'city' => 'sometimes|nullable',
            'uf' => 'sometimes|nullable',
            'description' => 'sometimes|nullable',
            'status' => 'required',
        ]);
        return $validator;
    }
}
