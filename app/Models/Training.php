<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Training extends Model
{
    use HasFactory;

    protected $fillable = ['category_id', 'technical_id', 'acronym', 'name', 'value', 'description','content_title', 'content', 'content02', 'status', 'image'];

    public function category()
    {
        return $this->belongsTo(TrainingsCategory::class, 'category_id');
    }

    public function technical()
    {
        return $this->belongsTo(TechnicalManager::class, 'technical_id');
    }
}
