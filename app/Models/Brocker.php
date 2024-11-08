<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brocker extends Model
{

    protected $fillable=[
        'user_id',
        'profit',
        'number_of_deals'
    ];
}
