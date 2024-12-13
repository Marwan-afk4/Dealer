<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{


    protected $fillable = [
        'name',
        'count_of_leads',
        'period_in_days',
        'price',
        'discount_type',
        'discount_value',
        'price_after_discount'
    ];

}
