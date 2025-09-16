<?php

namespace App\Console\Commands;

use App\Models\AuditLog;
use App\Models\UserSession;
use Illuminate\Console\Command;
use Carbon\Carbon;

class CleanAuditLogs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'audit:clean {--days=90 : Número de dias para manter os logs}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Limpar logs de auditoria antigos';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $days = (int) $this->option('days');
        $cutoffDate = Carbon::now()->subDays($days);

        $this->info("Iniciando limpeza de logs de auditoria...");
        $this->info("Mantendo logs dos últimos {$days} dias...");

        // Limpar logs de auditoria antigos
        $auditLogsDeleted = AuditLog::where('created_at', '<', $cutoffDate)->delete();
        $this->info("Logs de auditoria deletados: {$auditLogsDeleted}");

        // Limpar sessões antigas
        $sessionsDeleted = UserSession::where('created_at', '<', $cutoffDate)->delete();
        $this->info("Sessões antigas deletadas: {$sessionsDeleted}");

        // Limpar logs de segunda via antigos
        $reissuesDeleted = \App\Models\CertificateReissue::where('created_at', '<', $cutoffDate)->delete();
        $this->info("Logs de segunda via deletados: {$reissuesDeleted}");

        $totalDeleted = $auditLogsDeleted + $sessionsDeleted + $reissuesDeleted;
        
        $this->info("Limpeza concluída!");
        $this->info("Total de registros deletados: {$totalDeleted}");

        return 0;
    }
}
