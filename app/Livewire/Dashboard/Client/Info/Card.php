<?php

namespace App\Livewire\Dashboard\Client\Info;

use App\Models\Evidence;
use App\Repositories\Client\DashboardRepository;
use App\Repositories\Movements\EvidenceParticipantsRepository;
use App\Repositories\Movements\EvidenceRepository;
use App\Repositories\ParticipantRepository;
use App\Repositories\ScheduleCompanyRepository;
use App\Trait\Interactions;
use Livewire\Component;

class Card extends Component
{
    use Interactions;

    public $participants;
    public $schedules;
    public $cetificates;

    public $presences;
    public $absences;

    public $trainingsMonth;
    public $companiesMonth;
    public $extraClassesMonth;

    public function mount($contract = null)
    {
        $participantRepository = new ParticipantRepository();
        $this->participants = $participantRepository->index()['data'];

        $scheduleCompanyRepository = new ScheduleCompanyRepository();
        $this->schedules = $scheduleCompanyRepository->index()['data'];


        $dashboardRepository = new DashboardRepository();
        $this->presences = $dashboardRepository->getCountPresences(true);
        $this->absences = $dashboardRepository->getCountPresences(false);

        // Novos cards
        $this->trainingsMonth = $this->getTrainingsMonth();
        $this->companiesMonth = $this->getCompaniesMonth();
        $this->extraClassesMonth = $this->getExtraClassesMonth();

//        dd($this->presences);
    }

    public function message()
    {
        if($this->message) {
            $this->sendNotificationSuccess('Sucesso', 'Contrato alterado com sucesso !');
        }
    }

    public function render()
    {
        return view('livewire.dashboard.client.info.card');
    }

    // Treinamentos ministrados no mês
    private function getTrainingsMonth()
    {
        $start = now()->startOfMonth();
        $end = now()->endOfMonth();
        
        $count = \App\Models\SchedulePrevat::where('status', 'Concluído')
            ->whereBetween('date_event', [$start, $end])
            ->count();
            
        \Log::info('Dashboard Client - Treinamentos concluídos no mês: ' . $count);
        
        return $count;
    }
    // Empresas atendidas no mês
    private function getCompaniesMonth()
    {
        $start = now()->startOfMonth();
        $end = now()->endOfMonth();
        
        $count = \App\Models\ScheduleCompany::whereHas('schedule', function($q) use ($start, $end) {
                $q->where('status', 'Concluído')
                  ->whereBetween('date_event', [$start, $end]);
            })
            ->distinct('company_id')
            ->count('company_id');
            
        \Log::info('Dashboard Client - Empresas únicas no mês: ' . $count);
        
        return $count;
    }
    // Turmas extras no mês (type = 'Fechado')
    private function getExtraClassesMonth()
    {
        $start = now()->startOfMonth();
        $end = now()->endOfMonth();
        
        $count = \App\Models\SchedulePrevat::where('status', 'Concluído')
            ->where('type', 'Fechado')
            ->whereBetween('date_event', [$start, $end])
            ->count();
            
        \Log::info('Dashboard Client - Turmas extras concluídas (type=Fechado) no mês: ' . $count);
        
        return $count;
    }
}
