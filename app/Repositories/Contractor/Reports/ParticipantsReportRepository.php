<?php

namespace App\Repositories\Contractor\Reports;

use App\Jobs\ExportTrainingParticipantsJob;
use App\Models\TrainingParticipants;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Bus;
use PHPUnit\Exception;

class ParticipantsReportRepository
{
    public function index($orderBy = null, $filterData = null, $pageSize = null)
    {
        try {
            $trainingParticipantsDB = TrainingParticipants::query()->with([
                'training_participation.schedule_prevat.training' ,
                'participant' => fn ($query) => $query->withoutGlobalScopes(),
                'participant.contract' => fn ($query) => $query->withoutGlobalScopes(),
                'participant.role' => fn ($query) => $query->withoutGlobalScopes(),
                'contract' => fn ($query) => $query->withoutGlobalScopes(),
            ]);

            $trainingParticipantsDB->whereHas('contract', function($query) {
                $query->withoutGlobalScopes()->where('contractor_id', Auth::user()->company->id);
            });

            if(isset($filterData['search']) && $filterData['search'] != null) {
                $trainingParticipantsDB->whereHas('participant', function($query) use ($filterData){
                    $query->withoutGlobalScopes()->where('name', 'LIKE', '%'.$filterData['search'].'%');
                    $query->withoutGlobalScopes()->orWhere('taxpayer_registration', 'LIKE', '%'.$filterData['search'].'%');
                });

                $trainingParticipantsDB->orWhereHas('training_participation.schedule_prevat.training', function ($query) use ($filterData){
                    $query->where('name', 'LIKE', '%'.$filterData['search'].'%');
                }) ;

                $trainingParticipantsDB->whereHas('contract', function($query) {
                    $query->withoutGlobalScopes()->where('contractor_id', Auth::user()->company->id);
                });
            }

            if(isset($filterData['presence']) && $filterData['presence'] != null) {
                $trainingParticipantsDB->where('presence', $filterData['presence']);
            }

            if(isset($filterData['dates']) && $filterData['dates'] != null) {
                $trainingParticipantsDB->whereHas('training_participation.schedule_prevat', function($query) use ($filterData){
                    $dates = explode(' to ', $filterData['dates']);
                    if(isset($dates[1])) {
                        $query->whereBetween('date_event', [$dates[0], $dates[1]]);
                    } else {
                        $query->where('date_event', '=', $dates[0]);
                    }
                });
            }

            if($orderBy) {
                $trainingParticipantsDB->orderBy($orderBy['column'], $orderBy['order']);
            }

            if($pageSize) {
                $trainingParticipantsDB = $trainingParticipantsDB->paginate($pageSize);
            } else {
                $trainingParticipantsDB = $trainingParticipantsDB->get();
            }

            return [
                'status' => 'success',
                'data' => $trainingParticipantsDB,
                'code' => 200,

            ];
        } catch (Exception $exception){
            return [
                'status' => 'error',
                'code' => 400,
                'message' => 'Erro na requisição'
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
