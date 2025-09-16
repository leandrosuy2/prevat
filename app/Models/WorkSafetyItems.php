<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkSafetyItems extends Model
{
    use HasFactory;

    protected $fillable = ['work_safety_id', 'safety_category_id', 'safety_item_id', 'responsible_plan', 'action_plan', 'date_execution', 'yes', 'not', 'na'];

    protected $casts = [
        'yes' => 'bool',
        'not' => 'bool',
        'na' => 'bool',
    ];

    public function worksafety()
    {
        return $this->belongsTo(WorkSafety::class, 'work_safety_id');
    }

    public function category()
    {
        return $this->belongsTo(SafetyCategories::class, 'safety_category_id');
    }

    public function item()
    {
        return $this->belongsTo(SafetyItems::class, 'safety_item_id');
    }
}
