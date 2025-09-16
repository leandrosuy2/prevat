<?php

namespace App\Livewire\Movement\SchedulePrevat\Participants\Signature;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use Livewire\Component;

class Form extends Component
{
    public $signature;

    #[On('signature-saved')]
    public function submit($refreshPosts)
    {
//        Storage::disk('public')->makeDirectory('lista-participantes/'.$scheduleCompanyDB['schedule_prevat_id']);

        \Storage::disk('public')->put('signatures2/signature.png', base64_decode(Str::of($refreshPosts)->after(',')));
    }

    public function render()
    {
        return view('livewire.movement.schedule-prevat.participants.signature.form');
    }
}
