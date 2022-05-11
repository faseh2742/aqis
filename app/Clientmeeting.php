<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Clientmeeting extends Model
{
    protected $fillable = [
        'client_id',
    	'programName',
    	'serviceProvided',
    	'type',
    	'date',
    	'status',
    	'serviceDelivery',
        'meetingLink',
    	'location',
    	'funder',
    	'staff_id',
        'notes',
        'duration'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function staff()
    {
        return $this->belongsTo('App\Staff');
    }

    function clientaps()
    {
        return $this->hasMany(Clientap::class, 'clientmeeting_id');
    }
}
