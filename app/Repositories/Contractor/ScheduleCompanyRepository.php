<?php

namespace App\Repositories\Contractor;

use App\Models\ScheduleCompany;
use Illuminate\Support\Facades\Auth;
use PHPUnit\Exception;

class ScheduleCompanyRepository
{

    public function index($orderBy = null, $filterData = null, $pageSize = null)
    {
        try {
            $scheduleCompanyDB = ScheduleCompany::query()->with([
                'schedule.training', 'schedule.location', 'schedule.room', 'schedule.first_time', 'schedule.second_time', 'company', 'contract'
            ]);

            if(Auth::user()->company->type == 'contractor') {
                $scheduleCompanyDB->withoutGlobalScopes();
                $scheduleCompanyDB->whereHas('contract', function($query) use ($filterData){
                    $query->where('contractor_id', Auth::user()->company->id);
                });
            }

            if(isset($filterData['search']) && $filterData['search'] != null) {
                $scheduleCompanyDB->whereHas('schedule.training', function($query) use ($filterData){
                    $query->where('name', 'LIKE', '%'.$filterData['search'].'%');
                    $query->orWhere('acronym', 'LIKE', '%'.$filterData['search'].'%');
                });

                $scheduleCompanyDB->orWhereHas('company', function($query) use ($filterData){
                    $query->where('name', 'LIKE', '%'.$filterData['search'].'%');
                    $query->orWhere('employer_number', 'LIKE', '%'.$filterData['search'].'%');
                });
            }

            if(isset($filterData['dates']) && $filterData['dates'] != null) {
                $scheduleCompanyDB->whereHas('schedule', function($query) use ($filterData){
                    $dates = explode(' to ', $filterData['dates']);
                    if(isset($dates[1])) {
                        $query->whereBetween('date_event', [$dates[0], $dates[1]]);
                    } else {
                        $query->where('date_event', '=', $dates[0]);
                    }
                });
            }

            if($orderBy)  {
                $scheduleCompanyDB->orderBy($orderBy['column'], $orderBy['order']);
            }

            if($pageSize) {
                $scheduleCompanyDB = $scheduleCompanyDB->paginate($pageSize);
            } else {
                $scheduleCompanyDB = $scheduleCompanyDB->get();
            }

            return [
                'status' => 'success',
                'data' => $scheduleCompanyDB,
                'code' => 200
            ];

        } catch (Exception $exception) {
            return [
                'status' => 'error',
                'code' => 400,
                'message' => 'Erro ao Indexar'
            ];
        }
    }
}
