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
        'apparment',
        'strat_price',
        'delivery_date',
        'sale_type',
        'image',
        'status',
        'space',
        'bathroom',
        'bed',
        'google_map',
    ];

    public function developer(){
        return $this->belongsTo(Developer::class);
    }

    public function images(){
        return $this->hasMany(UnitsImage::class);
    }

    public function salesman(){
        return $this->hasMany(DeveloperSalesman::class);
    }
}
