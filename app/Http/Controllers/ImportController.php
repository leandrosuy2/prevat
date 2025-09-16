<?php

namespace App\Http\Controllers;

use App\Models\AgendaEmpresa;
use App\Models\CompaniesContracts;
use App\Models\Company;
use App\Models\Empresas;
use App\Models\Enderecos;
use App\Models\Evidence;
use App\Models\Participant;
use App\Models\ParticipantsItens;
use App\Models\ScheduleCompany;
use App\Models\ScheduleCompanyParticipants;
use App\Models\SchedulePrevat;
use App\Models\Training;
use App\Models\TrainingCertificates;
use App\Models\TrainingParticipants;
use App\Models\TrainingParticipations;
use App\Models\TrainingsCategory;
use App\Models\User;
use App\Models\UsersContracts;
use App\Services\ReferenceService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use LaravelQRCode\Facades\QRCode;
use function Symfony\Component\String\s;

class ImportController extends Controller
{
    public function importCompanies()
    {
        $companiesDB = Company::query()->get();

        foreach ($companiesDB as $itemCompany) {
            $empresa = Empresas::query()->where('fantasy_name', 'like', '%'.$itemCompany['fantasy_name'].'%')->first();
            if($empresa) {
                $itemCompany->old_id = $empresa['id'];
                $itemCompany->name = $empresa['name'];
                $itemCompany->email = $empresa['email'];
                $itemCompany->phone = $empresa['phone'];
                $itemCompany->employer_number= $empresa['employer_number'];
                $itemCompany->save();
            }
        }
    }

    public function importAddress()
    {
        $companiesDB = Company::query()->get();

        foreach ($companiesDB as $itemCompany) {
            $endereco = Enderecos::query()->find($itemCompany['old_id']);
            if($endereco) {
                $itemCompany->zip_code = $endereco['cep'];
                $itemCompany->address = $endereco['logradouro'];
                $itemCompany->number = $endereco['numero'];
                $itemCompany->complement = $endereco['complemento'];
                $itemCompany->neighborhood = $endereco['bairro'];
                $itemCompany->city = $endereco['cidade'];
                $itemCompany->uf = $endereco['estado'];
                $itemCompany->save();
            }
        }
    }

    public function addUsers()
    {
        $companiesDB = Company::query()->whereNot('id', 1000)->whereNull('user_id')->get();

        foreach ($companiesDB as $itemCompany) {
            if($itemCompany['email'] != null) {
                $userDB = User::query()->create([
                    'company_id' => $itemCompany['id'],
                    'name' => $itemCompany['fantasy_name'],
                    'email' => $itemCompany['email'],
                    'password' => bcrypt('Prevat@2024'),
                    'status' => 'Ativo',
                    'type' => 'client'
                ]);
                $itemCompany->user_id = $userDB['id'];
                $itemCompany->save();
            }
        }
    }

    public function addScheduleCompany()
    {
        $agendaEmpresa = AgendaEmpresa::query()->distinct()->select('schedule_prevat_id', 'company_id')->get();

        foreach ($agendaEmpresa as $item) {
             $scheduleCompanyDB = ScheduleCompany::query()->with('participants')->create([
                'schedule_prevat_id' => $item['schedule_prevat_id'],
                'company_id' => $item['company_id'],
                'status' => $item['concluído']
            ]);
        }
    }

    public function addParticipantsBySchedule()
    {
        $scheduleCompany = ScheduleCompany::query()->with(['participants'])->get();

        foreach ($scheduleCompany as $itemSchedule) {
            $teste = ScheduleCompany::query()->with(['participants'])->find($itemSchedule['id']);

            $teste->update([
                'total_participants' => $itemSchedule['participants']->count()
            ]);
//            dd($teste);
//            dd();
//            ScheduleCompany::query()->with([''])
//
//            $scheduleCompany-> =
//            $scheduleCompany->save();
//            $agendaEmpresa = AgendaEmpresa::query()->where('schedule_prevat_id', $itemSchedule['schedule_prevat_id'])->where('company_id', $itemSchedule['company_id'])->get();
//            foreach ($agendaEmpresa as $itemAgendaEmpresa) {
//                ScheduleCompanyParticipants::query()->create([
//                    'schedule_company_id' => $itemSchedule['id'],
//                    'participant_id' => $itemAgendaEmpresa['participant_id']
//                ]);
//            }
//
        }


    }

    public function trainingParticipants()
    {
        $participantsItens  = TrainingParticipants::query()->get();

        foreach ($participantsItens as $participant) {
            if($participant->note >= 7) {
                $participant->status = 'Aprovado';
                $participant->table_color = 'table-primary';
            } elseif ($participant->note < 7) {
                $participant->status = 'Reprovado';
                $participant->table_color = 'table-danger';
            }
            $participant->presence = true;
            $participant->save();
        }
    }

    public function separatecontractParticipants()
    {
        $participantsDB = Participant::query()->withoutGlobalScopes()->get();

//        foreach($participantsDB as $itemParticipant) {
//            $separate = explode("-", $itemParticipant['name']);
//            $itemParticipant->name = $separate[0];
//            if(isset($separate[1])){
//                $itemParticipant->contract = $separate[1];
//            }
//            $itemParticipant->save();
//        }

        foreach($participantsDB as $itemParticipant) {

            $itemParticipant->contract = strtr($itemParticipant->contract, [' : ' => ''  ]);
//            $separate = explode(" ", $itemParticipant['contract']);
//
//            dd($separate);
//            if(isset($separate[1])){
//                $itemParticipant->contract = $separate[1];
//            }
            $itemParticipant->save();
        }

    }

    public function addNameCompany()
    {
        $companiesDB = Company::query()->whereNull('name')->withoutGlobalScopes()->get();

        foreach($companiesDB as $itemCompany) {

            $itemCompany->name = $itemCompany->fantasy_name;
            $itemCompany->save();
        }

    }

    public function addCategories()
    {
        $trainingDB = Training::query()->get()->unique('acronym');

        foreach ($trainingDB as $item) {
            TrainingsCategory::query()->create([
                'name' => $item['acronym'] ?? 'S/C',
                'status' => 'Ativo',
                'featured' => 'Não'
            ]);
        }
    }

    public function addCategoryTraining()
    {
        $trainingDB = Training::query()->get();

        foreach ($trainingDB as $itemTraining) {
            $trainingCategoryDB = TrainingsCategory::query()->where('name', $itemTraining['acronym'])->first();

            if($trainingCategoryDB) {
                $itemTraining->category_id = $trainingCategoryDB->id;
                $itemTraining->save();
            }
        }

    }

    public function addReferencesSchedulePrevat()
    {
        $referenceService = new ReferenceService();

        $schedulePrevatDB = SchedulePrevat::query()->get();

        foreach ($schedulePrevatDB as $itemSchedulePrevat){
            if($itemSchedulePrevat->reference == null) {
                $itemSchedulePrevat->reference = $referenceService->getReference();
                $itemSchedulePrevat->save();
            }
        }

    }

    public function addReferencesScheduleCompany()
    {
        $referenceService = new ReferenceService();

        $scheduleCompaniesDB = ScheduleCompany::query()->withoutGlobalScopes()->get();

        foreach ($scheduleCompaniesDB as $itemScheduleCompany){
            if($itemScheduleCompany->reference == null) {
                $itemScheduleCompany->reference = $referenceService->getReference();
                $itemScheduleCompany->save();
            }
        }
    }

    public function addReferencesEvidence()
    {
        $referenceService = new ReferenceService();

        $evidenceDB = Evidence::query()->withoutGlobalScopes()->get();

        foreach ($evidenceDB as $itemEvidence){
            if($itemEvidence->reference == null) {
                $itemEvidence->reference = $referenceService->getReference();
                $itemEvidence->save();
            }
        }
    }

    public function changeVacancies()
    {
        $schedulePrevatDB = SchedulePrevat::query()->orderBy('id', 'desc')->get();

        foreach ($schedulePrevatDB as $itemSchedulePrevat) {

            $scheduleCompanyParticpantsDB = ScheduleCompanyParticipants::query()->with([
                'schedule_company',
                'participant' => fn ($query) => $query->withoutGlobalScopes(),
                'participant.company.contract' => fn ($query) => $query->withoutGlobalScopes(),
                'participant.role' => fn ($query) => $query->withoutGlobalScopes()
            ]);
            $scheduleCompanyParticpantsDB->whereHas('schedule_company', function($query) use ($itemSchedulePrevat){
                $query->withoutGlobalScopes()->where('schedule_prevat_id', $itemSchedulePrevat['id']);
            });

            $itemSchedulePrevat->vacancies_occupied = $scheduleCompanyParticpantsDB->count();
            $itemSchedulePrevat->vacancies_available = $itemSchedulePrevat->vacancies - $scheduleCompanyParticpantsDB->count();
            $itemSchedulePrevat->save();
        }
    }

    public function changeContractsDefault()
    {
        $companiesContractDB = CompaniesContracts::query()->get();

        foreach ($companiesContractDB as $itemCompanyContract) {
            $companyDB = Company::query()->find($itemCompanyContract['company_id']);
//
            if($companyDB['user_id'] != null) {
                UsersContracts::query()->create([
                    'user_id' => $companyDB['user_id'],
                    'contract_id' => $itemCompanyContract['id']
                ]);
            }
        }
    }

    public function addContrats()
    {
        $trainingParticipationsDB = TrainingParticipants::query()->with(['participant' => fn($query) => $query->withoutGlobalScopes()])->get();

        foreach ($trainingParticipationsDB as $itemParticipant) {
            $itemParticipant->contract_id = $itemParticipant['participant']['contract_id'];
            $itemParticipant->save();
        }
    }

    public function changeVacanciesNew()
    {
        $schedulePrevatDB = SchedulePrevat::query()->orderBy('id', 'desc')->get();

        foreach ($schedulePrevatDB as $itemSchedulePrevat) {

            $scheduleCompanyParticpantsDB = ScheduleCompanyParticipants::query()->with([
                'schedule_company',
                'participant' => fn ($query) => $query->withoutGlobalScopes(),
//                'participant.company.contract' => fn ($query) => $query->withoutGlobalScopes(),
                'participant.role' => fn ($query) => $query->withoutGlobalScopes()
            ])->whereHas('schedule_company', function($query) use ($itemSchedulePrevat){
                $query->withoutGlobalScopes()->where('schedule_prevat_id', $itemSchedulePrevat['id']);
            })->get();

            $vacancies_occupied = 0;
            $vacancies_absences = 0;
//            dd($scheduleCompanyParticpantsDB);

            foreach ($scheduleCompanyParticpantsDB as $itemParticipant) {
//                dd($itemParticipant);
                if($itemParticipant['presence'] == 1) {
//                    dd('caiu');
                    $vacancies_occupied ++;
                } elseif ($itemParticipant['presence'] == 0) {
                    $vacancies_absences ++;
                }
            }
//            dd($vacancies_occupied, $vacancies_absences);

            $itemSchedulePrevat->vacancies_occupied = $vacancies_occupied;
            $itemSchedulePrevat->vacancies_available = $itemSchedulePrevat->vacancies - $vacancies_occupied;
            $itemSchedulePrevat->absences = $vacancies_absences;
            $itemSchedulePrevat->save();
        }
    }

    public function addPrices()
    {
        $scheduleCompanyDB = ScheduleCompany::query()->with(['schedule.training', 'participants', 'participantsPresent'])->withoutGlobalScopes()->get();

        foreach ($scheduleCompanyDB as $itemScheduleCompany) {
            foreach ($itemScheduleCompany['participantsPresent'] as $itemParticipant ) {
                $itemParticipant->quantity = 1;
                $itemParticipant->value = $itemScheduleCompany['schedule']['training']['value'];
                $itemParticipant->total_value = $itemScheduleCompany['schedule']['training']['value'] * $itemParticipant->quantity;
                $itemParticipant->save();
            }
            $itemScheduleCompany->price = $itemScheduleCompany['schedule']['training']['value'];
            $itemScheduleCompany->price_total = $itemScheduleCompany['participantsPresent']->sum('value');
            $itemScheduleCompany->save();
        }
    }

    public function genererateQrCodes()
    {
        $trainingParticipantsDB = TrainingParticipants::query()->with([
            'training_participation.schedule_prevat',
            'participant' => fn ($query) => $query->withoutGlobalScopes(),
        ]);

//        $trainingParticipantsDB->where('training_participation_id', $training_participation_id);
        $trainingParticipantsDB->where('presence', true);
        $trainingParticipantsDB->whereStatus('Aprovado');

        $trainingParticipantsDB = $trainingParticipantsDB->get();

        foreach ($trainingParticipantsDB as $itemParticipant) {

            Storage::disk('public')->makeDirectory('qrcodes/');

            $path = 'qrcodes/'.$itemParticipant['reference'].'.png';

            if(Storage::exists('public/'.$path)) {
                Storage::delete('public/'.$path);
            }

            QRCode::url(url('consulta-certificado/'.$itemParticipant['reference']))
                ->setOutfile(Storage::disk("public")->path($path))
                ->png();

            $trainingCertificationDB = TrainingCertificates::query()->find($itemParticipant['id']);

            $trainingCertificationDB = TrainingCertificates::query()->create([
                'reference' => $reference,
                'training_participant_id' => $itemParticipant['id'],
                'training_participation_id' => $itemParticipant['training_participation_id'],
                'company_id' => $itemParticipant['participant']['company_id'],
                'training_id' => $itemParticipant['training_participation']['schedule_prevat']['training_id'],
                'participant_id' => $itemParticipant['participant_id'],
                'note' => $itemParticipant['note'],
                'registry' => $lastRegistry + 1,
                'year' => today()->format('Y'),
                'path_qrcode' => $path
            ]);
        }
    }
}
