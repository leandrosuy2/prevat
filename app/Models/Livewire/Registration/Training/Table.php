<?php

namespace App\Livewire\Registration\Training;

use App\Repositories\TrainingRepository;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Table extends Component
{
    use WithPagination;

    public $order = [
        'column' => 'name',
        'order' => 'ASC'
    ];

    public $filters;

    public $pageSize = 15;

    #[On('filterTableTrainings')]
    public function filterTableTrainings($filterData = null)
    {
        $this->filters = $filterData;
    }


    #[On('getTrainings')]
    public function getTrainings()
    {
        $trainingRepository = new TrainingRepository();
        $trainingReturnDB = $trainingRepository->index($this->order, $this->filters, $this->pageSize)['data'];

        return $trainingReturnDB;
    }

    #[On('confirmDeleteTraining')]
    public function delete($id = null)
    {
        $trainingRepository = new TrainingRepository();
        $trainingReturnDB = $trainingRepository->delete($id);

        if($trainingReturnDB['status'] == 'success') {
            return redirect()->route('registration.training')->with($trainingReturnDB['status'], $trainingReturnDB['message']);
        } else if ($trainingReturnDB['status'] == 'error') {
            return redirect()->route('registration.training')->with($trainingReturnDB['status'], $trainingReturnDB['message']);
        }
    }

    public function render()
    {
        $response = new \stdClass();
        $response->trainings = $this->getTrainings();

        return view('livewire.registration.training.table', ['response' => $response]);
    }
}
