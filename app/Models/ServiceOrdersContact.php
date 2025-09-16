<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class ServiceOrdersContact extends Model
{
    use HasFactory;
    use Notifiable;

    protected $fillable = ['service_order_id', 'type', 'name', 'fantasy_name', 'responsible', 'employer_number', 'contact_name', 'taxpayer_registration', 'zip_code', 'address', 'number',  'complement', 'neighborhood', 'city',
        'uf', 'phone', 'email', 'observations'
    ];

    public function order()
    {
        return $this->belongsTo(ServiceOrder::class, 'service_order_id');
    }
}
