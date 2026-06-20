<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClickLog extends Model
{
    use HasFactory;
    protected $fillable = ['url', 'ip_address', 'country', 'device', 'browser', 'referrer'];
}
