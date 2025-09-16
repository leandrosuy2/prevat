<?php

namespace App\Requests;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ScheduleCompanyRequest
{
    public function validate($request, $id = null)
    {
        $validator =  Validator::validate($request, [
            'schedule_prevat_id' => 'required',
            'company_id' => [
                Rule::requiredIf(fn () => auth()->user()->company->type == 'admin'),
            ],
            'contract_id' =>  [
                Rule::requiredIf(fn () => auth()->user()->company->type == 'admin'),
            ]
        ]);
        return $validator;
    }

    public function validatePrice($request)
    {
        $request['price'] = formatDecimal($request['price']);

        $validator =  Validator::validate($request, [
            'price' => 'required',
        ]);
        return $validator;
    }

}
