<?php

namespace App\Livewire\Reports\Companies;

use Livewire\Component;

class Filter extends Component
{
    public $filter = [
        'dates' => null,
    ];

    public function clearFilter()
    {
        $this->reset();
        $this->dispatch('clearFilterReportCompanies');
    }

    public function submit()
    {
        $request = $this->filter;
        $this->dispatch('filterTableReportCompanies', filterData: $request);
    }

    public function render()
    {
        return view('livewire.reports.companies.filter');
    }
}
