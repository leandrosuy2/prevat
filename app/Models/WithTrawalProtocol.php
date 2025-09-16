<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WithTrawalProtocol extends Model
{
    use HasFactory;

    protected $fillable = ['company_id', 'contract_id', 'training_participation_id', 'reference', 'name', 'document'];

    public function training_participation()
    {
        return $this->belongsTo(TrainingParticipations::class, 'training_participation_id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function contract()
    {
        return $this->belongsTo(CompaniesContracts::class, 'contract_id');
    }
}
