<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingParticipations extends Model
{
    use HasFactory;

    protected $fillable = ['schedule_prevat_id', 'training_id', 'training_location_id', 'training_room_id',
        'workload_id', 'date_event', 'start_event', 'end_event', 'time01_id', 'time02_id', 'template_id',
        'file', 'file_programmatic', 'status', 'evidences'];

    public function schedule_prevat()
    {
        return $this->belongsTo(SchedulePrevat::class, 'schedule_prevat_id');
    }

    public function training()
    {
        return $this->belongsTo(Training::class, 'training_id');
    }

    public function location()
    {
        return $this->belongsTo(TrainingLocation::class, 'training_location_id');
    }

    public function room()
    {
        return $this->belongsTo(TrainingRoom::class, 'training_room_id');
    }

    public function workload()
    {
        return $this->belongsTo(WorkLoad::class, 'workload_id');
    }

    public function time01()
    {
        return $this->belongsTo(Time::class, 'time01_id');
    }

    public function time02()
    {
        return $this->belongsTo(Time::class, 'time02_id');
    }

    public function professionals()
    {
        return $this->hasMany(TrainingProfessionals::class, 'training_participation_id');
    }

    public function participants()
    {
        return $this->hasMany(TrainingParticipants::class,'training_participation_id');
    }

    public function template()
    {
        return $this->belongsTo(TemplateCertifications::class, 'template_id');
    }


}
