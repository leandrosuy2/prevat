<?php

namespace App\Livewire\Movement\SchedulePrevat\Programmatic;

use App\Models\SchedulePrevat;
use App\Models\TrainingParticipations;
use App\Repositories\SchedulePrevatRepository;
use App\Trait\Interactions;
use Barryvdh\DomPDF\Facade\Pdf;
use Livewire\Component;
use Neysi\DirectPrint\DirectPrint;

class Card extends Component
{
    use Interactions;

    public $schedulePrevat;
    public function mount($id = null)
    {
        $schedulePrevatRepository = new SchedulePrevatRepository();
        $schdulePrevatReturnDB = $schedulePrevatRepository->show($id)['data'];

        if($schdulePrevatReturnDB) {
            $this->schedulePrevat = $schdulePrevatReturnDB;
        }
    }

    public function downloadPDF($schedule_prevat_id)
    {
        $schedulePrevatDB = SchedulePrevat::query()->findOrFail($schedule_prevat_id);

        $this->sendNotificationSuccess('Sucesso', 'Documento Baixado com sucesso!');
        return response()->download(storage_path($schedulePrevatDB['file_programmatic']));
    }

    public function printPDF($schedule_prevat_id)
    {
//        $printers =  DirectPrint::getPrinters() ;
//
        $printerName =  DirectPrint::getDefaultPrinter() ;
        if($printerName) {
            $schedulePrevatDB = SchedulePrevat::query()->findOrFail($schedule_prevat_id);
            $this->sendNotificationSuccess('Sucesso', 'Documento enviado para a Impressora'.$printerName);
            return DirectPrint::printFile(storage_path($schedulePrevatDB['file_programmatic']));
        } else {
            $this->sendNotificationDanger('Erro !', 'Você nao tem uma impressora padrão definda, defina uma impressora padrão.');
        }
    }

    public function downloadProgrammatic($id)
    {
        $trainingParticipationDB = TrainingParticipations::query()->with(['schedule_prevat.training.technical', 'professionals'])->findOrFail($id);

        $data = ['content' => $trainingParticipationDB];

        $pdf = Pdf::loadView('pdf.programmatic', $data)->setPaper('A4', 'landscape')->setOption(['defaultFont'=> 'arial']);

        return response()->streamDownload(function() use($pdf){
            echo $pdf->stream();
        },'conteudo_programatico'.$trainingParticipationDB['schedule_prevat']['training']['name'].'.pdf');

    }

    public function render()
    {
        return view('livewire.movement.schedule-prevat.programmatic.card');
    }
}
