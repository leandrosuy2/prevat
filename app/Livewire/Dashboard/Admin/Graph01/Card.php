<?php

namespace App\Livewire\Dashboard\Admin\Graph01;

use Livewire\Component;
use Carbon\Carbon;
use Livewire\Attributes\Reactive;

class Card extends Component
{
    public $trainingsThisMonth;
    public $trainingsLastMonth;
    #[Reactive]
    public $startDate;
    #[Reactive]
    public $endDate;

    public function mount(?string $startDate = null, ?string $endDate = null): void
    {
        $this->startDate = $startDate ?: Carbon::now()->startOfMonth()->format('Y-m-d');
        $this->endDate = $endDate ?: Carbon::now()->endOfMonth()->format('Y-m-d');
    }

    public function render()
    {
        $this->trainingsThisMonth = $this->getTrainingsThisMonth();
        $this->trainingsLastMonth = $this->getTrainingsLastMonth();
        return view('livewire.dashboard.admin.graph01.card', [
            'trainingsThisMonth' => $this->trainingsThisMonth,
            'trainingsLastMonth' => $this->trainingsLastMonth,
        ]);
    }

    private function getTrainingsThisMonth()
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
            
        \Log::info('Dashboard Admin Graph01 - Treinamentos com participação neste mês: ' . $count);
        
        return $count;
    }

    private function getTrainingsLastMonth()
    {
        $periodStart = Carbon::parse($this->startDate)->startOfDay();
        $periodEnd = Carbon::parse($this->endDate)->endOfDay();
        $diffDays = $periodStart->diffInDays($periodEnd) + 1;
        $start = (clone $periodStart)->subDays($diffDays);
        $end = (clone $periodEnd)->subDays($diffDays);
        
        $count = \App\Models\SchedulePrevat::where('status', 'Concluído')
            ->whereBetween('date_event', [$start, $end])
            ->whereExists(function($query) {
                $query->select(\DB::raw(1))
                      ->from('schedule_companies')
                      ->whereRaw('schedule_companies.schedule_prevat_id = schedule_prevats.id');
            })
            ->count();
            
        \Log::info('Dashboard Admin Graph01 - Treinamentos com participação no mês anterior: ' . $count);
        
        return $count;
    }
}
