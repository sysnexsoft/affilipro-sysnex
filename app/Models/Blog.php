<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;
    protected $fillable = [
        'title', 'slug', 'description', 'thumbnail', 'category_id',
        'views', 'featured', 'status', 'meta_title', 'meta_description',
        'meta_keywords', 'canonical_url','product_ids','affiliate_url','affiliate_source'
    ];
    protected $casts = [
        'product_ids' => 'array',
    ];
    // প্রতিটি ব্লগ একটি ক্যাটাগরির সাথে যুক্ত
    public function category()
    {
        return $this->belongsTo(BlogCategory::class, 'category_id')->withDefault([
            'name' => 'Uncategorized'
        ]);
    }
    public function seo()
    {
        return $this->morphOne(SeoManagement::class, 'model', 'model_type', 'model_id');
    }

    protected static function booted()
    {
        static::deleting(function ($blog) {
            $blog->seo()->delete();
        });
    }
}
