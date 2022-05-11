<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Facilitator extends User
{
    use HasApiTokens, Notifiable;

    protected $fillable = [
        'first_name',
        'last_name',
        'active',
        'gender',
        'address',
        'phone_primary',
        'email',
        'visible'
    ];

    protected $hidden = [
        'password', 'remember_token'
    ];

    public function scopeSearch($query, $string)
    {
        $resultString = explode(" ", $string);
            foreach ($resultString as $keyword) {
             $query->where("firstName", "LIKE", "%".$keyword."%")
                 ->orWhere("lastName", "LIKE", "%".$keyword."%")
                 ->orWhere("phonePrimary", "LIKE", "%".$keyword."%");
            }
            return $query;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

   
}
