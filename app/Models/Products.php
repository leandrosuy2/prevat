<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;

    protected $fillable = ['category_id', 'name', 'description', 'type' ,'time', 'image', 'status'];

    public function category()
    {
        return $this->belongsTo(ProductCategories::class, 'category_id');
    }
}
