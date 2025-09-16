<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contractors extends Model
{
    use HasFactory;

    protected $fillable = ['contract','name', 'employer_number', 'email', 'phone', 'zip_code', 'address', 'number', 'complement', 'neighborhood', 'city', 'uf', 'status', 'description'];
}
