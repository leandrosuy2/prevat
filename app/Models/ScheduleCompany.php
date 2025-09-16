<?php

namespace App\Models;

use App\Trait\CompanyTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScheduleCompany extends Model
{
    use HasFactory, CompanyTrait;

    protected $fillable = ['reference', 'schedule_prevat_id', 'company_id', 'contract_id', 'total_participants', 'price', 'price_total', 'status', 'invoiced'];


    public function schedule()
    {
        return $this->belongsTo(SchedulePrevat::class, 'schedule_prevat_id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function participants()
    {
        return $this->hasMany(ScheduleCompanyParticipants::class, 'schedule_company_id');
    }

    public function participantsPresent()
    {
        return $this->hasMany(ScheduleCompanyParticipants::class, 'schedule_company_id')->where('presence', 1);
    }

    public function participantsAusent()
    {
        return $this->hasMany(ScheduleCompanyParticipants::class, 'schedule_company_id')->where('presence', 0);
    }

    public function contract()
    {
        return $this->belongsTo(CompaniesContracts::class, 'contract_id');
    }
}
