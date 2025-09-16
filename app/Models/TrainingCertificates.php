<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class TrainingCertificates extends Model
{
    use HasFactory;

    protected $fillable = ['reference', 'training_participant_id', 'training_participation_id', 'company_id', 'training_id', 'participant_id', 'note', 'registry', 'year', 'file',
        'path_qrcode', 'uuid'];

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

    public function training_participant()
    {
        return $this->belongsTo(TrainingParticipants::class, 'training_participant_id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id')->withoutGlobalScopes();
    }

    public function training()
    {
        return $this->belongsTo(Training::class, 'training_id');
    }

    public function participant()
    {
        return $this->belongsTo(Participant::class, 'participant_id');
    }
}
