<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingLocation extends Model
{
    use HasFactory;

    protected $fillable = ['acronym', 'name', 'zip-code', 'address', 'number', 'neighborhood', 'complement', 'city', 'uf', 'status'];
}
