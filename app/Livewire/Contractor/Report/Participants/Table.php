<?php

namespace App\Livewire\Contractor\Report\Participants;

use App\Repositories\Contractor\Reports\ParticipantsReportRepository;
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

    #[On('filterTableReportTrainingParticipantsContractor')]
    public function filterTableEvidences($filterData = null)
    {
        $this->filters = $filterData;
        $this->resetPage();
        $this->visible = true;
    }

    #[On('clearFilterReportTrainingParticipantsContractor')]
    public function clearFilter($visible = null)
    {
        $this->visible = false;

        $this->reset('filters');
    }

    public function exportExcel()
    {
        $participantTrainingReport = new ParticipantsReportRepository();
        $participantTrainingRetunDB = $participantTrainingReport->exportExcel($this->order, $this->filters);


        if($participantTrainingRetunDB['status'] == 'success') {
            $this->sendNotificationSuccess('Sucesso', $participantTrainingRetunDB['message']);
            return Storage::download('public/relatorios/relatorio_treinamento_participantes.xlsx');
        } elseif ($participantTrainingRetunDB['status'] == 'erro') {
            $this->sendNotificationDanger('Erro', $participantTrainingRetunDB['error']);
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

        return view('livewire.contractor.report.participants.table', ['response' => $response]);
    }
}
