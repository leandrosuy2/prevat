<?php

namespace App\Models;

use App\Trait\CompanyTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchedulePrevat extends Model
{
    use HasFactory, CompanyTrait;

    protected $fillable = ['reference', 'training_id', 'workload_id', 'training_room_id', 'training_local_id', 'time01_id', 'time02_id', 'team_id', 'contractor_id', 'company_id', 'date_event', 'start_event',
        'end_event', 'days', 'vacancies', 'vacancies_available', 'vacancies_occupied', 'absences', 'file_presence', 'file_programmatic', 'status', 'type'];

    public function training()
    {
        return $this->belongsTo(Training::class, 'training_id');
    }

    public function workload()
    {
        return $this->belongsTo(WorkLoad::class, 'workload_id');
    }

    public function location()
    {
        return $this->belongsTo(TrainingLocation::class, 'training_local_id');
    }

    public function room()
    {
        return $this->belongsTo(TrainingRoom::class, 'training_room_id');
    }
    public function first_time()
    {
        return $this->belongsTo(Time::class, 'time01_id');
    }
    public function second_time()
    {
        return $this->belongsTo(Time::class, 'time02_id');
    }
    public function team()
    {
        return $this->belongsTo(TrainingTeam::class, 'team_id');
    }

    public function contractor()
    {
        return $this->belongsTo(Company::class, 'contractor_id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function scheduleCompanies()
    {
        return $this->hasMany(ScheduleCompany::class, 'schedule_prevat_id');
    }
}
