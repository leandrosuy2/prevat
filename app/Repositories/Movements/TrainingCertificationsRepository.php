<?php

namespace App\Repositories\Movements;

use App\Models\TrainingCertificates;
use App\Models\TrainingParticipants;
use App\Models\TrainingParticipations;
use App\Services\ReferenceService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use LaravelQRCode\Facades\QRCode;
use PHPUnit\Exception;

class TrainingCertificationsRepository
{
    public function getCertificates($participation_id = null)
    {
        try {
            $trainingCertificateDB = TrainingCertificates::query()->with([
                'training_participation', 'training', 'company',  'participant' => fn ($query) => $query->withoutGlobalScopes()
            ]);


            if($participation_id)  {
                $trainingCertificateDB->where('training_participation_id', $participation_id);
            }
            $trainingCertificateDB = $trainingCertificateDB->get();

            return [
                'status' => 'success',
                'data' => $trainingCertificateDB,
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

    public function create($training_participation_id)
    {
        try {
            $trainingParticipantsDB = TrainingParticipants::query()->with([
                'training_participation.schedule_prevat',
                'participant' => fn ($query) => $query->withoutGlobalScopes(),
                ]);

            $trainingParticipantsDB->where('training_participation_id', $training_participation_id);
            $trainingParticipantsDB->where('presence', true);
            $trainingParticipantsDB->whereStatus('Aprovado');

            $trainingParticipantsDB = $trainingParticipantsDB->get();
            $referenceService = new ReferenceService();

            $trainingCertificationDB = TrainingCertificates::query()->orderBy('id', 'DESC')->first();

            foreach ($trainingParticipantsDB as $itemParticipant) {
                $reference = $referenceService->getReference();
                if($trainingCertificationDB) {
                    $lastRegistry = $trainingCertificationDB['registry'];
                } else {
                    $lastRegistry = 12000;
                }

                Storage::disk('public')->makeDirectory('images/qrcodes/', 0755, true);

                $path = 'images/qrcodes/'.$reference.'.png';

                if(Storage::exists('public/'.$path)) {
                    Storage::delete('public/'.$path);
                }

                QRCode::url(url('consulta-certificado/'.$reference))
                    ->setOutfile(Storage::disk("public")->path($path))
                    ->setSize(4)
                    ->setMargin(2)
                    ->png();

                $trainingCertificationDB = TrainingCertificates::query()->create([
                    'reference' => $reference,
                    'training_participant_id' => $itemParticipant['id'],
                    'training_participation_id' => $training_participation_id,
                    'company_id' => $itemParticipant['participant']['company_id'],
                    'training_id' => $itemParticipant['training_participation']['schedule_prevat']['training_id'],
                    'participant_id' => $itemParticipant['participant_id'],
                    'note' => $itemParticipant['note'],
                    'registry' => $lastRegistry + 1,
                    'year' => today()->format('Y'),
                    'path_qrcode' => $path
                ]);
            }

            $this->generateAllCertificatesPDF($training_participation_id);
            $this->generateProgrammaticPDF($training_participation_id);

            return [
                'status' => 'success',
                'data' => $trainingCertificationDB,
                'message' => 'Participantes do curso atualizados com sucesso',
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

    public function update($training_participation_id)
    {
        try {
        $trainingParticipantsDB = TrainingParticipants::query()->with([
            'training_participation.schedule_prevat',
            'participant' => fn ($query) => $query->withoutGlobalScopes(),
        ]);

        $trainingParticipantsDB->where('training_participation_id', $training_participation_id);
        $trainingParticipantsDB->where('presence', true);
        $trainingParticipantsDB->whereStatus('Aprovado');

        $trainingParticipantsDB = $trainingParticipantsDB->get();

        $trainingCertificationDB = TrainingCertificates::query()->orderBy('id', 'DESC')->first();

        $referenceService = new ReferenceService();

        foreach ($trainingParticipantsDB as $itemTrainingParticipant) {
//            dd($itemTrainingParticipant);
            $trainingCertificatesDB = TrainingCertificates::query()->where('training_participation_id', $itemTrainingParticipant['training_participation_id'])->where('participant_id', $itemTrainingParticipant['participant_id'])->first();
//            dd($trainingCertificatesDB);
            if($trainingCertificatesDB){
                $trainingCertificatesDB->update([
                    'note' => $itemTrainingParticipant['note']
                ]);
            } else {
                $reference = $referenceService->getReference();
                if($trainingCertificationDB) {
                    $lastRegistry = $trainingCertificationDB['registry'];
                } else {
                    $lastRegistry = 12000;
                }

                $path = 'images/qrcodes/'.$reference.'.png';

                if(Storage::exists('public/'.$path)) {
                    Storage::delete('public/'.$path);
                }

                QRCode::url(url('consulta-certificado/'.$reference))
                    ->setOutfile(Storage::disk("public")->path($path))
                    ->setSize(4)
                    ->setMargin(2)
                    ->png();

                $trainingCertificationDB = TrainingCertificates::query()->create([
                    'reference' => $reference,
                    'training_participant_id' => $itemTrainingParticipant['id'],
                    'training_participation_id' => $training_participation_id,
                    'company_id' => $itemTrainingParticipant['participant']['company_id'],
                    'training_id' => $itemTrainingParticipant['training_participation']['schedule_prevat']['training_id'],
                    'participant_id' => $itemTrainingParticipant['participant_id'],
                    'note' => $itemTrainingParticipant['note'],
                    'registry' => $lastRegistry + 1,
                    'year' => today()->format('Y'),
                    'path_qrcode' => $path
                ]);
            }

        }
            $this->generateAllCertificatesPDF($training_participation_id);
            $this->generateProgrammaticPDF($training_participation_id);

            return [
                'status' => 'success',
                'data' => $trainingCertificationDB,
                'message' => 'Participantes do curso atualizados com sucesso',
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
    public function generateCertificateByParticipant($training_participation_id)
    {
        $trainingCertificatesDB = TrainingCertificates::query()->with(['company', 'training', 'participant'])->where('training_participation_id', $training_participation_id)->get();

        foreach ($trainingCertificatesDB as $itemCertificates) {
            $pdf = Pdf::loadView('admin.pdf.certificate')->setPaper('a4', 'landscape');

            Storage::disk('public')->makeDirectory('certificates/'.$itemCertificates['reference']);

            $path = 'storage/certificates/'.$itemCertificates['reference'].'/certificado_'.$itemCertificates['reference'].'.pdf';

            if(Storage::exists('public/'.$path)) {
                Storage::delete('public/'.$path);
            }

            $pdf->save($path);

            $itemCertificates->update(['file' => $path]);
        }
    }

    public function generateAllCertificatesPDF($training_participation_id)
    {
        $trainingCertificatesDB = TrainingCertificates::query()->with([
            'training_participation.participants' => fn ($query) => $query->withoutGlobalScopes(),
            'training_participation.schedule_prevat.workload',
            'training_participation.schedule_prevat.location',
            'training_participation.schedule_prevat.room',
            'training_participation.schedule_prevat.first_time',
            'training_participation.schedule_prevat.second_time',
            'company',
            'training',
            'participant'=> fn ($query) => $query->withoutGlobalScopes()])->where('training_participation_id', $training_participation_id)->get();

        // Garantir que os QR Codes existam e tenham caminhos absolutos
        foreach ($trainingCertificatesDB as $certificate) {
            if (!$certificate->path_qrcode || !Storage::exists('public/'.$certificate->path_qrcode)) {
                $reference = $certificate->reference ?? (new ReferenceService())->getReference();
                $path = 'images/qrcodes/'.$reference.'.png';
                
                Storage::disk('public')->makeDirectory('images/qrcodes/', 0755, true);
                $qrCodePath = Storage::disk("public")->path($path);
                
                QRCode::url(url('consulta-certificado/'.$reference))
                    ->setOutfile($qrCodePath)
                    ->setSize(4)
                    ->setMargin(2)
                    ->png();
                
                $certificate->path_qrcode = $path;
                $certificate->save();
            }
            
            // Garantir que o caminho do QR Code seja absoluto para o PDF
            $certificate->path_qrcode = Storage::disk('public')->path($certificate->path_qrcode);
        }

        $trainingParticipationDB = TrainingParticipations::query()->with(['schedule_prevat.training', 'professionals'])->find($training_participation_id);

        $data = ['certifications' => $trainingCertificatesDB, 'professionals' => $trainingParticipationDB];

        if($trainingParticipationDB['template_id'] == 1) {
            $pdf = Pdf::loadView('admin.pdf.all_certificates', $data)->setPaper('a4', 'landscape');
        } elseif($trainingParticipationDB['template_id'] == 2) {
            $pdf = Pdf::loadView('admin.pdf.all_certificates_02', $data)->setPaper('a4', 'landscape');
        } elseif($trainingParticipationDB['template_id'] == 3) {
            $pdf = Pdf::loadView('admin.pdf.all_certificates_03', $data)->setPaper('a4', 'landscape');
        }

        Storage::disk('public')->makeDirectory('certificates/'.$trainingParticipationDB['id']);

        $path = 'app/public/certificates/'.$trainingParticipationDB['id'].'/certificados_'.strtr($trainingParticipationDB['schedule_prevat']['training']['name'], [" " => "_", "ª" => "", "-"=> "", "/" => "_"]).'.pdf';

        if(Storage::exists('public/'.$path)) {
            Storage::delete('public/'.$path);
        }

        $pdf->save(storage_path($path));

        $trainingParticipationDB->update(['file' => $path]);

        return [
            'status' => 'success',
            'message' => 'Certificados gerados com sucesso!',
            'code' => 200
        ];
    }


    public function generateQRCODE($training_participation_id)
    {
        try {
            Log::info('Iniciando geração de QR Code para participação: ' . $training_participation_id);
            
            $trainingCertificatesDB = TrainingCertificates::query()
                ->where('training_participation_id', $training_participation_id)
                ->get();

            Log::info('Encontrados ' . count($trainingCertificatesDB) . ' certificados para processar');

            $referenceService = new ReferenceService();

            foreach ($trainingCertificatesDB as $itemCertificate) {
                Log::info('Processando certificado ID: ' . $itemCertificate->id);
                
                // Sempre gera um novo QR Code
                $reference = $referenceService->getReference();
                $path = 'images/qrcodes/'.$reference.'.png';
                $fullPath = public_path($path);

                // Verifica se o diretório existe
                if (!is_dir(public_path('images/qrcodes'))) {
                    mkdir(public_path('images/qrcodes'), 0755, true);
                }

                // Verifica permissões do diretório
                if (!is_writable(public_path('images/qrcodes'))) {
                    Log::error('Diretório qrcodes não tem permissão de escrita: ' . public_path('images/qrcodes'));
                    throw new \Exception('Diretório qrcodes não tem permissão de escrita');
                }

                // Remove o arquivo antigo se existir
                if (file_exists($fullPath)) {
                    Log::info('Removendo arquivo antigo: ' . $fullPath);
                    unlink($fullPath);
                }

                // Gera o QR Code
                try {
                    Log::info('Iniciando geração do QR Code');
                    QRCode::url(url('consulta-certificado/'.$reference))
                        ->setOutfile($fullPath)
                        ->setSize(4)
                        ->setMargin(2)
                        ->png();

                    Log::info('QR Code gerado com sucesso em: ' . $fullPath);

                    // Atualiza o certificado com o novo caminho
                    $itemCertificate->update([
                        'reference' => $reference,
                        'path_qrcode' => $path
                    ]);

                    Log::info('Certificado atualizado com sucesso');
                } catch (\Exception $e) {
                    Log::error('Erro ao gerar QR Code: ' . $e->getMessage());
                    throw $e;
                }
            }

            // Regenera os PDFs com os novos QR Codes
            $this->generateAllCertificatesPDF($training_participation_id);
            $this->generateProgrammaticPDF($training_participation_id);

            Log::info('Processo de geração de QR Codes concluído com sucesso');

            return [
                'status' => 'success',
                'data' => $trainingCertificatesDB,
                'message' => 'QR Codes atualizados com sucesso',
                'code' => 200,
            ];
        } catch (Exception $exception) {
            Log::error('Erro na geração de QR Codes: ' . $exception->getMessage());
            return [
                'status' => 'error',
                'code' => 400,
                'message' => 'Erro na requisição: ' . $exception->getMessage()
            ];
        }
    }
    public function generateProgrammaticPDF($training_participation_id)
    {
        $trainingParticipationDB = TrainingParticipations::query()->with(['schedule_prevat.training', 'participants.participant' => fn($query) => $query->withoutGlobalScopes(), 'professionals'])->findOrFail($training_participation_id);

        $data = ['content' => $trainingParticipationDB['schedule_prevat'], 'professionals' => $trainingParticipationDB['professionals'], 'participants' => $trainingParticipationDB['participants']];

        if($trainingParticipationDB['template_id'] == 1) {
            $pdf = Pdf::loadView('admin.pdf.programmatic', $data)->setPaper('A4', 'landscape')->setOption(['defaultFont'=> 'arial']);
        }elseif($trainingParticipationDB['template_id'] == 2) {
            $pdf = Pdf::loadView('admin.pdf.programmatic_02', $data)->setPaper('A4', 'landscape')->setOption(['defaultFont'=> 'arial']);
        }elseif($trainingParticipationDB['template_id'] == 3) {
            $pdf = Pdf::loadView('admin.pdf.programmatic_03', $data)->setPaper('A4', 'landscape')->setOption(['defaultFont'=> 'arial']);
        }

        // Create directory path
        $directory = 'conteudo-programatico/' . $trainingParticipationDB['id'];
        $fullDirectory = storage_path('app/public/' . $directory);
        
        // Create directory if it doesn't exist
        if (!file_exists($fullDirectory)) {
            mkdir($fullDirectory, 0755, true);
        }

        // Generate safe filename
        $filename = preg_replace('/[^a-zA-Z0-9_]/', '_', $trainingParticipationDB['schedule_prevat']['training']['name']) . '.pdf';
        $path = $directory . '/' . $filename;
        $fullPath = storage_path('app/public/' . $path);

        // Delete existing file if it exists
        if (file_exists($fullPath)) {
            unlink($fullPath);
        }

        // Save the PDF
        $pdf->save($fullPath);

        // Update the database with the relative path
        $trainingParticipationDB->update(['file_programmatic' => $path]);

        return [
            'status' => 'success',
            'message' => 'Conteúdo Programático Gerado com sucesso !',
            'code' => 200,
        ];
    }

    public function generateCertificatesPDF($training_certificate_id)
    {
        $trainingCertificateDB = TrainingCertificates::query()->with([
            'training_participation.participants' => fn ($query) => $query->withoutGlobalScopes(),
            'training_participation.schedule_prevat.workload',
            'training_participation.schedule_prevat.location',
            'training_participation.schedule_prevat.room',
            'training_participation.schedule_prevat.first_time',
            'training_participation.schedule_prevat.second_time',
            'company',
            'training',
            'participant'=> fn ($query) => $query->withoutGlobalScopes()])->find($training_certificate_id);

        // Garantir que o QR Code exista
        if (!$trainingCertificateDB->path_qrcode || !Storage::exists('public/'.$trainingCertificateDB->path_qrcode)) {
            $reference = $trainingCertificateDB->reference ?? (new ReferenceService())->getReference();
            $path = 'images/qrcodes/'.$reference.'.png';
            
            Storage::disk('public')->makeDirectory('images/qrcodes/', 0755, true);
            $qrCodePath = Storage::disk("public")->path($path);
            
            QRCode::url(url('consulta-certificado/'.$reference))
                ->setOutfile($qrCodePath)
                ->setSize(4)
                ->setMargin(2)
                ->png();
            
            $trainingCertificateDB->path_qrcode = $path;
            $trainingCertificateDB->save();
        }

        // Garantir que o caminho do QR Code seja absoluto para o PDF
        $qrCodePath = Storage::disk('public')->path($trainingCertificateDB->path_qrcode);
        $trainingCertificateDB->path_qrcode = $qrCodePath;

        $data = ['certification' => $trainingCertificateDB];

        if($trainingCertificateDB['template_id'] == 1) {
            $pdf = Pdf::loadView('admin.pdf.evidence_certificates', $data)->setPaper('a4', 'landscape');
        } elseif($trainingCertificateDB['template_id'] == 2) {
            $pdf = Pdf::loadView('admin.pdf.evidence_certificates_02', $data)->setPaper('a4', 'landscape');
        } elseif($trainingCertificateDB['template_id'] == 3) {
            $pdf = Pdf::loadView('admin.pdf.evidence_certificates_03', $data)->setPaper('a4', 'landscape');
        }

        Storage::disk('public')->makeDirectory('certificates/'.$trainingCertificateDB['training_participation_id']);

        $path = 'app/public/certificates/'.$trainingCertificateDB['training_participation_id'].'/certificado_'.strtr($trainingCertificateDB['training']['name'], [" " => "_", "ª" => "", "-"=> "", "/" => "_"]).'.pdf';

        if(Storage::exists('public/'.$path)) {
            Storage::delete('public/'.$path);
        }

        $pdf->save(storage_path($path));

        $trainingCertificateDB->update(['file' => $path]);

        return [
            'status' => 'success',
            'message' => 'Certificado gerado com sucesso!',
            'code' => 200
        ];
    }

}
