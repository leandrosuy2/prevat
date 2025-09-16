<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfessionalsFormation extends Model
{
    use HasFactory;

    protected $fillable = ['qualification_id', 'professional_id'];

    public function qualification()
    {
        return $this->belongsTo(ProfessionalQualifications::class, 'qualification_id');
    }

    public function professional()
    {
        return $this->belongsTo(Professional::class, 'professional_id');
    }
}
