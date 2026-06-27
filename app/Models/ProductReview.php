<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductReview extends Model
{
    use HasFactory;

    // আপনার স্কিমা অনুযায়ী fillable প্রপার্টিজ
    protected $fillable = ['product_id', 'name', 'email', 'rating', 'review', 'approved' , 'helpful'];

    // প্রোডাক্ট টেবিলের সাথে রিলেশন (যদি প্রোডাক্ট মডেল অলরেডি থাকে)
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id')->withDefault([
            'name' => 'Unknown Product'
        ]);
    }
}
