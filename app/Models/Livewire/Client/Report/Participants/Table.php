<?php

namespace App\Livewire\Client\Report\Participants;

use App\Repositories\Client\Reports\ParticipantsReportRepository;
use App\Trait\Interactions;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Table extends Component
{
    use WithPagination, Interactions;

    public $order = [
        'column' => 'created_at',
        'order' => 'DESC'
    ];

    public $filters;

    public $pageSize = 15;
    public $visible = false;

    #[On('filterTableReportTrainingParticipantsClient')]
    public function filterTableEvidences($filterData = null)
    {
        $this->resetPage();
        $this->filters = $filterData;
        $this->visible = true;
    }

    #[On('clearFilterReportTrainingParticipantsClient')]
    public function clearFilter($visible = null)
    {
        $this->visible = false;
        $this->resetPage();
    }

    public function exportExcel()
    {
        $participantTrainingReport = new ParticipantsReportRepository();
        $participantTrainingReturnDB = $participantTrainingReport->exportExcel($this->order, $this->filters);


        if($participantTrainingReturnDB['status'] == 'success') {
            $this->sendNotificationSuccess('Sucesso', $participantTrainingReturnDB['message']);
            return Storage::download('public/relatorios/relatorio_treinamento_participantes.xlsx');
        } elseif ($participantTrainingReturnDB['status'] == 'erro') {
            $this->sendNotificationDanger('Erro', $participantTrainingReturnDB['error']);
        }
    }

    public function exportPDF()
    {

        $participantTrainingReport = new ParticipantsReportRepository();
        $participantTrainingReturnDB = $participantTrainingReport->index($this->order, $this->filters)['data'];

        $data = ['participantTraining' => $participantTrainingReturnDB];

        $pdf = Pdf::loadView('admin.pdf.reports.participant_training', $data)->setPaper('a4', 'landscape');

        return response()->streamDownload(function() use($pdf){
            echo $pdf->stream();
        },'relatorio_treinamento_participante.pdf');
    }

    public function getParticipantsTraining()
    {
        $participantTrainingReport = new ParticipantsReportRepository();
        return $participantTrainingReport->index($this->order, $this->filters, $this->pageSize)['data'];
    }

    public function render()
    {
        $response = new \stdClass();

        if($this->filters && $this->visible == true) {
            $response->participantsTraining = $this->getParticipantsTraining();
        }

        return view('livewire.client.report.participants.table', ['response' => $response]);
    }
}
