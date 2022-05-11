<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable, SoftDeletes, HasFactory;
	public $timestamps = false;
    protected $fillable = [
    	'firstName', 'lastName', 'username', 'email', 'password', 'role_id', 'permission_id', 'active'
    	   ];

    protected $hidden = [
    	'password', 'remember_token'
    ];

    public function findForPassport($username)
    {
        return $this->where('username', $username)->first();
    }

    public function client()
    {
        return $this->hasOne('App\Client', 'user_id');
    }
    public function permission()
    {
        return $this->hasOne('App\Permission', 'user_id');
    }
    public function staff() 
    {
        return $this->hasOne('App\Staff');
    }
    public function role() 
    {
        return $this->belongsTo('App\Role', 'role_id');
    }
    public function aptemplates() 
    {
        return $this->hasMany(Aptemplate::class);
    }
    public function userClient()
    {
        return $this->role_id == 1; 
    }
    public function userFac()
    {
        return $this->role_id == 2; 
    }
    public function userAdmin()
    {
        return $this->role_id == 3; 
    }

}
