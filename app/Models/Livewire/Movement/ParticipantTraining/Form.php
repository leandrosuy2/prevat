<?php

namespace App\Livewire\Movement\ParticipantTraining;

use App\Http\Controllers\StockOrderProductsController;
use App\Models\TrainingProfessionals;
use App\Repositories\Movements\TrainingParticipantsRepository;
use App\Repositories\Movements\TrainingParticipationsRepository;
use App\Repositories\ProfessionalRepository;
use App\Repositories\ScheduleCompanyRepository;
use App\Repositories\SchedulePrevatRepository;
use App\Repositories\TemplatesRepository;
use App\Repositories\TimeRepository;
use App\Repositories\TrainingLocationRepository;
use App\Repositories\TrainingRoomRepository;
use App\Repositories\WorkloadRepository;
use App\Trait\WithSlide;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Form extends Component
{
    use WithSlide;
    public Collection $professionals;
    public $state = [
        'date_event' => '',
        'start_event' => '',
        'end_event' => '',
        'schedule_prevat_id' => '',
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

    public function updatedStateSchedulePrevatId()
    {
        $this->state['date_event'] = $this->getTrainement()['date_event'] ?? '';
        $this->state['start_event'] = $this->getTrainement()['start_event'] ?? '';
        $this->state['end_event'] = $this->getTrainement()['end_event']  ?? '';
        $this->state['training_location_id'] = $this->getTrainement()['training_local_id'] ?? '';
        $this->state['training_room_id'] = $this->getTrainement()['training_room_id'] ?? '';
        $this->state['workload_id'] = $this->getTrainement()['workload_id'] ?? '';
        $this->state['time01_id'] = $this->getTrainement()['time01_id'] ?? '';
        $this->state['time02_id'] = $this->getTrainement()['time02_id'] ?? null ;

        session()->forget('participants');
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
        
        if ($scheduleCompanyReturnDB && isset($scheduleCompanyReturnDB['status']) && $scheduleCompanyReturnDB['status'] == 'success') {
            $participants = [];
            foreach ($scheduleCompanyReturnDB['data'] as $participant) {
                $participants[] = [
                    "id" => $participant['id'],
                    "name" => $participant['name'],
                    "taxpayer_registration" => $participant['taxpayer_registration'],
                    "role" => $participant['role'],
                    "company" => $participant['company'],
                    "company_id" => $participant['company_id'],
                    "contract_id" => $participant['contract_id'],
                    "quantity" => 1,
                    "value" => $participant['value'],
                    "total_value" => $participant['value'] * 1,
                    "note" => '',
                    'status' => 'Reprovado',
                    "table" => 'table-default',
                    "presence" => true,
                    "icon" => '',
                ];
            }
            
            session()->put('participants', $participants);
            $this->dispatch('getParticipantsByTraining');
        }
    }
    public function clearParticipants()
    {
        session()->forget('participants');
        return redirect()->back();
    }

    #[On('addParticipantSession')]
    public function addParticipant($schedule_prevat_id = null, $participant_id = null )
    {
        $trainingParticipantsRepository = new TrainingParticipantsRepository();
        $trainingParticipantsRepository->addParticipant($this->state['schedule_prevat_id'], $participant_id);
        $this->dispatch('getParticipantsByTraining');
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
            'state.schedule_prevat_id' => 'required',
            'state.date_event' => 'required',
            'state.start_event' => 'required',
            'state.end_event'  => 'required',
            'state.training_location_id' => 'required',
            'state.training_room_id' => 'required',
            'state.workload_id' => 'required',
            'state.time01_id' => 'required',
            'state.time02_id' => 'sometimes|nullable',
            'state.template_id' => 'required',
            'quantity.*' => 'required',
            'presence.*' => 'sometimes',
            'note.*' => 'required_if:presence.*,true'
        ]);

        $participants = session()->get('participants');

        if (empty($participants)) {
            return redirect()->back()->with('error', 'Adicione pelo menos um participante antes de salvar.');
        }

        // Atualiza os participantes com as informações de presença e nota
        foreach ($participants as $key => $participant) {
            $participants[$key]['presence'] = $this->presence[$key] ?? false;
            $participants[$key]['note'] = $this->note[$key] ?? '';
            $participants[$key]['quantity'] = $this->quantity[$key] ?? 1;
            $participants[$key]['total_value'] = $participants[$key]['value'] * $participants[$key]['quantity'];
        }

        $trainingParticipationsRepository = new TrainingParticipationsRepository();
        $trainingParticipationsDB = $trainingParticipationsRepository->create($requestValidated['state'], $this->getProfessionals(), $participants);

        if($trainingParticipationsDB['status'] == 'success') {
            return redirect()->route('movement.participant-training')->with($trainingParticipationsDB['status'], $trainingParticipationsDB['message']);
        } else if ($trainingParticipationsDB['status'] == 'error') {
            return redirect()->back()->with($trainingParticipationsDB['status'], $trainingParticipationsDB['message']);
        }
    }

    public function update()
    {
        $request = $this->state;

        $requestValidated = $this->validate([
            'state.schedule_prevat_id' => 'required',
            'state.date_event' => 'required',
            'state.start_event' => 'required',
            'state.end_event'  => 'required',
            'state.training_location_id' => 'required',
            'state.training_room_id' => 'required',
            'state.workload_id' => 'required',
            'state.time01_id' => 'required',
            'state.time02_id' => 'sometimes|nullable',
            'state.template_id' => 'required',
        ]);

        $trainingParticipationRepository = new TrainingParticipationsRepository();
        $trainingParticipationsDB = $trainingParticipationRepository->update($requestValidated, $this->participantTraining->id);

        if($trainingParticipationsDB['status'] == 'success') {
            return redirect()->route('movement.participant-training')->with($trainingParticipationsDB['status'], $trainingParticipationsDB['message']);
        } else if ($trainingParticipationsDB['status'] == 'error') {
            return redirect()->route('movement.schedule-company')->with($trainingParticipationsDB['status'], $trainingParticipationsDB['message']);
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
                $this->presence[$key] = $participant['presence'] ?? 0;
            }
        }

        return $participants;
    }

    public function getSelectSchedulePrevat()
    {
        $schedulePrevatRepository = new SchedulePrevatRepository();
        return $schedulePrevatRepository->getSelectSchedulePrevat('Concluído');
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

    public function getSelectTemplates()
    {
        $templatesRepository = new TemplatesRepository();
        return $templatesRepository->getSelectTemplates();
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

    public function render()
    {
        $response = new \stdClass();
        $response->schedulePrevats = $this->getSelectSchedulePrevat();
        $response->trainingLocations = $this->getLocalTraining();
        $response->workloads = $this->getSelectWorkLoad();
        $response->rooms = $this->getSelectTrainingRooms();
        $response->times = $this->getSelectTimes();
        $response->participants = $this->getParticipants();
        $response->professionals = $this->getProfessionals();
        $response->templates = $this->getSelectTemplates();

        return view('livewire.movement.participant-training.form', ['response' => $response]);
    }
}
