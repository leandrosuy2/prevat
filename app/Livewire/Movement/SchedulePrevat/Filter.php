<?php

namespace App\Livewire\Movement\SchedulePrevat;

use Livewire\Component;

class Filter extends Component
{
    public $filter = [
        'date_start' => '',
        'date_end' => ''
    ];

    public function mount()
    {
        if(session('filter')){
            if(isset(session('filter')['search'])) {
                $this->filter['search'] = session('filter')['search'];
            }

            if(isset(session('filter')['cidade'])) {
                $this->filter['date_start'] = session('filter')['date_start'];
            }

            if(isset(session('filter')['bairro'])) {
                $this->filter['date_start'] = session('filter')['date_start'];
            }
        }
    }

    public function clearFilter()
    {
        $this->reset();
        session()->forget('filter');
        $this->dispatch('clearFilter');
    }

    public function submit()
    {
        $request = $this->filter;
        $this->dispatch('filterTableSchedulePrevat', filterData: $request);
        session()->put('filter', $request);
    }


    public function render()
    {
        return view('livewire.movement.schedule-prevat.filter');
    }
}
