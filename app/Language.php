<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    protected $fillable = ['language'];

    public function clients()
    {
        return $this->belongsToMany(Client::class);
    }

    public function staff()
    {
        return $this->belongsToMany(Staff::class);
    }
}
