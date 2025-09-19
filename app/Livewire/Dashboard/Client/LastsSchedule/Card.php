<?php

namespace App\Livewire\Dashboard\Client\LastsSchedule;

use App\Models\ScheduleCompany;
use Livewire\Component;

class Card extends Component
{
    public function getLastScheduleCompanies()
    {
        $scheduleCompanies = ScheduleCompany::query()
            ->with([
                'schedule' => function($query) {
                    $query->withoutGlobalScopes();
                },
                'schedule.training',
                'schedule.location', 
                'schedule.room', 
                'company'
            ])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
        
        \Log::info('Dashboard Client - Últimos agendamentos: ' . $scheduleCompanies->count());
        
        return $scheduleCompanies;
    }

    public function render()
    {
        $response = new \stdClass();
        $response->scheduleCompanies = $this->getLastScheduleCompanies();

        return view('livewire.dashboard.client.lasts-schedule.card', ['response' => $response]);
    }
}
