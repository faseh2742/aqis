<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GroupActivity extends Model
{
    protected $table = 'groupactivities';

    protected $fillable = [
        'staff_id',
        'programName',
        'type',
        'description',
        'location',
        'funder',
    ];

    public function events()
    {
        return $this->hasMany(Event::class, 'groupActivity_id', 'id');
    }

    public function clients()
    {
        return $this->belongsToMany(Client::class, 'client_groupactivity', 'groupActivity_id', 'client_id');
    }

    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }
}
