<?php

namespace App\Requests;

use Illuminate\Support\Facades\Validator;

class ProductRequest
{
    public function validate($request, $id = null)
    {
        $validator =  Validator::validate($request, [
            'category_id' => 'sometimes|nullable',
            'name' => 'required',
            'description' => 'required',
            'type' => 'required',
            'time' => 'required',
            'image' => 'sometimes|nullable',
            'status' => 'required',
        ]);

        return $validator;
    }

}
