<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function referrals()
    {
        return $this->belongsToMany(Referral::class);
    }

    public function outcomes()
    {
        return $this->hasMany(Outcome::class);
    }
}
