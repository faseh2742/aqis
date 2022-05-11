<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dropdown extends Model
{
    protected $fillale = [
        'name', 'item_id',
    ];

    public function items() 
    {
        return $this->hasMany('App\DropdownItem');
    }
}
