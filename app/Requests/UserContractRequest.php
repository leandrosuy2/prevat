<?php

namespace App\Requests;

use Illuminate\Support\Facades\Validator;

class UserContractRequest
{
    public function validate($request, $id = null)
    {
        $validator = Validator::validate($request, [
            'contract_id' => 'required',
        ]);

        return $validator;
    }
}
