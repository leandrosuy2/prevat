<?php

namespace App\Livewire\Manage\Consultancy;

use App\Repositories\Manage\ConsultancyRepository;
use Livewire\Attributes\On;
use Livewire\Component;

class Table extends Component
{
    public $order = [
        'column' => 'name',
        'order' => 'asc'
    ];

    #[On('getConsultancies')]
    public function getConsultancies()
    {
        $consultanciesRepository = new ConsultancyRepository();
        $consultanciesReturnDB = $consultanciesRepository->index($this->order)['data'];

        return $consultanciesReturnDB;
    }

    #[On('confirmDeleteConsultancy')]
    public function delete($id = null)
    {
        $consultanciesRepository = new ConsultancyRepository();
        $consultanciesReturnDB = $consultanciesRepository->delete($id);

        if($consultanciesReturnDB['status'] == 'success') {
            return redirect()->route('manage.consultancy')->with($consultanciesReturnDB['status'], $consultanciesReturnDB['message']);
        } else if ($consultanciesReturnDB['status'] == 'error') {
            return redirect()->back()->with($consultanciesReturnDB['status'], $consultanciesReturnDB['message']);
        }
    }

    public function render()
    {
        $response = new \stdClass();
        $response->consultancies = $this->getConsultancies();

        return view('livewire.manage.consultancy.table', ['response' => $response]);
    }
}
