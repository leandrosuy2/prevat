<?php

namespace App\Livewire\Client\Report\Participants;

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
        $this->dispatch('clearFilterReportTrainingParticipantsClient');
    }

    public function submit()
    {
        sleep(1);
        $request = $this->filter;
        $this->dispatch('filterTableReportTrainingParticipantsClient', filterData: $request);
    }
    public function render()
    {
        return view('livewire.client.report.participants.filter');
    }
}
