<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Compound extends Model
{


    protected $fillable = [
        'developer_id',
        'compound_name',
        'image',
        'units',
        'commission_percentage',
        'favourite'
    ];

    public function uptwons(){
        return $this->hasMany(Uptown::class);
    }

    public function transaction_deals(){
        return $this->hasMany(TransactionDeal::class);
    }
}
