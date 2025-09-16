<?php

namespace App\Requests;

use Illuminate\Support\Facades\Validator;

class ServiceOrderRequest
{
    public function validate($request, $id = null)
    {
        $validator =  Validator::validate($request, [
            'company_id' => 'required',
            'contract_id' => 'required',
            'due_date' => 'required',
            'payment_method_id' => 'required',
        ]);

        return $validator;
    }

    public function validateDiscount($request, $id = null)
    {
        $request['value'] = formatDecimal($request['value']);

        $validator =  Validator::validate($request, [
            'type' => 'required',
            'value' => 'required',
        ]);

        return $validator;
    }
}
