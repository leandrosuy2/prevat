<?php

namespace App\Requests\Site;

use Illuminate\Support\Facades\Validator;

class ProductCategoriesRequest
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
