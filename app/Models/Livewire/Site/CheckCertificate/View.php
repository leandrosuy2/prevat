<?php

namespace App\Livewire\Site\CheckCertificate;

use App\Models\TrainingCertificates;
use Livewire\Component;

class View extends Component
{
    public $certificate;

    public function mount($reference =  null)
    {
        $trainingCertificateDB = TrainingCertificates::query()->with([
            'participant'=> fn ($query) => $query->withoutGlobalScopes(),
            'company'=> fn ($query) => $query->withoutGlobalScopes(),
            'training'
        ])
            ->where('reference', $reference)->withoutGlobalScopes()
            ->first();


            $this->certificate =$trainingCertificateDB;

    }

    public function render()
    {
        return view('livewire.site.check-certificate.view');
    }
}
