<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Nicolaslopezj\Searchable\SearchableTrait;

class Staff extends Model
{
    use SoftDeletes, SearchableTrait;

    protected $fillable = [
        'user_id',
        'phonePrimary',
        'phoneEmerg',
        'phonePersonal',
        'position',
        'gender',
        'streetAddress',
        'city',
        'province',
        'postalCode',
        'contactEmerg',
    ];

    protected $searchable = [
        'columns' => [
            'users.firstName' => 20,
            // 'users.lastName' => 15,
        ],
        'joins' => [
            'users' => ['staff.user_id', 'users.id']
        ]
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function meetings()
    {
        return $this->hasMany('App\Clientmeeting');
    }

    function workshops()
    {
        return $this->hasMany(Clientworkshop::class);
    }

    function clientaps()
    {
        return $this->hasMany(Clientap::class);
    }

    public function languages()
    {
        return $this->belongsToMany(language::class);
    }
}
