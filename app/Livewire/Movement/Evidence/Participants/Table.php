<?php

namespace App\Livewire\Movement\Evidence\Participants;

use App\Repositories\Movements\EvidenceParticipantsRepository;
use App\Repositories\Movements\EvidenceRepository;
use Livewire\Attributes\On;
use Livewire\Component;

class Table extends Component
{
    public $evidence;

    public function mount($id = null)
    {
        $evidenceRepository = new EvidenceRepository();
        $evidenceReturnDB = $evidenceRepository->show($id)['data'];

        if($evidenceReturnDB) {
            $this->evidence = $evidenceReturnDB;
        }
    }

    #[On('getCertificatesByParticipation')]
    public function getParticipantsByEvidence()
    {
        $evidenceParticipantsRepository = new EvidenceParticipantsRepository();
        return  $evidenceParticipantsRepository->index($this->evidence->id, $this->evidence->company_id)['data'];
    }

    public function render()
    {
        $response = new \stdClass();
        $response->participants = $this->getParticipantsByEvidence();

        return view('livewire.movement.evidence.participants.table', ['response' => $response]);
    }
}
