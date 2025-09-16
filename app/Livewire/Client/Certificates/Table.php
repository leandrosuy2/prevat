<?php

namespace App\Livewire\Client\Certificates;

use App\Repositories\Movements\EvidenceRepository;
use App\Trait\Interactions;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class Table extends Component
{
    use Interactions;

    public $order = [
        'column' => 'date',
        'order' => 'DESC'
    ];

    public function getEvidences()
    {
        $evidenceRepository = new EvidenceRepository();
        return $evidenceRepository->index($this->order)['data'];
    }

    public function download($id = null)
    {
        $evidenceRepository = new EvidenceRepository();
        $evidenceReturnDB = $evidenceRepository->downloadClient($id);

        if($evidenceReturnDB['status'] == 'success') {
            $this->sendNotificationSuccess('Sucesso', $evidenceReturnDB['message']);
            return response()->download(public_path('storage/' . $evidenceReturnDB['data']['file_path']));
        } elseif ($evidenceReturnDB['status'] == 'error') {
            $this->sendNotificationDanger('Erro', $evidenceReturnDB['message']);
        }
    }

    public function render()
    {
        $response = new \stdClass();
        $response->evidences = $this->getEvidences();

        return view('livewire.client.certificates.table', ['response' => $response]);
    }
}
