<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    protected $fillable =[
        'user_id',
        'file_id',
        'whatsapp_number'
    ];
}
