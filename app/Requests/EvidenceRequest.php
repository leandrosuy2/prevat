<?php

namespace App\Requests;

use Illuminate\Support\Facades\Validator;

class EvidenceRequest
{
    public function validate($request, $id = null)
    {
        $validator =  Validator::validate($request, [
            'date' => 'required',
            'company_id' => 'required',
            'contract_id' => 'required',
            'training_participation_id' => 'required',
            'status' => 'required',
        ]);
        return $validator;
    }
}
