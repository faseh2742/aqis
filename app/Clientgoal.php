<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Clientgoal extends Model
{
    protected $fillable = [
    	'client_id',
    	'employment_goals',
    	'meeting_expectation'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
