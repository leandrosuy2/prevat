<?php

namespace App\Requests;

use Illuminate\Support\Facades\Validator;

class TrainingParticipationRequest
{
    public function validate($request, $id = null)
    {
        $validator =  Validator::validate($request, [
            'name' => 'required',
            'acronym' => 'required',
            'status' => 'required',
            'zip-code' => 'required',
            'address' => 'required',
            'number' => 'sometimes|nullable',
            'neighborhood' => 'required',
            'complement' => 'sometimes|nullable',
            'city' => 'required',
            'uf' => 'required',
            'status' => 'required',
        ]);

        return $validator;
    }
}
