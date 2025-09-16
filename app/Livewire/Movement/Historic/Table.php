<?php

namespace App\Livewire\Movement\Historic;

use App\Repositories\CountryRepository;
use App\Repositories\TrainingParticipantsHistoricRepository;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Table extends Component
{
    use WithPagination;

    public $order = [
        'column' => 'registry',
        'order' => 'DESC'
    ];
    public $filters;

    public $pageSize = 15;

    public function mount()
    {
        $this->filters['date_start'] = '2024-05-06';
        $this->filters['date_end'] = '2024-08-06';
    }
    #[On('filterTableHistoric')]
    public function filterTableHistoric($filterData = null)
    {
        $this->filters = $filterData;
    }

    #[On('clearFilter')]
    public function clearFilter($visible = null)
    {
        $this->filters = null;
    }

    public function getHistorics()
    {
        $trainingParticipantsHistoric = new TrainingParticipantsHistoricRepository();
        return $trainingParticipantsHistoric->index($this->order, $this->filters, $this->pageSize)['data'];
    }

    public function render()
    {

        $response = new \stdClass();
        $response->historics = $this->getHistorics();

        return view('livewire.movement.historic.table', ['response' => $response]);
    }
}
