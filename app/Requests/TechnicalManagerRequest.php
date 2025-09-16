<?php

namespace App\Requests;

use Illuminate\Support\Facades\Validator;

class TechnicalManagerRequest
{
    public function validate($request, $id = null)
    {
        $validator =  Validator::validate($request, [
            'name' => 'required',
            'registry' => 'required',
            'formation' => 'required',
            'email' => 'sometimes|nullable',
            'phone' => 'sometimes|nullable',
            'document' => 'sometimes|nullable',
            'status' => 'required',
        ]);
        return $validator;
    }

}
