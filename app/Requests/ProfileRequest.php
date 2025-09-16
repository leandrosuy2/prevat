<?php

namespace App\Requests;

use Illuminate\Support\Facades\Validator;
class ProfileRequest
{
    public function validate($request, $id = null)
    {
        $validator =  Validator::validate($request, [
            'name' => 'required',
            'email' => [
                'required',
                "unique :users,email,{$id},id"
            ],
            'document' => [
                'required',
                "unique :users,document,{$id},id"
            ],
            'phone' => 'required'
        ]);
        return $validator;
    }
}
