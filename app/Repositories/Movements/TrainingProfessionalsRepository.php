<?php

namespace App\Repositories\Movements;

use App\Models\Professional;
use App\Models\ProfessionalsFormation;
use App\Models\TrainingParticipants;
use App\Models\TrainingProfessionals;
use App\Repositories\ParticipantRepository;
use App\Repositories\ProfessionalRepository;
use Illuminate\Support\Facades\DB;
use PHPUnit\Exception;

class TrainingProfessionalsRepository
{
    public function getProfessionals($participation_id = null)
    {
        try {
            $trainingProfessionalsDB = TrainingProfessionals::query()->with([
                'professional', 'formation'
            ]);

            if($participation_id)  {
                $trainingProfessionalsDB->where('training_participation_id', $participation_id);
            }

            $trainingProfessionalsDB = $trainingProfessionalsDB->get();

            return [
                'status' => 'success',
                'data' => $trainingProfessionalsDB,
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

    public function create($training_participation_id, $request)
    {

        TrainingProfessionals::query()->create([
            'training_participation_id' => $training_participation_id,
            'professional_id' => $request['professional_id'],
            "professional_formation_id" => $request['professional_formation_id'],
            "front" => $request['front'],
            "verse" => $request['verse']
        ]);

        $trainintCertificationsRepository = new TrainingCertificationsRepository();
        $trainintCertificationsRepository->generateProgrammaticPDF($training_participation_id);
    }

    public function update($professional_id, $request)
    {
        try {
            DB::beginTransaction();

            $trainingProfessionalsDB = TrainingProfessionals::query()->with('training_participation')->find($professional_id);

            $trainingProfessionalsDB->update($request);
            $trainingProfessionalDB = $trainingProfessionalsDB->fresh();

            $trainintCertificationsRepository = new TrainingCertificationsRepository();
            $trainintCertificationsRepository->generateProgrammaticPDF($trainingProfessionalsDB['training_participation']['id']);

            DB::commit();
            return [
                'status' => 'success',
                'data' => $trainingProfessionalDB,
                'code' => 200,
                'message' => 'Profissional atualizado com sucesso !'
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
    public function addProfessional($request)
    {
        $professionalRepository = new ProfessionalRepository();
        $professionalReturnDB = $professionalRepository->show($request['professional_id'])['data'];


        $professionalFormationDB = ProfessionalsFormation::query()->with('qualification')->where('professional_id', $request['professional_id'])->where('qualification_id', $request['professional_formation_id'])->first();

        $professionals = session()->get('professionals');

        if (!$professionals) {
            $professionals = [
                [
                    "id" => $professionalReturnDB['id'],
                    "professional_formation_id" => $professionalFormationDB['qualification_id'],
                    "name" => $professionalReturnDB['name'],
                    "phone" => $professionalReturnDB['phone'],
                    "email" => $professionalReturnDB['email'],
                    "document" => $professionalReturnDB['document'],
                    "registry" => $professionalReturnDB['registry'],
                    "qualification" => $professionalFormationDB['qualification']['name'],
                    'front' => $request['front'] ?? false,
                    'verse' => $request['verse'] ?? false,
                ]
            ];

            session()->put('professionals', $professionals);

            return [
                'status' => 'success',
                'code' => 200,
                'message' => 'Profissional adicionado com sucesso !'
            ];
        }

        $professionals[] = [
            "id" => $professionalReturnDB['id'],
            "professional_formation_id" => $professionalFormationDB['qualification_id'],
            "name" => $professionalReturnDB['name'],
            "phone" => $professionalReturnDB['phone'],
            "email" => $professionalReturnDB['email'],
            "document" => $professionalReturnDB['document'],
            "registry" => $professionalReturnDB['registry'],
            "qualification" => $professionalFormationDB['qualification']['name'],
            'front' => $request['front'] ?? false,
            'verse' => $request['verse'] ?? false,
        ];

        session()->put('professionals', $professionals);

        return [
            'status' => 'success',
            'code' => 200,
            'message' => 'Profissional adicionado com sucesso !'
        ];
    }

    public function show($id)
    {
        try {
            $trainingProfessionalDB = TrainingProfessionals::query()->find($id);

            return [
                'status' => 'success',
                'data' => $trainingProfessionalDB,
                'code' => 200,

            ];
        } catch (Exception $exception) {
            return [
                'status' => 'error',
                'code' => 400,
                'message' => 'Erro na requisição'
            ];
        }
    }

    public function delete($professional_id)
    {
        try {
            DB::beginTransaction();

            $trainingProfessionalsDB = TrainingProfessionals::query()->with('training_participation')->find($professional_id);
            $trainingProfessionalsDB->delete();


            $trainintCertificationsRepository = new TrainingCertificationsRepository();
            $trainintCertificationsRepository->generateProgrammaticPDF($trainingProfessionalsDB['training_participation']['id']);

            DB::commit();
            return [
                'status' => 'success',
                'data' => $trainingProfessionalsDB,
                'code' => 200,
                'message' => 'Profissional deletado com sucesso !'
            ];

        } catch (\Exception $exception) {
            return [
                'status' => 'error',
                'code' => 400,
                'message' => 'Erro ao deletar'
            ];
        }
    }

}
