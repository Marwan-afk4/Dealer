<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Commission extends Model
{


    protected $fillable = [
        'brocker_id',
        'developer_id',
        'uptown_id',
        'commission',
    ];
}
