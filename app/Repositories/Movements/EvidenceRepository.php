<?php

namespace App\Repositories\Movements;

use App\Models\Evidence;
use App\Models\EvidenceDownloadHistorics;
use App\Models\EvidenceParticipation;
use App\Models\TrainingCertificates;
use App\Models\TrainingParticipants;
use App\Models\TrainingParticipations;
use App\Requests\EvidenceRequest;
use App\Services\ReferenceService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use PHPUnit\Exception;

class EvidenceRepository
{
    public function index($orderBy = null, $filterData = null, $pageSize = null)
    {
        try {
            $evidenceDB = Evidence::query()->with(['company', 'training_participation.schedule_prevat.training']);

            if($orderBy){
                $evidenceDB->orderBy($orderBy['column'], $orderBy['order']);
            }

            if(Auth::user()->company->type == 'admin') {
                $evidenceDB->withoutGlobalScopes();
            }

            // CORRIGIDO: Agrupar busca textual em um único where aninhado
            if(isset($filterData['search']) && $filterData['search'] != null) {
                $evidenceDB->where(function($query) use ($filterData) {
                    $query->whereHas('training_participation.schedule_prevat.training', function($q) use ($filterData){
                        $q->where('name', 'LIKE', '%'.$filterData['search'].'%')
                          ->orWhere('acronym', 'LIKE', '%'.$filterData['search'].'%');
                    })
                    ->orWhereHas('company', function($q) use ($filterData){
                        $q->where('name', 'LIKE', '%'.$filterData['search'].'%')
                          ->orWhere('fantasy_name', 'LIKE', '%'.$filterData['search'].'%')
                          ->orWhere('employer_number', 'LIKE', '%'.$filterData['search'].'%');
                    });
                });
            }

            if(isset($filterData['date_start']) && $filterData['date_start'] != null) {
                $evidenceDB->whereDate('date', '>=', $filterData['date_start']);
            }

            if(isset($filterData['date_end']) && $filterData['date_end'] != null) {
                $evidenceDB->whereDate( 'date', '<=', $filterData['date_end']);
            }

            if(Auth::user()->company->type == 'client') {
                $evidenceDB->whereStatus('Ativo');
            }

            if($pageSize) {
                $evidenceDB = $evidenceDB->paginate($pageSize);
            } else {
                $evidenceDB = $evidenceDB->get();
            }


            return [
                'status' => 'success',
                'data' => $evidenceDB,
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
        $evidenceRequest = new EvidenceRequest();
        $requestValidated = $evidenceRequest->validate($request);

        try {
            DB::beginTransaction();

            $referenceService = new ReferenceService();
            $reference = $referenceService->getReference();

            $requestValidated['reference'] = $reference;

            $evidenceDB = Evidence::query()->create($requestValidated);

            $trainingParticipantsDB = TrainingParticipants::query()->with(['participant'])
                ->where('training_participation_id', $evidenceDB['training_participation_id'])
                ->where('company_id', $evidenceDB['company_id'])
                ->whereHas('participant', function($query) use ($evidenceDB){
                    $query->withoutGlobalScopes()->where('contract_id', $evidenceDB['contract_id']);
                })
                ->get();


            foreach ($trainingParticipantsDB as $itemParticipant) {
                EvidenceParticipation::query()->create([
                    'evidence_id' => $evidenceDB['id'],
                    'participant_id' => $itemParticipant['participant_id'],
                    'note' => $itemParticipant['note'],
                    'presence' => $itemParticipant['presence'],
                ]);
            }

            $this->generateCertificatesPDF($evidenceDB['id']);

            DB::commit();
            return [
                'status' => 'success',
                'data' => $evidenceDB,
                'code' => 200,
                'message' => 'Evidência cadastrada com sucesso !'
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
        $evidenceRequest = new EvidenceRequest();
        $requestValidated = $evidenceRequest->validate($request, $id);

        try {
            DB::beginTransaction();

            $evidenceDB = Evidence::query()->withoutGlobalScopes()->findOrFail($id);

            $this->generateCertificatesPDF($evidenceDB['id']);

            $evidenceDB->update($requestValidated);

            DB::commit();
            return [
                'status' => 'success',
                'data' => $evidenceDB,
                'code' => 200,
                'message' => 'Evidência atualizada com sucesso !'
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
            $evidenceDB = Evidence::query()->with(['training_participation', 'company'])->withoutGlobalScopes()->find($id);

            return [
                'status' => 'success',
                'data' => $evidenceDB,
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

            $evidenceDB = Evidence::query()->withoutGlobalScopes()->findOrFail($id);

            if(Storage::exists('public/'.$evidenceDB['file_path'])) {
                Storage::delete('public/'.$evidenceDB['file_path']);
            }

            $evidenceDB->delete();

            DB::commit();
            return [
                'status' => 'success',
                'data' => $evidenceDB,
                'code' => 200,
                'message' => 'Evidência deletada com sucesso !'
            ];

        } catch (\Exception $exception) {
            return [
                'status' => 'error',
                'code' => 400,
                'message' => 'Erro ao deletar'
            ];
        }
    }

    public function getSelectEvidence()
    {
        $evidenceDB = Evidence::query()->with(['company', 'training'])->whereStatus('Ativo')->orderBy('name', 'ASC')->get();

        $return = [];
        $return[0]['label'] = 'Escolha';
        $return[0]['value'] = '';

        if($evidenceDB->count() > 0) {
            foreach ($evidenceDB as $key => $itemEvidence) {
                $return[$key +1]['label'] = $itemEvidence['company']['name'];
                $return[$key +1]['value'] = $itemEvidence['id'];
            }
        } else {
            $return[0]['label'] = 'Sem Cadastro';
            $return[0]['value'] = '';
        }

        return $return;
    }



    public function downloadClient($id = null)
    {
        try {
            DB::beginTransaction();

            $evidenceDB = Evidence::query()->withoutGlobalScopes()->findOrFail($id);

            $evidenceDownloadHistorics = EvidenceDownloadHistorics::query()->create([
                'user_id' => Auth::user()->id,
                'evidence_id' => $evidenceDB['id'],
                'training_participation_id' => $evidenceDB['training_participation_id'],
            ]);

            DB::commit();
            return [
                'status' => 'success',
                'data' => $evidenceDB,
                'code' => 200,
                'message' => 'Download Feito com sucesso !'
            ];

        } catch (\Exception $exception) {

            return [
                'status' => 'error',
                'code' => 400,
                'message' => 'Erro na requisição'
            ];
        }
    }

    public function showHistoricsByEvidence($evidence_id)
    {
        try {
            $evidenceDownloadHistoricsDB = EvidenceDownloadHistorics::query()->with(['training_participation.schedule_prevat.training', 'evidence', 'user'])->where('evidence_id', $evidence_id)->get();

            return [
                'status' => 'success',
                'data' => $evidenceDownloadHistoricsDB,
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

    public function createEvidence($training_participation_id)
    {
        try {
            DB::beginTransaction();

            $companiesDB = TrainingParticipants::query()->with(['training_participation.schedule_prevat'])
                ->select('company_id', 'training_participation_id', 'contract_id')
                ->where('training_participation_id', $training_participation_id)
                ->where('presence', 1)
                ->whereStatus('Aprovado')
                ->distinct()
                ->get();

            $referenceService = new ReferenceService();

            foreach ($companiesDB as $itemCompany) {
                $evidenceDB = Evidence::query()->create([
                    'reference' => $referenceService->getReference(),
                    'training_participation_id' => $itemCompany['training_participation_id'],
                    'company_id' => $itemCompany['company_id'],
                    'contract_id' => $itemCompany['contract_id'],
                    'date' => $itemCompany['training_participation']['schedule_prevat']['date_event'],
                    'status' => 'Ativo'
                ]);

                $trainingParticipantsDB = TrainingParticipants::query()
                    ->with(['participant'  => fn ($query) => $query->withoutGlobalScopes()])
                    ->where('training_participation_id', $training_participation_id)
                    ->where('company_id', $itemCompany['company_id'])
                    ->where('contract_id', $itemCompany['contract_id'])
                    ->get();

                foreach ($trainingParticipantsDB as $itemParticipant) {
                    EvidenceParticipation::query()->create([
                        'evidence_id' => $evidenceDB['id'],
                        'participant_id' => $itemParticipant['participant_id'],
                        'note' => $itemParticipant['note'],
                        'presence' => $itemParticipant['presence'],
                    ]);
                }

                $this->generateCertificatesPDF($evidenceDB['id']);
            }

            $trainingParticipationDB = TrainingParticipations::query()->where('id', $training_participation_id)->first();

            $trainingParticipationDB->update(['evidences' => 1]);

            DB::commit();

            return [
                'status' => 'success',
                'data' => $trainingParticipantsDB,
                'code' => 200,
                'message' => 'Evidencias geradas com sucesso !'
            ];

        } catch (\Exception $exception) {
            DB::rollback();
            \Log::error('Error generating evidence: ' . $exception->getMessage());
            \Log::error('Stack trace: ' . $exception->getTraceAsString());
            
            return [
                'status' => 'error',
                'code' => 400,
                'message' => 'Erro na requisição: ' . $exception->getMessage()
            ];
        }
    }

    public function updateEvidences($training_participation_id)
    {
        try {
            DB::beginTransaction();

            $evidencesDB = Evidence::query()->with(['participants', 'historics'])->where('training_participation_id', $training_participation_id)->withoutGlobalScopes()->get();

            foreach ($evidencesDB as $itemEvidence){
                foreach ($itemEvidence['participants'] as $itemParticipant){
                    EvidenceParticipation::query()->find($itemParticipant['id'])->delete();
                }
                foreach ($itemEvidence['historics'] as $itemHistoric) {
                    EvidenceDownloadHistorics::query()->find($itemHistoric['id'])->delete();

                }
                $itemEvidence->delete();
            }

            $this->createEvidence($training_participation_id);

            DB::commit();

            return [
                'status' => 'success',
                'data' => $evidencesDB,
                'code' => 200,
                'message' => 'Evidencias atualizadas com sucesso !'
            ];

        } catch (\Exception $exception) {

            dd($exception);
            return [
                'status' => 'error',
                'code' => 400,
                'message' => 'Erro na requisição !'
            ];
        }
    }

    public function generateCertificatesPDF($evidence_id)
    {
        try {
            $evidenceDB = Evidence::query()->withoutGlobalScopes()->find($evidence_id);

            $trainingCertificatesDB = TrainingCertificates::query()->with([
                'training_participation.schedule_prevat.workload',
                'training_participation.schedule_prevat.location',
                'training_participation.schedule_prevat.room',
                'training_participation.schedule_prevat.first_time',
                'training_participation.schedule_prevat.second_time',
                'company',
                'training',
                'participant' => fn($query) => $query->withoutGlobalScopes()])
                ->where('training_participation_id', $evidenceDB['training_participation_id'])
                ->where('company_id', $evidenceDB['company_id'])
                ->whereHas('participant', function($query) use ($evidenceDB){
                    $query->withoutGlobalScopes()->where('contract_id', $evidenceDB['contract_id']);
                })
                ->get();

            $trainingParticipationDB = TrainingParticipations::query()->with(['schedule_prevat.training', 'professionals', 'participants.participant' => fn ($query) => $query->withoutGlobalScopes()])->find($evidenceDB['training_participation_id']);

            $data = ['certifications' => $trainingCertificatesDB, 'professionals' => $trainingParticipationDB, 'professionalsProgramatic' => $trainingParticipationDB['professionals'], 'content' => $trainingParticipationDB['schedule_prevat'],
                'participants' => $trainingParticipationDB['participants']];

            if($trainingParticipationDB['template_id'] == 1) {
                $pdf = Pdf::loadView('admin.pdf.evidence_certificates', $data)->setPaper('a4', 'landscape');
            } elseif ($trainingParticipationDB['template_id'] == 2) {
                $pdf = Pdf::loadView('admin.pdf.evidence_certificates_02', $data)->setPaper('a4', 'landscape');
            } else {
                $pdf = Pdf::loadView('admin.pdf.evidence_certificates_03', $data)->setPaper('a4', 'landscape');
            }

            // Criar nome do arquivo seguro
            $fileName = preg_replace('/[^a-zA-Z0-9_]/', '_', $trainingParticipationDB['schedule_prevat']['training']['name']);
            $fileName = 'certificados_' . $fileName . '.pdf';

            // Criar diretório base se não existir
            $baseDir = public_path('storage/evidences');
            if (!is_dir($baseDir)) {
                if (!mkdir($baseDir, 0775, true)) {
                    \Log::error('Falha ao criar diretório base: ' . $baseDir);
                    throw new \Exception('Falha ao criar diretório base');
                }
                chmod($baseDir, 0775);
            }

            // Criar diretório específico para a evidência
            $evidenceDir = $baseDir . '/' . $evidenceDB['id'];
            if (!is_dir($evidenceDir)) {
                if (!mkdir($evidenceDir, 0775, true)) {
                    \Log::error('Falha ao criar diretório da evidência: ' . $evidenceDir);
                    throw new \Exception('Falha ao criar diretório da evidência');
                }
                chmod($evidenceDir, 0775);
            }

            // Caminho completo do arquivo
            $filePath = 'evidences/' . $evidenceDB['id'] . '/' . $fileName;
            $fullPath = public_path('storage/' . $filePath);

            // Salvar o PDF
            $pdf->save($fullPath);
            chmod($fullPath, 0664);

            // Verificar se o arquivo foi criado
            if (!file_exists($fullPath)) {
                \Log::error('Falha ao salvar o arquivo PDF: ' . $fullPath);
                throw new \Exception('Falha ao salvar o arquivo PDF');
            }

            // Atualizar o caminho no banco de dados
            $evidenceDB->update([
                'file_path' => $filePath
            ]);

            return [
                'status' => 'success',
                'data' => $evidenceDB,
                'code' => 200,
                'message' => 'PDF gerado com sucesso!'
            ];

        } catch (\Exception $exception) {
            \Log::error('Erro ao gerar PDF: ' . $exception->getMessage());
            \Log::error('Stack trace: ' . $exception->getTraceAsString());
            return [
                'status' => 'error',
                'code' => 400,
                'message' => 'Erro ao gerar PDF: ' . $exception->getMessage()
            ];
        }
    }

    public function generateCertificatesPDFCustom($evidence_id, $licenca_numero, $licenca_validade, $licenca_protocolo, $qrcode_atestado = null)
    {
        try {
            \Log::info('Iniciando generateCertificatesPDFCustom', [
                'evidence_id' => $evidence_id,
                'licenca_numero' => $licenca_numero,
                'licenca_validade' => $licenca_validade,
                'licenca_protocolo' => $licenca_protocolo,
                'qrcode_atestado_type' => is_object($qrcode_atestado) ? get_class($qrcode_atestado) : gettype($qrcode_atestado),
                'qrcode_atestado_exists' => $qrcode_atestado ? 'sim' : 'nao',
            ]);
            $evidenceDB = Evidence::query()->withoutGlobalScopes()->find($evidence_id);

            $trainingCertificatesDB = TrainingCertificates::query()->with([
                'training_participation.schedule_prevat.workload',
                'training_participation.schedule_prevat.location',
                'training_participation.schedule_prevat.room',
                'training_participation.schedule_prevat.first_time',
                'training_participation.schedule_prevat.second_time',
                'company',
                'training',
                'participant' => fn($query) => $query->withoutGlobalScopes()])
                ->where('training_participation_id', $evidenceDB['training_participation_id'])
                ->where('company_id', $evidenceDB['company_id'])
                ->whereHas('participant', function($query) use ($evidenceDB){
                    $query->withoutGlobalScopes()->where('contract_id', $evidenceDB['contract_id']);
                })
                ->get();

            $trainingParticipationDB = TrainingParticipations::query()->with(['schedule_prevat.training', 'professionals', 'participants.participant' => fn ($query) => $query->withoutGlobalScopes()])->find($evidenceDB['training_participation_id']);

            $qrcode_atestado_path = null;
            if (!empty($licenca_numero)) {
                $qrcode_url = "https://sisgat.bombeiros.pa.gov.br/verificar/" . $licenca_numero;
                $dir = 'storage/evidences/'.$evidenceDB['id'].'/qrcodes';
                $absDir = public_path($dir);
                if (!is_dir($absDir)) {
                    mkdir($absDir, 0775, true);
                }
                $filename = 'qrcode_atestado_' . $licenca_numero . '.png';
                $qrcode_atestado_path = $dir . '/' . $filename;
                $qrCodeFullPath = public_path($qrcode_atestado_path);
                if (!file_exists($qrCodeFullPath)) {
                    \LaravelQRCode\Facades\QRCode::url($qrcode_url)
                        ->setOutfile($qrCodeFullPath)
                        ->setSize(4)
                        ->setMargin(2)
                        ->png();
                }
                \Log::info('QR Code do atestado gerado', ['url' => $qrcode_url, 'path' => $qrcode_atestado_path]);
            }

            $data = [
                'certifications' => $trainingCertificatesDB,
                'professionals' => $trainingParticipationDB,
                'professionalsProgramatic' => $trainingParticipationDB['professionals'],
                'content' => $trainingParticipationDB['schedule_prevat'],
                'participants' => $trainingParticipationDB['participants'],
                'licenca_numero' => $licenca_numero,
                'licenca_validade' => $licenca_validade,
                'licenca_protocolo' => $licenca_protocolo,
                'qrcode_atestado_path' => $qrcode_atestado_path,
            ];

            $pdf = \PDF::loadView('admin.pdf.evidence_certificates_03', $data)->setPaper('a4', 'landscape');

            $fileName = preg_replace('/[^a-zA-Z0-9_]/', '_', $trainingParticipationDB['schedule_prevat']['training']['name']);
            $fileName = 'certificados_' . $fileName . '.pdf';

            $baseDir = public_path('storage/evidences');
            if (!is_dir($baseDir)) {
                if (!mkdir($baseDir, 0775, true)) {
                    \Log::error('Falha ao criar diretório base: ' . $baseDir);
                    throw new \Exception('Falha ao criar diretório base');
                }
                chmod($baseDir, 0775);
            }

            $evidenceDir = $baseDir . '/' . $evidenceDB['id'];
            if (!is_dir($evidenceDir)) {
                if (!mkdir($evidenceDir, 0775, true)) {
                    \Log::error('Falha ao criar diretório da evidência: ' . $evidenceDir);
                    throw new \Exception('Falha ao criar diretório da evidência');
                }
                chmod($evidenceDir, 0775);
            }

            $filePath = 'evidences/' . $evidenceDB['id'] . '/' . $fileName;
            $fullPath = public_path('storage/' . $filePath);

            $pdf->save($fullPath);
            chmod($fullPath, 0664);

            if (!file_exists($fullPath)) {
                \Log::error('Falha ao salvar o arquivo PDF: ' . $fullPath);
                throw new \Exception('Falha ao salvar o arquivo PDF');
            }

            $evidenceDB->update([
                'file_path' => $filePath
            ]);

            return [
                'status' => 'success',
                'data' => $evidenceDB,
                'code' => 200,
                'message' => 'PDF gerado com sucesso!'
            ];

        } catch (\Exception $exception) {
            \Log::error('Erro ao gerar PDF: ' . $exception->getMessage());
            \Log::error('Stack trace: ' . $exception->getTraceAsString());
            return [
                'status' => 'error',
                'code' => 400,
                'message' => 'Erro ao gerar PDF: ' . $exception->getMessage()
            ];
        }
    }

}
