<?php

namespace App\Requests;

use Illuminate\Support\Facades\Validator;

class SchedulePrevatRequest
{
    public function validate($request, $id = null)
    {
        $toValidate = [
            'training_id' => 'required',
            'workload_id' => 'required',
            'training_room_id' => 'required',
            'training_local_id' => 'required',
            'time01_id' => 'required',
            'time02_id' => 'sometimes|nullable',
            'team_id' => 'sometimes|nullable',
            'contractor_id' => 'required',
            'date_event' => 'required',
            'start_event' => 'required',
            'end_event' => 'required',
            'vacancies' => 'required',
            'days' => 'required',
            'status' => 'required',
            'type' => 'required'
        ];

        if ($this->hasCompany($request)) {
            $toValidate['company_id'] = 'nullable';
        }

        $validator =  Validator::validate($request, $toValidate);

        return $validator;
    }

    private function hasCompany($request)
    {
        return !empty($request['company_id']);
    }
}
