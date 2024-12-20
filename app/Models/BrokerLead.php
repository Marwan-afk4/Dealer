<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BrokerLead extends Model
{


    protected $fillable = [
        'lead_id',
        'brocker_id',
        'brocker_end_date',
        'status'
    ];

    public function lead(){
        return $this->belongsTo(Lead::class);
    }

    public function brocker(){
        return $this->belongsTo(Brocker::class);
    }
}
