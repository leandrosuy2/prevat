<?php

namespace App\Livewire\Registration\ProfessionalQualification;

use App\Repositories\ProfessionalQualificationRepository;
use Livewire\Component;

class Form extends Component
{
    public $state = [
        'status' => '',
    ];

    public $professional;

    public function mount($id = null)
    {
        $professionalQualificationRepository = new ProfessionalQualificationRepository();
        $professionalQualificationReturnDB = $professionalQualificationRepository->show($id)['data'];
        $this->professional = $professionalQualificationReturnDB;

        if($this->professional){
            $this->state = $this->professional->toArray();
        }
    }

    public function save()
    {
        if($this->professional){
            return $this->update();
        }

        $request = $this->state;

        $professionalQualificationRepository = new ProfessionalQualificationRepository();
        $professionalQualificationReturnDB = $professionalQualificationRepository->create($request);

        if($professionalQualificationReturnDB['status'] == 'success') {
            return redirect()->route('registration.professional-qualification')->with($professionalQualificationReturnDB['status'], $professionalQualificationReturnDB['message']);
        } else if ($professionalQualificationReturnDB['status'] == 'error') {
            return redirect()->route('registration.professional-qualification')->with($professionalQualificationReturnDB['status'], $professionalQualificationReturnDB['message']);
        }
    }

    public function update()
    {
        $request = $this->state;
        $professionalQualificationRepository = new ProfessionalQualificationRepository();

        $professionalQualificationReturnDB = $professionalQualificationRepository->update($request, $this->professional->id);

        if($professionalQualificationReturnDB['status'] == 'success') {
            return redirect()->route('registration.professional-qualification')->with($professionalQualificationReturnDB['status'], $professionalQualificationReturnDB['message']);
        } else if ($professionalQualificationReturnDB['status'] == 'error') {
            return redirect()->route('registration.professional-qualification')->with($professionalQualificationReturnDB['status'], $professionalQualificationReturnDB['message']);
        }
    }

    public function render()
    {
        return view('livewire.registration.professional-qualification.form');
    }
}
