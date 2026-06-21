<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'category_ids',
        'brand_id',
        'title',
        'slug',
        'sku',
        'short_description',
        'description',
        'pros',
        'cons',
        'featured_image',
        'gallery',

        'regular_price',
        'sale_price',
        'coupon',
        'rating',
        'review_count',
        'view_count',
        'click_count',

        'affiliate_url',
        'affiliate_network',
        'commission_rate',

        'allow_compare',
        'featured',
        'trending',
        'best_seller',
        'editors_choice',
        'status',

        'meta_title',
        'meta_description',
        'meta_keywords',
        'canonical_url',
    ];

    protected $casts = [
        'category_ids' => 'array',
    ];

    /*public function category()
    {
        return $this->belongsTo(Category::class);
    }*/
    public function category()
    {
        return Category::whereIn('id', $this->category_ids ?? [])->get();
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
        return $this->hasMany(ProductReview::class)->where('approved', 1);
    }
    public function faqs()
    {
        return $this->hasMany(ProductFaq::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }
}
