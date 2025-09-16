<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['contract', 'contract_id', 'user_id', 'fantasy_name', 'name', 'email', 'phone', 'employer_number', 'zip_code', 'address', 'number',
        'complement', 'neighborhood', 'city', 'uf', 'status', 'type', 'suggestion_contract'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function contract_default()
    {
        return $this->belongsTo(CompaniesContracts::class, 'contract_id');
    }
    public function contracts()
    {
        return $this->hasMany(CompaniesContracts::class, 'company_id');
    }
    public function participants()
    {
        return $this->hasMany(Participant::class, 'company_id');
    }
}
