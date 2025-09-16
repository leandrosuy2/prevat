<?php

namespace App\Requests\Site;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class InformationRequest
{
    public function validate($request, $id = null)
    {
        $validator =  Validator::validate($request, [
            'email_01' => 'required',
            'email_02' => 'sometimes|nullable',
            'phone_01' => 'required',
            'phone_02' => 'sometimes|nullable',
            'link_instagram' => 'sometimes|nullable|url',
            'link_facebook' => 'sometimes|nullable|url',
            'link_twitter' => 'sometimes|nullable|url',
            'link_youtube' => 'sometimes|nullable|url',
            'link_linkedin' => 'sometimes|nullable|url',
            'text_footer' => 'sometimes|nullable',
            'text_about' => 'sometimes|nullable',
            'logo' => 'sometimes|nullable',
        ]);
        return $validator;
    }
}
