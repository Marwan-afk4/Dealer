<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionDeal extends Model
{

    protected $fillable = [
        'brocker_id',
        'developer_id',
        'sale_person_id',
        'uptown_id',
        'fullname',
        'phone',
        'deal_value',
        'image',
        'status',
        'profit',
    ];
}
