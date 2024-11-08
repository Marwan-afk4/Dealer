<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrainingSubscription extends Model
{


    protected $fillable = [
        'user_id',
        'full_name',
        'email',
        'phone',
        'age',
        'qualification',
        'governate',
        'experience_year',
    ];
}
