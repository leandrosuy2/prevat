<?php

namespace App\Livewire\Registration\Company\Contracts;

use App\Repositories\CompanyContractRepository;
use App\Repositories\CompanyRepository;
use App\Trait\Interactions;
use App\Trait\WithSlide;
use Livewire\Attributes\On;
use Livewire\Component;

class Table extends Component
{
    use WithSlide, Interactions;

    public $company;

    public $order = [
        'column' => 'id',
        'order' => 'DESC'
    ];

    public function mount($id = null)
    {
        $companyRepository = new CompanyRepository();
        $companyReturnDB = $companyRepository->show($id)['data'];

        if($companyReturnDB) {
            $this->company = $companyReturnDB;
        }
    }

    #[On('getContractsByCompany')]
    public function getContractsByCompany()
    {
        $companyContractsRepository = new CompanyContractRepository();
        return $companyContractsRepository->index($this->company->id, $this->order)['data'];
    }

    #[On('confirmDeleteContractCompany')]
    public function delete($id = null)
    {
        $companyContractsRepository = new CompanyContractRepository();
        $contractReturnDB = $companyContractsRepository->delete($id);

        if($contractReturnDB['status'] == 'success') {
            return redirect()->route('registration.company.contract', $this->company->id)->with($contractReturnDB['status'], $contractReturnDB['message']);
        } else if ($contractReturnDB['status'] == 'error') {
            return redirect()->back()->with($contractReturnDB['status'], $contractReturnDB['message']);
        }
    }

    public function render()
    {
        $response = new \stdClass();
        $response->contracts = $this->getContractsByCompany();

        return view('livewire.registration.company.contracts.table', ['response' => $response]);
    }
}
