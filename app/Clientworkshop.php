<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Clientworkshop extends Model
{
    protected $fillable = [
        'client_id',
    	'programName',
    	'type',
    	'description',
    	'start_date',
    	'end_date',
    	'location',
    	'funder',
    	'staff_id',
        'notes',
        'duration',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }
}
