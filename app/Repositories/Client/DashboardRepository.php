<?php

namespace App\Repositories\Client;

use App\Models\ScheduleCompanyParticipants;
use Illuminate\Support\Facades\Auth;

class DashboardRepository
{
    public function getCountPresences($presence)
    {
        $presenceDB = ScheduleCompanyParticipants::query()->with('schedule_company');

        $presenceDB->whereHas('schedule_company', function($query) use ($presence){
            $query->where('company_id', Auth::user()->company->id);
            $query->where('contract_id', Auth::user()->company->contract_id);
            $query->where('presence', $presence);

            $query->whereHas('schedule', function ($query){
                $query->where('status', 'Concluido');
            });
        });

        return $presenceDB->count();
    }
}
