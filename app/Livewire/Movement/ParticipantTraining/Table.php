<?php

namespace App\Livewire\Movement\ParticipantTraining;

use App\Repositories\Movements\EvidenceRepository;
use App\Repositories\Movements\TrainingParticipationsRepository;
use App\Repositories\SchedulePrevatRepository;
use App\Trait\Interactions;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Table extends Component
{
    use WithPagination, Interactions;

    public $order = [
        'column' => 'id',
        'order' => 'DESC'
    ];

    public $filters;

    public $pageSize = 15;

    #[On('filterTableTrainingParticipation')]
    public function filterTableTrainingParticipation($filterData = null)
    {
        $this->filters = $filterData;
    }

    #[On('clearFilter')]
    public function clearFilter($visible = null)
    {
        $this->filters = null;
    }

    #[On('getTrainingParticipation')]
    public function getTrainingParticipation()
    {
        $trainingParticipationRepository = new TrainingParticipationsRepository();
        return $trainingParticipationRepository->index($this->order, $this->filters, $this->pageSize)['data'];
    }

    #[On('confirmDeleteScheduleTrainingParticipation')]
    public function delete($id = null)
    {
        $trainingParticipationRepository = new TrainingParticipationsRepository();
        $trainingRoomReturnDB = $trainingParticipationRepository->delete($id);

        if($trainingRoomReturnDB['status'] == 'success') {
            return redirect()->route('movement.participant-training')->with($trainingRoomReturnDB['status'], $trainingRoomReturnDB['message']);
        } else if ($trainingRoomReturnDB['status'] == 'error') {
            return redirect()->back()->with($trainingRoomReturnDB['status'], $trainingRoomReturnDB['message']);
        }
    }

    public function changeStatus($data)
    {
        $schedulePrevatRequestRepository = new TrainingParticipationsRepository();
        $trainingParticipationReturnDB = $schedulePrevatRequestRepository->changeStatus($data);

        if($trainingParticipationReturnDB['status'] == 'success') {
            $this->sendNotificationSuccess($trainingParticipationReturnDB['status'], $trainingParticipationReturnDB['message']);
        } else if ($trainingParticipationReturnDB['status'] == 'error') {
            $this->sendNotificationDanger($trainingParticipationReturnDB['status'], $trainingParticipationReturnDB['message']);
        }
    }

    public function createEvidences($training_participation_id)
    {
        $evidenceRepository = new EvidenceRepository();
        $evidenceReturnDB = $evidenceRepository->createEvidence($training_participation_id);

        if($evidenceReturnDB['status'] == 'success') {
            $this->sendNotificationSuccess($evidenceReturnDB['status'], $evidenceReturnDB['message']);
        } else if ($evidenceReturnDB['status'] == 'error') {
            $this->sendNotificationDanger($evidenceReturnDB['status'], $evidenceReturnDB['message']);
        }
    }

    public function updateEvidences($training_participation_id)
    {
        $evidenceRepository = new EvidenceRepository();
        $evidenceReturnDB = $evidenceRepository->updateEvidences($training_participation_id);

        if($evidenceReturnDB['status'] == 'success') {
            $this->sendNotificationSuccess($evidenceReturnDB['status'], $evidenceReturnDB['message']);
        } else if ($evidenceReturnDB['status'] == 'error') {
            $this->sendNotificationDanger($evidenceReturnDB['status'], $evidenceReturnDB['message']);
        }
    }

    public function render()
    {
        $response = new \stdClass();
        $response->trainingParticipation= $this->getTrainingParticipation();

        return view('livewire.movement.participant-training.table', ['response' => $response]);
    }
}
