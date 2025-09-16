<?php

namespace App\Livewire\Movement\ParticipantTraining\Certificates;

use App\Models\TrainingParticipations;
use App\Repositories\Movements\TrainingCertificationsRepository;
use App\Repositories\Movements\TrainingParticipationsRepository;
use App\Trait\Interactions;
use Livewire\Attributes\On;
use Livewire\Component;
use Neysi\DirectPrint\DirectPrint;
use Rawilk\Printing\Printing;

class Table extends Component
{
    use Interactions;

    public $trainingParticipation;
    public function mount($id = null)
    {
        $trainingProfessionalsRepository = new TrainingParticipationsRepository();
        $trainingReturnDB = $trainingProfessionalsRepository->show($id)['data'];

        if($trainingReturnDB) {
            $this->trainingParticipation = $trainingReturnDB;
        }
    }

    #[On('getCertificatesByParticipation')]
    public function getCertificatesByParticipation()
    {
        $trainingProfessionalsRepository = new TrainingCertificationsRepository();
        return  $trainingProfessionalsRepository->getCertificates($this->trainingParticipation->id)['data'];
    }

    public function refreshPDF($training_participation_id)
    {
        $trainingCertificationsRepository = new TrainingCertificationsRepository();
        $trainingCertificationsReturnDB = $trainingCertificationsRepository->generateAllCertificatesPDF($training_participation_id);

        if($trainingCertificationsReturnDB['status'] == 'success') {
            $this->sendNotificationSuccess('Sucesso', $trainingCertificationsReturnDB['message']);
        }
    }

    public function generateQRCode($training_participation_id)
    {
        $trainingCertificationsRepository = new TrainingCertificationsRepository();
        $trainingCertificationsReturnDB = $trainingCertificationsRepository->generateQRCODE($training_participation_id);

        if($trainingCertificationsReturnDB['status'] == 'success') {
            $this->sendNotificationSuccess('Sucesso', $trainingCertificationsReturnDB['message']);
        }
    }

    public function downloadPDF($training_participation_id)
    {
        $trainingParticipationID = TrainingParticipations::query()->findOrFail($training_participation_id);
        return response()->download(storage_path($trainingParticipationID['file']));
    }

    public function printPDF($training_participation_id)
    {
//        $printers =  DirectPrint::getPrinters() ;
//
//        $printerName =  DirectPrint::getDefaultPrinter() ;
//        dd($printerName);

        $trainingParticipationID = TrainingParticipations::query()->findOrFail($training_participation_id);
        return DirectPrint::printFile(storage_path($trainingParticipationID['file']));

    }


    public function render()
    {
        $response = new \stdClass();
        $response->certificates = $this->getCertificatesByParticipation();

        return view('livewire.movement.participant-training.certificates.table', ['response' => $response]);
    }
}
