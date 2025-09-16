<?php

namespace App\Livewire\Movement\ParticipantTraining\Private;

use App\Repositories\CompanyContractRepository;
use App\Repositories\CompanyRepository;
use App\Repositories\CreatePrivateRepository;
use App\Repositories\Movements\TrainingParticipationsRepository;
use App\Repositories\ScheduleCompanyRepository;
use App\Repositories\SchedulePrevatRepository;
use App\Repositories\TemplatesRepository;
use App\Repositories\TimeRepository;
use App\Repositories\TrainingLocationRepository;
use App\Repositories\TrainingRepository;
use App\Repositories\TrainingRoomRepository;
use App\Repositories\WorkloadRepository;
use App\Trait\WithSlide;
use Illuminate\Support\Collection;
use Livewire\Attributes\On;
use Livewire\Component;

class Form extends Component
{
    use WithSlide;

    public Collection $professionals;

    public $state = [
        'date_event' => '',
        'start_event' => '',
        'end_event' => '',
        'training_id' => '',
        'company_id' => '',
        'contract_id' => '',
        'training_location_id' => '',
        'training_room_id' => '',
        'workload_id' => '',
        'time01_id' => '' ,
        'time02_id' => null,
        'template_id' => ''
    ];

    public $quantity  = [];
    public $note = [];
    public $presence = [];

    public $participantTraining;

    public function mount($id = null)
    {
        $trainingParticipationRepository = new TrainingParticipationsRepository();
        $trainingParticipationReturnDB = $trainingParticipationRepository->show($id)['data'];
        $this->participantTraining = $trainingParticipationReturnDB;

        if($this->participantTraining) {
            $this->state = $this->participantTraining->toArray();
        }
        session()->forget('participants');
        session()->forget('professionals');
    }
    public function updatedQuantity($value, $key)
    {
        if($value != null ) {
            $scheduleCompanyRepository = new ScheduleCompanyRepository();
            $scheduleCompanyRepository->calculateTotalValue($key, $value);
        }
    }

    public function updatedNote($value, $key)
    {
        $scheduleCompanyRepository = new ScheduleCompanyRepository();
        $scheduleCompanyRepository->addNote($key, $value);
    }

    public function updatedPresence($value, $key)
    {

        $scheduleCompanyRepository = new ScheduleCompanyRepository();
        $scheduleCompanyRepository->validatePresence($key, $value);

        $this->validate([
            'presence.*' => 'sometimes',
            'note.*' => 'required_if:presence.*,true',
        ]);
    }
    public function addParticipants($schedule_prevat_id = null)
    {
        $scheduleCompanyRepository = new ScheduleCompanyRepository();
        $scheduleCompanyReturnDB = $scheduleCompanyRepository->getParticipantsBySchedule($schedule_prevat_id);
    }

    public function clearParticipants()
    {
        session()->forget('participants');
        return redirect()->back();
    }

    #[On('addParticipantSessionPrivate')]
    public function addParticipant($participant_id = null )
    {
        $trainingParticipantsRepository = new CreatePrivateRepository();
        $trainingParticipantsRepository->addParticipant($this->state['training_id'], $participant_id);
        $this->dispatch('getParticipantsPrivate');
    }


    public function remParticipant($value)
    {
        $participants = session()->get('participants');
        unset($participants[$value]);
        unset($this->note[$value]);
        unset($this->quantity[$value]);
        unset($this->presence[$value]);

        sort($participants);
        session()->put('participants', $participants);

        $this->getParticipants();
        $this->dispatch('getParticipantsByTraining');
    }

    public function save()
    {
        if($this->participantTraining){
            return $this->update();
        }

        $requestValidated = $this->validate([
            'state.training_id' => 'required',
            'state.company_id' => 'required',
            'state.contract_id' => 'required',
            'state.date_event' => 'required',
            'state.start_event' => 'required',
            'state.end_event'  => 'required',
            'state.training_local_id' => 'required',
            'state.training_room_id' => 'required',
            'state.workload_id' => 'required',
            'state.time01_id' => 'required',
            'state.time02_id' => 'sometimes|nullable',
            'state.template_id' => 'required',
            'state.vacancies' => 'required',
            'quantity.*' => 'required',
            'presence.*' => 'sometimes',
            'note.*' => 'required_if:presence.*,true'
        ]);

        $createPrivateRepository = new CreatePrivateRepository();
        $createPrivateReturnDB = $createPrivateRepository->create($requestValidated['state'], $this->getProfessionals(), $this->getParticipants());

        if($createPrivateReturnDB['status'] == 'success') {
            return redirect()->route('movement.participant-training')->with($createPrivateReturnDB['status'], $createPrivateReturnDB['message']);
        } else if ($createPrivateReturnDB['status'] == 'error') {
            return redirect()->back()->with($createPrivateReturnDB['status'], $createPrivateReturnDB['message']);
        }
    }

    public function update()
    {
        $request = $this->state;

        $scheduleCompanyRepository = new ScheduleCompanyRepository();
        $scheduleCompanyReturnDB = $scheduleCompanyRepository->update($request, $this->participantTraining->id);

        if($scheduleCompanyReturnDB['status'] == 'success') {
            return redirect()->route('movement.participant-training')->with($scheduleCompanyReturnDB['status'], $scheduleCompanyReturnDB['message']);
        } else if ($scheduleCompanyReturnDB['status'] == 'error') {
            return redirect()->route('movement.schedule-company')->with($scheduleCompanyReturnDB['status'], $scheduleCompanyReturnDB['message']);
        }
    }

    #[On('getParticipantsSession')]
    public function getParticipants()
    {
        $participants = session()->get('participants');

        if($participants) {
            foreach ($participants as $key => $participant) {
                $this->quantity[$key] = $participant['quantity'];
                $this->note[$key] = $participant['note'];
            }
        }

        return $participants;
    }

    public function getSelectTrainings()
    {
        $trainingsRepository = new TrainingRepository();
        return $trainingsRepository->getSelectTraining();
    }

    public function getSelectCompanies()
    {
        $companiesRepository = new CompanyRepository();
        return $companiesRepository->getSelectCompany();
    }

    public function getTrainement()
    {
        if(isset($this->state['schedule_prevat_id']) && $this->state['schedule_prevat_id'] != null) {
            $schedulePrevatRepository = new SchedulePrevatRepository();
            return $schedulePrevatRepository->show($this->state['schedule_prevat_id'])['data'];
        }
    }

    public function getSelectWorkLoad()
    {
        $workloadRepository = new WorkloadRepository();
        return $workloadRepository->getSelectWorkLoad();
    }

    public function getSelectTrainingRooms()
    {
        $trainingRoomsRepository = new TrainingRoomRepository();
        return $trainingRoomsRepository->getSelectTrainingRoom();
    }

    public function getSelectTimes()
    {
        $timeRepository = new TimeRepository();
        return $timeRepository->getSelectTime();
    }

    public function getLocalTraining()
    {
        $trainingLocationRepository = new TrainingLocationRepository();
        return $trainingLocationRepository->getSelectTrainingLocation();
    }

    #[On('getProfessionals')]
    public function getProfessionals()
    {
        return  session()->get('professionals');
    }

    public function remProfessional($key)
    {
        $professionals = session()->get('professionals');
        unset($professionals[$key]);
        sort($professionals);
        session()->put('professionals', $professionals);
    }

    public function getContratsByCompany()
    {
        $companyContractsRepository = new CompanyContractRepository();
        return $companyContractsRepository->getSelectContracts($this->state['company_id']);
    }

    public function getSelectTemplates()
    {
        $templatesRepository = new TemplatesRepository();
        return $templatesRepository->getSelectTemplates();
    }

    public function render()
    {
        $response = new \stdClass();
        $response->trainings = $this->getSelectTrainings();
        $response->companies = $this->getSelectCompanies();
        $response->trainingLocations = $this->getLocalTraining();
        $response->workloads = $this->getSelectWorkLoad();
        $response->rooms = $this->getSelectTrainingRooms();
        $response->times = $this->getSelectTimes();
        $response->participants = $this->getParticipants();
        $response->professionals = $this->getProfessionals();
        $response->contracts = $this->getContratsByCompany();
        $response->templates = $this->getSelectTemplates();

        return view('livewire.movement.participant-training.private.form', ['response' => $response]);
    }
}
