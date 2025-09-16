<?php

namespace App\Livewire\Contractor\Report\Participants;

use Livewire\Component;

class Filter extends Component
{
    public $filter = [
        'dates' => '',
        'presence' => '',
    ];

    public function clearFilter()
    {
        $this->reset();
        $this->dispatch('clearFilterReportTrainingParticipantsContractor');
    }

    public function submit()
    {
        sleep(1);
        $request = $this->filter;
        $this->dispatch('filterTableReportTrainingParticipantsContractor', filterData: $request);
    }

    public function render()
    {
        return view('livewire.contractor.report.participants.filter');
    }
}
