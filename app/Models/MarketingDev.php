<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MarketingDev extends Model
{

    protected $fillable = [
        'developer_id',
        'name',
        'phone',
        'place',
        'start_date',
        'end_date',
    ];
}
