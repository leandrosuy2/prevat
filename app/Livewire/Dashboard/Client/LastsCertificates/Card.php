<?php

namespace App\Livewire\Dashboard\Client\LastsCertificates;

use App\Models\Evidence;
use App\Repositories\Movements\EvidenceRepository;
use App\Trait\Interactions;
use Livewire\Component;

class Card extends Component
{
    use Interactions;
    public function getLastsCertificates()
    {
        $certificates = Evidence::query()
            ->with(['training_participation.schedule_prevat.training'])
            ->orderBy('created_at', 'asc')
            ->take(5)
            ->get();
        
        \Log::info('Dashboard Client - Últimos certificados: ' . $certificates->count());
        
        return $certificates;
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
        $response->certificates = $this->getLastsCertificates();

        return view('livewire.dashboard.client.lasts-certificates.card', ['response' => $response]);
    }
}
