<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgendaEmpresa extends Model
{
    use HasFactory;
    protected $fillable = ['schedule_prevat_id', 'company_id', 'participant_id', 'name', 'status'];

}
