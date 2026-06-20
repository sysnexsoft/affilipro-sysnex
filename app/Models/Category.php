<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'slug',
        'description',
        'parent_id',
        'icon',
        'position',
        'featured',
        'image',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'status'
    ];
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function childrenRecursive()
    {
        return $this->children()->with('childrenRecursive');
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }
    public function comparisonFields()
    {
        return $this->belongsToMany(ComparisonField::class, 'category_comparison_fields');
    }
}
