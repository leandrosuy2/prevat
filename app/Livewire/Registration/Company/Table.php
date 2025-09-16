<?php

namespace App\Livewire\Registration\Company;

use App\Repositories\CompanyRepository;
use App\Repositories\UserRepository;
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

    #[On('filterTableCompanies')]
    public function filterTableCompanies($filterData = null)
    {
        $this->filters = $filterData;
    }

    #[On('clearFilter')]
    public function clearFilter($visible = null)
    {
        $this->filters = null;
    }

    #[On('getCompanies')]
    public function getCompanies()
    {
        $companyRepository = new CompanyRepository();
        $companyReturnDB = $companyRepository->index($this->order, $this->filters, $this->pageSize)['data'];

        return $companyReturnDB;
    }

    #[On('confirmDeleteCompany')]
    public function delete($id = null)
    {
        $companyRepository = new CompanyRepository();
        $companyReturnDB = $companyRepository->delete($id);

        if($companyReturnDB['status'] == 'success') {
            return redirect()->route('registration.company')->with($companyReturnDB['status'], $companyReturnDB['message']);
        } else if ($companyReturnDB['status'] == 'error') {
            return redirect()->route('registration.company')->with($companyReturnDB['status'], $companyReturnDB['message']);
        }
    }

    public function render()
    {
        $response = new \stdClass();
        $response->companies = $this->getCompanies();

        return view('livewire.registration.company.table', ['response' => $response]);
    }
}
