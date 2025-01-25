<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Uptown extends Model
{
    use HasFactory;


    protected $fillable = [
        //'developer_id', //3aiz ashil el coulmn da mn el production
        'compound_id',
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
        'latitude',
        'longitude',
        'floor_plan_image',
        'master_plan_image',
        'commission_price',
        'description',
        'favourite'
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

    public function unitimages(){
        return $this->hasMany(UnitsImage::class);
    }

    public function compound(){
        return $this->belongsTo(Compound::class);
    }

    public function leads(){
        return $this->hasMany(Lead::class);
    }

    public function transaction_deals(){
        return $this->hasMany(TransactionDeal::class);
    }

}
