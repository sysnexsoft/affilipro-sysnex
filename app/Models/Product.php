<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [

        'category_id',
        'brand_id',
        'title',
        'slug',
        'short_description',
        'description',
        'pros',
        'cons',
        'featured_image',
        'regular_price',
        'sale_price',
        'affiliate_url',
        'affiliate_network',
        'featured',
        'trending',
        'best_seller',
        'editors_choice',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'status'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function specifications()
    {
        return $this->hasMany(ProductSpecification::class);
    }

    public function reviews()
    {
        return $this->hasMany(ProductReview::class)
            ->where('approved',1);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }
}
