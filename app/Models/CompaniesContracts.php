<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompaniesContracts extends Model
{
    use HasFactory;

    protected $fillable = ['company_id', 'contractor_id', 'name', 'contract', 'default', 'status'];

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function contractor()
    {
        return $this->belongsTo(Company::class, 'contractor_id');
    }
}
