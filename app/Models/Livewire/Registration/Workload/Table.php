<?php

namespace App\Livewire\Registration\Workload;

use App\Repositories\WorkloadRepository;
use Livewire\Attributes\On;
use Livewire\Component;

class Table extends Component
{
    public $order = [
        'column' => 'name',
        'order' => 'ASC'
    ];

    #[On('getWorkLoads')]
    public function getWorkLoads()
    {
        $workloadRepository = new WorkloadRepository();
        $workloadReturnDB = $workloadRepository->index($this->order)['data'];

        return $workloadReturnDB;
    }

    #[On('confirmDeleteWorkload')]
    public function delete($id = null)
    {
        $workloadRepository = new WorkloadRepository();
        $workloadReturnDB = $workloadRepository->delete($id);

        if($workloadReturnDB['status'] == 'success') {
            return redirect()->route('registration.workload')->with($workloadReturnDB['status'], $workloadReturnDB['message']);
        } else if ($workloadReturnDB['status'] == 'error') {
            return redirect()->route('registration.workload')->with($workloadReturnDB['status'], $workloadReturnDB['message']);
        }
    }

    public function render()
    {
        $response = new \stdClass();
        $response->workloads = $this->getWorkLoads();

        return view('livewire.registration.workload.table', ['response' => $response]);
    }
}
