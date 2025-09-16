<?php

namespace App\Livewire\Registration\Team;

use App\Repositories\TimeRepository;
use App\Repositories\TrainingTeamRepository;
use Livewire\Attributes\On;
use Livewire\Component;
class Table extends Component
{
    public $order = [
        'column' => 'name',
        'order' => 'ASC'
    ];

    #[On('getTeams')]
    public function getTeams()
    {
        $trainingTeamsRepository = new TrainingTeamRepository();
        $teamsReturnDB = $trainingTeamsRepository->index($this->order)['data'];

        return $teamsReturnDB;
    }

    #[On('confirmDeleteTeam')]
    public function delete($id = null)
    {
        $trainingTeamsRepository = new TrainingTeamRepository();
        $teamsReturnDB = $trainingTeamsRepository->delete($id);

        if($teamsReturnDB['status'] == 'success') {
            return redirect()->route('registration.team')->with($teamsReturnDB['status'], $teamsReturnDB['message']);
        } else if ($teamsReturnDB['status'] == 'error') {
            return redirect()->route('registration.team')->with($teamsReturnDB['status'], $teamsReturnDB['message']);
        }
    }

    public function render()
    {
        $response = new \stdClass();
        $response->teams = $this->getTeams();

        return view('livewire.registration.team.table', ['response' => $response]);
    }
}
