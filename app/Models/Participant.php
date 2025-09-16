<?php

namespace App\Models;

use App\Trait\CompanyTrait;
use App\Trait\ContractTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    use HasFactory, CompanyTrait;

    protected $fillable = ['company_id', 'contract_id', 'participant_role_id', 'name', 'email', 'identity_registration', 'contract', 'taxpayer_registration', 'driving_license', 'status', 'signature_image'];

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function role()
    {
        return $this->belongsTo(ParticipantRole::class,'participant_role_id');
    }

    public function contract()
    {
        return $this->belongsTo(CompaniesContracts::class, 'contract_id');
    }
}
