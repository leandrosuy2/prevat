<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsersContracts extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'contract_id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function contract()
    {
        return $this->belongsTo(CompaniesContracts::class, 'contract_id');
    }
}
