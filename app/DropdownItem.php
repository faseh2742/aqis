<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DropdownItem extends Model
{
    protected $fillable = [
        'item', 'status'
    ];

    public function dropdown () 
    {
        return $this->belongsTo('App\DropdownItem', 'item_id');
    }
}
