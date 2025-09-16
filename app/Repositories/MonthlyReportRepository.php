<?php

namespace App\Repositories;

use App\Models\Training;
use App\Models\ScheduleCompany;
use App\Models\SchedulePrevat;
use App\Models\Company;
use App\Models\TrainingParticipants;
use App\Models\Evidence;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class MonthlyReportRepository
{
    public function getMonthlyReportData($startDate, $endDate, $trainingId = null, $sections = [])
    {
        $data = [];

        if ($sections['trainings'] ?? false) {
            $data['trainings'] = $this->getTrainingsData($startDate, $endDate, $trainingId);
        }

        if ($sections['companies'] ?? false) {
            $data['companies'] = $this->getCompaniesData($startDate, $endDate, $trainingId);
        }

        if ($sections['extra_classes'] ?? false) {
            $data['extra_classes'] = $this->getExtraClassesData($startDate, $endDate, $trainingId);
        }

        if ($sections['cards_delivered'] ?? false) {
            $data['cards_delivered'] = $this->getCardsDeliveredData($startDate, $endDate, $trainingId);
        }

        if ($sections['improvements'] ?? false) {
            $data['improvements'] = $this->getImprovementsData($startDate, $endDate, $trainingId);
        }

        return $data;
    }

    private function getTrainingsData($startDate, $endDate, $trainingId = null)
    {
        $query = DB::table('schedule_companies')
            ->join('trainings', 'schedule_companies.training_id', '=', 'trainings.id')
            ->whereBetween('schedule_companies.date', [$startDate, $endDate])
            ->where('schedule_companies.status', 'completed');

        if ($trainingId) {
            $query->where('schedule_companies.training_id', $trainingId);
        }

        $trainings = $query->select(
                'trainings.name as training_name',
                'trainings.acronym',
                DB::raw('COUNT(schedule_companies.id) as total_schedules'),
                DB::raw('SUM(schedule_companies.vacancies) as total_vacancies'),
                DB::raw('SUM(
                    (SELECT COUNT(*) FROM schedule_company_participants scp 
                     WHERE scp.schedule_company_id = schedule_companies.id)
                ) as total_participants')
            )
            ->groupBy('trainings.id', 'trainings.name', 'trainings.acronym')
            ->orderBy('total_schedules', 'desc')
            ->get();

        // Adicionar treinamentos da agenda Prevat
        $prevatQuery = DB::table('schedule_prevat')
            ->join('trainings', 'schedule_prevat.training_id', '=', 'trainings.id')
            ->whereBetween('schedule_prevat.date', [$startDate, $endDate])
            ->where('schedule_prevat.status', 'completed');

        if ($trainingId) {
            $prevatQuery->where('schedule_prevat.training_id', $trainingId);
        }

        $prevatTrainings = $prevatQuery->select(
                'trainings.name as training_name',
                'trainings.acronym',
                DB::raw('COUNT(schedule_prevat.id) as total_schedules'),
                DB::raw('SUM(schedule_prevat.vacancies) as total_vacancies'),
                DB::raw('SUM(
                    (SELECT COUNT(*) FROM training_participants tp 
                     WHERE tp.schedule_prevat_id = schedule_prevat.id)
                ) as total_participants')
            )
            ->groupBy('trainings.id', 'trainings.name', 'trainings.acronym')
            ->orderBy('total_schedules', 'desc')
            ->get();

        // Combinar e consolidar dados
        $allTrainings = collect();
        
        foreach ($trainings as $training) {
            $allTrainings->push([
                'name' => $training->training_name,
                'acronym' => $training->acronym,
                'total_schedules' => $training->total_schedules,
                'total_vacancies' => $training->total_vacancies,
                'total_participants' => $training->total_participants,
                'type' => 'Empresa'
            ]);
        }

        foreach ($prevatTrainings as $training) {
            $existing = $allTrainings->firstWhere('name', $training->training_name);
            if ($existing) {
                $existing['total_schedules'] += $training->total_schedules;
                $existing['total_vacancies'] += $training->total_vacancies;
                $existing['total_participants'] += $training->total_participants;
            } else {
                $allTrainings->push([
                    'name' => $training->training_name,
                    'acronym' => $training->acronym,
                    'total_schedules' => $training->total_schedules,
                    'total_vacancies' => $training->total_vacancies,
                    'total_participants' => $training->total_participants,
                    'type' => 'Prevat'
                ]);
            }
        }

        return [
            'total_trainings' => $allTrainings->sum('total_schedules'),
            'total_participants' => $allTrainings->sum('total_participants'),
            'total_vacancies' => $allTrainings->sum('total_vacancies'),
            'trainings' => $allTrainings->sortByDesc('total_schedules')->values()
        ];
    }

    private function getCompaniesData($startDate, $endDate, $trainingId = null)
    {
        $query = DB::table('schedule_companies')
            ->join('companies', 'schedule_companies.company_id', '=', 'companies.id')
            ->whereBetween('schedule_companies.date', [$startDate, $endDate])
            ->where('schedule_companies.status', 'completed');

        if ($trainingId) {
            $query->where('schedule_companies.training_id', $trainingId);
        }

        $companies = $query->select(
                'companies.name as company_name',
                'companies.fantasy_name',
                DB::raw('COUNT(DISTINCT schedule_companies.id) as total_schedules'),
                DB::raw('COUNT(DISTINCT schedule_companies.training_id) as total_trainings'),
                DB::raw('SUM(
                    (SELECT COUNT(*) FROM schedule_company_participants scp 
                     WHERE scp.schedule_company_id = schedule_companies.id)
                ) as total_participants')
            )
            ->groupBy('companies.id', 'companies.name', 'companies.fantasy_name')
            ->orderBy('total_schedules', 'desc')
            ->get();

        return [
            'total_companies' => $companies->count(),
            'total_schedules' => $companies->sum('total_schedules'),
            'total_participants' => $companies->sum('total_participants'),
            'companies' => $companies
        ];
    }

    private function getExtraClassesData($startDate, $endDate, $trainingId = null)
    {
        $query = DB::table('schedule_companies')
            ->whereBetween('date', [$startDate, $endDate])
            ->where('status', 'completed')
            ->where('is_extra', true);

        if ($trainingId) {
            $query->where('training_id', $trainingId);
        }

        $extraClasses = $query->select(
                DB::raw('COUNT(*) as total_extra_classes'),
                DB::raw('SUM(vacancies) as total_vacancies'),
                DB::raw('SUM(
                    (SELECT COUNT(*) FROM schedule_company_participants scp 
                     WHERE scp.schedule_company_id = schedule_companies.id)
                ) as total_participants')
            )
            ->first();

        return [
            'total_extra_classes' => $extraClasses->total_extra_classes ?? 0,
            'total_vacancies' => $extraClasses->total_vacancies ?? 0,
            'total_participants' => $extraClasses->total_participants ?? 0
        ];
    }

    private function getCardsDeliveredData($startDate, $endDate, $trainingId = null)
    {
        $query = DB::table('training_certificates')
            ->join('training_participants', 'training_certificates.training_participant_id', '=', 'training_participants.id')
            ->join('schedule_companies', 'training_participants.schedule_company_id', '=', 'schedule_companies.id')
            ->whereBetween('training_certificates.created_at', [$startDate, $endDate])
            ->where('training_certificates.status', 'delivered');

        if ($trainingId) {
            $query->where('schedule_companies.training_id', $trainingId);
        }

        $cards = $query->select(
                DB::raw('COUNT(*) as total_cards_delivered'),
                DB::raw('COUNT(DISTINCT training_participants.participant_id) as unique_participants')
            )
            ->first();

        return [
            'total_cards_delivered' => $cards->total_cards_delivered ?? 0,
            'unique_participants' => $cards->unique_participants ?? 0
        ];
    }

    private function getImprovementsData($startDate, $endDate, $trainingId = null)
    {
        // Esta é uma implementação de exemplo - você pode adaptar conforme sua estrutura de dados
        $query = DB::table('evidence')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->where('type', 'improvement');

        if ($trainingId) {
            $query->where('training_id', $trainingId);
        }

        $improvements = $query->select(
                DB::raw('COUNT(*) as total_improvements'),
                DB::raw('COUNT(DISTINCT company_id) as companies_with_improvements')
            )
            ->first();

        return [
            'total_improvements' => $improvements->total_improvements ?? 0,
            'companies_with_improvements' => $improvements->companies_with_improvements ?? 0,
            'improvements_by_type' => $this->getImprovementsByType($startDate, $endDate, $trainingId)
        ];
    }

    private function getImprovementsByType($startDate, $endDate, $trainingId = null)
    {
        $query = DB::table('evidence')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->where('type', 'improvement');

        if ($trainingId) {
            $query->where('training_id', $trainingId);
        }

        return $query->select(
                'category',
                DB::raw('COUNT(*) as count')
            )
            ->groupBy('category')
            ->orderBy('count', 'desc')
            ->get();
    }
}
