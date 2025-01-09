<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Developer extends Model
{
    use HasFactory;


    protected $fillable = [
        'name',
        'email',
        'place',
        'units',
        'total_deals',
        'total_profit',
        'deals_done',
        'start_date',
        'end_date',
        'image',
        'description'
    ];

    public function place(){
        return $this->hasMany(Place::class);
    }

    public function uptowns(){
        return $this->hasMany(Uptown::class);
    }


    public function sales_developer(){
        return $this->hasMany(SalesDeveloper::class);
    }

    public function transaction_deals(){
        return $this->hasMany(TransactionDeal::class);
    }


}
