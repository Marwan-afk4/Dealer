<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brocker extends Model
{
    use HasFactory;

    protected $fillable=[
        'user_id',
        'profit',
        'number_of_deals'
    ];
}
