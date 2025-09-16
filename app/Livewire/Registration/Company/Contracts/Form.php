<?php

namespace App\Livewire\Registration\Company\Contracts;

use App\Repositories\CompanyContractRepository;
use App\Repositories\CompanyRepository;
use App\Repositories\ContractorsRepository;
use App\Trait\Interactions;
use App\Trait\WithSlide;
use Livewire\Component;

class Form extends Component
{
    use WithSlide, Interactions;

    public $state = [
        'status' => ''
    ];

    public $contract;
    public $company_id;

    public function mount($id = null, $company_id = null)
    {
        $this->company_id = $company_id;

        $companiesContractRepository = new CompanyContractRepository();
        $contractReturnDB = $companiesContractRepository->show($id)['data'];

        $this->contract = $contractReturnDB;

        if($this->contract){
            $this->state = $this->contract->toArray();
        }
    }

    public function save()
    {
        if($this->contract){
            return $this->update();
        }

        $request = $this->state;

        $companiesContractRepository = new CompanyContractRepository();
        $contractReturnDB = $companiesContractRepository->create($this->company_id, $request);

        if($contractReturnDB['status'] == 'success') {
            $this->dispatch('getContractsByCompany');
            $this->closeModal();
            $this->sendNotificationSuccess('Sucesso', $contractReturnDB['message']);
            $this->reset('state');
            return redirect()->back();
        } else if ($contractReturnDB['status'] == 'error') {
            $this->sendNotificationDanger('Erro', $contractReturnDB['message']);
            $this->closeModal();
        }
    }

    public function update()
    {
        $request = $this->state;
        $companiesContractRepository = new CompanyContractRepository();

        $contractReturnDB = $companiesContractRepository->update($request, $this->contract->id);

        if($contractReturnDB['status'] == 'success') {
            $this->dispatch('getContractsByCompany');
            $this->closeModal();
            $this->sendNotificationSuccess('Sucesso', $contractReturnDB['message']);
            $this->reset('state');
            return redirect()->back();
        } else if ($contractReturnDB['status'] == 'error') {
            $this->sendNotificationDanger('Erro', $contractReturnDB['message']);
            $this->closeModal();
        }
    }

    public function getSelectContractors()
    {
        $contractorsRepository = new ContractorsRepository();
        return $contractorsRepository->getSelectContractor(null, true);
    }

    public function render()
    {
        $response = new \stdClass();
        $response->contractors = $this->getSelectContractors();

        return view('livewire.registration.company.contracts.form', ['response' => $response]);
    }
}
