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
            $evidenceData = $evidenceReturnDB['data'];
            
            // Se não há file_path ou o arquivo não existe, gerar o PDF
            if (!$evidenceData['file_path'] || !file_exists(public_path('storage/' . $evidenceData['file_path']))) {
                $result = $evidenceRepository->generateCertificatesPDF($id);
                
                if ($result['status'] !== 'success') {
                    $this->sendNotificationDanger('Erro', $result['message'] ?? 'Erro ao gerar PDF');
                    return null;
                }
                
                // Atualizar com o novo caminho do arquivo
                $evidenceData = $evidenceData->fresh();
            }
            
            $this->sendNotificationSuccess('Sucesso', $evidenceReturnDB['message']);
            return response()->download(public_path('storage/' . $evidenceData['file_path']));
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
