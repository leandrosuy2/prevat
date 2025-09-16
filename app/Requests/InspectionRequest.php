<?php

namespace App\Requests;

use Illuminate\Support\Facades\Validator;

class InspectionRequest
{
    public function validate($request, $id = null)
    {
        $validator =  Validator::validate($request, [
            'company_id' => 'required',
            'zip_code' => 'required',
            'address' => 'required',
            'number' => 'required',
            'complement' => 'sometimes|nullable',
            'neighborhood' => 'required',
            'city' => 'required',
            'uf' => 'required',
            'date' => 'required',
            'time' => 'required',
            'step' => 'sometimes|nullable',
        ]);

        return $validator;
    }

    public function validateInfo($request, $id = null)
    {
        $validator =  Validator::validate($request, [
            'action_plan' => 'required',
            'responsible_plan' => 'required',
            'date_execution' => 'required',
        ]);

        return $validator;
    }

}
