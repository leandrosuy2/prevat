<?php

namespace App\Livewire\Movement\ParticipantTraining\Programmatic;

use App\Models\SchedulePrevat;
use App\Models\TrainingParticipations;
use App\Repositories\Movements\TrainingCertificationsRepository;
use App\Repositories\Movements\TrainingParticipationsRepository;
use App\Repositories\ParticipantRepository;
use App\Repositories\SchedulePrevatRepository;
use App\Trait\Interactions;
use Barryvdh\DomPDF\Facade\Pdf;
use Livewire\Component;
use Neysi\DirectPrint\DirectPrint;

class Card extends Component
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

    public function refreshPDF($training_participation_id)
    {
        $trainingCertificationsRepository = new TrainingCertificationsRepository();
        $trainingCertificationsReturnDB = $trainingCertificationsRepository->generateProgrammaticPDF($training_participation_id);

        if($trainingCertificationsReturnDB['status'] == 'success') {
            $this->sendNotificationSuccess('Sucesso', $trainingCertificationsReturnDB['message']);
        }
    }

    public function printPDF($training_participation_id)
    {
//        $printers =  DirectPrint::getPrinters() ;
//
        $printerName =  DirectPrint::getDefaultPrinter() ;
        if($printerName) {
            $trainingParticipationDB = TrainingParticipations::query()->findOrFail($training_participation_id);
            $this->showToast('Sucesso', 'Documento enviado para a Impressora'.$printerName);
            return DirectPrint::printFile(storage_path($trainingParticipationDB['file_programmatic']));
        } else {
            $this->showToast('Erro !', 'Você nao tem uma impressora padrão definda, defina uma impressora padrão.');
        }
    }

    public function downloadProgrammatic($id)
    {
        $trainingParticipationDB = TrainingParticipations::query()
            ->with([
                'schedule_prevat' => function($query) {
                    $query->withoutGlobalScopes();
                },
                'schedule_prevat.training.technical', 
                'professionals'
            ])
            ->findOrFail($id);

        $data = ['content' => $trainingParticipationDB];

        $pdf = Pdf::loadView('pdf.programmatic', $data)->setPaper('A4', 'landscape')->setOption(['defaultFont'=> 'arial']);

        return response()->streamDownload(function() use($pdf){
            echo $pdf->stream();
        },'conteudo_programatico'.$trainingParticipationDB['schedule_prevat']['training']['name'].'.pdf');
    }

    public function render()
    {
        return view('livewire.movement.participant-training.programmatic.card');
    }
}
