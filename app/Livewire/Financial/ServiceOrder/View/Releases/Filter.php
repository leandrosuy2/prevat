<?php

namespace App\Livewire\Financial\ServiceOrder\View\Releases;

use App\Repositories\ScheduleCompanyRepository;
use Livewire\Component;

class Filter extends Component
{
    public $filter = [
        'status_id' => '',
        'start_date' => '',
        'end_date' => ''
    ];

    public function clearFilter()
    {
        $this->reset();
        $this->dispatch('clearFilterReleasesView');
    }

    public function submit()
    {
        $request = $this->filter;
        $this->dispatch('filterTableReleasesView', filterData: $request);
    }

    public function render()
    {
        return view('livewire.financial.service-order.view.releases.filter');
    }
}
