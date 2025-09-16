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
        $certificates = Evidence::query()->with('training')->orderBy('created_at', 'asc')->take(5)->get();
        
        \Log::info('Dashboard Client - Últimos certificados: ' . $certificates->count());
        
        return $certificates;
    }

    public function download($id = null)
    {
        $evidenceRepository = new EvidenceRepository();
        $evidenceReturnDB = $evidenceRepository->downloadClient($id);

        if($evidenceReturnDB['status'] == 'success') {
            $this->sendNotificationSuccess('Sucesso', $evidenceReturnDB['message']);
            return response()->download(storage_path($evidenceReturnDB['data']['file_path']));
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
