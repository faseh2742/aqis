<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
	return view('app');
});

Route::get('/test', function () {
    $month = 02;
    $year = 2018;

    $startDate = Carbon::create($year, $month, 01, null);
//    print($startDate);
    echo("<br>");
    $endDate = $startDate->endOfMonth();
//    print($endDate);
    $data = array(
        'startDate' => $startDate,
        'endDate' => $endDate
    );
    $user=DB::table('users')->where(['username'=>'ajlal.haider'])->first();
    if (Hash::check('secret', $user->password)) {
       return 'Ok';
    }
    else{
        return "Not Ok";
    }

    // return view('test')->with($data);
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


Route::get('/Testing', function () {

    return \App\Aptemplate::withCount('categories')
            ->orderBy('categories_count', 'desc')->get();

});
