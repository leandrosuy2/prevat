<?php

namespace App\Livewire\Movement\ScheduleCompany\Participants;

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


    public function mount($id = null)
    {

        $companyRepository = new ScheduleCompanyRepository();
        $companyReturnDB = $companyRepository->show($id);

        if($companyReturnDB) {
            $this->scheduleCompany = $companyReturnDB['data'];
        }
    }

    #[On('filterTableParticipantsScheduleCompany')]
    public function filterTableParticipantsScheduleCompany($filterData = null)
    {
        $this->filters = $filterData;
    }

    #[On('clearFilter')]
    public function clearFilter($visible = null)
    {
        $this->filters = null;
    }

    #[On('getParticipantsByTrainingCompany')]
    public function getParticipantsByTrainingCompany()
    {
        $scheduleCompanyRepository = new ScheduleCompanyParticipantsRepository();
        return $scheduleCompanyRepository->getParticipantsScheduleByCompany($this->scheduleCompany->id, $this->order, $this->filters, $this->pageSize)['data'];
    }

    #[On('confirmDeleteScheduleParticipanteee')]
    public function delete($id = null)
    {
        $scheduleCompanyRepository = new ScheduleCompanyParticipantsRepository();
        $trainingRoomReturnDB = $scheduleCompanyRepository->delete($id);

        if($trainingRoomReturnDB['status'] == 'success') {
            return redirect()->route('movement.schedule-company.participants', $this->scheduleCompany->id )->with($trainingRoomReturnDB['status'], $trainingRoomReturnDB['message']);
        } else if ($trainingRoomReturnDB['status'] == 'error') {
            return redirect()->route('movement.schedule-company.participants', $this->scheduleCompany->id)->with($trainingRoomReturnDB['status'], $trainingRoomReturnDB['message']);
        }
    }


    public function render()
    {
        $response = new \stdClass();
        $response->participants = $this->getParticipantsByTrainingCompany();

        return view('livewire.movement.schedule-company.participants.table', ['response' => $response]);
    }
}
