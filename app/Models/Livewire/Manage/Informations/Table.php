<?php

namespace App\Livewire\Manage\Informations;

use App\Repositories\Site\InfomationsRepository;
use App\Repositories\TimeRepository;
use Livewire\Attributes\On;
use Livewire\Component;

class Table extends Component
{
    public $order = [
        'column' => 'id',
        'order' => 'ASC'
    ];

    #[On('getInformations')]
    public function getInformations()
    {
        $informationsRepository = new InfomationsRepository();
        $informationsReturnDB = $informationsRepository->index($this->order)['data'];

        return $informationsReturnDB;
    }

    #[On('confirmDeleteInformation')]
    public function delete($id = null)
    {
        $informationsRepository = new InfomationsRepository();
        $informationsReturnDB = $informationsRepository->delete($id);

        if($informationsReturnDB['status'] == 'success') {
            return redirect()->route('manage.information')->with($informationsReturnDB['status'], $informationsReturnDB['message']);
        } else if ($informationsReturnDB['status'] == 'error') {
            return redirect()->back()->with($informationsReturnDB['status'], $informationsReturnDB['message']);
        }
    }

    public function render()
    {
        $response = new \stdClass();
        $response->informations = $this->getInformations();

        return view('livewire.manage.informations.table', ['response' => $response]);
    }
}
