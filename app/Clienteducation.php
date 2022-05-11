<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clienteducation extends Model
{

    use HasFactory;
    
    protected $fillable = [
        'client_id',
    	'education_level',
    	'major',
    	'graduation_date',
    	'education_country'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
