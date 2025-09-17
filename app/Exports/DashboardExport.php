<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Font;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
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

class DashboardSummarySheet implements FromArray, WithTitle, WithHeadings, WithStyles, ShouldAutoSize, WithEvents
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

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $highestColumn = $sheet->getHighestColumn();
                $highestRow = $sheet->getHighestRow();

                // Melhorar visual
                $sheet->getColumnDimension('A')->setAutoSize(true);
                $sheet->getStyle('A1:A'.$highestRow)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                $sheet->getStyle('A1')->getFont()->setSize(16);
            }
        ];
    }
}

class TrainingsSheet implements FromArray, WithTitle, WithHeadings, WithStyles, ShouldAutoSize, WithEvents
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

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $highestColumn = $sheet->getHighestColumn();
                $highestRow = $sheet->getHighestRow();

                // Header style
                $sheet->getStyle('A1:'.$highestColumn.'1')->applyFromArray([
                    'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '3B82F6']],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);

                // Borders
                $sheet->getStyle('A1:'.$highestColumn.$highestRow)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['rgb' => 'E5E7EB']
                        ]
                    ]
                ]);

                // Zebra striping
                for ($row = 2; $row <= $highestRow; $row++) {
                    if ($row % 2 === 0) {
                        $sheet->getStyle('A'.$row.':'.$highestColumn.$row)
                            ->getFill()->setFillType(Fill::FILL_SOLID)
                            ->getStartColor()->setRGB('F9FAFB');
                    }
                }

                // Freeze header and set auto filter
                $sheet->freezePane('A2');
                $sheet->setAutoFilter('A1:'.$highestColumn.'1');
            }
        ];
    }
}

class CompaniesSheet implements FromArray, WithTitle, WithHeadings, WithStyles, ShouldAutoSize, WithEvents
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

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $highestColumn = $sheet->getHighestColumn();
                $highestRow = $sheet->getHighestRow();

                // Header style
                $sheet->getStyle('A1:'.$highestColumn.'1')->applyFromArray([
                    'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '10B981']],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);

                // Borders
                $sheet->getStyle('A1:'.$highestColumn.$highestRow)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['rgb' => 'E5E7EB']
                        ]
                    ]
                ]);

                // Zebra striping
                for ($row = 2; $row <= $highestRow; $row++) {
                    if ($row % 2 === 0) {
                        $sheet->getStyle('A'.$row.':'.$highestColumn.$row)
                            ->getFill()->setFillType(Fill::FILL_SOLID)
                            ->getStartColor()->setRGB('F9FAFB');
                    }
                }

                $sheet->freezePane('A2');
                $sheet->setAutoFilter('A1:'.$highestColumn.'1');
            }
        ];
    }
}

class ExtraClassesSheet implements FromArray, WithTitle, WithHeadings, WithStyles, ShouldAutoSize, WithEvents
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
                $turma->turma_type ?? optional($turma->team)->name ?? '-',
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

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $highestColumn = $sheet->getHighestColumn();
                $highestRow = $sheet->getHighestRow();

                // Header style
                $sheet->getStyle('A1:'.$highestColumn.'1')->applyFromArray([
                    'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'EF4444']],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);

                // Borders
                $sheet->getStyle('A1:'.$highestColumn.$highestRow)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['rgb' => 'E5E7EB']
                        ]
                    ]
                ]);

                // Zebra striping
                for ($row = 2; $row <= $highestRow; $row++) {
                    if ($row % 2 === 0) {
                        $sheet->getStyle('A'.$row.':'.$highestColumn.$row)
                            ->getFill()->setFillType(Fill::FILL_SOLID)
                            ->getStartColor()->setRGB('F9FAFB');
                    }
                }

                $sheet->freezePane('A2');
                $sheet->setAutoFilter('A1:'.$highestColumn.'1');
            }
        ];
    }
} 