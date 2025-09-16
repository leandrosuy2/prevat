<?php

namespace App\Livewire\Registration\Workload;

use App\Repositories\WorkloadRepository;
use Livewire\Component;

class Form extends Component
{
    public $state = [
        'status' => '',
    ];

    public $workload;

    public function mount($id = null)
    {
        $workloadRepository = new WorkloadRepository();
        $workloadReturnDB = $workloadRepository->show($id)['data'];
        $this->workload = $workloadReturnDB;

        if($this->workload){
            $this->state = $this->workload->toArray();
        }
    }

    public function save()
    {
        if($this->workload){
            return $this->update();
        }

        $request = $this->state;

        $workloadRepository = new WorkloadRepository();
        $workloadReturnDB = $workloadRepository->create($request);

        if($workloadReturnDB['status'] == 'success') {
            return redirect()->route('registration.workload')->with($workloadReturnDB['status'], $workloadReturnDB['message']);
        } else if ($workloadReturnDB['status'] == 'error') {
            return redirect()->route('registration.workload')->with($workloadReturnDB['status'], $workloadReturnDB['message']);
        }
    }

    public function update()
    {
        $request = $this->state;
        $workloadRepository = new WorkloadRepository();

        $workloadReturnDB = $workloadRepository->update($request, $this->workload->id);

        if($workloadReturnDB['status'] == 'success') {
            return redirect()->route('registration.workload')->with($workloadReturnDB['status'], $workloadReturnDB['message']);
        } else if ($workloadReturnDB['status'] == 'error') {
            return redirect()->route('registration.workload')->with($workloadReturnDB['status'], $workloadReturnDB['message']);
        }
    }

    public function render()
    {
        return view('livewire.registration.workload.form');
    }
}
