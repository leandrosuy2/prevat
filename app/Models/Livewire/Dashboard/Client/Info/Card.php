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

    public function mount($contract = null)
    {
        $participantRepository = new ParticipantRepository();
        $this->participants = $participantRepository->index()['data'];

        $scheduleCompanyRepository = new ScheduleCompanyRepository();
        $this->schedules = $scheduleCompanyRepository->index()['data'];


        $dashboardRepository = new DashboardRepository();
        $this->presences = $dashboardRepository->getCountPresences(true);
        $this->absences = $dashboardRepository->getCountPresences(false);

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
}
