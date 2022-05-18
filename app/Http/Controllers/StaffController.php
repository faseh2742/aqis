<?php

namespace App\Http\Controllers;

use App\Client;
use App\Staff;
use App\User;
use App\Activity;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use \App\Rules\PhoneNumber;
use \App\Rules\PostalCode;

class StaffController extends Controller
{
    public function index()
    {
        // $staffs = Staff::with('user')->where('user_id','2')->orderBy('id', 'DESC')->paginate(10);
        $staffs = Staff::with('user')->orderBy('id', 'DESC')->paginate(10);

        return $staffs;
    }

    function show($id)
    {
        $staff = Staff::with('user')->findOrFail($id);

        return $staff;
    }

    function update(Request $request, $id)
    {
        $staff = Staff::with('user')->findOrFail($id);
        $phoneNumber = new PhoneNumber;
        $request->validate(
            [
                'user.firstName' => 'bail|required|string|max:255',
                'user.lastName' => 'required|string|max:255',
                'user.username' => 'required|string|max:255|unique:users,username,' . $staff->user_id,
                'user.email' => 'required|string|email|max:255|unique:users,email,' . $staff->user_id,
                'user.active' => 'required',
                'phonePrimary' => ['required',  $phoneNumber],
                'phoneEmerg' =>  ['nullable',  $phoneNumber],
                'position' => 'required|string|max:255',
                'postalCode' => ['nullable', new PostalCode],
                'phonePersonal' =>  ['nullable',  $phoneNumber],
                'contactEmerg' => 'nullable|string|max:255',

            ],
            [
                'user.firstName.required' => 'The first name field is required.',
                'user.lastName.required' => 'The last name field is required.',
                'user.email.required' => 'The email field is required.',
                'user.username.required' => 'The username field is required.',
                'user.email.unique' => 'The email field must be unique.',
                'user.username.unique' => 'The username  must be unique.',
                'phonePrimary.required' => 'The primary phone field is required.',
            ]
        );

        // $staff = Staff::findOrFail($id);

        if (!array_key_exists('password', $request->user)) {
            $staff->user()->update(
                [
                    'firstName' => $request->user['firstName'],
                    'lastName' => $request->user['lastName'],
                    'username' => $request->user['username'],
                    'email' => $request->user['email'],
                    'active' => $request->user['active'],
                ]
            );
        } else {
            $staff->user()->update(
                [
                    'firstName' => $request->user['firstName'],
                    'lastName' => $request->user['lastName'],
                    'username' => $request->user['username'],
                    'password' => Hash::make($request->user['password']),
                    'active' => $request->user['active'],
                ]
            );
        }


        $staff->update(
            [
                'phonePrimary' =>  $phoneNumber->formatPhoneNumber($request->phonePrimary),
                'phoneEmerg' =>  $phoneNumber->formatPhoneNumber($request->phoneEmerg),
                'position' => $request->position,
                'gender' => $request->gender,
                'streetAddress' => $request->streetAddress,
                'city' => $request->city,
                'province' => $request->province,
                'postalCode' => $request->postalCode,
                'phonePersonal' =>  $phoneNumber->formatPhoneNumber($request->phonePersonal),
                'contactEmerg' => $request->contactEmerg,
            ]
        );
        $activity=new Activity();
        $activity->description=$staff->user->username." | Staff Updated";
        $activity->user_id=Auth::id();
        $activity->save();
        return response("Staff updated", 200);
    }

    public function search(Request $request)
    {

        $resultStaff = Staff::search($request->input('string'))
            ->with('user')
            ->paginate(10);

        return $resultStaff;
    }

    function getStaffList()
    {
        $staff = Staff::with('user')->whereHas('user', function ($query) {
            $query->where('active', 1);
        })->get();

        return $staff;
    }

    public function destroy($id)
    {
        $staff = Staff::findOrFail($id);

        $staff->user()->delete();
        $activity=new Activity();
        $activity->description=$staff->user->username." | Staff Deleted";
        $activity->user_id=Auth::id();
        $activity->save();

        $staff->delete();

        return 204;
    }

    public function getAuthenticatedStaff()
    {

        $user_id = Auth::User()->id;
        $staff = Staff::with('user')->where('user_id', $user_id)->first();
        if (!$staff) {
            $staff['user'] = Auth::User();
        }
        return $staff;
    }

    public function updateProfile(Request $request, $id)
    {
        if (!Auth::check()) {
            return 401;
        }
        $user = User::findorFail($id);
        $phoneNumber = new PhoneNumber;
        $request->validate(
            [
                'user.firstName' => 'bail|required|string|max:255',
                'user.lastName' => 'required|string|max:255',
                'user.email' => 'required|string|email|max:255|unique:users,email,' . $id,
                'phonePrimary' => ['required',  $phoneNumber],
                'phoneEmerg' =>  ['nullable',  $phoneNumber],
                'postalCode' => ['nullable', new PostalCode],
                'phonePersonal' =>  ['nullable',  $phoneNumber],
                'contactEmerg' => 'nullable|string|max:255',
            ]
        );

        $user->update([
            'firstName' => $request->user['firstName'],
            'lastName' => $request->user['lastName'],
            'email' => $request->user['email'],

        ]);

        $staffData = [
            'phonePrimary' => $phoneNumber->formatPhoneNumber($request->phonePrimary),
            'phoneEmerg' => $phoneNumber->formatPhoneNumber($request->phoneEmerg),
            'city' => $request->city,
            'streetAddress' => $request->streetAddress,
            'city' => $request->city,
            'province' => $request->province,
            'postalCode' => $request->postalCode,
            'phonePersonal' =>  $phoneNumber->formatPhoneNumber($request->phonePersonal),
            'contactEmerg' => $phoneNumber->formatPhoneNumber($request->contactEmerg),
        ];

        if ($user->staff()->first()) {
            $user->staff()->update($staffData);
            $activity=new Activity();
        $activity->description=$user->username." | Staff Updated";
        $activity->user_id=Auth::id();
        $activity->save();
        } else {
            $activity=new Activity();
            $activity->description=$user->username." | Staff Created";
            $activity->user_id=Auth::id();
            $activity->save();
            $user->staff()->create($staffData);
        }


    }
}
