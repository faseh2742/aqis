<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class Referral extends Model
{
    use SearchableTrait, SearchableTrait;

    protected $fillable = [
        'name',
        'community',
        'address',
        'phone',
        'website',
        'notes',
        'category',
    ];

    protected $searchable = [
        'columns' => [
            'referrals.name' => 20,
        ],
        'joins' => [
            'category_referral' => ['referrals.id', 'category_referral.referral_id'],
            'categories' => ['category_referral.category_id', 'categories.id']
        ]
    ];

//    public function scopeSearch($query, $string)
//    {
//        $resultString = explode(" ", $string);
//        // if ($keyword!='') {
//		foreach ($resultString as $keyword) {
//            $query->where("name", "LIKE", "%".$keyword."%")
//                ->orWhere("phone", "LIKE", "%".$keyword."%")
//                ->orWhere("website", "LIKE", "%".$keyword."%");
//		}
//		return $query;
//        // }
//
//	}

    public function aptemplates()
    {
        return $this->belongsToMany(Aptemplate::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function clientaps()
    {
        return $this->belongsToMany(Clientap::class);
    }
}
