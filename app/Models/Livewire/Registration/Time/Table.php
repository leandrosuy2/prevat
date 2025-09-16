<?php

namespace App\Livewire\Registration\Time;

use App\Repositories\TimeRepository;
use App\Repositories\WorkloadRepository;
use http\Env\Request;
use Livewire\Attributes\On;
use Livewire\Component;

class Table extends Component
{
    public $order = [
        'column' => 'name',
        'order' => 'ASC'
    ];

    #[On('getTimes')]
    public function getTimes()
    {
        $timeRepository = new TimeRepository();
        $timeReturnDB = $timeRepository->index($this->order)['data'];

        return $timeReturnDB;
    }

    #[On('confirmDeleteTime')]
    public function delete($id = null)
    {
        $timeRepository = new TimeRepository();
        $timeReturnDB = $timeRepository->delete($id);

        if($timeReturnDB['status'] == 'success') {
            return redirect()->route('registration.time')->with($timeReturnDB['status'], $timeReturnDB['message']);
        } else if ($timeReturnDB['status'] == 'error') {
            return redirect()->route('registration.time')->with($timeReturnDB['status'], $timeReturnDB['message']);
        }
    }

    public function render()
    {
        $response = new \stdClass();
        $response->times = $this->getTimes();

        return view('livewire.registration.time.table', ['response' => $response]);
    }
}
