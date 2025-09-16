<?php

namespace App\Livewire\Contractor\ScheduleCompany;

use App\Repositories\Contractor\ScheduleCompanyRepository;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Table extends Component
{
    use WithPagination;

    public $order = [
        'column' => 'created_at',
        'order' => 'DESC'
    ];

    public $filters;

    public $pageSize = 15;

    #[On('filterTableScheduleCompanyContractor')]
    public function filterTableScheduleCompany($filterData = null)
    {
        $this->filters = $filterData;
    }

    #[On('clearFilterContractor')]
    public function clearFilter($visible = null)
    {
        $this->filters = null;
    }
    #[On('getScheduleCompanyClient')]
    public function getScheduleCompany()
    {
        $scheduleCompanyRepository = new ScheduleCompanyRepository();
        $trainingRoomReturnDB = $scheduleCompanyRepository->index($this->order, $this->filters, $this->pageSize)['data'];

        return $trainingRoomReturnDB;
    }

    public function render()
    {
        $response = new \stdClass();
        $response->scheduleCompanies = $this->getScheduleCompany();

        return view('livewire.contractor.schedule-company.table', ['response' => $response]);
    }
}
