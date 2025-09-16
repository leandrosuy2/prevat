<?php

namespace App\Repositories\Reports;

use App\Jobs\ExportTrainingParticipantsJob;
use App\Models\TrainingParticipants;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use PHPUnit\Exception;
use Illuminate\Bus\Batch;
use Illuminate\Support\Facades\Bus;

class ParticipantTrainingsReport
{
    public function index($orderBy = null, $filterData = null, $pageSize = null)
    {
        try {
            $trainingParticipantsDB = TrainingParticipants::query()
                ->select('training_participants.*')
                ->join('training_participations', 'training_participants.training_participation_id', '=', 'training_participations.id')
                ->join('schedule_prevats', 'training_participations.schedule_prevat_id', '=', 'schedule_prevats.id')
                ->join('trainings', 'schedule_prevats.training_id', '=', 'trainings.id')
                ->with([
                    'company' => fn ($query) => $query->withoutGlobalScopes(),
                    'training_participation.schedule_prevat.training' => fn ($query) => $query->withoutGlobalScopes(),
                    'participant' => fn ($query) => $query->withoutGlobalScopes(),
                    'participant.company' => fn ($query) => $query->withoutGlobalScopes(),
                    'participant.contract' => fn ($query) => $query->withoutGlobalScopes(),
                    'participant.role' => fn ($query) => $query->withoutGlobalScopes(),
                    'contract' => fn ($query) => $query->withoutGlobalScopes(),
                ])
                ->withoutGlobalScopes();

            if(isset($filterData['search']) && $filterData['search'] != null) {
                $trainingParticipantsDB->whereHas('participant', function($query) use ($filterData){
                    $query->withoutGlobalScopes()
                        ->where(function($q) use ($filterData) {
                            $q->where('name', 'LIKE', '%'.$filterData['search'].'%')
                              ->orWhere('taxpayer_registration', 'LIKE', '%'.$filterData['search'].'%');
                        });
                });
            }

            if(isset($filterData['company']) && $filterData['company'] != null) {
                $trainingParticipantsDB->whereHas('company', function ($query) use ($filterData) {
                    $query->withoutGlobalScopes()
                        ->where(function($q) use ($filterData) {
                            $q->where('name', 'LIKE', '%'.$filterData['company'].'%')
                              ->orWhere('fantasy_name', 'LIKE', '%'.$filterData['company'].'%');
                        });
                });
            }

            if(isset($filterData['training']) && $filterData['training'] != null) {
                $searchTerm = $filterData['training'];
                
                // Quebra o termo de busca em palavras-chave
                $keywords = preg_split('/[\s\-]+/', trim($searchTerm));
                
                $trainingParticipantsDB->where(function($query) use ($keywords) {
                    foreach ($keywords as $word) {
                        if (!empty($word)) {
                            $query->where('trainings.name', 'LIKE', '%' . $word . '%');
                        }
                    }
                });
            }

            if(isset($filterData['presence']) && $filterData['presence'] != null) {
                $trainingParticipantsDB->where('training_participants.presence', $filterData['presence']);
            }

            if(isset($filterData['dates']) && $filterData['dates'] != null) {
                $dates = explode(' to ', $filterData['dates']);
                if(isset($dates[1])) {
                    $trainingParticipantsDB->whereBetween('schedule_prevats.date_event', [$dates[0], $dates[1]]);
                } else {
                    $trainingParticipantsDB->where('schedule_prevats.date_event', '=', $dates[0]);
                }
            }

            if($orderBy) {
                $trainingParticipantsDB->orderBy($orderBy['column'], $orderBy['order']);
            }

            // Log para debug
            \Log::info('SQL Query: ' . $trainingParticipantsDB->toSql());
            \Log::info('SQL Bindings: ', $trainingParticipantsDB->getBindings());

            if($pageSize) {
                $trainingParticipantsDB = $trainingParticipantsDB->paginate($pageSize);
            } else {
                $trainingParticipantsDB = $trainingParticipantsDB->get();
            }

            // Log para debug
            \Log::info('Total Results: ' . ($pageSize ? $trainingParticipantsDB->total() : $trainingParticipantsDB->count()));

            return [
                'status' => 'success',
                'data' => $trainingParticipantsDB,
                'code' => 200,
            ];
        } catch (Exception $exception){
            \Log::error('Error in ParticipantTrainingsReport: ' . $exception->getMessage());
            \Log::error($exception->getTraceAsString());
            return [
                'status' => 'error',
                'code' => 400,
                'message' => 'Erro na requisição: ' . $exception->getMessage()
            ];
        }
    }

    public function exportExcel($orderBy = null, $filterData = null)
    {
        try{

            sleep(1);

            $batch = Bus::batch([
                new ExportTrainingParticipantsJob($orderBy, $filterData),
            ])->dispatch();

            return [
                'status' => 'success',
                'data' => $batch,
                'code' => 200,
                'message' => 'Exportação feita com sucesso !'
            ];

        } catch (Exception $exception) {
            return [
                'status' => 'error',
                'code' => 400,
                'message' => 'Erro ao exportar'
            ];
        }
    }

    public function exportPDF($orderBy = null, $filterData = null)
    {
        try{

            sleep(2);

            $batch = Bus::batch([
                new ExportTrainingParticipantsJob($orderBy, $filterData),
            ])->dispatch();

            return [
                'status' => 'success',
                'data' => $batch,
                'code' => 200,
                'message' => 'Exportação feita com sucesso !'
            ];

        } catch (Exception $exception) {
            return [
                'status' => 'error',
                'code' => 400,
                'message' => 'Erro ao exportar'
            ];
        }
    }
}
