<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clientemployment extends Model
{
    use HasFactory;

    
    protected $fillable = [
        'client_id',
    	'noc',
    	'job_title',
    	// 'field',
    	'experience_years',
    	'country',
    	'notes'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
