<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComparisonField extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'slug'];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_comparison_fields');
    }
    public function products()
    {
        return $this->belongsToMany(Product::class, 'comparison_field_products')
            ->withPivot('value')
            ->withTimestamps();
    }
}
