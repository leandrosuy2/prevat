<?php

namespace App\Livewire\Client\ScheduleCompany;

use App\Repositories\ScheduleCompanyRepository;
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

    #[On('filterTableScheduleCompanyClient')]
    public function filterTableScheduleCompanyClient($filterData = null)
    {
        $this->filters = $filterData;
    }

    #[On('clearFilterClient')]
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

    #[On('confirmDeleteScheduleCompanyClient')]
    public function delete($id = null)
    {
        $scheduleCompanyRepository = new ScheduleCompanyRepository();
        $trainingRoomReturnDB = $scheduleCompanyRepository->delete($id);

        if($trainingRoomReturnDB['status'] == 'success') {
            return redirect()->route('client.movement.schedule-company')->with($trainingRoomReturnDB['status'], $trainingRoomReturnDB['message']);
        } else if ($trainingRoomReturnDB['status'] == 'error') {
            return redirect()->back()->with($trainingRoomReturnDB['status'], $trainingRoomReturnDB['message']);
        }
    }

    public function render()
    {
        $response = new \stdClass();
        $response->scheduleCompanies = $this->getScheduleCompany();

        return view('livewire.client.schedule-company.table', ['response' => $response]);
    }
}
