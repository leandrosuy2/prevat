<?php

namespace App\Livewire\Movement\SchedulePrevat\Participants;

use App\Models\SchedulePrevat;
use App\Repositories\SchedulePrevatRepository;
use App\Trait\Interactions;
use Livewire\Component;

class Printer extends Component
{
    use Interactions;
    public $schedulePrevat;

    public function mount($id = null)
    {
        $schedulePrevatRepository = new SchedulePrevatRepository();
        $schedulePrevatReturnDB = $schedulePrevatRepository->show($id);

        if($schedulePrevatReturnDB) {
            $this->schedulePrevat = $schedulePrevatReturnDB['data'];
        }

    }

    public function downloadPDF($schedule_prevat_id)
    {
        $schedulePrevatDB = SchedulePrevat::query()->findOrFail($schedule_prevat_id);
        $this->showToast('Sucesso', 'Documento Baixado com sucesso!');
        return response()->download(storage_path($schedulePrevatDB['file_presence']));
    }
    public function render()
    {
        return view('livewire.movement.schedule-prevat.participants.printer');
    }
}
