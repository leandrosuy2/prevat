<?php

namespace App\Requests;

use Illuminate\Support\Facades\Validator;

class ContactsRequest
{
    public function validate($request, $id = null)
    {
        $validator =  Validator::validate($request, [
            'name' => 'required',
            'whatsapp01' => 'sometimes|nullable',
            'whatsapp02' => 'sometimes|nullable',
            'email01' => 'sometimes|nullable',
            'email02' => 'sometimes|nullable',
        ]);

        return $validator;
    }
}
