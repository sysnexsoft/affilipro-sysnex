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
        'meta_keywords', 'canonical_url'
    ];

    // প্রতিটি ব্লগ একটি ক্যাটাগরির সাথে যুক্ত
    public function category()
    {
        return $this->belongsTo(BlogCategory::class, 'category_id')->withDefault([
            'name' => 'Uncategorized'
        ]);
    }
}
