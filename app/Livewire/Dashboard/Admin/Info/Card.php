<?php

namespace App\Livewire\Dashboard\Admin\Info;

use Livewire\Component;
use Carbon\Carbon;
use Livewire\Attributes\Reactive;

class Card extends Component
{
    public $trainingsMonth;
    public $companiesMonth;
    public $extraClassesMonth;
    public $trainings;
    #[Reactive]
    public $startDate;
    #[Reactive]
    public $endDate;

    public function mount(?string $startDate = null, ?string $endDate = null)
    {
        $this->startDate = $startDate ?: Carbon::now()->startOfMonth()->format('Y-m-d');
        $this->endDate = $endDate ?: Carbon::now()->endOfMonth()->format('Y-m-d');

        $this->trainingsMonth = $this->getTrainingsMonth();
        $this->companiesMonth = $this->getCompaniesMonth();
        $this->extraClassesMonth = $this->getExtraClassesMonth();
        $this->trainings = \App\Models\Training::orderBy('name')->get();
    }

    public function render()
    {
        $this->trainingsMonth = $this->getTrainingsMonth();
        $this->companiesMonth = $this->getCompaniesMonth();
        $this->extraClassesMonth = $this->getExtraClassesMonth();
        return view('livewire.dashboard.admin.info.card');
    }

    // Treinamentos ministrados no mês (que tiveram participação)
    private function getTrainingsMonth()
    {
        $start = Carbon::parse($this->startDate)->startOfDay();
        $end = Carbon::parse($this->endDate)->endOfDay();
        
        $count = \App\Models\SchedulePrevat::where('status', 'Concluído')
            ->whereBetween('date_event', [$start, $end])
            ->whereExists(function($query) {
                $query->select(\DB::raw(1))
                      ->from('schedule_companies')
                      ->whereRaw('schedule_companies.schedule_prevat_id = schedule_prevats.id');
            })
            ->count();
            
        \Log::info('Dashboard Admin - Treinamentos com participação no mês: ' . $count);
        
        return $count;
    }

    // Empresas atendidas no mês (que participaram de treinamentos concluídos)
    private function getCompaniesMonth()
    {
        $start = Carbon::parse($this->startDate)->startOfDay();
        $end = Carbon::parse($this->endDate)->endOfDay();
        
        $count = \App\Models\ScheduleCompany::withoutGlobalScopes()
            ->whereHas('schedule', function($query) use ($start, $end) {
                $query->where('status', 'Concluído')
                      ->whereBetween('date_event', [$start, $end]);
            })
            ->distinct('company_id')
            ->count('company_id');
            
        \Log::info('Dashboard Admin - Empresas únicas no mês: ' . $count);
        
        return $count;
    }

    // Turmas extras no período (identificadas por "EXTRA" no nome da equipe ou "TURMA EXTRA" no nome do treinamento)
    private function getExtraClassesMonth()
    {
        $start = Carbon::parse($this->startDate)->startOfDay();
        $end = Carbon::parse($this->endDate)->endOfDay();

        $count = \App\Models\SchedulePrevat::whereBetween('date_event', [$start, $end])
            ->where(function($q){
                $q->whereHas('team', function($q2){
                    $q2->where('name', 'like', '%EXTRA%')
                       ->orWhere('name', 'like', '%TURMA EXTRA%');
                })
                ->orWhereHas('training', function($q3){
                    $q3->where('name', 'like', '%TURMA EXTRA%');
                });
            })
            ->count();
            
        \Log::info('Dashboard Admin - Turmas extras no período (por nome): ' . $count);
        
        return $count;
    }

    // Métodos de debug para verificar os dados
    public function debugData()
    {
        $start = Carbon::parse($this->startDate)->startOfDay();
        $end = Carbon::parse($this->endDate)->endOfDay();
        
        // Debug: Total de SchedulePrevat concluídos no mês
        $totalConcluidos = \App\Models\SchedulePrevat::where('status', 'Concluído')
            ->whereBetween('date_event', [$start, $end])
            ->count();
            
        // Debug: Total de SchedulePrevat com ScheduleCompany
        $totalComParticipacao = \App\Models\SchedulePrevat::where('status', 'Concluído')
            ->whereBetween('date_event', [$start, $end])
            ->whereExists(function($query) {
                $query->select(\DB::raw(1))
                      ->from('schedule_companies')
                      ->whereRaw('schedule_companies.schedule_prevat_id = schedule_prevats.id');
            })
            ->count();
            
        // Debug: Total de ScheduleCompany no período (sem global scope)
        $totalScheduleCompany = \App\Models\ScheduleCompany::withoutGlobalScopes()
            ->whereHas('schedule', function($query) use ($start, $end) {
                $query->where('status', 'Concluído')
                      ->whereBetween('date_event', [$start, $end]);
            })
            ->count();
            
        // Debug: Total de empresas únicas (sem global scope)
        $totalEmpresasUnicas = \App\Models\ScheduleCompany::withoutGlobalScopes()
            ->whereHas('schedule', function($query) use ($start, $end) {
                $query->where('status', 'Concluído')
                      ->whereBetween('date_event', [$start, $end]);
            })
            ->distinct('company_id')
            ->count('company_id');
            
        return [
            'total_concluidos' => $totalConcluidos,
            'total_com_participacao' => $totalComParticipacao,
            'total_schedule_company' => $totalScheduleCompany,
            'total_empresas_unicas' => $totalEmpresasUnicas,
            'periodo' => $start->format('Y-m-d') . ' a ' . $end->format('Y-m-d')
        ];
    }
}
