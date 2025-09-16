<?php

namespace App\Livewire\Reports\Trainings;

use App\Repositories\Reports\TrainingReport;
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
        'column' => 'id',
        'order' => 'ASC'
    ];

    public $filters;

    public $pageSize = 15;
    public $visible = false;

    #[On('filterTableReportTrainings')]
    public function filterTableReportTrainings($filterData = null)
    {
        $this->filters = $filterData;
        $this->visible = true;
    }

    #[On('clearFilterReportTrainings')]
    public function clearFilter($visible = null)
    {
        $this->visible = false;

        $this->reset('filters');
    }

    public function exportExcel()
    {
        $trainingsReport = new TrainingReport();
        $trainingsReturnDB = $trainingsReport->exportExcel($this->order, $this->filters);

        if($trainingsReturnDB['status'] == 'success') {
            $this->sendNotificationSuccess('Sucesso', $trainingsReturnDB['message']);
            return Storage::download('public/relatorios/relatorio_treinamentos.xlsx');
        } elseif ($trainingsReturnDB['status'] == 'erro') {
            $this->sendNotificationDanger('Erro', $trainingsReturnDB['error']);
        }
    }

    public function exportPDF()
    {

        $trainingsReport = new TrainingReport();
        $trainingsReturnDB = $trainingsReport->index($this->order, $this->filters)['data'];

        $data = ['trainings' => $trainingsReturnDB];

        $pdf = Pdf::loadView('admin.pdf.reports.trainings', $data)->setPaper('a4', 'landscape');

        return response()->streamDownload(function() use($pdf){
            echo $pdf->stream();
        },'relatorio_treinamentos.pdf');
    }

    public function getScheduleCompany()
    {
        $trainingsReport = new TrainingReport();
        return $trainingsReport->index($this->order, $this->filters, $this->pageSize)['data'];
    }

    public function render()
    {
        $response = new \stdClass();

        if($this->filters && $this->visible == true) {
            $response->trainings = $this->getScheduleCompany();
        }

        return view('livewire.reports.trainings.table', ['response' => $response]);
    }
}
