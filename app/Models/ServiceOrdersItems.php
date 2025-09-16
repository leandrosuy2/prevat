<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceOrdersItems extends Model
{
    use HasFactory;

    protected $fillable = ['service_order_id', 'schedule_company_id', 'quantity', 'value', 'total_value'];

    public function service_order()
    {
        return $this->belongsTo(ServiceOrder::class, 'service_order_id');
    }

    public function schedule_company()
    {
        return $this->belongsTo(ScheduleCompany::class, 'schedule_company_id');
    }

}
