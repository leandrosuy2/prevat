<?php

namespace App\Repositories;

use App\Models\AuditLog;
use App\Models\CertificateReissue;
use App\Models\UserSession;
use App\Models\User;
use App\Models\Company;
use App\Models\TrainingCertificates;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AuditRepository
{
    public function getDashboardStats()
    {
        $now = now();
        $lastMonth = $now->subMonth();
        
        return [
            'total_users' => User::count(),
            'active_users' => UserSession::getActiveUsers()->count(),
            'pending_users' => User::where('status', 'Pendente')->count(),
            'total_companies' => Company::count(),
            'total_certificates' => TrainingCertificates::count(),
            'reissued_certificates' => CertificateReissue::count(),
            'suspicious_sessions' => UserSession::getSuspiciousSessions()->count(),
            'audit_logs_today' => AuditLog::whereDate('created_at', $now->toDateString())->count(),
            'audit_logs_month' => AuditLog::where('created_at', '>=', $lastMonth)->count(),
            'external_accesses' => UserSession::where('is_suspicious', true)
                ->where('created_at', '>=', $lastMonth)
                ->count()
        ];
    }

    public function getRecentActivities($limit = 20)
    {
        return AuditLog::with(['user', 'company'])
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    public function getCertificateReissues($filters = [], $pageSize = 15)
    {
        $query = CertificateReissue::with(['originalCertificate', 'reissuedBy', 'company']);

        if (isset($filters['company_id']) && $filters['company_id']) {
            $query->where('company_id', $filters['company_id']);
        }

        if (isset($filters['date_start']) && $filters['date_start']) {
            $query->where('created_at', '>=', $filters['date_start']);
        }

        if (isset($filters['date_end']) && $filters['date_end']) {
            $query->where('created_at', '<=', $filters['date_end']);
        }

        if (isset($filters['user_id']) && $filters['user_id']) {
            $query->where('reissued_by_user_id', $filters['user_id']);
        }

        return $query->orderBy('created_at', 'desc')->paginate($pageSize);
    }

    public function getSuspiciousAccesses($filters = [], $pageSize = 15)
    {
        $query = UserSession::with(['user', 'company'])
            ->where('is_suspicious', true);

        if (isset($filters['company_id']) && $filters['company_id']) {
            $query->where('company_id', $filters['company_id']);
        }

        if (isset($filters['date_start']) && $filters['date_start']) {
            $query->where('created_at', '>=', $filters['date_start']);
        }

        if (isset($filters['date_end']) && $filters['date_end']) {
            $query->where('created_at', '<=', $filters['date_end']);
        }

        if (isset($filters['ip_address']) && $filters['ip_address']) {
            $query->where('ip_address', 'LIKE', '%' . $filters['ip_address'] . '%');
        }

        return $query->orderBy('created_at', 'desc')->paginate($pageSize);
    }

    public function getUserAccessHistory($userId, $pageSize = 15)
    {
        return UserSession::where('user_id', $userId)
            ->with(['company'])
            ->orderBy('created_at', 'desc')
            ->paginate($pageSize);
    }

    public function getCompanyAuditLogs($companyId, $filters = [], $pageSize = 15)
    {
        $query = AuditLog::where('company_id', $companyId)
            ->with(['user']);

        if (isset($filters['action']) && $filters['action']) {
            $query->where('action', $filters['action']);
        }

        if (isset($filters['date_start']) && $filters['date_start']) {
            $query->where('created_at', '>=', $filters['date_start']);
        }

        if (isset($filters['date_end']) && $filters['date_end']) {
            $query->where('created_at', '<=', $filters['date_end']);
        }

        if (isset($filters['user_id']) && $filters['user_id']) {
            $query->where('user_id', $filters['user_id']);
        }

        return $query->orderBy('created_at', 'desc')->paginate($pageSize);
    }

    public function getAccessPatterns($companyId = null)
    {
        $query = UserSession::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('HOUR(created_at) as hour'),
            DB::raw('COUNT(*) as total_accesses'),
            DB::raw('COUNT(CASE WHEN is_suspicious = 1 THEN 1 END) as suspicious_accesses')
        );

        if ($companyId) {
            $query->where('company_id', $companyId);
        }

        return $query->groupBy('date', 'hour')
            ->orderBy('date', 'desc')
            ->orderBy('hour', 'asc')
            ->get();
    }

    public function getTopActions($companyId = null, $limit = 10)
    {
        $query = AuditLog::select(
            'action',
            DB::raw('COUNT(*) as total')
        );

        if ($companyId) {
            $query->where('company_id', $companyId);
        }

        return $query->groupBy('action')
            ->orderBy('total', 'desc')
            ->limit($limit)
            ->get();
    }

    public function getUsersByAccessLevel()
    {
        return User::select(
            'users.id',
            'users.name',
            'users.email',
            'users.status',
            'companies.name as company_name',
            'roles.name as role_name',
            DB::raw('COUNT(user_sessions.id) as total_logins'),
            DB::raw('COUNT(CASE WHEN user_sessions.is_suspicious = 1 THEN 1 END) as suspicious_logins'),
            DB::raw('MAX(user_sessions.last_activity) as last_activity')
        )
        ->leftJoin('companies', 'users.company_id', '=', 'companies.id')
        ->leftJoin('roles', 'users.role_id', '=', 'roles.id')
        ->leftJoin('user_sessions', 'users.id', '=', 'user_sessions.user_id')
        ->groupBy('users.id', 'users.name', 'users.email', 'users.status', 'companies.name', 'roles.name')
        ->orderBy('total_logins', 'desc')
        ->get();
    }

    public function getSecurityAlerts()
    {
        $alerts = [];

        // Usuários com muitos acessos suspeitos
        $suspiciousUsers = UserSession::select(
            'user_id',
            DB::raw('COUNT(*) as suspicious_count')
        )
        ->where('is_suspicious', true)
        ->where('created_at', '>=', now()->subDays(7))
        ->groupBy('user_id')
        ->having('suspicious_count', '>', 3)
        ->with(['user'])
        ->get();

        foreach ($suspiciousUsers as $suspicious) {
            $alerts[] = [
                'type' => 'warning',
                'title' => 'Múltiplos Acessos Suspeitos',
                'message' => "Usuário {$suspicious->user->name} teve {$suspicious->suspicious_count} acessos suspeitos na última semana",
                'user_id' => $suspicious->user_id,
                'created_at' => now()
            ];
        }

        // Acessos fora do horário comercial
        $afterHoursAccess = UserSession::where('is_suspicious', true)
            ->where('created_at', '>=', now()->subDays(1))
            ->where('created_at', '>=', now()->setTime(18, 0))
            ->orWhere('created_at', '<=', now()->setTime(8, 0))
            ->with(['user'])
            ->get();

        foreach ($afterHoursAccess as $access) {
            $alerts[] = [
                'type' => 'info',
                'title' => 'Acesso Fora do Horário Comercial',
                'message' => "Usuário {$access->user->name} acessou às " . $access->created_at->format('H:i'),
                'user_id' => $access->user_id,
                'created_at' => $access->created_at
            ];
        }

        // Acessos de IPs externos
        $externalIPAccess = UserSession::where('is_suspicious', true)
            ->where('created_at', '>=', now()->subDays(1))
            ->where('location', '!=', 'Rede Interna')
            ->where('location', '!=', 'Local')
            ->with(['user'])
            ->get();

        foreach ($externalIPAccess as $access) {
            $alerts[] = [
                'type' => 'danger',
                'title' => 'Acesso de IP Externo',
                'message' => "Usuário {$access->user->name} acessou de {$access->location}",
                'user_id' => $access->user_id,
                'created_at' => $access->created_at
            ];
        }

        return collect($alerts)->sortByDesc('created_at')->values();
    }
}
