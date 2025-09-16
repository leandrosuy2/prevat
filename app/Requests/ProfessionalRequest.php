<?php

namespace App\Requests;

use Illuminate\Support\Facades\Validator;

class ProfessionalRequest
{
    public function validate($request, $id = null)
    {
        $validator =  Validator::validate($request, [
            'name' => 'required',
            'registry' => 'required',
            'status' => 'required',
        ]);
        return $validator;
    }
}
