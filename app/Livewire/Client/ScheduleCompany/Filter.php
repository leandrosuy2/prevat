<?php

namespace App\Livewire\Client\ScheduleCompany;

use Livewire\Component;

class Filter extends Component
{
    public $filter = [
        'date_start' => '',
        'date_end' => ''
    ];

    public function clearFilter()
    {
        $this->reset();
        $this->dispatch('clearFilterClient');
    }

    public function submit()
    {
        $request = $this->filter;
        $this->dispatch('filterTableScheduleCompanyClient', filterData: $request);
    }
    public function render()
    {
        return view('livewire.client.schedule-company.filter');
    }
}
