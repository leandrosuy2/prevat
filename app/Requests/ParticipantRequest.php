<?php

namespace App\Requests;

use App\Rules\ParticipantCompanyUnique;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ParticipantRequest
{
    public function validate($request, $id = null)
    {
        $validator =  Validator::validate($request, [
            'company_id' => [
                Rule::requiredIf(fn () => auth()->user()->company->type == 'admin'),
            ],
            'participant_role_id' => 'required',
            'name' => 'required',
            'email' => 'sometimes|nullable',
            'identity_registration' => 'sometimes|nullable',
            'taxpayer_registration' => [
                'required',
                new ParticipantCompanyUnique('participants', $id)
                ],
            'driving_license' => 'sometimes|nullable',
            'status' => 'required',
            'contract_id' => [
                Rule::requiredIf(fn () => auth()->user()->company->type == 'admin'),
            ],
            'signature' => 'sometimes|nullable|string',
        ]);
        return $validator;
    }
}
