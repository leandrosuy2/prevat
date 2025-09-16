<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Font;
use Carbon\Carbon;

class DashboardExport implements WithMultipleSheets
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function sheets(): array
    {
        $sheets = [];

        // Aba de Resumo
        if (isset($this->data['trainings']) || isset($this->data['companies']) || isset($this->data['turmasExtras'])) {
            $sheets[] = new DashboardSummarySheet($this->data);
        }

        // Aba de Treinamentos
        if (isset($this->data['trainings'])) {
            $sheets[] = new TrainingsSheet($this->data['trainings']);
        }

        // Aba de Empresas
        if (isset($this->data['companies'])) {
            $sheets[] = new CompaniesSheet($this->data['companies']);
        }

        // Aba de Turmas Extras
        if (isset($this->data['turmasExtras'])) {
            $sheets[] = new ExtraClassesSheet($this->data['turmasExtras']);
        }

        return $sheets;
    }
}

class DashboardSummarySheet implements FromArray, WithTitle, WithHeadings, WithStyles
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function title(): string
    {
        return 'Resumo';
    }

    public function headings(): array
    {
        return [
            'Relatório de Dashboard',
            '',
            'Período: ' . Carbon::parse($this->data['start'])->format('d/m/Y') . ' a ' . Carbon::parse($this->data['end'])->format('d/m/Y'),
            '',
            'Filtros aplicados:',
            isset($this->data['training_filter']) ? 'Treinamento: ' . $this->data['training_filter']->name : 'Todos os treinamentos',
            '',
            'Estatísticas:',
            'Treinamentos ministrados: ' . (isset($this->data['trainings']) ? $this->data['trainings']->count() : 0),
            'Empresas atendidas: ' . (isset($this->data['companies']) ? $this->data['companies']->count() : 0),
            'Turmas extras: ' . (isset($this->data['turmasExtras']) ? $this->data['turmasExtras']->count() : 0),
        ];
    }

    public function array(): array
    {
        return [];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A3')->getFont()->setBold(true);
        $sheet->getStyle('A5')->getFont()->setBold(true);
        $sheet->getStyle('A8')->getFont()->setBold(true);
        
        return [
            1 => ['font' => ['bold' => true, 'size' => 14]],
            3 => ['font' => ['bold' => true]],
            5 => ['font' => ['bold' => true]],
            8 => ['font' => ['bold' => true]],
        ];
    }
}

class TrainingsSheet implements FromArray, WithTitle, WithHeadings, WithStyles
{
    protected $trainings;

    public function __construct($trainings)
    {
        $this->trainings = $trainings;
    }

    public function title(): string
    {
        return 'Treinamentos';
    }

    public function headings(): array
    {
        return [
            'Data',
            'Treinamento',
            'Empresa',
            'Participantes',
        ];
    }

    public function array(): array
    {
        $data = [];
        foreach ($this->trainings as $item) {
            $data[] = [
                optional($item->schedule)->date_event ? Carbon::parse($item->schedule->date_event)->format('d/m/Y') : '-',
                optional($item->schedule->training)->name ?? '-',
                optional($item->company)->fantasy_name ?? '-',
                $item->participants->count(),
            ];
        }
        return $data;
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}

class CompaniesSheet implements FromArray, WithTitle, WithHeadings, WithStyles
{
    protected $companies;

    public function __construct($companies)
    {
        $this->companies = $companies;
    }

    public function title(): string
    {
        return 'Empresas';
    }

    public function headings(): array
    {
        return [
            'Empresa',
            'CNPJ',
            'Email',
            'Telefone',
        ];
    }

    public function array(): array
    {
        $data = [];
        foreach ($this->companies as $company) {
            $data[] = [
                $company->fantasy_name ?? '-',
                $company->employer_number ?? '-',
                $company->email ?? '-',
                $company->phone ?? '-',
            ];
        }
        return $data;
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}

class ExtraClassesSheet implements FromArray, WithTitle, WithHeadings, WithStyles
{
    protected $turmasExtras;

    public function __construct($turmasExtras)
    {
        $this->turmasExtras = $turmasExtras;
    }

    public function title(): string
    {
        return 'Turmas Extras';
    }

    public function headings(): array
    {
        return [
            'Data',
            'Treinamento',
            'Empresa Contratante',
            'Equipe',
        ];
    }

    public function array(): array
    {
        $data = [];
        foreach ($this->turmasExtras as $turma) {
            $data[] = [
                $turma->date_event ? Carbon::parse($turma->date_event)->format('d/m/Y') : '-',
                optional($turma->training)->name ?? '-',
                optional($turma->contractor)->fantasy_name ?? '-',
                optional($turma->team)->name ?? '-',
            ];
        }
        return $data;
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
} 