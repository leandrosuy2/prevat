<?php

namespace App\Repositories;

use App\Models\TrainingParticipantsHistoric;
use PHPUnit\Exception;

class TrainingParticipantsHistoricRepository
{

    public function index($orderBy ,$filterData = null, $pageSize)
    {
        try {
            $trainingParticipantsHistory = TrainingParticipantsHistoric::query()->orderBy($orderBy['column'], $orderBy['order']);

            if(isset($filterData['search']) && $filterData['search'] != null) {
                $trainingParticipantsHistory->where('name', 'LIKE', '%'.$filterData['search'].'%');
                $trainingParticipantsHistory->orWhere('taxpayer_registration', 'LIKE', '%'.$filterData['search'].'%');
                $trainingParticipantsHistory->orWhere('company_name', 'LIKE', '%'.$filterData['search'].'%');
                $trainingParticipantsHistory->orWhere('training_name', 'LIKE', '%'.$filterData['search'].'%');
                $trainingParticipantsHistory->orWhere('registry', 'LIKE', '%'.$filterData['search'].'%');
            }

            if(isset($filterData['date_start']) && $filterData['date_start'] != null) {
                $trainingParticipantsHistory->whereDate('date', '>=', $filterData['date_start']);
            }

            if(isset($filterData['date_end']) && $filterData['date_end'] != null) {
                $trainingParticipantsHistory->whereDate( 'date', '<=', $filterData['date_end']);
            }

            if($pageSize) {
                $trainingParticipantsHistory = $trainingParticipantsHistory->paginate($pageSize);
            } else {
                $trainingParticipantsHistory = $trainingParticipantsHistory->get();
            }


            return [
                'status' => 'success',
                'data' => $trainingParticipantsHistory,
                'code' => 200
            ];

        } catch (Exception $exception) {
            return [
                'status' => 'error',
                'code' => 400,
                'message' => 'Erro ao Indexar'
            ];
        }
    }
}
