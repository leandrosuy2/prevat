<?php

namespace App\Repositories;

use App\Models\ScheduleCompany;
use App\Models\ScheduleCompanyParticipants;
use App\Models\SchedulePrevat;
use App\Models\TrainingParticipants;
use App\Models\TrainingParticipations;
use App\Models\TrainingProfessionals;
use App\Repositories\Movements\TrainingCertificationsRepository;
use App\Services\ReferenceService;
use Illuminate\Support\Facades\DB;
use PHPUnit\Exception;

class CreatePrivateRepository
{
    public function create($request, $professionals, $participants)
    {
        try {
            DB::beginTransaction();

            if($professionals == null) {
                return [
                    'status' => 'error',
                    'code' => 400,
                    'message' => 'Por favor selecione o profissional que lecionou o treinamento.'
                ];
            }

            if($participants == null) {
                return [
                    'status' => 'error',
                    'code' => 400,
                    'message' => 'Você precisa cadastrar pelo menos 1 participante do treinamento para efetuar o cadastro.'
                ];
            }

            $schedulePrevatDB = $this->createSchedulePrevat($request);
            $this->createScheduleCompany($schedulePrevatDB['id'], $request['company_id'], $request['contract_id'], $participants);

            $request['schedule_prevat_id'] = $schedulePrevatDB['id'];
            $trainingParticipationDB = TrainingParticipations::query()->create($request);

            foreach($professionals as $itemProfessional) {
                TrainingProfessionals::query()->create([
                    'training_participation_id' => $trainingParticipationDB['id'],
                    'professional_id' => $itemProfessional['id'],
                    'professional_formation_id' => $itemProfessional['professional_formation_id'],
                    'front' => $itemProfessional['front'],
                    'verse' => $itemProfessional['verse']
                ]);
            }

            foreach($participants as $participant) {
                TrainingParticipants::query()->create([
                    'training_participation_id' => $trainingParticipationDB['id'],
                    'participant_id' => $participant['id'],
                    'company_id' => $participant['company_id'],
                    'contract_id' => $participant['contract_id'],
                    'quantity' => $participant['quantity'],
                    'value' => $participant['value'],
                    'total_value' => $participant['total_value'],
                    'table_color' => $participant['table'],
                    'note' => $participant['note'],
                    'status' => $participant['status'],
                    'presence' => $participant['presence'] ?? true
                ]);
            }

            $trainingCertificationRepository = new TrainingCertificationsRepository();
            $trainingCertificationRepository->create($trainingParticipationDB['id']);

            session()->forget('participants');

            DB::commit();
            return [
                'status' => 'success',
                'data' => $trainingParticipationDB,
                'code' => 200,
                'message' => 'Participação cadastrada com sucesso !'
            ];

        } catch (Exception $exception){
            DB::rollback();
            return [
                'status' => 'error',
                'data' => $exception,
                'code' => 400,
                'message' => 'Erro ao Cadastrar'
            ];
        }
    }

    public function createSchedulePrevat($request)
    {
        $refereceService = new ReferenceService();
        $reference = $refereceService->getReference();

        $schedulePrevatDB = SchedulePrevat::query()->create([
            'reference' => $reference,
            'training_id' => $request['training_id'],
            'workload_id' => $request['workload_id'],
            'training_room_id' => $request['training_room_id'],
            'training_local_id' => $request['training_local_id'],
            'time01_id' => $request['time01_id'],
            'time02_id' => $request['time02_id'] ?? null,
            'date_event' => $request['date_event'],
            'start_event' => $request['start_event'],
            'end_event' => $request['end_event'],
            'vacancies' => $request['vacancies'],
            'vacancies_available' => $request['vacancies'],
            'status' => 'Em Aberto',
            'type' => 'Fechado'
        ]);

        return $schedulePrevatDB;
    }
    public function createScheduleCompany($schedule_prevat_id, $company_id, $contract_id, $participants)
    {
        $refereceService = new ReferenceService();
        $reference = $refereceService->getReference();

        $scheduleCompanyDB = ScheduleCompany::query()->create([
            'reference' => $reference,
            'schedule_prevat_id' => $schedule_prevat_id,
            'company_id' => $company_id,
            'contract_id' => $contract_id,
            'total_participants' => 0
        ]);

        foreach ($participants as $itemParticipant) {
            ScheduleCompanyParticipants::query()->create([
                'schedule_company_id' => $scheduleCompanyDB['id'],
                'participant_id' => $itemParticipant['id'],
            ]);
        }

        $schedule = ScheduleCompany::query()->with('participants')->withoutGlobalScopes()->find($scheduleCompanyDB['id']);

        $schedule->update([
            'total_participants' => $schedule['participants']->count()
        ]);

        $schedulePrevatRepository = new SchedulePrevatRepository();
        $schedulePrevatRepository->decrementVacany($schedule['schedule_prevat_id'], $schedule['total_participants']);

        $participantRepository = new ParticipantRepository();
        $participantRepository->generateListPDF($schedule['id']);
    }

    public function addParticipant($training_id, $participant_id)
    {
        $participantsRepository = new ParticipantRepository();
        $participantReturnDB = $participantsRepository->show($participant_id)['data'];

        $trainingRepository = new TrainingRepository();
        $trainingReturnDB = $trainingRepository->show($training_id)['data'];

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
                    "value" => $trainingReturnDB['value'],
                    "total_value" => $trainingReturnDB['value'] * 1,
                    "note" => '',
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
            "value" => $trainingReturnDB['value'],
            "total_value" => $trainingReturnDB['value'] * 1,
            "note" => '',
            'status' => 'Reprovado',
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
}
