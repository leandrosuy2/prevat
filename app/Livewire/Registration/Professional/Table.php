<?php

namespace App\Livewire\Registration\Professional;

use App\Repositories\ProfessionalQualificationRepository;
use App\Repositories\ProfessionalRepository;
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

    #[On('filterTableProfessionals')]
    public function filterTableProfessionals($filterData = null)
    {
        $this->filters = $filterData;
    }

    #[On('getProfessional')]
    public function getProfessional()
    {
        $professionalRepository = new ProfessionalRepository();
        $professionalReturnDB = $professionalRepository->index($this->order, $this->filters, $this->pageSize)['data'];

        return $professionalReturnDB;
    }

    #[On('confirmDeleteProfessional')]
    public function delete($id = null)
    {
        $professionalRepository = new ProfessionalRepository();
        $professionalReturnDB = $professionalRepository->delete($id);

        if($professionalReturnDB['status'] == 'success') {
            return redirect()->route('registration.professional')->with($professionalReturnDB['status'], $professionalReturnDB['message']);
        } else if ($professionalReturnDB['status'] == 'error') {
            return redirect()->route('registration.professional')->with($professionalReturnDB['status'], $professionalReturnDB['message']);
        }
    }

    public function render()
    {
        $response = new \stdClass();
        $response->professionals = $this->getProfessional();

        return view('livewire.registration.professional.table', ['response' => $response]);
    }
}
