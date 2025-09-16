<?php

namespace App\Livewire\Movement\Evidence;

use App\Models\Evidence;
use App\Models\TrainingParticipations;
use App\Repositories\Movements\EvidenceRepository;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Log;
use Livewire\WithFileUploads;

class Table extends Component
{
    use WithPagination, WithFileUploads;

    public $order = [
        'column' => 'date',
        'order' => 'DESC'
    ];

    public $filters;

    public $pageSize = 15;

    public $licenca_numero;
    public $licenca_validade;
    public $licenca_protocolo;
    public $evidence_id_for_download;

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

    #[On('toggleOrderByDate')]
    public function toggleOrderByDate()
    {
        if ($this->order['column'] === 'date') {
            $this->order['order'] = $this->order['order'] === 'DESC' ? 'ASC' : 'DESC';
        } else {
            $this->order['column'] = 'date';
            $this->order['order'] = 'DESC';
        }
    }

    public function openDownloadModal($evidence_id)
    {
        $this->evidence_id_for_download = $evidence_id;
        $this->licenca_numero = '';
        $this->licenca_validade = '';
        $this->licenca_protocolo = '';
        $this->dispatch('openDownloadModal');
    }

    public function downloadPDFWithData()
    {
        $evidence_id = $this->evidence_id_for_download;
        $licenca_numero = $this->licenca_numero;
        $licenca_validade = $this->licenca_validade;
        $licenca_protocolo = $this->licenca_protocolo;
        $this->dispatch('closeDownloadModal');
        return app()->call([
            $this,
            'downloadPDFCustom'
        ], compact('evidence_id', 'licenca_numero', 'licenca_validade', 'licenca_protocolo'));
    }

    public function downloadPDFCustom($evidence_id, $licenca_numero, $licenca_validade, $licenca_protocolo)
    {
        \Log::info('Livewire: downloadPDFCustom chamado', [
            'evidence_id' => $evidence_id,
            'licenca_numero' => $licenca_numero,
        ]);
        $evidenceRepository = new \App\Repositories\Movements\EvidenceRepository();
        $result = $evidenceRepository->generateCertificatesPDFCustom($evidence_id, $licenca_numero, $licenca_validade, $licenca_protocolo);
        if ($result['status'] === 'success') {
            $filePath = public_path('storage/' . $result['data']['file_path']);
            return response()->download($filePath);
        } else {
            session()->flash('error', $result['message'] ?? 'Erro ao gerar PDF');
            return null;
        }
    }

    public function downloadPDF($evidence_id)
    {
        $evidenceDB = \App\Models\Evidence::query()->withoutGlobalScopes()->findOrFail($evidence_id);
        $fullPath = public_path('storage/' . $evidenceDB['file_path']);
        if (!file_exists($fullPath)) {
            session()->flash('error', 'Arquivo não encontrado.');
            return null;
        }
        return response()->download($fullPath);
    }

    public function render()
    {
        $response = new \stdClass();
        $response->evidences = $this->getEvidences();
        $order = $this->order;
        return view('livewire.movement.evidence.table', ['response' => $response, 'order' => $order]);
    }
}
