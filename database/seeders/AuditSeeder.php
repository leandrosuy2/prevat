<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AuditLog;
use App\Models\UserSession;
use App\Models\CertificateReissue;
use App\Models\User;
use App\Models\Company;
use App\Models\TrainingCertificates;
use Carbon\Carbon;

class AuditSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Populando tabelas de auditoria...');

        // Criar logs de auditoria de exemplo
        $this->createSampleAuditLogs();

        // Criar sessões de usuário de exemplo
        $this->createSampleUserSessions();

        // Criar logs de segunda via de exemplo
        $this->createSampleCertificateReissues();

        $this->command->info('Tabelas de auditoria populadas com sucesso!');
    }

    private function createSampleAuditLogs()
    {
        $actions = [
            'login_success' => 'Acesso ao sistema realizado',
            'logout' => 'Saída do sistema realizada',
            'user_created' => 'Novo usuário foi cadastrado',
            'user_updated' => 'Dados do usuário foram modificados',
            'certificate_generated' => 'Novo certificado foi criado',
            'certificate_downloaded' => 'Certificado foi transferido',
            'training_scheduled' => 'Nova data de treinamento foi definida',
            'participant_registered' => 'Nova pessoa foi inscrita'
        ];

        $users = User::take(5)->get();
        $companies = Company::take(3)->get();

        foreach (range(1, 50) as $i) {
            $action = array_rand($actions);
            $user = $users->random();
            $company = $companies->random();

            AuditLog::create([
                'user_id' => $user->id,
                'action' => $action,
                'description' => $actions[$action],
                'ip_address' => $this->getRandomIP(),
                'user_agent' => $this->getRandomUserAgent(),
                'target_type' => $this->getTargetType($action),
                'target_id' => rand(1, 100),
                'company_id' => $company->id,
                'contract_id' => $company->contract_id ?? null,
                'location' => $this->getRandomLocation(),
                'session_id' => 'session_' . $i,
                'created_at' => Carbon::now()->subDays(rand(0, 30))->subHours(rand(0, 23))
            ]);
        }
    }

    private function createSampleUserSessions()
    {
        $users = User::take(10)->get();
        $companies = Company::take(3)->get();

        foreach ($users as $user) {
            $company = $companies->random();
            
            // Criar múltiplas sessões para cada usuário
            foreach (range(1, rand(3, 8)) as $i) {
                $loginAt = Carbon::now()->subDays(rand(0, 30))->subHours(rand(0, 23));
                $isSuspicious = rand(0, 10) > 7; // 30% de chance de ser suspeito

                UserSession::create([
                    'user_id' => $user->id,
                    'session_id' => 'session_' . $user->id . '_' . $i,
                    'ip_address' => $this->getRandomIP(),
                    'user_agent' => $this->getRandomUserAgent(),
                    'location' => $this->getRandomLocation(),
                    'login_at' => $loginAt,
                    'logout_at' => $isSuspicious ? null : $loginAt->addHours(rand(1, 8)),
                    'last_activity' => $isSuspicious ? $loginAt->addHours(rand(1, 4)) : null,
                    'company_id' => $company->id,
                    'contract_id' => $company->contract_id ?? null,
                    'is_suspicious' => $isSuspicious,
                    'suspicious_reason' => $isSuspicious ? $this->getRandomSuspiciousReason() : null,
                    'created_at' => $loginAt
                ]);
            }
        }
    }

    private function createSampleCertificateReissues()
    {
        $users = User::take(5)->get();
        $companies = Company::take(3)->get();
        $certificates = TrainingCertificates::take(10)->get();

        if ($certificates->count() > 0) {
            foreach (range(1, 20) as $i) {
                $user = $users->random();
                $company = $companies->random();
                $certificate = $certificates->random();

                CertificateReissue::create([
                    'original_certificate_id' => $certificate->id,
                    'reissued_by_user_id' => $user->id,
                    'reason' => $this->getRandomReissueReason(),
                    'ip_address' => $this->getRandomIP(),
                    'user_agent' => $this->getRandomUserAgent(),
                    'company_id' => $company->id,
                    'contract_id' => $company->contract_id ?? null,
                    'status' => 'completed',
                    'notes' => 'Segunda via solicitada pelo usuário',
                    'created_at' => Carbon::now()->subDays(rand(0, 60))
                ]);
            }
        }
    }

    private function getRandomIP()
    {
        $ips = [
            '192.168.1.' . rand(1, 254),
            '10.0.0.' . rand(1, 254),
            '172.16.' . rand(0, 31) . '.' . rand(1, 254),
            '200.150.100.' . rand(1, 254),
            '189.120.80.' . rand(1, 254)
        ];

        return $ips[array_rand($ips)];
    }

    private function getRandomUserAgent()
    {
        $agents = [
            'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
            'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36',
            'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36',
            'Mozilla/5.0 (iPhone; CPU iPhone OS 14_7_1 like Mac OS X) AppleWebKit/605.1.15'
        ];

        return $agents[array_rand($agents)];
    }

    private function getRandomLocation()
    {
        $locations = [
            'Local',
            'Rede Interna',
            'São Paulo, Brasil',
            'Rio de Janeiro, Brasil',
            'Belo Horizonte, Brasil',
            'Curitiba, Brasil',
            'Porto Alegre, Brasil'
        ];

        return $locations[array_rand($locations)];
    }

    private function getTargetType($action)
    {
        $types = [
            'login_success' => 'Auth',
            'logout' => 'Auth',
            'user_created' => 'User',
            'user_updated' => 'User',
            'certificate_generated' => 'TrainingCertificate',
            'certificate_downloaded' => 'TrainingCertificate',
            'training_scheduled' => 'Training',
            'participant_registered' => 'Participant'
        ];

        return $types[$action] ?? 'System';
    }

    private function getRandomSuspiciousReason()
    {
        $reasons = [
            'Fora do horário comercial',
            'Fim de semana',
            'IP externo',
            'Fora do horário comercial, IP externo',
            'Fim de semana, IP externo'
        ];

        return $reasons[array_rand($reasons)];
    }

    private function getRandomReissueReason()
    {
        $reasons = [
            'Certificado perdido',
            'Certificado danificado',
            'Erro na impressão',
            'Dados incorretos',
            'Solicitação do usuário'
        ];

        return $reasons[array_rand($reasons)];
    }
}
