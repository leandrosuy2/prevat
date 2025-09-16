<?php

namespace App\Livewire\Registration\Time;

use App\Repositories\TimeRepository;
use Livewire\Component;

class Form extends Component
{
    public $state = [
        'status' => '',
        'members' => ''
    ];

    public $time;

    public function mount($id = null)
    {
        $timeRepository = new TimeRepository();
        $timeReturnDB = $timeRepository->show($id)['data'];
        $this->time = $timeReturnDB;

        if($this->time){
            $this->state = $this->time->toArray();
        }
    }

    public function save()
    {
        if($this->time){
            return $this->update();
        }

        $request = $this->state;

        $timeRepository = new TimeRepository();
        $timeReturnDB = $timeRepository->create($request);

        if($timeReturnDB['status'] == 'success') {
            return redirect()->route('registration.time')->with($timeReturnDB['status'], $timeReturnDB['message']);
        } else if ($timeReturnDB['status'] == 'error') {
            return redirect()->back()->with($timeReturnDB['status'], $timeReturnDB['message']);
        }
    }

    public function update()
    {
        $request = $this->state;
        $timeRepository = new TimeRepository();

        $timeReturnDB = $timeRepository->update($request, $this->time->id);

        if($timeReturnDB['status'] == 'success') {
            return redirect()->route('registration.time')->with($timeReturnDB['status'], $timeReturnDB['message']);
        } else if ($timeReturnDB['status'] == 'error') {
            return redirect()->back()->with($timeReturnDB['status'], $timeReturnDB['message']);
        }
    }

    public function render()
    {
        return view('livewire.registration.time.form');
    }
}
