<?php

namespace App\Livewire\Reports\Companies;

use App\Repositories\Reports\CompaniesReport;
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
        'column' => 'name',
        'order' => 'ASC'
    ];

    public $filters;

    public $pageSize = 15;
    public $visible = false;

    #[On('filterTableReportCompanies')]
    public function filterTableReportCompanies($filterData = null)
    {
        $this->filters = $filterData;
        $this->visible = true;
    }

    #[On('clearFilterReportCompanies')]
    public function clearFilter($visible = null)
    {
        $this->visible = false;

        $this->reset('filters');
    }

    public function exportExcel()
    {
        $companiesReport = new CompaniesReport();
        $companiesReturnDB = $companiesReport->exportExcel($this->order, $this->filters);

        if($companiesReturnDB['status'] == 'success') {
            $this->sendNotificationSuccess('Sucesso', $companiesReturnDB['message']);
            return Storage::download('public/relatorios/relatorio_empresas.xlsx');
        } elseif ($companiesReturnDB['status'] == 'erro') {
            $this->sendNotificationDanger('Erro', $companiesReturnDB['error']);
        }
    }

    public function exportPDF()
    {

        $companiesReport = new CompaniesReport();
        $companiesReturnDB = $companiesReport->index($this->order, $this->filters)['data'];

        $data = ['companies' => $companiesReturnDB];

        $pdf = Pdf::loadView('admin.pdf.reports.companies', $data)->setPaper('a4', 'landscape');

        return response()->streamDownload(function() use($pdf){
            echo $pdf->stream();
        },'relatorio_empresas.pdf');
    }

    public function getCompanies()
    {
        $companiesReport = new CompaniesReport();
        return $companiesReport->index($this->order, $this->filters, $this->pageSize)['data'];
    }

    public function render()
    {
        $response = new \stdClass();

        if($this->filters && $this->visible == true) {
            $response->companies = $this->getCompanies();
        }
        return view('livewire.reports.companies.table', ['response' => $response]);
    }
}
