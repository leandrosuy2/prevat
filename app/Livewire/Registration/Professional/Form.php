<?php

namespace App\Livewire\Registration\Professional;

use App\Models\ProfessionalsFormation;
use App\Repositories\ProfessionalQualificationRepository;
use App\Repositories\ProfessionalRepository;
use Illuminate\Support\Collection;
use Livewire\Component;
use Livewire\WithFileUploads;

class Form extends Component
{
    use WithFileUploads;
    public Collection $formations;
    public $formationsToDelete = [];

    public $state = [
        'status' => '',
    ];
    public $signature_image;

    public $professional;

    public function mount($id = null)
    {
        $professionalRepository = new ProfessionalRepository();
        $professionalReturnDB = $professionalRepository->show($id)['data'];
        $this->professional = $professionalReturnDB;

        if($this->professional){
            $this->state = $this->professional->toArray();
            $professionalsFormationDB = ProfessionalsFormation::query()->where('professional_id', $id)->get()->toArray();
            foreach ($professionalsFormationDB as $key => $value) {
                $return['data'][$key] = $value;
                $this->fill([
                    'formations' => collect($return['data']),
                ]);
            }
        } else {
            $this->fill([
                'formations' => collect([['qualification_id' => '']]),
            ]);
        }
    }

    public function updatedSignatureImage()
    {
        if($this->signature_image){
            $this->validate([
                'signature_image' => 'required|image|mimes:jpeg,png,jpg|max:2048', // 2MB Max
            ]);
        }
    }

    public function addInput()
    {
        $this->formations->push(['qualification_id' => '']);
    }

    public function removeInput($key, $id = null)
    {
        $this->formations->pull($key);
        $this->formationsToDelete[] += $id;
    }

    public function save()
    {
        if($this->professional) {
            return $this->update();
        }


        $requestValidated = $this->validate([
            'state.name' => 'required',
            'state.registry' => 'required',
            'state.status' => 'required',
            'state.phone' => 'sometimes|nullable',
            'state.email' => 'sometimes|nullable',
            'state.document' => 'sometimes|nullable',
            'formations.*.id' => 'sometimes',
            'formations.*.qualification_id' => 'required',
            'signature_image' => 'sometimes|nullable|image|mimes:jpeg,png,jpg|max:2048', // 2MB Max
        ],[
            'formations.*.qualification_id' => ' Campo formação é obrigatório',
        ]);


        $professionalRepository = new ProfessionalRepository();
        $professionalReturnDB = $professionalRepository->create($requestValidated);

        if($professionalReturnDB['status'] == 'success') {
            return redirect()->route('registration.professional')->with($professionalReturnDB['status'], $professionalReturnDB['message']);
        } else if ($professionalReturnDB['status'] == 'error') {
            return redirect()->route('registration.professional')->with($professionalReturnDB['status'], $professionalReturnDB['message']);
        }
    }

    public function update()
    {
        $formationsToDelete = $this->formationsToDelete;

        $requestValidated = $this->validate([
            'state.name' => 'required',
            'state.registry' => 'required',
            'state.status' => 'required',
            'state.phone' => 'sometimes|nullable',
            'state.email' => 'sometimes|nullable',
            'state.document' => 'sometimes|nullable',
            'formations.*.id' => 'sometimes',
            'formations.*.qualification_id' => 'required',
            'signature_image' => 'sometimes|nullable|image|mimes:jpeg,png,jpg|max:2048', // 2MB Max
        ],[
            'formations.*.qualification_id' => ' Campo formação é obrigatório',
        ]);

        $professionalRepository = new ProfessionalRepository();
        $professionalReturnDB = $professionalRepository->update($this->professional->id, $requestValidated, $formationsToDelete);

        if($professionalReturnDB['status'] == 'success') {
            return redirect()->route('registration.professional')->with($professionalReturnDB['status'], $professionalReturnDB['message']);
        } else if ($professionalReturnDB['status'] == 'error') {
            return redirect()->route('registration.professional')->with($professionalReturnDB['status'], $professionalReturnDB['message']);
        }
    }
    public function getSelectQualifications()
    {
        $professionalQualificationsRepository = new ProfessionalQualificationRepository();
        return $professionalQualificationsRepository->getSelectProfessionaQualification();
    }

    public function render()
    {
        $response = new \stdClass();
        $response->qualificatons = $this->getSelectQualifications();

        return view('livewire.registration.professional.form', ['response' => $response]);
    }
}
