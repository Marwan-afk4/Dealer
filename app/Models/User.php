<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Model
{
    use HasApiTokens, HasFactory, Notifiable;


    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'password',
        'provider',
        'provider_id',
        'role'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}
