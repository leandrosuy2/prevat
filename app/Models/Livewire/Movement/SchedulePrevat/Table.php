<?php

namespace App\Livewire\Movement\SchedulePrevat;

use App\Repositories\SchedulePrevatRepository;
use App\Trait\Interactions;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Table extends Component
{
    use WithPagination, Interactions;

    public $order = [
        'column' => 'created_at',
        'order' => 'DESC'
    ];

    public $filters;

    public $pageSize = 15;

    #[On('filterTableSchedulePrevat')]
    public function filterTableSchedulePrevat($filterData = null)
    {
        $this->filters = $filterData;
    }

    #[On('clearFilter')]
    public function clearFilter($visible = null)
    {
        $this->filters = null;
    }

    #[On('getSchedulePrevat')]
    public function getSchedulePrevat()
    {
        $schedulePrevatRequestRepository = new SchedulePrevatRepository();
        $trainingRoomReturnDB = $schedulePrevatRequestRepository->index($this->order, $this->filters, $this->pageSize)['data'];

        return $trainingRoomReturnDB;
    }

    #[On('confirmDeleteSchedulePrevat')]
    public function delete($id = null)
    {
        $schedulePrevatRequestRepository = new SchedulePrevatRepository();
        $trainingRoomReturnDB = $schedulePrevatRequestRepository->delete($id);

        if($trainingRoomReturnDB['status'] == 'success') {
            return redirect()->route('movement.schedule-prevat')->with($trainingRoomReturnDB['status'], $trainingRoomReturnDB['message']);
        } else if ($trainingRoomReturnDB['status'] == 'error') {
            return redirect()->back()->with($trainingRoomReturnDB['status'], $trainingRoomReturnDB['message']);
        }
    }

    public function changeStatus($data)
    {
        $schedulePrevatRequestRepository = new SchedulePrevatRepository();
        $trainingRoomReturnDB = $schedulePrevatRequestRepository->changeStatus($data);

        if($trainingRoomReturnDB['status'] == 'success') {
            $this->sendNotificationSuccess($trainingRoomReturnDB['status'], $trainingRoomReturnDB['message']);
        } else if ($trainingRoomReturnDB['status'] == 'error') {
            $this->sendNotificationDanger($trainingRoomReturnDB['status'], $trainingRoomReturnDB['message']);
        }

    }

    public function changeType($data)
    {
        $schedulePrevatRequestRepository = new SchedulePrevatRepository();
        $trainingRoomReturnDB = $schedulePrevatRequestRepository->changeType($data);

        if($trainingRoomReturnDB['status'] == 'success') {
            $this->sendNotificationSuccess($trainingRoomReturnDB['status'], $trainingRoomReturnDB['message']);
        } else if ($trainingRoomReturnDB['status'] == 'error') {
            $this->sendNotificationDanger($trainingRoomReturnDB['status'], $trainingRoomReturnDB['message']);
        }

    }

    public function render()
    {
        $response = new \stdClass();
        $response->schedulePrevats = $this->getSchedulePrevat();

        return view('livewire.movement.schedule-prevat.table', ['response' => $response]);
    }
}
