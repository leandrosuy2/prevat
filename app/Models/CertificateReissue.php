<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class CertificateReissue extends Model
{
    use HasFactory;

    protected $fillable = [
        'original_certificate_id',
        'reissued_by_user_id',
        'reason',
        'ip_address',
        'user_agent',
        'company_id',
        'contract_id',
        'status',
        'notes'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    public function originalCertificate()
    {
        return $this->belongsTo(TrainingCertificates::class, 'original_certificate_id');
    }

    public function reissuedBy()
    {
        return $this->belongsTo(User::class, 'reissued_by_user_id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function contract()
    {
        return $this->belongsTo(CompaniesContracts::class, 'contract_id');
    }

    // Método estático para registrar segunda via
    public static function recordReissue($originalCertificateId, $reason = null, $notes = null)
    {
        $user = Auth::user();
        
        return self::create([
            'original_certificate_id' => $originalCertificateId,
            'reissued_by_user_id' => $user ? $user->id : null,
            'reason' => $reason,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'company_id' => $user ? $user->company_id : null,
            'contract_id' => $user ? $user->contract_id : null,
            'status' => 'completed',
            'notes' => $notes
        ]);
    }
}
