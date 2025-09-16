<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class AuditLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'action',
        'description',
        'ip_address',
        'user_agent',
        'target_type',
        'target_id',
        'old_values',
        'new_values',
        'company_id',
        'contract_id',
        'location',
        'session_id'
    ];

    protected $casts = [
        'old_values' => 'array',
        'new_values' => 'array',
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

    // Método estático para registrar logs de auditoria
    public static function log($action, $description = null, $targetType = null, $targetId = null, $oldValues = null, $newValues = null)
    {
        $user = Auth::user();
        
        return self::create([
            'user_id' => $user ? $user->id : null,
            'action' => $action,
            'description' => $description,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'target_type' => $targetType,
            'target_id' => $targetId,
            'old_values' => $oldValues,
            'new_values' => $newValues,
            'company_id' => $user ? $user->company_id : null,
            'contract_id' => $user ? $user->contract_id : null,
            'location' => self::getLocationInfo(),
            'session_id' => session()->getId()
        ]);
    }

    // Obter informações de localização
    private static function getLocationInfo()
    {
        $ip = request()->ip();
        
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

    // Verificar se o acesso é suspeito (fora do horário comercial ou localização diferente)
    public static function isSuspiciousAccess($userId)
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
        $ip = request()->ip();
        $isExternalIP = filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE);
        
        return !$isBusinessHours || $isWeekend || $isExternalIP;
    }
}
