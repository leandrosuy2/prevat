<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class MonthlyReportExport implements FromArray, WithHeadings, WithStyles, WithColumnWidths, WithEvents
{
    protected $data;
    protected $sections;

    public function __construct($data, $sections)
    {
        $this->data = $data;
        $this->sections = $sections;
    }

    public function array(): array
    {
        $exportData = [];

        // Seção 1: Quantidade de Treinamentos ministrados no mês
        if ($this->sections['trainings'] ?? false) {
            $exportData[] = ['QUANTIDADE DE TREINAMENTOS MINISTRADOS NO MÊS (CRONOGRAMA DO MÊS)'];
            $exportData[] = [];
            $exportData[] = ['Total de Treinamentos:', $this->data['trainings']['total_trainings'] ?? 0];
            $exportData[] = ['Total de Participantes:', $this->data['trainings']['total_participants'] ?? 0];
            $exportData[] = ['Total de Vagas:', $this->data['trainings']['total_vacancies'] ?? 0];
            $exportData[] = [];

            if (!empty($this->data['trainings']['trainings'])) {
                $exportData[] = ['Detalhamento por Treinamento:'];
                $exportData[] = ['Treinamento', 'Sigla', 'Quantidade de Turmas', 'Total de Vagas', 'Total de Participantes', 'Tipo'];
                
                foreach ($this->data['trainings']['trainings'] as $training) {
                    $exportData[] = [
                        $training['name'],
                        $training['acronym'],
                        $training['total_schedules'],
                        $training['total_vacancies'],
                        $training['total_participants'],
                        $training['type']
                    ];
                }
            }
            $exportData[] = [];
            $exportData[] = [];
        }

        // Seção 2: Quantidade de Turmas Extras no mês
        if ($this->sections['extra_classes'] ?? false) {
            $exportData[] = ['QUANTIDADE DE TURMAS EXTRAS NO MÊS'];
            $exportData[] = [];
            $exportData[] = ['Total de Turmas Extras:', $this->data['extra_classes']['total_extra_classes'] ?? 0];
            $exportData[] = ['Total de Vagas em Turmas Extras:', $this->data['extra_classes']['total_vacancies'] ?? 0];
            $exportData[] = ['Total de Participantes em Turmas Extras:', $this->data['extra_classes']['total_participants'] ?? 0];
            $exportData[] = [];
            $exportData[] = [];
        }

        // Seção 3: Quantidade de empresas atendidas no mês
        if ($this->sections['companies'] ?? false) {
            $exportData[] = ['QUANTIDADE DE EMPRESAS ATENDIDAS NO MÊS'];
            $exportData[] = [];
            $exportData[] = ['Total de Empresas Atendidas:', $this->data['companies']['total_companies'] ?? 0];
            $exportData[] = ['Total de Agendamentos:', $this->data['companies']['total_schedules'] ?? 0];
            $exportData[] = ['Total de Participantes:', $this->data['companies']['total_participants'] ?? 0];
            $exportData[] = [];

            if (!empty($this->data['companies']['companies'])) {
                $exportData[] = ['Detalhamento por Empresa:'];
                $exportData[] = ['Empresa', 'Nome Fantasia', 'Quantidade de Agendamentos', 'Quantidade de Treinamentos', 'Total de Participantes'];
                
                foreach ($this->data['companies']['companies'] as $company) {
                    $exportData[] = [
                        $company->company_name,
                        $company->fantasy_name,
                        $company->total_schedules,
                        $company->total_trainings,
                        $company->total_participants
                    ];
                }
            }
            $exportData[] = [];
            $exportData[] = [];
        }

        // Seção 4: Cartões e Cartas entregues no mês
        if ($this->sections['cards_delivered'] ?? false) {
            $exportData[] = ['CARTÕES E CARTAS ENTREGUES NO MÊS'];
            $exportData[] = [];
            $exportData[] = ['Total de Cartões Entregues:', $this->data['cards_delivered']['total_cards_delivered'] ?? 0];
            $exportData[] = ['Participantes Únicos com Cartões:', $this->data['cards_delivered']['unique_participants'] ?? 0];
            $exportData[] = [];
            $exportData[] = [];
        }

        // Seção 5: Quantidade de melhorias do mês
        if ($this->sections['improvements'] ?? false) {
            $exportData[] = ['QUANTIDADE DE MELHORIAS DO MÊS (PROCESSO/INSTALAÇÃO)'];
            $exportData[] = [];
            $exportData[] = ['Total de Melhorias:', $this->data['improvements']['total_improvements'] ?? 0];
            $exportData[] = ['Empresas com Melhorias:', $this->data['improvements']['companies_with_improvements'] ?? 0];
            $exportData[] = [];

            if (!empty($this->data['improvements']['improvements_by_type'])) {
                $exportData[] = ['Melhorias por Categoria:'];
                $exportData[] = ['Categoria', 'Quantidade'];
                
                foreach ($this->data['improvements']['improvements_by_type'] as $improvement) {
                    $exportData[] = [
                        $improvement->category,
                        $improvement->count
                    ];
                }
            }
        }

        return $exportData;
    }

    public function headings(): array
    {
        return [];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 50,
            'B' => 20,
            'C' => 25,
            'D' => 20,
            'E' => 20,
            'F' => 15,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => [
                    'bold' => true,
                    'size' => 14,
                    'color' => ['rgb' => 'FFFFFF']
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '2E86AB']
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                ]
            ],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $lastRow = $sheet->getHighestRow();
                $lastColumn = $sheet->getHighestColumn();

                // Aplicar bordas a todas as células
                $sheet->getStyle('A1:' . $lastColumn . $lastRow)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['rgb' => '000000']
                        ]
                    ]
                ]);

                // Estilizar cabeçalhos das seções
                $currentRow = 1;
                for ($i = 1; $i <= $lastRow; $i++) {
                    $cellValue = $sheet->getCell('A' . $i)->getValue();
                    if (is_string($cellValue) && strpos($cellValue, 'QUANTIDADE') === 0) {
                        $sheet->getStyle('A' . $i . ':' . $lastColumn . $i)->applyFromArray([
                            'font' => [
                                'bold' => true,
                                'size' => 12,
                                'color' => ['rgb' => 'FFFFFF']
                            ],
                            'fill' => [
                                'fillType' => Fill::FILL_SOLID,
                                'startColor' => ['rgb' => '2E86AB']
                            ],
                            'alignment' => [
                                'horizontal' => Alignment::HORIZONTAL_CENTER,
                            ]
                        ]);
                    }
                }

                // Estilizar cabeçalhos de tabelas
                for ($i = 1; $i <= $lastRow; $i++) {
                    $cellValue = $sheet->getCell('A' . $i)->getValue();
                    if (is_string($cellValue) && (
                        strpos($cellValue, 'Treinamento') === 0 ||
                        strpos($cellValue, 'Empresa') === 0 ||
                        strpos($cellValue, 'Categoria') === 0
                    )) {
                        $sheet->getStyle('A' . $i . ':' . $lastColumn . $i)->applyFromArray([
                            'font' => [
                                'bold' => true,
                                'color' => ['rgb' => 'FFFFFF']
                            ],
                            'fill' => [
                                'fillType' => Fill::FILL_SOLID,
                                'startColor' => ['rgb' => '4A90E2']
                            ]
                        ]);
                    }
                }

                // Centralizar colunas numéricas
                $sheet->getStyle('B:B')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('C:C')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('D:D')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('E:E')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('F:F')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            },
        ];
    }
}
