<?php

namespace App\Repositories\Movements;
use App\Models\Company;
use App\Models\Evidence;
use App\Models\EvidenceParticipation;
use App\Models\TrainingParticipants;
use App\Models\TrainingParticipations;
use App\Models\TrainingProfessionals;
use App\Requests\ScheduleCompanyRequest;
use App\Services\ReferenceService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use PHPUnit\Exception;

class TrainingParticipationsRepository
{
    public function index($orderBy = null, $filterData = null, $pagesize = null)
    {
        try {
            $trainingParticipationsDB = TrainingParticipations::query()->with([
                'schedule_prevat.training', 'schedule_prevat.first_time', 'schedule_prevat.second_time', 'training',
                'location', 'room', 'workload', 'time01', 'time02', 'professionals.professional', 'participants'
            ]);

            if($orderBy){
                $trainingParticipationsDB->orderBy($orderBy['column'], $orderBy['order']);
            }

            if(isset($filterData['search']) && $filterData['search'] != null) {
                $trainingParticipationsDB->whereHas('schedule_prevat', function($query) use ($filterData) {
                    $query->whereHas('training', function ($q) use ($filterData){
                        $q->where('name', 'LIKE', '%'.$filterData['search'].'%');
                        $q->orWhere('acronym', 'LIKE', '%'.$filterData['search'].'%');
                    });

                });
            }

            if(isset($filterData['date_event']) && $filterData['date_event'] != null) {
                $trainingParticipationsDB->whereHas('schedule_prevat', function($query) use ($filterData) {

                    $query->where('date_event', $filterData['date_event']);
//                    $query->orWhere('acronym', 'LIKE', '%'.$filterData['search'].'%');

                });
            }

            if($pagesize) {
                $trainingParticipationsDB = $trainingParticipationsDB->paginate($pagesize);
            } else {
                $trainingParticipationsDB = $trainingParticipationsDB->get();
            }


            return [
                'status' => 'success',
                'data' => $trainingParticipationsDB,
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



    public function update($request, $id)
    {
        try {
            DB::beginTransaction();

            $trainingParticipationsDB = TrainingParticipations::query()->findOrFail($id);
            $trainingParticipationsDB->update($request['state']);

            DB::commit();
            return [
                'status' => 'success',
                'data' => $trainingParticipationsDB,
                'code' => 200,
                'message' => 'Treinamento do participante atualizado com sucesso !'
            ];

        }catch (\Exception $exception) {
            DB::rollback();
            return [
                'status' => 'error',
                'code' => 400,
                'message' => 'Erro ao Atualizar'
            ];
        }
    }

    public function show($id)
    {
        try {
            $trainingParticipationsDB = TrainingParticipations::query()->with(['schedule_prevat.training.technical','location', 'professionals','participants.participant' => fn($query) => $query->withoutGlobalScopes()]);
            $trainingParticipationsDB = $trainingParticipationsDB->find($id);

            return [
                'status' => 'success',
                'data' => $trainingParticipationsDB,
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

    public function delete($id = null)
    {
        try {
            DB::beginTransaction();

            $trainingParticipationsDB = TrainingParticipations::query()->findOrFail($id);

            if(Storage::exists($trainingParticipationsDB['file'])) {
                Storage::delete('public/'.$trainingParticipationsDB['file']);
            }

            $trainingParticipationsDB->delete();

            DB::commit();
            return [
                'status' => 'success',
                'data' => $trainingParticipationsDB,
                'code' => 200,
                'message' => 'Treinamento deletado com sucesso !'
            ];

        } catch (\Exception $exception) {
            return [
                'status' => 'error',
                'code' => 400,
                'message' => 'Erro ao deletar'
            ];
        }
    }

    public function getSelectScheduleCompany()
    {
        $trainingParticipationsDB = TrainingParticipations::query()->with(['schedule', 'company']);

        $trainingParticipationsDB->whereHas('company', function($query){
            $query->orderBy('name', 'ASC');
        });

        $trainingParticipationsDB = $trainingParticipationsDB->get();

        $return = [];

        foreach ($trainingParticipationsDB as $key => $itemUser) {
            $return[0]['label'] = 'Escolha';
            $return[0]['value'] = '';
            $return[$key + 1]['label'] = $itemUser['company']['name'];
            $return[$key + 1]['value'] = $itemUser['id'];
        }

        return $return;
    }

    public function getSelectSchedulePrevat($date_event = null)
    {
        $trainingParticipations = TrainingParticipations::query()->with(['schedule_prevat.training', 'workload']);
        $trainingParticipations->orderBy('created_at', 'DESC');
        $trainingParticipations = $trainingParticipations->get();

        $return = [];

        $return[0]['label'] = 'Escolha';
        $return[0]['value'] = '';

        if($trainingParticipations->count() > 0) {
            foreach ($trainingParticipations as $key => $itemSchedulePrevat) {
                $return[$key +1]['label'] = formatDate($itemSchedulePrevat['date_event']).' - '.$itemSchedulePrevat['schedule_prevat']['training']['acronym']. ' ' .$itemSchedulePrevat['schedule_prevat']['training']['name'];
                $return[$key +1]['value'] = $itemSchedulePrevat['id'];
            }
        } else {
            $return[0]['label'] = 'Sem evento para a data selecionada';
            $return[0]['value'] = '';
        }
        return $return;
    }

    public function getSelectCompabyByTraining($training_participation_id = null)
    {
        $trainingParticipantsDB = TrainingParticipants::query();

        $companies = null;

            if($training_participation_id) {
                $trainingParticipantsDB->where('training_participation_id', $training_participation_id);
                $companies = $trainingParticipantsDB->pluck('company_id');
            }

        $companyDB = Company::query();
            if($companies) {
                $companyDB->whereIn('id', $companies);
                    $companyDB = $companyDB->get();
            }

        $return = [];

        $return[0]['label'] = 'Escolha';
        $return[0]['value'] = '';

        if($companyDB->count() > 0) {
            foreach ($companyDB as $key => $itemCompany) {
                $return[0]['label'] = 'Escolha a Empresa';
                $return[0]['value'] = '';

                $return[$key +1]['label'] = $itemCompany['name'] ?? $itemCompany['fantasy_name'];
                $return[$key +1]['value'] = $itemCompany['id'];
            }
        } else {
            $return[0]['label'] = 'Sem evento para a data selecionada';
            $return[0]['value'] = '';
        }
        return $return;

    }

    public function changeStatus($data)
    {
        try {
            DB::beginTransaction();

            $trainingParticipations = TrainingParticipations::query()->findOrFail($data['id']);
            $trainingParticipations->update([
                'status' => $data['status']
            ]);

            DB::commit();
            return [
                'status' => 'success',
                'data' => $trainingParticipations,
                'code' => 200,
                'message' => 'Trainamento do participante atualizado com sucesso !'
            ];

        } catch (\Exception $exception) {

            return [
                'status' => 'error',
                'code' => 400,
                'message' => 'Erro na requisição !'
            ];
        }
    }


}
