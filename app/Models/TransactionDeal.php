<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionDeal extends Model
{

    protected $fillable = [
        'brocker_id',
        'developer_id',
        'sales_developer_id',
        'uptown_id',
        'fullname',
        'phone',
        'deal_value',
        'image',
        'status',
        'lead_id',
        'days_for_profits',
        'compound_id'
    ];

    public function sales_developer(){
        return $this->belongsTo(SalesDeveloper::class);
    }

    public function uptown(){
        return $this->belongsTo(Uptown::class);
    }

    public function brocker(){
        return $this->belongsTo(Brocker::class);
    }

    public function developer(){
        return $this->belongsTo(Developer::class);
    }

    public function lead(){
        return $this->belongsTo(Lead::class);
    }

    public function compound(){
        return $this->belongsTo(Compound::class);
    }
}
