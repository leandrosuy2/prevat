<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class UserSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'session_id',
        'ip_address',
        'user_agent',
        'location',
        'login_at',
        'logout_at',
        'last_activity',
        'company_id',
        'contract_id',
        'is_suspicious',
        'suspicious_reason'
    ];

    protected $casts = [
        'login_at' => 'datetime',
        'logout_at' => 'datetime',
        'last_activity' => 'datetime',
        'is_suspicious' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function contract()
    {
        return $this->belongsTo(CompaniesContracts::class, 'contract_id');
    }

    // Método estático para registrar login
    public static function recordLogin($userId)
    {
        $user = User::find($userId);
        if (!$user) return null;

        $ip = request()->ip();
        $location = self::getLocationInfo($ip);
        $isSuspicious = self::isSuspiciousAccess($userId, $ip);

        return self::create([
            'user_id' => $userId,
            'session_id' => session()->getId(),
            'ip_address' => $ip,
            'user_agent' => request()->userAgent(),
            'location' => $location,
            'login_at' => now(),
            'last_activity' => now(),
            'company_id' => $user->company_id,
            'contract_id' => $user->contract_id,
            'is_suspicious' => $isSuspicious,
            'suspicious_reason' => $isSuspicious ? self::getSuspiciousReason($userId, $ip) : null
        ]);
    }

    // Método estático para registrar logout
    public static function recordLogout($userId)
    {
        $session = self::where('user_id', $userId)
            ->where('session_id', session()->getId())
            ->whereNull('logout_at')
            ->first();

        if ($session) {
            $session->update([
                'logout_at' => now()
            ]);
        }
    }

    // Método estático para atualizar última atividade
    public static function updateLastActivity($userId)
    {
        $session = self::where('user_id', $userId)
            ->where('session_id', session()->getId())
            ->whereNull('logout_at')
            ->first();

        if ($session) {
            $session->update([
                'last_activity' => now()
            ]);
        }
    }

    // Obter informações de localização
    private static function getLocationInfo($ip)
    {
        // Para IPs locais, retornar "Local"
        if (in_array($ip, ['127.0.0.1', '::1', 'localhost'])) {
            return 'Local';
        }

        // Para IPs privados, retornar "Rede Interna"
        if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) === false) {
            return 'Rede Interna';
        }

        // Para IPs externos, tentar obter informações de geolocalização
        try {
            $geoData = file_get_contents("http://ip-api.com/json/{$ip}");
            if ($geoData) {
                $geoInfo = json_decode($geoData, true);
                if ($geoInfo && $geoInfo['status'] === 'success') {
                    return $geoInfo['city'] . ', ' . $geoInfo['country'];
                }
            }
        } catch (\Exception $e) {
            // Em caso de erro, retornar apenas o IP
        }

        return $ip;
    }

    // Verificar se o acesso é suspeito
    private static function isSuspiciousAccess($userId, $ip)
    {
        $user = User::find($userId);
        if (!$user) return false;

        $now = now();
        $hour = (int) $now->format('H');
        
        // Horário comercial: 8h às 18h
        $isBusinessHours = $hour >= 8 && $hour <= 18;
        
        // Verificar se é fim de semana
        $isWeekend = $now->isWeekend();
        
        // Verificar se o IP é externo
        $isExternalIP = filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE);
        
        return !$isBusinessHours || $isWeekend || $isExternalIP;
    }

    // Obter razão para acesso suspeito
    private static function getSuspiciousReason($userId, $ip)
    {
        $reasons = [];
        $now = now();
        $hour = (int) $now->format('H');

        if ($hour < 8 || $hour > 18) {
            $reasons[] = 'Fora do horário comercial';
        }

        if ($now->isWeekend()) {
            $reasons[] = 'Fim de semana';
        }

        if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
            $reasons[] = 'IP externo';
        }

        return implode(', ', $reasons);
    }

    // Obter usuários atualmente logados
    public static function getActiveUsers()
    {
        return self::whereNull('logout_at')
            ->where('last_activity', '>=', now()->subMinutes(30))
            ->with(['user', 'company'])
            ->get();
    }

    // Obter sessões suspeitas
    public static function getSuspiciousSessions()
    {
        return self::where('is_suspicious', true)
            ->with(['user', 'company'])
            ->orderBy('created_at', 'desc')
            ->get();
    }
}
