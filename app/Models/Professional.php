<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Professional extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'phone', 'document', 'registry', 'status', 'signature_image'];

    public function formations()
    {
        return $this->hasMany(ProfessionalsFormation::class, 'professional_id');
    }
}
