<?php

namespace App\Models;

use App\Trait\CompanyTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceOrder extends Model
{
    use HasFactory, CompanyTrait;

    protected $fillable = ['reference', 'user_id', 'company_id', 'contract_id', 'payment_method_id', 'status_id', 'total_releases', 'total_value',
        'total_fees', 'total_discounts', 'percentage_discount', 'due_date', 'observations', 'os_path', 'participants_path'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function contract()
    {
        return $this->belongsTo(CompaniesContracts::class, 'contract_id');
    }

    public function contact()
    {
        return $this->hasOne(ServiceOrdersContact::class, 'service_order_id');
    }

    public function payment()
    {
        return $this->belongsTo(PaymentMethod::class, 'payment_method_id');
    }

    public function releases()
    {
      return $this->hasMany(ServiceOrdersItems::class, 'service_order_id');
    }

    public function status()
    {
        return $this->belongsTo(ServiceOrderStatus::class, 'status_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
