<?php

namespace App\Livewire\Movement\Evidence\Historic;

use App\Repositories\Movements\EvidenceRepository;
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

    public function getHistoricsEvidence()
    {
        $evidenceRepository = new EvidenceRepository();
        return $evidenceRepository->showHistoricsByEvidence($this->evidence->id)['data'];

    }

    public function render()
    {
        $response = new \stdClass();
        $response->historics = $this->getHistoricsEvidence();

        return view('livewire.movement.evidence.historic.table', ['response' => $response]);
    }
}
