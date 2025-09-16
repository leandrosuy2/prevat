<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkSafety extends Model
{
    use HasFactory;

    public $fillable = ['reference', 'company_id', 'zip_code',
        'address', 'number', 'complement', 'neighborhood',
        'city', 'uf', 'date', 'time', 'observations'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }
}
