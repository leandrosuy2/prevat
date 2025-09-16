<?php

namespace App\Livewire\Reports\MonthlyReport;

use App\Exports\MonthlyReportExport;
use App\Repositories\MonthlyReportRepository;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;

class Index extends Component
{
    public $startDate;
    public $endDate;
    public $trainingId = null;
    public $sections = [
        'trainings' => true,
        'companies' => true,
        'extra_classes' => true,
        'cards_delivered' => true,
        'improvements' => true
    ];
    public $exportFormat = 'pdf';

    protected $rules = [
        'startDate' => 'required|date',
        'endDate' => 'required|date|after_or_equal:startDate',
        'trainingId' => 'nullable|exists:trainings,id',
        'sections' => 'required|array',
        'exportFormat' => 'required|in:pdf,excel'
    ];

    protected $messages = [
        'startDate.required' => 'A data inicial é obrigatória.',
        'endDate.required' => 'A data final é obrigatória.',
        'endDate.after_or_equal' => 'A data final deve ser maior ou igual à data inicial.',
        'trainingId.exists' => 'O treinamento selecionado não existe.',
        'sections.required' => 'Selecione pelo menos uma seção para incluir no relatório.',
        'exportFormat.required' => 'Selecione o formato de exportação.',
        'exportFormat.in' => 'Formato de exportação inválido.'
    ];

    public function mount()
    {
        $this->startDate = now()->startOfMonth()->format('Y-m-d');
        $this->endDate = now()->endOfMonth()->format('Y-m-d');
    }

    public function export()
    {
        $this->validate();

        $repository = new MonthlyReportRepository();
        $data = $repository->getMonthlyReportData($this->startDate, $this->endDate, $this->trainingId, $this->sections);

        $fileName = 'relatorio_mensal_' . date('Y_m', strtotime($this->startDate)) . '_' . time();

        if ($this->exportFormat === 'excel') {
            return Excel::download(new MonthlyReportExport($data, $this->sections), $fileName . '.xlsx');
        } else {
            return $this->exportToPdf($data, $fileName);
        }
    }

    private function exportToPdf($data, $fileName)
    {
        $pdf = app('dompdf.wrapper');
        $pdf->loadView('admin.reports.monthly-report.pdf', [
            'data' => $data,
            'sections' => $this->sections,
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
            'trainingName' => $this->getTrainingName()
        ]);

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, $fileName . '.pdf');
    }

    private function getTrainingName()
    {
        if ($this->trainingId) {
            $training = \App\Models\Training::find($this->trainingId);
            return $training ? $training->name : 'Treinamento não encontrado';
        }
        return 'Todos os treinamentos';
    }

    public function render()
    {
        $trainings = \App\Models\Training::where('status', 'active')->orderBy('name')->get();
        
        return view('livewire.reports.monthly-report.index', [
            'trainings' => $trainings
        ]);
    }
}
