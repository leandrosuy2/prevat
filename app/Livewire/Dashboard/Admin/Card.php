<?php

namespace App\Livewire\Dashboard\Admin;

use Livewire\Component;
use Carbon\Carbon;

class Card extends Component
{
    public $startDate;
    public $endDate;

    public function mount(): void
    {
        $this->startDate = Carbon::now()->startOfMonth()->format('Y-m-d');
        $this->endDate = Carbon::now()->endOfMonth()->format('Y-m-d');
    }

    public function render()
    {
        return view('livewire.dashboard.admin.card');
    }
}
