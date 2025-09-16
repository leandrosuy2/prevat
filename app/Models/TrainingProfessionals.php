<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingProfessionals extends Model
{
    use HasFactory;

    protected $fillable = ['training_participation_id', 'professional_id', 'professional_formation_id', 'front', 'verse'];
    protected $casts = [
        'front' => 'bool',
        'verse' => 'bool',
    ];

    public function training_participation()
    {
        return $this->belongsTo(TrainingParticipations::class, 'training_participation_id');
    }

    public function professional()
    {
        return $this->belongsTo(Professional::class, 'professional_id');
    }

    public function formation()
    {
        return $this->belongsTo(ProfessionalQualifications::class, 'professional_formation_id');
    }
}
