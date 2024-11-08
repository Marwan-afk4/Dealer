<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{


    protected $fillable = [
        'developer_id',
        'uptown_id',
        'sale_person_id',
        'brocker_id',
        'brocker_start_date',
        'lead_name',
        'start_date',
        'end_date',
        'status',
    ];
}
