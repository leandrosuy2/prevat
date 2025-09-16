<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvidenceParticipation extends Model
{
    use HasFactory;

    protected $fillable = ['evidence_id', 'participant_id', 'note', 'presence'];

    public function evidence()
    {
        return $this->belongsTo(Evidence::class, 'evidence_id');
    }

    public function participant()
    {
        return $this->belongsTo(Participant::class, 'participant_id');
    }
}
