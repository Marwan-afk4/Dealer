<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Developer extends Model
{


    protected $fillable = [
        'name',
        'email',
        'place',
        'units',
        'total_deals',
        'deals_done',
    ];
}
