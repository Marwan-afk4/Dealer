<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{


    protected $fillable = [
        'user_id',
        'brocker_id',
        'plan_id',
        'payment_method_id',
        'receipt',
        'status',
    ];

    public function paymentmethod()
    {
        return $this->belongsTo(PaymentMethod::class, 'payment_method_id');
    }



    public function user(){
        return $this->belongsTo(User::class);
    }

    public function plan(){
        return $this->belongsTo(Plan::class);
    }
}
