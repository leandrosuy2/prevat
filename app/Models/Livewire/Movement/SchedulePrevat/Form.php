<?php

namespace App\Livewire\Movement\SchedulePrevat;

use App\Repositories\ContractorsRepository;
use App\Repositories\SchedulePrevatRepository;
use App\Repositories\TimeRepository;
use App\Repositories\TrainingLocationRepository;
use App\Repositories\TrainingRepository;
use App\Repositories\TrainingRoomRepository;
use App\Repositories\TrainingTeamRepository;
use App\Repositories\WorkloadRepository;
use App\Trait\Interactions;
use Livewire\Component;

class Form extends Component
{
    use Interactions;

    public $state = [
        'status' => 'Em Aberto',
        'date_event' => '',
        'start_event' => '',
        'end_event' => '',
        'training_id' => '',
        'training_local_id' => '',
        'training_room_id' => '',
        'workload_id' => '',
        'time01_id' => '',
        'time02_id' => null,
        'team_id' => null,
        'contractor_id' => null,
        'type' => ''
    ];
    public $schedulePrevat;

    public function mount($id = null)
    {
        $schedulePrevatRepository = new SchedulePrevatRepository();
        $schedulePrevatReturnDB = $schedulePrevatRepository->show($id)['data'];
        $this->schedulePrevat = $schedulePrevatReturnDB;

        if ($this->schedulePrevat) {
            $this->state = $this->schedulePrevat->toArray();
        }
    }

    public function save()
    {
        if ($this->schedulePrevat) {
            return $this->update();
        }

        $request = $this->state;

        $schedulePrevatRepository = new SchedulePrevatRepository();
        $schedulePrevatReturnDB = $schedulePrevatRepository->create($request); // Corrigido aqui

        return $this->handleResponse($schedulePrevatReturnDB);
    }

    public function update()
    {
        $request = $this->state;

        $schedulePrevatRepository = new SchedulePrevatRepository();
        $schedulePrevatReturnDB = $schedulePrevatRepository->update($request, $this->schedulePrevat->id);

        return $this->handleResponse($schedulePrevatReturnDB);
    }

    private function handleResponse($response)
    {
        if ($response['status'] == 'success') {
            return redirect()->route('movement.schedule-prevat')->with($response['status'], $response['message']);
        } else if ($response['status'] == 'error') {
            return redirect()->back()->with($response['status'], $response['message']);
        }
    }

    public function getSelectTrainings()
    {
        $trainingRepository = new TrainingRepository();
        return $trainingRepository->getSelectTraining();
    }

    public function getSelectWorkLoad()
    {
        $workloadRepository = new WorkloadRepository();
        return $workloadRepository->getSelectWorkLoad();
    }

    public function getSelectTrainingRooms()
    {
        $trainingRoomsRepository = new TrainingRoomRepository();
        return $trainingRoomsRepository->getSelectTrainingRoom();
    }

    public function getSelectTimes()
    {
        $timeRepository = new TimeRepository();
        return $timeRepository->getSelectTime();
    }

    public function getLocalTraining()
    {
        $trainingLocationRepository = new TrainingLocationRepository();
        return $trainingLocationRepository->getSelectTrainingLocation();
    }

    public function getSelectTeams()
    {
        $trainingTeamsRepository = new TrainingTeamRepository();
        return $trainingTeamsRepository->getSelectTrainingTeam();
    }

    public function getSelectContractors()
    {
        $contractorRepository = new ContractorsRepository();
        return $contractorRepository->getSelectContractor();
    }

    public function render()
    {
        $response = new \stdClass();
        $response->trainings = $this->getSelectTrainings();
        $response->trainingLocations = $this->getLocalTraining();
        $response->workloads = $this->getSelectWorkLoad();
        $response->rooms = $this->getSelectTrainingRooms();
        $response->times = $this->getSelectTimes();
        $response->teams = $this->getSelectTeams();
        $response->contractors = $this->getSelectContractors();

        return view('livewire.movement.schedule-prevat.form', ['response' => $response]);
    }
}
