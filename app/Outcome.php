<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Outcome extends Model
{
    protected $fillable = [
        'outcome',
        'category_id',
        'status',
        'client_id',
        'notes'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function clients()
    {
        return $this->belongsToMany(Client::class);
    }
}
