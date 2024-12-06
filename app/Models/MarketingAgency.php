<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarketingAgency extends Model
{
    use HasFactory;


    protected $fillable = [
        'name',
        'email',
        'phone',  //rg3ha varchar
        'start_date',
        'end_date',
        'image',
        'total_leads', //3aiz a8irha from total_deals to total leads in production
    ];
}
