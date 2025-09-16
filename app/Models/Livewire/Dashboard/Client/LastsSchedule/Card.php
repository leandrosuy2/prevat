<?php

namespace App\Livewire\Dashboard\Client\LastsSchedule;

use App\Models\ScheduleCompany;
use Livewire\Component;

class Card extends Component
{
    public function getLastScheduleCompanies()
    {
        return  ScheduleCompany::query()->with(['schedule.training','schedule.location', 'schedule.room'])->orderBy('created_at', 'desc')->take(5)->get();
    }

    public function render()
    {
        $response = new \stdClass();
        $response->scheduleCompanies = $this->getLastScheduleCompanies();

        return view('livewire.dashboard.client.lasts-schedule.card', ['response' => $response]);
    }
}
