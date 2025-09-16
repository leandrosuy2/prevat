<?php

namespace App\Requests;

use Illuminate\Support\Facades\Validator;

class CompanyContractRequest
{
    public function validate($request, $id = null)
    {
        $validator = Validator::validate($request, [
            'contractor_id' => 'sometimes|nullable',
            'name' => 'required',
            'contract' => 'required',
            'status' => 'required',
        ]);

        return $validator;
    }
}
