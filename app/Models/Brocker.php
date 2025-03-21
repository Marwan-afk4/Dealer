<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brocker extends Model
{
    use HasFactory;

    protected $fillable=[
        'user_id',
        'plan_id',
        'profit',
        'number_of_deals',
        'deals_done',
        'comission_percentage'
    ];


    public function user(){
        return $this->belongsTo(User::class);
    }

    public function plan(){
        return $this->belongsTo(Plan::class);
    }

    public function leads(){
        return $this->hasMany(Lead::class);
    }

    public function subscribtions(){
        return $this->hasMany(Subscribtion::class);
    }
}
