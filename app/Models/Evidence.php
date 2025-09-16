<?php

namespace App\Models;

use App\Trait\CompanyTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evidence extends Model
{
    use HasFactory, CompanyTrait;

    protected $fillable = ['reference', 'company_id', 'training_id', 'contract_id', 'training_participation_id' ,'date', 'file_path', 'status'];

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function training()
    {
        return $this->belongsTo(Training::class, 'training_id');
    }

    public function training_participation()
    {
        return $this->belongsTo(TrainingParticipations::class, 'training_participation_id');
    }

    public function participants()
    {
        return $this->hasMany(EvidenceParticipation::class, 'evidence_id');
    }

    public function historics()
    {
        return $this->hasMany(EvidenceDownloadHistorics::class, 'evidence_id');
    }
}
