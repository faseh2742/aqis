<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $fillable = [
        'user_id',
        'clients',
        'facilitators',
        'aptemplates',
        'schedules',
        'reports',
        'dropdowns',
        'permissions',
        'outcomes',
        'referrals',
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    function getPermissionLevel($method)
    {
        switch ($method) {
            case 'GET':
                $crud = 1;
                break;
            case 'POST':
                $crud = 2;
                break;
            case 'PUT':
                $crud = 2;
                break;
            case 'DELETE':
                $crud = 3;
                break;
            default:
                $crud = 0;
                break;
        }
        return $crud;
    }
}
