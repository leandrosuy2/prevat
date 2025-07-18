<?php

namespace App\Livewire\Client\Participants;

use App\Repositories\ParticipantRepository;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Table extends Component
{
    use WithPagination;

    public $order = [
        'column' => 'name',
        'order' => 'ASC'
    ];

    public $filters;

    public $pageSize = 15;

    #[On('filterTableParticipantsByClient')]
    public function filterTableParticipants($filterData = null)
    {
        $this->filters = $filterData;
    }

    #[On('clearFilter')]
    public function clearFilter($visible = null)
    {
        $this->filters = null;
    }

    #[On('getParticipantsByClient')]
    public function getParticipant()
    {
        $participantRepository = new ParticipantRepository();
        $participantReturnDB = $participantRepository->index($this->order, $this->filters, $this->pageSize)['data'];

        return $participantReturnDB;
    }

    #[On('confirmDeleteParticipantClient')]
    public function delete($id = null)
    {
        $participantRepository = new ParticipantRepository();
        $participantReturnDB = $participantRepository->delete($id);

        if($participantReturnDB['status'] == 'success') {
            return redirect()->route('client.registration.participant')->with($participantReturnDB['status'], $participantReturnDB['message']);
        } else if ($participantReturnDB['status'] == 'error') {
            return redirect()->back()->with($participantReturnDB['status'], $participantReturnDB['message']);
        }
    }

    public function render()
    {
        $response = new \stdClass();
        $response->participants = $this->getParticipant();

        return view('livewire.client.participants.table', ['response' => $response]);
    }
}
