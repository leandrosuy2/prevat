<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Reports\TrainingReport;
use App\Repositories\Reports\CompaniesReport;
use App\Repositories\SchedulePrevatRepository;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DashboardExport;
use Carbon\Carbon;

class DashboardExportController extends Controller
{
    public function export(Request $request)
    {
        // Valores padrão se não fornecidos
        $start = $request->get('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $end = $request->get('end_date', Carbon::now()->endOfMonth()->format('Y-m-d'));
        $trainingId = $request->get('training_id');
        $contractorFilter = $request->get('contractor_filter'); // 'alunorte' | 'prevat' | null
        $sections = $request->get('sections', ['trainings', 'companies', 'extra_classes']);
        $format = $request->get('format', 'pdf');

        $dates = $start . ' to ' . $end;
        
        // Log dos parâmetros recebidos
        \Log::info('=== INÍCIO DA EXPORTAÇÃO DO DASHBOARD ===');
        \Log::info('Parâmetros recebidos:', [
            'Data Início' => $start,
            'Data Fim' => $end,
            'Treinamento ID' => $trainingId,
            'Seções' => $sections,
            'Formato' => $format,
            'Contratante' => $contractorFilter
        ]);

        $data = [
            'start' => $start,
            'end' => $end,
            'training_filter' => null,
        ];

        // Treinamentos ministrados
        if (in_array('trainings', $sections)) {
            $trainingReport = new TrainingReport();
            $trainings = $trainingReport->index(null, ['dates' => $dates], null)['data'];

            // Filtrar por contratante se solicitado
            if ($contractorFilter) {
                $trainings = $trainings->filter(function($item) use ($contractorFilter) {
                    $name = strtolower(optional($item->schedule->contractor)->fantasy_name ?? '');
                    if ($contractorFilter === 'alunorte') {
                        return str_contains($name, 'alunorte');
                    }
                    if ($contractorFilter === 'prevat') {
                        return str_contains($name, 'prevat');
                    }
                    return true;
                });
                \Log::info('Filtro aplicado - Contratante (treinamentos): ' . $contractorFilter . ' -> ' . $trainings->count());
            }
            
            // Log dos dados de treinamentos vindos do banco
            \Log::info('=== DADOS DE TREINAMENTOS DO BANCO ===');
            \Log::info('Período: ' . $dates);
            \Log::info('Total de treinamentos encontrados: ' . $trainings->count());
            foreach ($trainings as $index => $training) {
                \Log::info("Treinamento " . ($index + 1) . ":", [
                    'ID' => $training->id ?? 'N/A',
                    'Data' => optional($training->schedule)->date_event ?? 'N/A',
                    'Treinamento' => optional($training->schedule->training)->name ?? 'N/A',
                    'Empresa' => optional($training->company)->fantasy_name ?? 'N/A',
                    'Participantes' => $training->participants->count() ?? 0
                ]);
            }
            
            // Filtrar por treinamento específico se selecionado
            if ($trainingId) {
                $trainings = $trainings->filter(function($item) use ($trainingId) {
                    return optional($item->schedule->training)->id == $trainingId;
                });
                $data['training_filter'] = \App\Models\Training::find($trainingId);
                \Log::info('Filtro aplicado - Treinamento ID: ' . $trainingId);
                \Log::info('Treinamentos após filtro: ' . $trainings->count());
            }
            
            $data['trainings'] = $trainings;
        }

        // Empresas atendidas (empresas com agendamento no período)
        if (in_array('companies', $sections)) {
            $companies = \App\Models\ScheduleCompany::withoutGlobalScopes()
                ->whereHas('schedule', function($query) use ($start, $end, $contractorFilter) {
                    $query->where('status', 'Concluído')
                          ->whereBetween('date_event', [$start, $end]);
                    if ($contractorFilter === 'alunorte') {
                        $query->whereHas('contractor', function($q){ $q->where('fantasy_name', 'like', '%ALUNORTE%'); });
                    } elseif ($contractorFilter === 'prevat') {
                        $query->whereHas('contractor', function($q){ $q->where('fantasy_name', 'like', '%PREVAT%'); });
                    }
                })
                ->with('company')
                ->get()
                ->pluck('company')
                ->unique('id');
            
            // Log dos dados de empresas vindos do banco
            \Log::info('=== DADOS DE EMPRESAS DO BANCO ===');
            \Log::info('Período: ' . $start . ' a ' . $end);
            \Log::info('Total de empresas encontradas: ' . $companies->count());
            foreach ($companies as $index => $company) {
                \Log::info("Empresa " . ($index + 1) . ":", [
                    'ID' => $company->id ?? 'N/A',
                    'Nome Fantasia' => $company->fantasy_name ?? 'N/A',
                    'Razão Social' => $company->corporate_name ?? 'N/A',
                    'CNPJ' => $company->cnpj ?? 'N/A'
                ]);
            }
            
            // Filtrar por treinamento específico se selecionado
            if ($trainingId) {
                $companies = $companies->filter(function($company) use ($start, $end, $trainingId) {
                    return \App\Models\ScheduleCompany::withoutGlobalScopes()
                        ->where('company_id', $company->id)
                        ->whereHas('schedule', function($query) use ($start, $end, $trainingId) {
                            $query->where('status', 'Concluído')
                                  ->whereBetween('date_event', [$start, $end])
                                  ->where('training_id', $trainingId);
                        })
                        ->exists();
                });
                \Log::info('Filtro aplicado - Treinamento ID: ' . $trainingId);
                \Log::info('Empresas após filtro: ' . $companies->count());
            }
            
            $data['companies'] = $companies;
        }

        // Turmas extras (detectadas por nome e filtradas diretamente no banco)
        if (in_array('extra_classes', $sections)) {
            $turmasExtras = \App\Models\SchedulePrevat::query()
                ->with(['team:id,name', 'training:id,name', 'contractor:id,fantasy_name'])
                ->whereBetween('date_event', [$start, $end])
                ->when($trainingId, function($q) use ($trainingId){
                    $q->where('training_id', $trainingId);
                })
                ->when($contractorFilter === 'alunorte', function($q){
                    $q->whereHas('contractor', function($qc){ $qc->where('fantasy_name', 'like', '%ALUNORTE%'); });
                })
                ->when($contractorFilter === 'prevat', function($q){
                    $q->whereHas('contractor', function($qc){ $qc->where('fantasy_name', 'like', '%PREVAT%'); });
                })
                ->where(function($q){
                    $q->whereHas('team', function($qt){
                        $qt->where('name', 'like', '%EXTRA%')->orWhere('name', 'like', '%TURMA EXTRA%');
                    })->orWhereHas('training', function($qr){
                        $qr->where('name', 'like', '%TURMA EXTRA%');
                    });
                })
                ->orderByDesc('date_event')
                ->get();
            
            // Log dos dados de turmas extras vindos do banco
            \Log::info('=== DADOS DE TURMAS EXTRAS DO BANCO ===');
            \Log::info('Período: ' . $start . ' a ' . $end);
            \Log::info('Total de turmas extras encontradas: ' . $turmasExtras->count());
            
            // Processar as turmas para determinar se é 1ª, 2ª ou turma extra
            $turmasProcessadas = $turmasExtras->map(function($turma, $index) {
                $teamName = optional($turma->team)->name ?? '';
                $trainingName = optional($turma->training)->name ?? '';
                
                // Determinar o tipo de turma baseado no nome da equipe e treinamento
                $turmaType = $this->determinarTipoTurma($teamName, $trainingName);
                
                // Adicionar o tipo de turma ao objeto
                $turma->turma_type = $turmaType;
                
                \Log::info("Turma Extra " . ($index + 1) . ":", [
                    'ID' => $turma->id ?? 'N/A',
                    'Data' => $turma->date_event ?? 'N/A',
                    'Treinamento' => $trainingName,
                    'Empresa Contratante' => optional($turma->contractor)->fantasy_name ?? 'N/A',
                    'Equipe Original' => $teamName,
                    'Tipo Turma' => $turmaType,
                    'Tipo' => $turma->type ?? 'N/A',
                    'Vagas' => $turma->vacancies ?? 0,
                    'Vagas Ocupadas' => $turma->vacancies_occupied ?? 0
                ]);
                
                return $turma;
            });
            
            // Ordenar as turmas: 1ª TURMA, 2ª TURMA, TURMA EXTRA
            $turmasOrdenadas = $turmasProcessadas->sortBy(function($turma) {
                $tipo = $turma->turma_type ?? 'TURMA EXTRA';
                
                // Definir ordem de prioridade
                switch($tipo) {
                    case '1ª TURMA':
                        return 1;
                    case '2ª TURMA':
                        return 2;
                    case 'TURMA EXTRA':
                    default:
                        return 3;
                }
            })->values(); // values() para reindexar a collection
            
            \Log::info('=== TURMAS ORDENADAS ===');
            \Log::info('Total de turmas ordenadas: ' . $turmasOrdenadas->count());
            \Log::info('Ordem: 1ª TURMA → 2ª TURMA → TURMA EXTRA');
            
            $data['turmasExtras'] = $turmasOrdenadas;
        }

        // Log do resumo final dos dados
        \Log::info('=== RESUMO FINAL DOS DADOS ===');
        \Log::info('Dados preparados para exportação:', [
            'Treinamentos' => isset($data['trainings']) ? $data['trainings']->count() : 0,
            'Empresas' => isset($data['companies']) ? $data['companies']->count() : 0,
            'Turmas Extras' => isset($data['turmasExtras']) ? $data['turmasExtras']->count() : 0,
            'Filtro de Treinamento' => isset($data['training_filter']) ? $data['training_filter']->name : 'Nenhum'
        ]);

        $filename = 'dashboard_export_' . Carbon::parse($start)->format('Y_m_d') . '_to_' . Carbon::parse($end)->format('Y_m_d');

        if ($format === 'excel') {
            \Log::info('Gerando arquivo Excel: ' . $filename . '.xlsx');
            return Excel::download(new DashboardExport($data), $filename . '.xlsx');
        } else {
            \Log::info('Gerando arquivo PDF: ' . $filename . '.pdf');
            $pdf = Pdf::loadView('admin.pdf.dashboard_export', $data);
            $pdf->setPaper('a4', 'landscape');
            return $pdf->download($filename . '.pdf');
        }
    }
    
    /**
     * Determina o tipo de turma baseado no nome da equipe e treinamento
     */
    private function determinarTipoTurma($teamName, $trainingName)
    {
        // Se o nome da equipe contém "1ª TURMA" ou "1ª"
        if (stripos($teamName, '1ª TURMA') !== false || stripos($teamName, '1ª') !== false) {
            return '1ª TURMA';
        }
        
        // Se o nome da equipe contém "2ª TURMA" ou "2ª"
        if (stripos($teamName, '2ª TURMA') !== false || stripos($teamName, '2ª') !== false) {
            return '2ª TURMA';
        }
        
        // Se o nome da equipe contém "TURMA EXTRA" ou "EXTRA"
        if (stripos($teamName, 'TURMA EXTRA') !== false || stripos($teamName, 'EXTRA') !== false) {
            return 'TURMA EXTRA';
        }
        
        // Se o nome do treinamento contém "TURMA EXTRA"
        if (stripos($trainingName, 'TURMA EXTRA') !== false) {
            return 'TURMA EXTRA';
        }
        
        // Se não conseguir determinar, retorna o nome original da equipe ou "TURMA EXTRA" como padrão
        return !empty($teamName) ? $teamName : 'TURMA EXTRA';
    }
} 