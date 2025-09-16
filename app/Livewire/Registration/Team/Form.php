<?php

namespace App\Livewire\Registration\Team;

use App\Repositories\TrainingTeamRepository;
use Livewire\Component;

class Form extends Component
{
    public $state = [
        'status' => '',
        'members' => ''
    ];

    public $team;

    public function mount($id = null)
    {
        $trainingTeamsRepository = new TrainingTeamRepository();
        $trainingTeamsReturnDB = $trainingTeamsRepository->show($id)['data'];
        $this->team = $trainingTeamsReturnDB;

        if($this->team){
            $this->state = $this->team->toArray();
        }
    }

    public function save()
    {
        if($this->team){
            return $this->update();
        }

        $request = $this->state;

        $trainingTeamsRepository = new TrainingTeamRepository();
        $trainingTeamsReturnDB = $trainingTeamsRepository->create($request);

        if($trainingTeamsReturnDB['status'] == 'success') {
            return redirect()->route('registration.team')->with($trainingTeamsReturnDB['status'], $trainingTeamsReturnDB['message']);
        } else if ($trainingTeamsReturnDB['status'] == 'error') {
            return redirect()->back()->with($trainingTeamsReturnDB['status'], $trainingTeamsReturnDB['message']);
        }
    }

    public function update()
    {
        $request = $this->state;
        $trainingTeamsRepository = new TrainingTeamRepository();

        $trainingTeamsReturnDB = $trainingTeamsRepository->update($request, $this->team->id);

        if($trainingTeamsReturnDB['status'] == 'success') {
            return redirect()->route('registration.team')->with($trainingTeamsReturnDB['status'], $trainingTeamsReturnDB['message']);
        } else if ($trainingTeamsReturnDB['status'] == 'error') {
            return redirect()->back()->with($trainingTeamsReturnDB['status'], $trainingTeamsReturnDB['message']);
        }
    }

    public function render()
    {
        return view('livewire.registration.team.form');
    }
}
