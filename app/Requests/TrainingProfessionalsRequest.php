<?php

namespace App\Requests;

use Illuminate\Support\Facades\Validator;

class TrainingProfessionalsRequest
{
    public function validate($request, $id = null)
    {
        $validator =  Validator::validate($request, [
            'schedule_prevat_id' => 'required',
            'date_event' => 'required',
//            'company_id' => [
//                Rule::requiredIf(fn () => auth()->user()->company->type == 'admin'),
//            ],
        ]);
        return $validator;
    }

    public function validateProfessionals($request, $id = null)
    {

//        dd($request);
        $validator =  Validator::make($request, [
            '*.professional_id' => 'required',
            '*.professional_formation_id' => 'required',
            'quantity.*' => 'required',
            'note.*' => 'required',
        ],[
            '*.professional_id' => ' O Campo Profissional é obrigatório',
            '*.professional_formation_id' => 'O Campo Formação profissional é obrigatório',

        ]);
        return $validator;
    }
}
