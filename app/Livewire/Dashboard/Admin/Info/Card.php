<?php

namespace App\Livewire\Dashboard\Admin\Info;

use Livewire\Component;
use Carbon\Carbon;

class Card extends Component
{
    public $trainingsMonth;
    public $companiesMonth;
    public $extraClassesMonth;
    public $trainings;

    public function mount()
    {
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
        $start = now()->startOfMonth();
        $end = now()->endOfMonth();
        
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
        $start = now()->startOfMonth();
        $end = now()->endOfMonth();
        
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

    // Turmas extras no mês (type = 'Fechado')
    private function getExtraClassesMonth()
    {
        $start = now()->startOfMonth();
        $end = now()->endOfMonth();
        
        $count = \App\Models\SchedulePrevat::where('type', 'Fechado')
            ->whereBetween('date_event', [$start, $end])
            ->count();
            
        \Log::info('Dashboard Admin - Turmas extras (type=Fechado) no mês: ' . $count);
        
        return $count;
    }

    // Métodos de debug para verificar os dados
    public function debugData()
    {
        $start = now()->startOfMonth();
        $end = now()->endOfMonth();
        
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
