<?php

namespace App\Livewire\Financial\Releases\Participants;

use App\Repositories\Financial\FinancialParticipantsRepository;
use App\Repositories\ScheduleCompanyRepository;
use App\Trait\WithSlide;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Table extends Component
{
    use WithSlide, WithPagination;

    public $scheduleCompany;

    public $filters;

    public $pageSize = 15;

    public $quantity = [];
    public $value = [];
    public $participant_id;

    public $order = [
        'column' => 'name',
        'order' => 'ASC'
    ];


    public function mount($reference = null)
    {

        $companyRepository = new ScheduleCompanyRepository();
        $companyReturnDB = $companyRepository->showByReference($reference);

        if($companyReturnDB) {
            $this->scheduleCompany = $companyReturnDB['data'];
        }
    }

    public function updatedQuantity($value, $key)
    {
        if($value != null ) {
            $financialParticipantsRepository = new FinancialParticipantsRepository();
            $financialParticipantsRepository->calculateTotalValueByQuanity($this->participant_id[$key], $value);
        }
    }

    public function updatedValue($value, $key)
    {
        if($value != null ) {
            $financialParticipantsRepository = new FinancialParticipantsRepository();
            $financialParticipantsRepository->calculateTotalValueByValue($this->participant_id[$key], $value);
        }
    }

    #[On('filterTableParticipantsReleases')]
    public function filterTableParticipantsReleases($filterData = null)
    {
        $this->filters = $filterData;
    }

    #[On('clearFilterReleases')]
    public function clearFilter($visible = null)
    {
        $this->filters = null;
    }

    #[On('getParticipantsByTrainingCompany')]
    public function getParticipantsByTrainingCompany()
    {
        $financialParticipantsRepository = new FinancialParticipantsRepository();
        $participants = $financialParticipantsRepository->index($this->scheduleCompany->id, $this->order, $this->filters, $this->pageSize)['data'];

        foreach ($participants as $key => $participant) {
            $this->participant_id[$key] = $participant['id'];
            $this->quantity[$key] = formatNumber($participant['quantity']);
            $this->value[$key] = formatMoneyInput($participant['value']);
        }

        return $participants;
    }

    public function render()
    {
        $response = new \stdClass();
        $response->participants = $this->getParticipantsByTrainingCompany();

        return view('livewire.financial.releases.participants.table', ['response' => $response]);
    }
}
