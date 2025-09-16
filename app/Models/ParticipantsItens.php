<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParticipantsItens extends Model
{
    use HasFactory;

    protected $fillable = ['training_participation_id', 'participant_id', 'name', 'company_id', 'quantity', 'value', 'total_value', 'note', 'table_color', 'status', 'registry', 'presence'];
}
