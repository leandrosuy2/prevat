<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvidenceDownloadHistorics extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'evidence_id', 'training_participation_id'];

    public function evidence()
    {
        return $this->belongsTo(Evidence::class, 'evidence_id');
    }

    public function training_participation()
    {
        return $this->belongsTo(TrainingParticipations::class, 'training_participation_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
