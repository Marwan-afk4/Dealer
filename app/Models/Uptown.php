<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Uptown extends Model
{
    use HasFactory;


    protected $fillable = [
        'developer_id',
        'name',
        'description',
        'apparment',
        'strat_price',
        'delivery_date',
        'sale_type',
        'image',
    ];
}
