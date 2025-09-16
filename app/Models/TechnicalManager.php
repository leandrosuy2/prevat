<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TechnicalManager extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'registry', 'email', 'phone', 'document', 'formation', 'signature_image', 'status'];
}
