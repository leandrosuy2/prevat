<?php

namespace App\Models;

use App\Trait\CompanyTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class TrainingParticipants extends Model
{
    use HasFactory;

    protected $fillable = ['training_participation_id', 'participant_id', 'company_id', 'contract_id', 'quantity', 'value', 'total_value', 'note', 'table_color', 'registry', 'presence', 'status'];

    protected $casts = [
        'presence' => 'bool',
    ];

    protected static function boot() {
        parent::boot();
        static::creating(function ($model) {
            $model->uuid = (string)Str::uuid();
        });
    }

    public function training_participation()
    {
        return $this->belongsTo(TrainingParticipations::class, 'training_participation_id');
    }

    public function participant()
    {
        return $this->belongsTo(Participant::class, 'participant_id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function certificate()
    {
        return $this->hasOne(TrainingCertificates::class, 'training_participant_id');
    }

    public function contract()
    {
        return $this->belongsTo(CompaniesContracts::class, 'contract_id');
    }
}
