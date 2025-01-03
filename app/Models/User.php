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
        'role',
        'qualification',
        'experience_year',
        'governce',
        'age'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function complaints(){
        return $this->hasMany(Complaint::class);
    }

    public function brockers(){
        return $this->hasMany(Brocker::class);
    }

    public function payments(){
        return $this->hasMany(Payment::class);
    }

    public function trainings(){
        return $this->hasMany(TrainingSubscription::class);
    }
}
