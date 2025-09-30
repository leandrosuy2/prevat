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
        // Normaliza valores que representam "Todos" para null (sem filtro)
        if ($contractor_id === 'all' || $contractor_id === 'todos' || $contractor_id === 'Todos' || $contractor_id === '' || $contractor_id === 0 || $contractor_id === '0' || $contractor_id === null) {
            $this->contractor_id = null;
        } else {
            $this->contractor_id = $contractor_id;
        }

        \Log::info('Schedule/Card: filtro de contratante atualizado', [
            'contractor_id' => $this->contractor_id
        ]);
    }

    #[On('filterScheduleTrainingByCompany')]
    public function filterScheduleTrainingByCompany($company_id = null)
    {
        // Normaliza valores que representam "Todos" para null (sem filtro)
        if ($company_id === 'all' || $company_id === 'todos' || $company_id === 'Todos' || $company_id === '' || $company_id === 0 || $company_id === '0' || $company_id === null) {
            $this->company_id = null;
        } else {
            $this->company_id = $company_id;
        }

        \Log::info('Schedule/Card: filtro de empresa atualizado', [
            'company_id' => $this->company_id
        ]);
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
                    // Quando sem filtro de empresa, restringe a turmas abertas para exibição geral
                    if (empty($this->company_id)) {
                        $schedulePrevatDB->where('type', 'Aberto');
                    }
                }

                if(Auth::user()->company->type == 'client') {
                    // Cliente não tem select de empresa na tela de agenda semanal.
                    // Por padrão, sempre exibe apenas as turmas da própria empresa do cliente.
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

                // Quando nenhuma empresa estiver selecionada (ou seja, sem filtro),
                // priorizamos registros com ocupação definida para garantir exibição.
                if (empty($this->company_id)) {
                    $schedulePrevatDB->orderByRaw('vacancies_occupied IS NULL ASC')
                        ->orderByDesc('vacancies_occupied');
                }

                // DEBUG: capturar resultados antes do first()
                $debugResults = (clone $schedulePrevatDB)
                    ->select('id','date_event','training_room_id','company_id','contractor_id','status','type','vacancies','vacancies_occupied')
                    ->get();

                \Log::info('Schedule/Card: consulta diária', [
                    'user_type' => Auth::user()->company->type,
                    'room_id' => $itemRoom['id'],
                    'room' => $itemRoom['name'],
                    'date' => $date,
                    'company_filter' => $this->company_id,
                    'contractor_filter' => $this->contractor_id,
                    'count' => $debugResults->count(),
                    'ids' => $debugResults->pluck('id')->all(),
                    'rows' => $debugResults->map(function($r){
                        return [
                            'id' => $r->id,
                            'company_id' => $r->company_id,
                            'contractor_id' => $r->contractor_id,
                            'status' => $r->status,
                            'type' => $r->type,
                            'vacancies' => $r->vacancies,
                            'vacancies_occupied' => $r->vacancies_occupied,
                        ];
                    })->all()
                ]);

                $schedulePrevatDB = $schedulePrevatDB->first();

                $return[$key]['trainings'][$i] = [
                    'date' => $date,
                    'id' => $schedulePrevatDB['id'] ?? '',
                    'name' => $schedulePrevatDB['training']['name'] ?? '',
                    'contractor' => $schedulePrevatDB['contractor']['fantasy_name'] ?? '',
                    'team' => $schedulePrevatDB['team']['name'] ?? '',
                    'vacancies_occupied' => $schedulePrevatDB['vacancies_occupied'] ?? 0,
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
