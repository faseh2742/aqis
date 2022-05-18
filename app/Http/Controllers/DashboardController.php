<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function getReferrals()
    {

        return \App\Referral::withCount('aptemplates')
            ->orderBy('aptemplates_count', 'desc')->limit(10)->get();
    }
    public function getNocs()
    {

        return \App\Aptemplate::withCount('categories')
            ->orderBy('categories_count', 'desc')->get();
    }
    public function getMeetings()
    {
         $id =2;

        return \App\Clientmeeting::with('staff')
            ->orWhere(function ($query) use ($id) {
                $query->whereHas('staff', function ($q) use ($id) {
                    $q->where('user_id', '=', $id);
                });
            })
            ->with('user')
            ->orderBy('date', 'desc')->paginate(10);
    }
    public function getActivities()
    {
        return \App\Activity::with('user')
            ->where('user_id', '=', Auth::id())
            
            ->orderBy('created_at', 'desc')->paginate(10);
    }
}
