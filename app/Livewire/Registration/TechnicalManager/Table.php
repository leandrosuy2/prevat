<?php

namespace App\Livewire\Registration\TechnicalManager;

use App\Repositories\TechnicalManagerRepository;
use Livewire\Attributes\On;
use Livewire\Component;

class Table extends Component
{
    public $order = [
        'column' => 'name',
        'order' => 'ASC'
    ];

    #[On('getTechnicals')]
    public function getTechnicals()
    {
        $technicalManagerRepository = new TechnicalManagerRepository();
        $technicalManagerReturnDB = $technicalManagerRepository->index($this->order)['data'];

        return $technicalManagerReturnDB;
    }

    #[On('confirmDeleteTechnicalManager')]
    public function delete($id = null)
    {
        $technicalManagerRepository = new TechnicalManagerRepository();
        $technicalManagerReturnDB = $technicalManagerRepository->delete($id);

        if($technicalManagerReturnDB['status'] == 'success') {
            return redirect()->route('registration.technical-manager')->with($technicalManagerReturnDB['status'], $technicalManagerReturnDB['message']);
        } else if ($technicalManagerReturnDB['status'] == 'error') {
            return redirect()->back()->with($technicalManagerReturnDB['status'], $technicalManagerReturnDB['message']);
        }
    }

    public function render()
    {
        $response = new \stdClass();
        $response->technicals = $this->getTechnicals();

        return view('livewire.registration.technical-manager.table', ['response' => $response]);
    }
}
