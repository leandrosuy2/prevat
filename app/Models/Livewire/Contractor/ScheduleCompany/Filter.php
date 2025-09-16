<?php

namespace App\Livewire\Contractor\ScheduleCompany;

use Livewire\Component;

class Filter extends Component
{
    public $filter = [
        'dates' => '',
    ];

    public function clearFilter()
    {
        $this->reset();
        $this->dispatch('clearFilterContractor');
    }

    public function submit()
    {
        $request = $this->filter;

        $this->dispatch('filterTableScheduleCompanyContractor', filterData: $request);
    }
    public function render()
    {
        return view('livewire.contractor.schedule-company.filter');
    }
}
