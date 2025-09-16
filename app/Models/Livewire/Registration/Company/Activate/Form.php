<?php

namespace App\Livewire\Registration\Company\Activate;

use App\Repositories\CompanyRepository;
use App\Repositories\ContractorsRepository;
use App\Trait\Interactions;
use App\Trait\WithSlide;
use Livewire\Component;

class Form extends Component
{

    use WithSlide, Interactions;

    public $state = [
        'contractor_id' => null
    ];
    public $company_id;

    public function mount($id)
    {
        $this->company_id = $id;
    }

    public function save()
    {
        $request = $this->state;

        $companyRepository = new CompanyRepository();
        $companyReturnDB = $companyRepository->activate($this->company_id, $request);

        if($companyReturnDB['status'] == 'success') {
            $this->dispatch('getCompanies');
            $this->closeModal();
            $this->sendNotificationSuccess('Sucesso', $companyReturnDB['message']);
            $this->reset('state');
            return redirect()->back();
        } else if ($companyReturnDB['status'] == 'error') {
            $this->sendNotificationDanger('Erro', $companyReturnDB['message']);
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

        return view('livewire.registration.company.activate.form', ['response' => $response]);
    }
}
