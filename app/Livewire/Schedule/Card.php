<?php

namespace App\Livewire\Schedule;

use App\Models\SchedulePrevat;
use App\Models\TrainingRoom;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class Card extends Component
{
    public $date;
    public $contractor_id;
    public $company_id;

    public function mount()
    {
        $now = Carbon::now();
        $this->date =  $now->startOfWeek()->format('Y-m-d');
    }

    #[On('filterScheduleTraining')]
    public function filterScheduleTraining($date = null)
    {
        $this->date = $date;
    }

    #[On('filterScheduleTrainingByContractor')]
    public function filterScheduleTrainingByContractor($contractor_id = null)
    {
        $this->contractor_id = $contractor_id;
    }

    #[On('filterScheduleTrainingByCompany')]
    public function filterScheduleTrainingByCompany($company_id = null)
    {
        $this->company_id = $company_id;
    }

    public function getSchedule()
    {
        $roomsDB = TrainingRoom::query()->whereStatus('Ativo')->get();

        $return = [];
        foreach ($roomsDB as $key => $itemRoom) {
            $return[$key]['room'] = $itemRoom['name'];
            for($i=0; $i <= 6; $i++){

                $date = Carbon::parse($this->date)->addDays($i)->format('Y-m-d');

                $schedulePrevatDB = SchedulePrevat::query()->with(['training', 'team', 'contractor']);

                $schedulePrevatDB->where('date_event', $date)->where('training_room_id', $itemRoom['id']);

                if(Auth::user()->company->type == 'client') {
                    $schedulePrevatDB->where('status','Em Aberto');
                    $schedulePrevatDB->where('type', 'Aberto');
                } elseif (Auth::user()->company->type == 'admin') {
                    $schedulePrevatDB->where('status','Em Aberto');
                }

                if(Auth::user()->company->type == 'client') {
                    $schedulePrevatDB->where('contractor_id', Auth::user()->contract_default->contractor_id);
                    $schedulePrevatDB->where('company_id', Auth::user()->company->id);
                } elseif (Auth::user()->company->type == 'contractor') {
                    $schedulePrevatDB->where('contractor_id', Auth::user()->company->id);
                }

                if(!empty($this->contractor_id) && Auth::user()->company->type == 'admin') {
                    $schedulePrevatDB->where('contractor_id',  $this->contractor_id);
                }

                if(!empty($this->company_id) && Auth::user()->company->type == 'admin') {
                    $schedulePrevatDB->where('company_id',  $this->company_id);
                }

                $schedulePrevatDB = $schedulePrevatDB->first();

                $return[$key]['trainings'][$i] = [
                    'date' => $date,
                    'id' => $schedulePrevatDB['id'] ?? '',
                    'name' => $schedulePrevatDB['training']['name'] ?? '',
                    'contractor' => $schedulePrevatDB['contractor']['fantasy_name'] ?? '',
                    'team' => $schedulePrevatDB['team']['name'] ?? '',
                    'vacancies_occupied' => $schedulePrevatDB['vacancies_occupied'] ?? '',
                    'vacancies' => $schedulePrevatDB['vacancies'] ?? '',
                ];
            }
        }

        return $return;
    }

    public function render()
    {
        $response = new \stdClass();
        $response->schedules = $this->getSchedule();

        return view('livewire.schedule.card', ['response' => $response]);
    }
}
