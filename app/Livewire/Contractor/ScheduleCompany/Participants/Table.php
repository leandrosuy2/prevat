<?php

namespace App\Livewire\Contractor\ScheduleCompany\Participants;

use App\Repositories\ScheduleCompanyParticipantsRepository;
use App\Repositories\ScheduleCompanyRepository;
use App\Trait\WithSlide;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Table extends Component
{
    use WithSlide, WithPagination;

    public $scheduleCompany;

    public $filters;

    public $pageSize = 15;

    public $order = [
        'column' => 'name',
        'order' => 'ASC'
    ];

    public function mount($reference = null)
    {
        $companyRepository = new ScheduleCompanyRepository();
        $companyReturnDB = $companyRepository->showByReference($reference)['data'];

        if($companyReturnDB) {
            $this->scheduleCompany = $companyReturnDB;
        }
    }

    #[On('filterTableParticipantsScheduleCompanyContractor')]
    public function filterTableParticipantsScheduleCompanyContractor($filterData = null)
    {
        $this->filters = $filterData;
    }

    #[On('clearFilterParticipantClient')]
    public function clearFilter($visible = null)
    {
        $this->filters = null;
    }

    #[On('getParticipantsByTrainingCompanyClient')]
    public function getParticipantsByTrainingCompany()
    {
        $scheduleCompanyRepository = new ScheduleCompanyParticipantsRepository();

        return $scheduleCompanyRepository->getParticipantsScheduleByCompany($this->scheduleCompany->id ?? null, $this->order, $this->filters, $this->pageSize)['data'];

    }




    public function render()
    {
        $response = new \stdClass();
        $response->participants = $this->getParticipantsByTrainingCompany();

        return view('livewire.contractor.schedule-company.participants.table', ['response' => $response]);
    }
}
