<?php

namespace App\Requests;

use Illuminate\Support\Facades\Validator;

class TrainingRequest
{
    public function validate($request, $id = null)
    {
        $request['value'] = strtr($request['value'], ['.' => '',  ',' => '.', ]);

        $validator =  Validator::validate($request, [
            'category_id' => 'sometimes|nullable',
            'name' => 'required',
            'acronym' => 'required',
            'status' => 'required',
            'value' => 'required',
            'content_title' => 'required',
            'content' => 'required',
            'content02' => 'sometimes|nullable',
            'description' => 'required',
        ]);

        return $validator;
    }

}
