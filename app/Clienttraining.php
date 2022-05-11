<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Clienttraining extends Model
{
    protected $fillable = [
        'client_id',
    	'subject',
    	'association',
    	'training_year',
    	'country',
    	'notes'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
