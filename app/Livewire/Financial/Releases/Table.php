<?php

namespace App\Livewire\Financial\Releases;

use App\Repositories\Financial\FinancialRepository;
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

    #[On('filterTableScheduleCompanyFinancial')]
    public function filterTableScheduleCompanyFinancial($filterData = null)
    {
        $this->filters = $filterData;
    }

    #[On('clearFilterFinancial')]
    public function clearFilter($visible = null)
    {
        $this->filters = null;
    }

    #[On('getScheduleCompany')]
    public function getScheduleCompany()
    {
        $financialRepository = new FinancialRepository();
        return $financialRepository->index($this->order, $this->filters, $this->pageSize)['data'];
    }

    public function exportExcel($type)
    {
        $financialRepository = new FinancialRepository();
        $financialReturnDB = $financialRepository->exportExcel($this->order, $this->filters, $type);

        if($financialReturnDB['status'] == 'success') {
            $this->sendNotificationSuccess('Sucesso', $financialReturnDB['message']);
            return Storage::download('public/relatorios/financeiro.xlsx');
        } elseif ($financialReturnDB['status'] == 'erro') {
            $this->sendNotificationDanger('Erro', $financialReturnDB['error']);
        }
    }

    public function exportPDF($type)
    {

        $companiesReport = new FinancialRepository();
        if($type == 'company' ) {
            $companiesReturnDB = $companiesReport->index($this->order, $this->filters)['data'];
            $data = ['companies' => $companiesReturnDB];
            $pdf = Pdf::loadView('admin.pdf.reports.financial_companies', $data)->setPaper('a4', 'landscape');
            $filename = 'relatorio_financeiro_empresas.pdf';
        } else {
            $companiesReturnDB = $companiesReport->exportPDF($this->order, $this->filters)['data'];
            $filename = 'relatorio_financeiro_participantes.pdf';
            $data = ['companies' => $companiesReturnDB];

            $pdf = Pdf::loadView('admin.pdf.reports.financial_participants', $data)->setPaper('a4', 'landscape');
        }

        return response()->streamDownload(function() use($pdf){
            echo $pdf->stream();
        }, $filename);
    }

    public function render()
    {
        $response = new \stdClass();
        $response->scheduleCompanies = $this->getScheduleCompany();

        return view('livewire.financial.releases.table', ['response' => $response]);
    }
}
