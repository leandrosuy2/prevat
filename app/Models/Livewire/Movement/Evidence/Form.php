<?php

namespace App\Livewire\Movement\Evidence;

use App\Repositories\CompanyContractRepository;
use App\Repositories\CompanyRepository;
use App\Repositories\Movements\EvidenceRepository;
use App\Repositories\Movements\TrainingParticipationsRepository;
use Livewire\Component;
use Livewire\WithFileUploads;

class Form extends Component
{
    use WithFileUploads;

    public $state = [
        'date' => '',
        'training_participation_id' => '',
        'company_id' => '',
        'contract_id' => '',
        'status' => ''
    ];

    public $evidence;

    public function mount($id = null)
    {
        $evidenceRepository = new EvidenceRepository();
        $evidenceReturnDB = $evidenceRepository->show($id)['data'];
        $this->evidence = $evidenceReturnDB;

        if($this->evidence){
            $this->state = $this->evidence->toArray();
        }
    }

    public function updatedStateTrainingParticipationID()
    {
        $trainingParticipationRepository = new TrainingParticipationsRepository();
        $return = $trainingParticipationRepository->show($this->state['training_participation_id'])['data'];

        $this->state['date'] = $return['date_event'] ?? '';
     }

    public function save()
    {
        if($this->evidence){
            return $this->update();
        }

        $request = $this->state;

        $evidenceRepository = new EvidenceRepository();
        $evidenceReturnDB = $evidenceRepository->create($request);

        if($evidenceReturnDB['status'] == 'success') {
            return redirect()->route('movement.evidence')->with($evidenceReturnDB['status'], $evidenceReturnDB['message']);
        } else if ($evidenceReturnDB['status'] == 'error') {
            return redirect()->back()->with($evidenceReturnDB['status'], $evidenceReturnDB['message']);
        }
    }

    public function update()
    {
        $request = $this->state;

        $evidenceRepository = new EvidenceRepository();
        $evidenceReturnDB = $evidenceRepository->update($request, $this->evidence->id);

        if($evidenceReturnDB['status'] == 'success') {
            return redirect()->route('movement.evidence')->with($evidenceReturnDB['status'], $evidenceReturnDB['message']);
        } else if ($evidenceReturnDB['status'] == 'error') {
            return redirect()->back()->with($evidenceReturnDB['status'], $evidenceReturnDB['message']);
        }
    }
    public function getSelectTraining()
    {
        $trainingRepository = new TrainingParticipationsRepository();
        return $trainingRepository->getSelectSchedulePrevat();
    }

    public function getSelectCompanies()
    {
        $trainingRepository = new TrainingParticipationsRepository();

        if($this->state['training_participation_id'] != null) {
            return $trainingRepository->getSelectCompabyByTraining($this->state['training_participation_id']);
        }

        return $trainingRepository->getSelectCompabyByTraining();
    }

    public function getContratsByCompany()
    {
        $companyContractsRepository = new CompanyContractRepository();
        return $companyContractsRepository->getSelectContracts($this->state['company_id']);
    }
    public function render()
    {
        $response = new  \stdClass();
        $response->companies = $this->getSelectCompanies();
        $response->trainings = $this->getSelectTraining();
        $response->contracts = $this->getContratsByCompany();

        return view('livewire.movement.evidence.form', ['response' => $response]);
    }
}
