<?php

namespace App\Livewire\Registration\Contractors;

use App\Repositories\ContractorsRepository;
use App\Trait\WithSlide;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Table extends Component
{
    use WithPagination, WithSlide;

    public $order = [
        'column' => 'id',
        'order' => 'DESC'
    ];

    public $filters;

    public $pageSize = 15;

    #[On('filterTableContractors')]
    public function filterTableCompanies($filterData = null)
    {
        $this->filters = $filterData;
    }

    #[On('clearFilter')]
    public function clearFilter($visible = null)
    {
        $this->filters = null;
    }

    #[On('getContractors')]
    public function getContractors()
    {
        $contractorRepository = new ContractorsRepository();
        $contractorReturnDB = $contractorRepository->index($this->order, $this->filters, $this->pageSize)['data'];

        return $contractorReturnDB;
    }

    #[On('confirmDeleteContractor')]
    public function delete($id = null)
    {
        $contractorRepository = new ContractorsRepository();
        $contractorReturnDB = $contractorRepository->delete($id);

        if($contractorReturnDB['status'] == 'success') {
            return redirect()->route('registration.contractors')->with($contractorReturnDB['status'], $contractorReturnDB['message']);
        } else if ($contractorReturnDB['status'] == 'error') {
            return redirect()->back()->with($contractorReturnDB['status'], $contractorReturnDB['message']);
        }
    }

    public function render()
    {
        $response = new \stdClass();
        $response->contractors = $this->getContractors();

        return view('livewire.registration.contractors.table', ['response' => $response]);
    }
}
