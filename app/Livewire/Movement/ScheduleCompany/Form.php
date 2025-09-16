<?php

namespace App\Livewire\Movement\ScheduleCompany;

use App\Models\Participant;
use App\Models\ScheduleCompanyParticipants;
use App\Repositories\CompanyContractRepository;
use App\Repositories\CompanyRepository;
use App\Repositories\ParticipantRepository;
use App\Repositories\ScheduleCompanyRepository;
use App\Repositories\SchedulePrevatRepository;
use App\Trait\Interactions;
use App\Trait\WithSlide;
use Illuminate\Support\Collection;
use Livewire\Attributes\On;
use Livewire\Component;

class Form extends Component
{
    use Interactions, WithSlide;

    public Collection $participants;

    #[Reactive]
    public $state = [
        'date_event' => '',
        'schedule_prevat_id' => '',
        'company_id' => '',
        'contract_id' => ''
    ];

    public $date;
    public $today;

    public $company_id;

    public $scheduleCompany;

    public $participantsDelete = [];

    public function mount($id = null, $schedule_prevat_id = null)
    {
        $scheduleCompanyRepository = new ScheduleCompanyRepository();
        $scheduleCompanyReturnDB = $scheduleCompanyRepository->show($id)['data'];
        $this->scheduleCompany = $scheduleCompanyReturnDB;

        if($schedule_prevat_id) {
            $this->state['schedule_prevat_id'] = $schedule_prevat_id;
        }

        $this->state['date_event'] = today()->format('Y-m-d');
        $this->today = today()->format('Y-m-d');

        $this->fill([
            'participants' => collect([]),
        ]);

        if($this->scheduleCompany){
            $this->state = $this->scheduleCompany->toArray();
            $scheduleCompanyParticipantsDB = ScheduleCompanyParticipants::query()
                ->with([
                    'participant' => fn($query) => $query->withoutGlobalScopes(),
                    'participant.role' => fn($query) => $query->withoutGlobalScopes()
                ])
                ->where('schedule_company_id', $this->scheduleCompany->id)
                ->get();

            $return = [];
            foreach ($scheduleCompanyParticipantsDB as $key => $itemParticipant) {
            $return['data'][$key]['id'] = $itemParticipant['id'];
            $return['data'][$key]['name'] = $itemParticipant['participant']['name'];
            $return['data'][$key]['role'] = $itemParticipant['participant']['role']['name'];
            $return['data'][$key]['contract'] = $itemParticipant['participant']['contract']['contract'];
            $return['data'][$key]['taxpayer_registration'] = $itemParticipant['participant']['taxpayer_registration'];
            $return['data'][$key]['company'] = $itemParticipant['participant']['company']['name'];
            $return['data'][$key]['status'] = $itemParticipant['participant']['status'];

                $this->fill([
                    'participants' => collect($return['data']),
                ]);
            }
        }
    }
    #[On('addParticipant')]
    public function addParticipant($participant_id = null)
    {
        $participantRepository = new ParticipantRepository();
        $participantReturnDB = $participantRepository->show($participant_id)['data'];

        $this->participants->push([
            'id' => $participantReturnDB['id'],
            'name' => $participantReturnDB['name'],
            'role' => $participantReturnDB['role']['name'],
            'contract' => $participantReturnDB['contract']['contract'],
            'taxpayer_registration' => $participantReturnDB['taxpayer_registration'],
            'company' => $participantReturnDB['company']['name'] ?? $participantReturnDB['company']['fantasy_name'],
            'status' => $participantReturnDB['status'],
            'new' => 'new',
        ]);
    }

    public function remParticipant($key, $id = null)
    {
        $this->participants->pull($key);
        $this->participantsDelete[] += $id;
        $this->dispatch('remParticipantCard', key:$key);
    }

    public function getTraining()
    {
        if(isset($this->state['schedule_prevat_id']) && $this->state['schedule_prevat_id'] != null) {
            $schedulePrevatRepository = new SchedulePrevatRepository();
            return $schedulePrevatRepository->show($this->state['schedule_prevat_id'])['data'];
        }
    }

    public function save()
    {
        if($this->scheduleCompany){
            return $this->update();
        }
        $request = $this->state;
        $scheduleCompanyRepository = new ScheduleCompanyRepository();
        $scheduleCompanyReturnDB = $scheduleCompanyRepository->create($request, $this->participants);

        if($scheduleCompanyReturnDB['status'] == 'success') {
            return redirect()->route('movement.schedule-company')->with($scheduleCompanyReturnDB['status'], $scheduleCompanyReturnDB['message']);
        } else if ($scheduleCompanyReturnDB['status'] == 'error') {
            return redirect()->back()->with($scheduleCompanyReturnDB['status'], $scheduleCompanyReturnDB['message']);
        }
    }

    public function update()
    {
        $request = $this->state;

        $scheduleCompanyRepository = new ScheduleCompanyRepository();
        $scheduleCompanyReturnDB = $scheduleCompanyRepository->update($this->scheduleCompany->id, $request, $this->participants, $this->participantsDelete);

        if($scheduleCompanyReturnDB['status'] == 'success') {
            return redirect()->route('movement.schedule-company')->with($scheduleCompanyReturnDB['status'], $scheduleCompanyReturnDB['message']);
        } else if ($scheduleCompanyReturnDB['status'] == 'error') {
            return redirect()->back()->with($scheduleCompanyReturnDB['status'], $scheduleCompanyReturnDB['message']);
        }
    }
    #[On('getSelectCompaniesss')]
    public function getSelectCompanies()
    {
        $companyRepository = new CompanyRepository();
        return $companyRepository->getSelectCompany();
    }

    #[On('getSelectSchedulePrevat')]
    public function getSelectSchedulePrevat()
    {
        $schedulePrevatRepository = new SchedulePrevatRepository();
        return  $schedulePrevatRepository->getSelectSchedulePrevat('Em Aberto');
    }

    public function getContratsByCompany()
    {
        $companyContractsRepository = new CompanyContractRepository();
        return $companyContractsRepository->getSelectContracts($this->state['company_id']);
    }

    public function render()
    {
        $response = new \stdClass();
        $response->companies = $this->getSelectCompanies();
        $response->schedulePrevats = $this->getSelectSchedulePrevat();
        $response->event = $this->getTraining();
        $response->contracts = $this->getContratsByCompany();

        return view('livewire.movement.schedule-company.form', ['response' => $response]);
    }
}
