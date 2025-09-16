<?php

namespace App\Livewire\Reports\ParticipantTraining;

use Livewire\Component;

class Filter extends Component
{
    public $filter = [
        'dates' => null,
        'presence' => null,
        'training' => null,
    ];

    public function clearFilter()
    {
        $this->reset();
        $this->dispatch('clearFilterReportTrainingParticipants');
    }

    public function submit()
    {
        $request = $this->filter;
        $this->dispatch('filterTableReportTrainingParticipants', filterData: $request);
    }

    public function render()
    {
        return view('livewire.reports.participant-training.filter');
    }
}
