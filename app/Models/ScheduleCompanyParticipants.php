<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScheduleCompanyParticipants extends Model
{
    use HasFactory;

    protected $fillable = ['schedule_company_id', 'participant_id', 'presence', 'quantity', 'value', 'total_value'];

    protected $casts = [
        'presence' => 'bool',
    ];

    public function schedule_company()
    {
        return $this->belongsTo(ScheduleCompany::class, 'schedule_company_id');
    }

    public function participant()
    {
        return $this->belongsTo(Participant::class, 'participant_id');
    }

    public function participant_allscope()
    {
        return $this->belongsTo(Participant::class, 'participant_id')->withoutGlobalScopes();
    }
}
