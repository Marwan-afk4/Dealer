<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    protected $fillable =[
        'contract_name',
        'user_id',
        'file_id',
        'whatsapp_number',
        'status',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function file(){
        return $this->belongsTo(File::class);
    }
}
