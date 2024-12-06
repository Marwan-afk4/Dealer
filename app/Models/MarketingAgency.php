<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarketingAgency extends Model
{
    use HasFactory;


    protected $fillable = [
        'name',
        'email',
        'phone',
        'start_date',
        'end_date',
        'image',
        'total_leads', 
    ];
}
