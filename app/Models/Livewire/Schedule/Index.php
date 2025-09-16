<?php

namespace App\Livewire\Schedule;

use App\Models\SchedulePrevat;
use App\Models\TrainingRoom;
use Carbon\Carbon;
use Livewire\Component;

class Index extends Component
{

    public $value = 0;
    public $date;

    public $startOfWeek;
    public $endOfWeek;

    public function mount()
    {
        $now = Carbon::now();
        $this->date =  $now->startOfWeek();
    }

    public function previous()
    {
        $date = $this->date;

        $previous = $date->addWeek(-1)->format('Y-m-d');

        $this->dispatch('filterScheduleTraining', date:$previous);
    }
    public function next()
    {
        $date = $this->date;

        $next = $date->addWeek(1)->format('Y-m-d');

        $this->dispatch('filterScheduleTraining', date:$next);
    }
    public function render()
    {
        return view('livewire.schedule.index');
    }
}
