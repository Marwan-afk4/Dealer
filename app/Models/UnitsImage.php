<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UnitsImage extends Model
{


    protected $fillable = [
        'uptown_id',
        'image',
    ];

    public function uptown(){
        return $this->belongsTo(Uptown::class);
    }
}
