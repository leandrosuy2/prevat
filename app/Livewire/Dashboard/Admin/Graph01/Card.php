<?php

namespace App\Livewire\Dashboard\Admin\Graph01;

use Livewire\Component;
use Carbon\Carbon;

class Card extends Component
{
    public $trainingsThisMonth;
    public $trainingsLastMonth;

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
            
        \Log::info('Dashboard Admin Graph01 - Treinamentos com participação neste mês: ' . $count);
        
        return $count;
    }

    private function getTrainingsLastMonth()
    {
        $start = now()->subMonth()->startOfMonth();
        $end = now()->subMonth()->endOfMonth();
        
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
