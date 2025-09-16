<?php

namespace App\Requests;

use Illuminate\Support\Facades\Validator;

class CountryRequest
{
    public function validate($request, $id = null)
    {
        $validator =  Validator::validate($request, [
            'city' => 'required',
            'uf' => 'required',
            'status' => 'required',
        ]);
        return $validator;
    }

}
