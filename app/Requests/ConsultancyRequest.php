<?php

namespace App\Requests;

use Illuminate\Support\Facades\Validator;

class ConsultancyRequest
{
    public function validate($request, $id = null)
    {
        $validator =  Validator::validate($request, [
            'name' => 'required',
            'description' => 'required',
            'status' => 'required'
        ]);

        return $validator;
    }
}
