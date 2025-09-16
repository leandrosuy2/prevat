<?php

namespace App\Livewire\Movement\ParticipantTraining\Programmatic;

use App\Models\TrainingParticipations;
use App\Repositories\Movements\TrainingParticipationsRepository;
use App\Trait\Interactions;
use Livewire\Component;

class Printer extends Component
{
    use Interactions;

    public $trainingParticipation;

    public function mount($id = null)
    {
        $trainingParticipationRepository = new TrainingParticipationsRepository();
        $trainingParticipationDB = $trainingParticipationRepository->show($id)['data'];

        if($trainingParticipationDB) {
            $this->trainingParticipation = $trainingParticipationDB;
        }
    }

    public function downloadPDF($training_participation_id)
    {
        $trainingParticipationDB = TrainingParticipations::query()->findOrFail($training_participation_id);

        $this->showToast('Sucesso', 'Documento Baixado com sucesso!');
        return response()->download(storage_path($trainingParticipationDB['file_programmatic']));
    }

    public function render()
    {
        return view('livewire.movement.participant-training.programmatic.printer');
    }
}
