<?php

namespace App\Requests;

use Illuminate\Support\Facades\Validator;

class ParticipantRoleRequest
{
    public function validate($request, $id = null)
    {
        $validator =  Validator::validate($request, [
            'name' => 'required',
            'status' => 'required',
        ]);
        return $validator;
    }

}
