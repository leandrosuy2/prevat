<?php

namespace App\Requests;

use Illuminate\Support\Facades\Validator;

class WithdrawalProtocolRequest
{
    public function validate($request, $id = null)
    {
        $validator =  Validator::validate($request, [
            'company_id' => 'required',
            'contract_id' => 'required',
            'training_participation_id' => 'required',
            'name' => 'required',
            'document' => 'required',
        ]);
        return $validator;
    }

}
