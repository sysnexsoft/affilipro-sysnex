<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PageSetting extends Model
{
    use HasFactory;
    protected $fillable = [
        'privacy_policy',
        'terms_conditions',
        'disclosure',
        'affiliate_disclosure',
        'disclaimer',
        'about_us',
        'contact_info',
        'cookie_policy'
    ];
    protected $casts = [ 'about_us' => 'array' ];
}
