<?php

namespace App\Repositories\Movements;

use App\Models\ProfessionalsFormation;
use App\Models\ScheduleCompanyParticipants;
use App\Models\Services;
use App\Models\TrainingCertificates;
use App\Models\TrainingParticipants;
use App\Repositories\ParticipantRepository;
use App\Repositories\ProfessionalRepository;
use App\Repositories\SchedulePrevatRepository;
use Illuminate\Support\Facades\DB;
use PHPUnit\Exception;

class TrainingParticipantsRepository
{
    public function getParticipants($participation_id = null)
    {
       try {
            $trainingParticipantsDB = TrainingParticipants::query()->with([
                'certificate',
                'training_participation',
                'participant' => fn ($query) => $query->withoutGlobalScopes(),
                'participant.role' => fn ($query) => $query->withoutGlobalScopes(),
                'participant.company'
            ]);

           if($participation_id)  {
                $trainingParticipantsDB->where('training_participation_id', $participation_id);
           }

           $trainingParticipantsDB = $trainingParticipantsDB->get();

            return [
                'status' => 'success',
                'data' => $trainingParticipantsDB,
                'code' => 200,

            ];
        }catch (Exception $exception){
            return [
                'status' => 'error',
                'code' => 400,
                'message' => 'Erro na requisição'
            ];
        }
    }

    public function create($training_participation_id, $participant_id)
    {
        $participantsRepository = new ParticipantRepository();
        $participantReturnDB = $participantsRepository->show($participant_id)['data'];

        $trainingParticipationRepository = new TrainingParticipationsRepository();
        $trainingParticipationReturnDB = $trainingParticipationRepository->show($training_participation_id)['data'];

        TrainingParticipants::query()->create([
            'training_participation_id' => $training_participation_id,
            'participant_id' => $participant_id,
            'company_id' => $participantReturnDB['company_id'],
            'quantity' => 1,
            'value' => $trainingParticipationReturnDB['schedule_prevat']['training']['value'],
            'total_value' => $trainingParticipationReturnDB['schedule_prevat']['training']['value'],
            'note' => 0,
            'status' => 'Reprovado'
        ]);

    }

    public function delete($participant_id)
    {
        try {
            DB::beginTransaction();

            $trainingParticipant = TrainingParticipants::query()->find($participant_id);
            $trainingParticipant->delete();

            DB::commit();
            return [
                'status' => 'success',
                'data' => $trainingParticipant,
                'code' => 200,
                'message' => 'Participante deletado com sucesso !'
            ];

        } catch (\Exception $exception) {
            return [
                'status' => 'error',
                'code' => 400,
                'message' => 'Erro ao deletar'
            ];
        }
    }

    public function addParticipant($schedule_prevat_id, $participant_id)
    {
        $participantsRepository = new ParticipantRepository();
        $participantReturnDB = $participantsRepository->show($participant_id)['data'];

        $schedulePrevatRepository = new SchedulePrevatRepository();
        $schedulePrevatDB = $schedulePrevatRepository->show($schedule_prevat_id)['data'];

        $participants = session()->get('participants');

        if (!$participants) {
            $participants = [
                [
                    "id" => $participantReturnDB['id'],
                    "name" => $participantReturnDB['name'],
                    "taxpayer_registration" => $participantReturnDB['taxpayer_registration'],
                    "role" => $participantReturnDB['role']['name'],
                    "company" => $participantReturnDB['company']['name'] ?? $participantReturnDB['company']['fantasy_name'],
                    "company_id" => $participantReturnDB['company_id'],
                    "contract_id" => $participantReturnDB['contract_id'],
                    "quantity" => 1,
                    "value" => $schedulePrevatDB['training']['value'],
                    "total_value" => $schedulePrevatDB['training']['value'] * 1,
                    "note" => '',
                    'presence' => 0,
                    'status' => 'Reprovado',
                    "table" => 'table-default',
                    "icon" => '',
                ]
            ];

            session()->put('participants', $participants);

            return [
                'status' => 'success',
                'code' => 200,
                'message' => 'Participante adicionado com sucesso !'
            ];
        }

        $participants[] = [
            "id" => $participantReturnDB['id'],
            "name" => $participantReturnDB['name'],
            "taxpayer_registration" => $participantReturnDB['taxpayer_registration'],
            "role" => $participantReturnDB['role']['name'],
            "company" => $participantReturnDB['company']['name'],
            "company_id" => $participantReturnDB['company_id'],
            "contract_id" => $participantReturnDB['contract_id'],
            "quantity" => 1,
            "value" => $schedulePrevatDB['training']['value'],
            "total_value" => $schedulePrevatDB['training']['value'] * 1,
            "note" => '',
            'status' => 'Reprovado',
            'presence' => 0,
            "table" => 'table-default',
            "icon" => '',
        ];

        session()->put('participants', $participants);

        return [
            'status' => 'success',
            'code' => 200,
            'message' => 'Participante adicionado com sucesso !'
        ];
    }

    public function remParticipant($participant_id)
    {
        $participants = session()->get('participants');
        foreach ($participants as $itemParticipant) {
            if($participant_id == $itemParticipant['id']) {
                unset($participants[$itemParticipant['id']]);
            }


            session()->put('participants', $participants);
        }
    }

    public function createAll($schedule_prevat_id, $training_participation_id)
    {
        try {
            $scheduleCompanyParticipantsDB = ScheduleCompanyParticipants::query()->with('schedule_company.schedule.training')->whereHas('schedule_company', function($query) use ($schedule_prevat_id) {
                $query->where('schedule_prevat_id', $schedule_prevat_id);
            })->get();

            foreach ($scheduleCompanyParticipantsDB as $itemParticipant) {

                TrainingParticipants::query()->create([
                    'training_participation_id' => $training_participation_id,
                    'participant_id' => $itemParticipant['participant_id'],
                    'quantity' => 1,
                    'value' => $itemParticipant['schedule_company']['schedule']['training']['value'],
                    'total_value' => $itemParticipant['schedule_company']['schedule']['training']['value'],
                    'table_color' => 'table-default',
                    'note' => '',
                    'status' => 'Reprovado',
                    'presence' => false
                ]);
            }
            return [
                'status' => 'success',
                'code' => 400,
                'message' => 'Participantes Adicionados com sucesso !'
            ];

        }catch (\Exception $exception) {
            return [
                'status' => 'error',
                'code' => 400,
                'message' => 'Erro na execucao'
            ];
        }
    }
    public function deleteAll($training_participation_id)
    {
        $trainingCertificatesDB = TrainingCertificates::query()->where('training_participation_id', $training_participation_id)->delete();
        $trainingParticipantsDB = TrainingParticipants::query()->where('training_participation_id', $training_participation_id)->delete();

        return [
            'status' => 'error',
            'code' => 400,
            'message' => 'Participantes Deletado com sucesso !'
        ];

    }



    public function addNote($id, $value)
    {
        $trainingParticipant = TrainingParticipants::query()->find($id);
        if($value >= 7) {
            $table = 'table-primary';
            $status = 'Aprovado';
        } else {
            $table = 'table-danger';
            $status = 'Reprovado';
        }

        $trainingParticipant->update([
            'note' => $value,
            'table_color' => $table,
            'status' => $status
        ]);
    }

    public function calculateTotalValue($id, $quantity)
    {
        $trainingParticipant = TrainingParticipants::query()->find($id);

        $trainingParticipant->update([
            'quantity' => $quantity,
            'total_value' => $quantity * $trainingParticipant['value'],
        ]);
    }


    public function validatePresence($id, $presence)
    {
        $trainingParticipant = TrainingParticipants::query()->find($id);

        $trainingParticipant->update([
            'presence' => $presence,
        ]);
    }

    public function getTrainingsByParticipant($participant_id, $pageSize = null)
    {
        $trainingParticipant = TrainingParticipants::query()->with(['training_participation.schedule_prevat.training', 'participant'])->where('participant_id', $participant_id);

        if($pageSize) {
            $trainingParticipant =  $trainingParticipant->paginate($pageSize);
        } else {
            $trainingParticipant =  $trainingParticipant->get();
        }

        return $trainingParticipant;
    }
}
