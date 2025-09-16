<?php

namespace App\Requests;

use Illuminate\Support\Facades\Validator;

class BlogRequest
{
    public function validate($request, $id = null)
    {
        $validator =  Validator::validate($request, [
            'category_id' => 'required',
            'title' => 'required',
            'content' => 'required',
        ]);

        return $validator;
    }
}
