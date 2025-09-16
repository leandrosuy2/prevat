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
        $sections = $request->get('sections', ['trainings', 'companies', 'extra_classes']);
        $format = $request->get('format', 'pdf');

        $dates = $start . ' to ' . $end;

        $data = [
            'start' => $start,
            'end' => $end,
            'training_filter' => null,
        ];

        // Treinamentos ministrados
        if (in_array('trainings', $sections)) {
            $trainingReport = new TrainingReport();
            $trainings = $trainingReport->index(null, ['dates' => $dates], null)['data'];
            
            // Filtrar por treinamento específico se selecionado
            if ($trainingId) {
                $trainings = $trainings->filter(function($item) use ($trainingId) {
                    return optional($item->schedule->training)->id == $trainingId;
                });
                $data['training_filter'] = \App\Models\Training::find($trainingId);
            }
            
            $data['trainings'] = $trainings;
        }

        // Empresas atendidas (empresas com agendamento no período)
        if (in_array('companies', $sections)) {
            $companies = \App\Models\ScheduleCompany::withoutGlobalScopes()
                ->whereHas('schedule', function($query) use ($start, $end) {
                    $query->where('status', 'Concluído')
                          ->whereBetween('date_event', [$start, $end]);
                })
                ->with('company')
                ->get()
                ->pluck('company')
                ->unique('id');
            
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
            }
            
            $data['companies'] = $companies;
        }

        // Turmas extras (type = 'Fechado')
        if (in_array('extra_classes', $sections)) {
            $schedulePrevatRepo = new SchedulePrevatRepository();
            $orderBy = ['column' => 'date_event', 'order' => 'DESC'];
            $turmasExtras = collect($schedulePrevatRepo->index($orderBy, null, null)['data'] ?? [])
                ->filter(function($item) use ($start, $end, $trainingId) {
                    $dateMatch = $item->date_event >= $start && $item->date_event <= $end;
                    $typeMatch = $item->type === 'Fechado';
                    $trainingMatch = !$trainingId || optional($item->training)->id == $trainingId;
                    return $dateMatch && $typeMatch && $trainingMatch;
                });
            $data['turmasExtras'] = $turmasExtras;
        }

        $filename = 'dashboard_export_' . Carbon::parse($start)->format('Y_m_d') . '_to_' . Carbon::parse($end)->format('Y_m_d');

        if ($format === 'excel') {
            return Excel::download(new DashboardExport($data), $filename . '.xlsx');
        } else {
            $pdf = Pdf::loadView('admin.pdf.dashboard_export', $data);
            $pdf->setPaper('a4', 'landscape');
            return $pdf->download($filename . '.pdf');
        }
    }
} 