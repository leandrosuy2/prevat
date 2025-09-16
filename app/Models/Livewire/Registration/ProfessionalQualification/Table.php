<?php

namespace App\Livewire\Registration\ProfessionalQualification;

use App\Repositories\ProfessionalQualificationRepository;
use Livewire\Attributes\On;
use Livewire\Component;

class Table extends Component
{
    public $order = [
        'column' => 'name',
        'order' => 'ASC'
    ];

    #[On('getProfessionalQualification')]
    public function getProfessionalQualification()
    {
        $professionalQualificationRepository = new ProfessionalQualificationRepository();
        $professionalQualificationDB = $professionalQualificationRepository->index($this->order)['data'];

        return $professionalQualificationDB;
    }

    #[On('confirmDeleteProfessionalQ')]
    public function delete($id = null)
    {
        $professionalQualificationRepository = new ProfessionalQualificationRepository();
        $professionalQualificationDB = $professionalQualificationRepository->delete($id);

        if($professionalQualificationDB['status'] == 'success') {
            return redirect()->route('registration.professional-qualification')->with($professionalQualificationDB['status'], $professionalQualificationDB['message']);
        } else if ($professionalQualificationDB['status'] == 'error') {
            return redirect()->route('registration.professional-qualification')->with($professionalQualificationDB['status'], $professionalQualificationDB['message']);
        }
    }

    public function render()
    {
        $response = new \stdClass();
        $response->professionalQualifications = $this->getProfessionalQualification();

        return view('livewire.registration.professional-qualification.table', ['response' => $response]);
    }
}
