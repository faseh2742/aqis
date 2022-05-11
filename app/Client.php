<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;
use Nicolaslopezj\Searchable\SearchableTrait;

class Client extends User
{
    use HasApiTokens, Notifiable, SoftDeletes, SearchableTrait, HasFactory;

    public $timestamps = true;

    protected $fillable = [
        'wc_id',
        'immigrationStatus',
        'dob',
        'doa',
        'gender',
        'streetAddress',
        'city',
        'province',
        'postalCode',
        'phonePrimary',
        'phoneSecondary',
        'motherTongue',
        'countryOrigin',
        'engProficiency',
        'interpreterNeeded',
        'interpreterLanguage',
        'childcareNeeded',
        'notes',
    ];

    protected $searchable = [
        'columns' => [
            'clients.wc_id' => 5,
            'users.firstName' => 30,
            // 'users.lastName' => 5,
        ],
        'joins' => [
            'users' => ['clients.user_id', 'users.id']
        ]
    ];

    protected $hidden = [
        'password', 'remember_token'
    ];

    public function clientaps()
    {
       return $this->hasMany(Clientap::class);
    }
    public function user()
    {
       return $this->hasOne(User::class, 'id', 'user_id');
    }
    public function educations()
    {
       return $this->hasMany(Clienteducation::class);
    }
    public function highestEducation()
    {
        return $this->hasOne(Clienteducation::class, 'id', 'highestEducation_id');
    }
    public function employments()
    {
       return $this->hasMany(Clientemployment::class);
    }
    public function goals()
    {
       return $this->hasMany(Clientgoal::class);
    }
    public function meetings()
    {
       return $this->hasMany(Clientmeeting::class);
    }
    public function trainings()
    {
       return $this->hasMany(Clienttraining::class);
    }
    public function workshops()
    {
       return $this->hasMany(Clientworkshop::class);
    }
    public function outcomes()
    {
        return $this->belongsToMany(Outcome::class);
    //    return $this->belongsToMany(Outcome::class)->withPivot('created_at');
    }
    public function languages()
    {
        return $this->belongsToMany(Language::class);
    }

    public function groupActivities()
    {
        return $this->belongsToMany(GroupActivity::class, 'client_groupactivity', 'client_id', 'groupActivity_id');
    }

    public function events()
    {
        return $this->belongsToMany(Event::class,'client_event');
    }
    public function docs()
    {
       return $this->hasMany(ClientDocs::class);
    }

}
