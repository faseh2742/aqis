<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/noclist', 'NOCController@getNoc');
Route::get('/attachTemplates', 'ClientapsController@attachTemplates');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', 'AuthController@login');
Route::middleware('auth:api')->post('/register', 'AuthController@register');
Route::middleware('auth:api')->post('/register/staff', 'AuthController@registerStaff');
Route::middleware('auth:api')->post('/logout', 'AuthController@logout');
Route::post('/auth/refresh', 'AuthController@refreshToken');
Route::get('meetings/monthly', 'ClientmeetingController@monthlyReport');

Route::get('clients/groupActivities/{id}', 'ClientsController@getGroupActivities');


//Password Reset Routes

Route::group([
    'middleware' => 'api',
    'prefix' => 'password'
], function () {
    Route::post('create', 'PasswordResetController@create');
    Route::get('find/{token}', 'PasswordResetController@find');
    Route::post('reset', 'PasswordResetController@reset');
});

Route::group(['middleware' => ['auth:api', 'role:Facilitator']], function () {
    Route::get('user', 'UserController@index');
    Route::get('user/role', 'UserController@getRole');
    Route::get('user/permission', 'UserController@getPermission');
    Route::get('user/getAuthenticatedUser', 'UserController@getAuthenticatedUser');
    Route::get('user/getFacilitators', 'UserController@getFacilitators');
    Route::get('user/getAuthenticatedStaff', 'StaffController@getAuthenticatedStaff');
    Route::put('user/updateProfile', 'StaffController@updateProfile');
    Route::get('user/getPermissionUsers', 'UserController@getPermissionUsers');
    Route::put('user/{id}', 'UserController@update');
    Route::put('user/updatePassword', 'UserController@updatePassword');

    Route::put('password/update', 'UserController@updatePassword');

    Route::resource('clients', 'ClientsController');
    Route::resource('clientDocs', 'ClientDocsController');
    Route::get('getClientDocs/{id}', 'ClientDocsController@getCilentDocs');
    Route::get('clients/getActionPlans/{id}', 'ClientsController@getActionPlans');
    Route::post('clients/highestEducation', 'ClientsController@postHighestEducaiton');
    Route::post('clients/outcomes', 'ClientsController@updateOutcomes');
//    Route::post('clients/groupActivities/{id}', 'ClientsController@getGroupActivities');
    Route::get('clientaps/referrals/{id}', 'ClientapsController@getAllReferrals');
    Route::get('clientaps/referrals/{id}/{category}', 'ClientapsController@getReferrals');
    Route::resource('clientaps', 'ClientapsController');

    //Staff Route: Default @ Dashboard
    Route::get('staff/list', 'StaffController@getStaffList');

    //Dropdown Routes: Default @ Dashboard
    Route::get('dropdown', 'DropdownController@index');
    Route::get('dropdown/create', 'DropdownController@create');
    Route::get('dropdown/{dropdown}', 'DropdownController@show');
    Route::get('dropdown/{dropdown}/edit', 'DropdownController@edit');
    Route::get('getdropdown/{id}', 'DropdownController@getDropdown');

    //All Referrals Route: Default @ Dashboard
    Route::get('referrals/all', 'ReferralController@getAllReferrals');

    Route::get('getoutcomes/{id}', 'CategoryController@getOutcomes');
    Route::resource('category', 'CategoryController');
    Route::resource('categories', 'CategoryController');
    Route::resource('role', 'RoleController');

    // SEARCH Endpoints
    Route::post('search/client', 'ClientsController@search');
    Route::post('search/client/registration', 'ClientsController@searchRegistration');
    Route::post('search/facilitator', 'FacilitatorController@search');
    Route::post('search/aptemplate', 'AptemplatesController@search');
    Route::post('search/referrals', 'ReferralController@search');
    Route::post('search/staff', 'StaffController@search');
    Route::post('search/permission', 'PermissionController@search');

    // Groups for Permissions Middleware
    Route::group(['middleware' => ['perm:clients']], function () {
        Route::get('educations/{id}', 'ClienteducationController@show');
        Route::get('trainings/{id}', 'ClienttrainingController@show');
        Route::get('employments/{id}', 'ClientemploymentController@show');
        Route::get('meetings/{id}', 'ClientmeetingController@show');

        Route::get('workshops/{id}', 'ClientworkshopController@show');
        Route::resource('education', 'ClienteducationController');
        Route::resource('employment', 'ClientemploymentController');
        Route::resource('goals', 'ClientgoalController');
        Route::get('meeting/clientaps/{id}', 'ClientmeetingController@getClientaps');
        Route::resource('meeting', 'ClientmeetingController');
        Route::resource('workshop', 'ClientworkshopController');
        Route::resource('training', 'ClienttrainingController');
        Route::resource('groupActivities', 'GroupActivityController');
        Route::post('groupActivities/registerClient', 'GroupActivityController@registerClient');
        Route::post('groupActivities/unregisterClient', 'GroupActivityController@unregisterClient');
        Route::get('groupActivities/registrations/{id}', 'GroupActivityController@registrations');
        Route::resource('scheduleEvents', 'ScheduleEventsController');
        Route::get('scheduleEvents/attendances/{id}', 'ScheduleEventsController@getAttendances');
        Route::post('scheduleEvents/attend', 'ScheduleEventsController@attend');
    });
    Route::group(['middleware' => ['perm:facilitators']], function () {
        Route::resource('staff', 'StaffController');
        Route::put('staff/updateProfile/{id}', 'StaffController@updateProfile');
        Route::resource('facilitator', 'FacilitatorController');
        Route::post('facilitator/{id}', 'FacilitatorController@update');
        Route::get('facilitator/{id}', 'FacilitatorController@show');
    });
    Route::group(['middleware' => ['perm:aptemplates']], function () {
        Route::get('aptemplates/referrals/{id}', 'AptemplatesController@getAllReferrals');
        Route::get('aptemplates/referrals/{id}/{category}', 'AptemplatesController@getReferrals');
        Route::resource('aptemplates', 'AptemplatesController');
        Route::get('aptemplates/find/{noc}', 'AptemplatesController@find');
        Route::post('aptemplates/filter/{id}', 'AptemplatesController@filter');
    });
    Route::group(['middleware' => ['perm:reports']], function () {
        Route::get('report/workshop', 'ClientworkshopController@generateReport');
        Route::get('reports/monthly', 'ReportController@getMonthlyReport');
        Route::get('report/clients', 'ClientmeetingController@getClientsReport');
        Route::get('report/demographics', 'ClientsController@getDemographicReport');

        // Route::post('client/report', 'ClientsController@reportReg');
        // Route::post('client/report/chart/ClientReg', 'ClientsController@reportRegChart');
        // Route::post('client/report/chart/ClientMeet', 'ClientmeetingController@ClientMeet');
        // Route::post('client/report/chart/DeptMeetings', 'ClientmeetingController@DeptClientMeet');
        // Route::post('client/report/chart/FacilMeet', 'FacilitatorController@FacilMeet');

        // Route::post('clients/{id}', 'ClientsController@update');
        // Route::get('clients/{id}', 'ClientsController@show');
        // Route::delete('clients/{id}', 'ClientsController@destroy');
    });
    Route::group(['middleware' => ['perm:dropdowns']], function () {
        Route::post('dropdown', 'DropdownController@store');
        Route::post('dropdown/{id}', 'DropdownController@update');
        Route::put('dropdown/{dropdown}', 'DropdownController@update');
        Route::delete('dropdown/dropdownitem/{id}', 'DropdownController@destroy');
        Route::delete('dropdown/{dropdown}', 'DropdownController@destroy');
    });

    Route::group(['middleware' => ['perm:dropdowns']], function () {
        Route::resource('language', 'LanguageController');
    });

    Route::group(['middleware' => ['perm:dropdowns']], function () {
        Route::resource('city', 'CityController');
    });

    Route::group(['middleware' => ['perm:outcomes']], function () {
        Route::resource('outcomes', 'OutcomeController');
    });

    Route::group(['middleware' => ['perm:referrals']], function () {
        Route::resource('referrals', 'ReferralController');
    });

    Route::group(['middleware' => ['perm:permissions']], function () {
        Route::resource('permission', 'PermissionController');
        Route::post('permission/{id}', 'PermissionController@update');
    });
    //Dashboard Endpoints
    Route::get('getReferrals', 'DashboardController@getReferrals');
    Route::get('getNocs', 'DashboardController@getNocs');
    Route::get('getMeetings', 'DashboardController@getMeetings');
    Route::get('getActivities', 'DashboardController@getActivities');
});

//Unrestricted Endpoints

Route::get('getdropdown/{id}', 'DropdownController@getDropdown')->middleware('auth:api'); //Restricting this makes dropdowns unreadable in forms.
Route::get('getLanguages', 'LanguageController@index')->middleware('auth:api'); //Restricting this makes Languages unreadable in forms.
Route::get('getCities', 'CityController@index')->middleware('auth:api'); //Restricting this makes Cities unreadable in forms.

Route::get('meetingStatus/{id}/{status}', 'ClientmeetingController@updateStatus');




// Route::post('client/report', 'ClientsController@reportReg')->middleware('auth:api');
// Route::post('client/report/chart/ClientReg', 'ClientsController@reportRegChart')->middleware('auth:api');
// Route::post('client/report/chart/ClientMeet', 'ClientmeetingController@ClientMeet')->middleware('auth:api');
// Route::post('client/report/chart/DeptMeetings', 'ClientmeetingController@DeptClientMeet')->middleware('auth:api');
// Route::post('client/report/chart/FacilMeet', 'FacilitatorController@FacilMeet')->middleware('auth:api');

// Route::post('clients/{id}', 'ClientsController@update')->middleware('auth:api');
// Route::get('clients/{id}', 'ClientsController@show')->middleware('auth:api');
// Route::delete('clients/{id}', 'ClientsController@destroy')->middleware('auth:api');

//Route::get('report/forum', 'ClientworkshopController@generateReport');//->middleware('auth:api');

Route::get('/Testing', function () {
    //   $user_id = Auth::id();

       $user = App\User::findorFail(2);

       return $user;
});

