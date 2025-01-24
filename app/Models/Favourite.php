<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favourite extends Model
{


    protected $fillable = [
        'user_id',
        'uptown_id',
        'compound_id',
        'type'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function uptown(){
        return $this->belongsTo(Uptown::class);
    }

    public function compound(){
        return $this->belongsTo(Compound::class);
    }
}
