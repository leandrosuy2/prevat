<?php

namespace App\Repositories;

use App\Models\Company;
use App\Models\Participant;
use App\Models\ParticipantRole;
use App\Models\ScheduleCompany;
use App\Models\ScheduleCompanyParticipants;
use App\Models\SchedulePrevat;
use App\Models\TrainingCertificates;
use App\Models\TrainingParticipations;
use App\Requests\ParticipantRequest;
use App\Requests\ParticipantRoleRequest;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use PHPUnit\Exception;

class ParticipantRepository
{
    public function index($orderBy = null, $filterData = null, $pageSize = null)
    {
        try {
            $participantDB = Participant::query()->with(['company', 'contract', 'role']);

            if(Auth::user()->company->type == 'admin'){
                $participantDB->withoutGlobalScopes();
            }

            if(isset($filterData['search']) && $filterData['search'] != null) {
                $participantDB->where('name', 'LIKE', '%'.$filterData['search'].'%');
                $participantDB->orWhere('taxpayer_registration', 'LIKE', '%'.$filterData['search'].'%');
            }
            if(isset($filterData['company_id']) && $filterData['company_id'] != null) {
                $participantDB->where('company_id', $filterData['company_id']);
            }

            if(isset($filterData['participant_role_id']) && $filterData['participant_role_id'] != null) {
                $participantDB->where('participant_role_id', $filterData['participant_role_id']);
            }

            if(isset($filterData['status']) && $filterData['status'] != null) {
                $participantDB->where('status', $filterData['status']);
            }


            if($orderBy) {
                $participantDB->orderBy($orderBy['column'], $orderBy['order']);
            }

            if($pageSize) {
                $participantDB = $participantDB->paginate($pageSize);
            } else {
                $participantDB = $participantDB->get();
            }


            return [
                'status' => 'success',
                'data' => $participantDB,
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

    public function create($request)
    {
        $participantRequest = new ParticipantRequest();
        $requestValidated = $participantRequest->validate($request);

        try {
            DB::beginTransaction();

            // Handle base64 signature if present
            if (!empty($request['signature'])) {
                Storage::disk('public')->makeDirectory('signatures');
                $path = 'signatures/participant_' . uniqid() . '.png';
                $base64 = $request['signature'];
                $image = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64));
                Storage::disk('public')->put($path, $image);
                $requestValidated['signature_image'] = $path;
            }

            $participantDB = Participant::query()->create($requestValidated);

            DB::commit();
            return [
                'status' => 'success',
                'data' => $participantDB,
                'code' => 200,
                'message' => 'Participante cadastrado com sucesso !'
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
        $participantRequest = new ParticipantRequest();
        $requestValidated = $participantRequest->validate($request, $id);

        try {
            DB::beginTransaction();

            $participantDB = Participant::query();

            if(Auth::user()->company->type == 'admin') {
                $participantDB->withoutGlobalScopes();
            }
            $model = $participantDB->findOrFail($id);

            // Handle base64 signature if present
            if (!empty($request['signature'])) {
                Storage::disk('public')->makeDirectory('signatures');
                $path = 'signatures/participant_' . uniqid() . '.png';
                $base64 = $request['signature'];
                $image = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64));
                Storage::disk('public')->put($path, $image);
                $requestValidated['signature_image'] = $path;
            }

            $model->update($requestValidated);

            DB::commit();
            return [
                'status' => 'success',
                'data' => $model,
                'code' => 200,
                'message' => 'Participante atualizado com sucesso !'
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
            $participantDB = Participant::query()->with(['company', 'contract']);

            if(Auth::user()->company->type == 'admin') {
                $participantDB->withoutGlobalScopes();
            }
            $participantDB = $participantDB->find($id);

            return [
                'status' => 'success',
                'data' => $participantDB,
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

            $participantDB = Participant::query()->findOrFail($id);
            $participantDB->delete();

            DB::commit();
            return [
                'status' => 'success',
                'data' => $participantDB,
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

    public function getSelectParticipant()
    {
        $participantDB = Participant::query()->whereStatus('Ativo');

        if(Auth::user()->company->type == 'admin'){
            $participantDB->withoutGlobalScopes();
        }
        $participantDB->orderBy('name', 'ASC');
        $participantDB = $participantDB->get();

//        dd($participantDB);

        $return = [];

        foreach ($participantDB as $key => $itemParticipant) {
            $return[0]['label'] = 'Escolha';
            $return[0]['value'] = '';
            $return[$key + 1]['label'] = $itemParticipant['name'];
            $return[$key + 1]['value'] = $itemParticipant['id'];
        }

        return $return;
    }

    public function getParticipantActive($company_id = null, $contract_id = null,  $participants = null, $filterData = null)
    {
        $participantDB = Participant::query()->whereStatus('Ativo');

        if(Auth::user()->company->type == 'admin'){
            $participantDB->withoutGlobalScopes();
        }

        if($participants) {
            $participantDB->whereNotin('id', $participants);
        }

        if($contract_id) {
            $participantDB->where('contract_id', $contract_id);
        }

        if($company_id) {
            $participantDB->where('company_id', $company_id);
        }

        if($filterData) {
            $participantDB->where('name', 'like', '%'.$filterData.'%');
            $participantDB->orWhere('identity_registration', 'like', '%'.$filterData.'%');
            $participantDB->orWhere('taxpayer_registration', 'like', '%'.$filterData.'%');
            $participantDB->orWhere('driving_license', 'like', '%'.$filterData.'%');
        }

        $participantDB->orderBy('name', 'ASC');
        $participantDB = $participantDB->get();

        return $participantDB;
    }

    public function getSelectedsParticipants($participants)
    {
        $participantDB = Participant::query()->whereStatus('Ativo');

        $participantDB->whereIn('id', $participants);

        if(Auth::user()->company->type == 'admin'){
            $participantDB->withoutGlobalScopes();
        }
        $participantDB->orderBy('name', 'ASC');

        $participantDB = $participantDB->get();

        return $participantDB;

    }

    public function generateListPDF($shedule_company_id)
    {
        $scheduleCompanyDB = ScheduleCompany::query()->with(['schedule.training', 'schedule.workload'])->withoutGlobalScopes()->findOrFail($shedule_company_id);

        $scheduleCompanyParticpantsDB = ScheduleCompanyParticipants::query()->with([
            'participant' => fn ($query) => $query->withoutGlobalScopes(),
            'participant.company' => fn ($query) => $query->orderBy('name', 'asc')->withoutGlobalScopes(),
            'participant.company.contract_default' => fn ($query) => $query->orderBy('name', 'asc')->withoutGlobalScopes(),
            'participant.role' => fn ($query) => $query->withoutGlobalScopes()
        ]);
        $scheduleCompanyParticpantsDB->whereHas('schedule_company', function($query) use ($scheduleCompanyDB){
            $query->withoutGlobalScopes()->where('schedule_prevat_id', $scheduleCompanyDB['schedule_prevat_id']);
        });

        $scheduleCompanyParticpantsDB = $scheduleCompanyParticpantsDB->get()->sortBy('participant.company.fantasy_name');

        $data = ['training' => $scheduleCompanyDB, 'participants' => $scheduleCompanyParticpantsDB];

        $pdf = Pdf::loadView('admin.pdf.list_participants', $data)->setPaper('a4', 'landscape');

        // Create directory path
        $directory = 'lista-participantes/' . $scheduleCompanyDB['schedule_prevat_id'];
        $fullDirectory = storage_path('app/public/' . $directory);
        
        // Create directory if it doesn't exist
        if (!file_exists($fullDirectory)) {
            mkdir($fullDirectory, 0755, true);
        }

        // Generate safe filename
        $filename = 'lista_' . preg_replace('/[^a-zA-Z0-9_]/', '_', $scheduleCompanyDB['schedule']['training']['name']) . '.pdf';
        $path = $directory . '/' . $filename;
        $fullPath = storage_path('app/public/' . $path);

        // Delete existing file if it exists
        if (file_exists($fullPath)) {
            unlink($fullPath);
        }

        // Save the PDF
        $pdf->save($fullPath);

        // Update the database with the relative path
        $scheduleCompanyDB['schedule']->update(['file_presence' => $path]);
    }

    public function refreshListPDF($schedule_prevat_id)
    {
        $scheduleCompanyDB = ScheduleCompany::query()->with(['schedule.training', 'schedule.workload'])->where('schedule_prevat_id', $schedule_prevat_id)->withoutGlobalScopes()->first();

        $scheduleCompanyParticpantsDB = ScheduleCompanyParticipants::query()->with([
            'participant' => fn ($query) => $query->withoutGlobalScopes(),
            'participant.company' => fn ($query) => $query->orderBy('name', 'asc')->withoutGlobalScopes(),
            'participant.company.contract_default' => fn ($query) => $query->orderBy('name', 'asc')->withoutGlobalScopes(),
            'participant.role' => fn ($query) => $query->withoutGlobalScopes()
        ])->where('presence', 1);

        if($scheduleCompanyDB) {
            $scheduleCompanyParticpantsDB->whereHas('schedule_company', function($query) use ($scheduleCompanyDB){
                $query->withoutGlobalScopes()->where('schedule_prevat_id', $scheduleCompanyDB['schedule_prevat_id']);
            });

            $scheduleCompanyParticpantsDB = $scheduleCompanyParticpantsDB->get()->sortBy('participant.company.fantasy_name');

            $data = ['training' => $scheduleCompanyDB, 'participants' => $scheduleCompanyParticpantsDB];

            $pdf = Pdf::loadView('admin.pdf.list_participants', $data)->setPaper('a4', 'landscape');

            Storage::disk('public')->makeDirectory('lista-participantes/'.$scheduleCompanyDB['schedule_prevat_id']);

            $path = 'app/public/lista-participantes/'.$scheduleCompanyDB['schedule_prevat_id'].'/lista_'.strtr($scheduleCompanyDB['schedule']['training']['name'], [" " => "_", "ª" => "", "-"=> ""]).'.pdf';

            if(Storage::exists('public/'.$path)) {
                Storage::delete('public/'.$path);
            }

            $pdf->save(storage_path($path));

            $scheduleCompanyDB['schedule']->update(['file_presence' => $path]);
        }

        return [
            'status' => 'success',
            'code' => 200,
            'message' => 'Lista Atualizada com sucesso !'
        ];

    }
}
