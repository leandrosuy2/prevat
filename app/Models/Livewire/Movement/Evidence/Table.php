<?php

namespace App\Livewire\Movement\Evidence;

use App\Models\Evidence;
use App\Models\TrainingParticipations;
use App\Repositories\Movements\EvidenceRepository;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Table extends Component
{
    use WithPagination;

    public $order = [
        'column' => 'created_at',
        'order' => 'DESC'
    ];

    public $filters;

    public $pageSize = 15;

    #[On('filterTableEvidences')]
    public function filterTableEvidences($filterData = null)
    {
        $this->filters = $filterData;
    }

    #[On('clearFilter')]
    public function clearFilter($visible = null)
    {
        $this->filters = null;
    }

    #[On('getEvidences')]
    public function getEvidences()
    {
        $evidenceRepository = new EvidenceRepository();
        $evidenceReturnDB = $evidenceRepository->index($this->order, $this->filters, $this->pageSize)['data'];

        return $evidenceReturnDB;
    }

    #[On('confirmDeleteEvidence')]
    public function delete($id = null)
    {
        $evidenceRepository = new EvidenceRepository();
        $evidenceReturnDB = $evidenceRepository->delete($id);

        if($evidenceReturnDB['status'] == 'success') {
            return redirect()->route('movement.evidence')->with($evidenceReturnDB['status'], $evidenceReturnDB['message']);
        } else if ($evidenceReturnDB['status'] == 'error') {
            return redirect()->back()->with($evidenceReturnDB['status'], $evidenceReturnDB['message']);
        }
    }

    public function downloadPDF($evidence_id)
    {
        $evidenceDB = Evidence::query()->withoutGlobalScopes()->findOrFail($evidence_id);

        return response()->download(storage_path($evidenceDB['file_path']));
    }

    public function render()
    {
        $response = new \stdClass();
        $response->evidences = $this->getEvidences();

        return view('livewire.movement.evidence.table', ['response' => $response]);
    }
}
