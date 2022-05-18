<?php

namespace App\Http\Controllers;

use App\User;
use App\Staff;
use App\Activity;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use \App\Rules\PhoneNumber;
use \App\Rules\PostalCode;

class UserController extends Controller
{

    public function index()
    {
        return User::all();
    }

    function show()
    {
        $user_id = Auth::id();

        $user = User::findorFail($user_id);

        return $user;
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $request->validate(
            [
                'firstName' => 'bail|required|string|max:255',
                'lastName' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            ]
        );
        $user = User::findOrFail($id);
        $user->update([
            'firstName' => $request->firstName,
            'lastName' => $request->lastName,
            'email' => $request->email,
        ]);
          $activity=new Activity();
          $activity->description=$user->username." | User Profile Updated";
          $activity->user_id=Auth::id();
          $activity->save();

    }

    public function updatePassword(Request $request)
    {
        if (!Auth::check()) {
            return 401;
        }

        $user_id = Auth::id();

        $user = User::findorFail($user_id);
        $request->validate(
            [
                'currentPassword' => 'required|string|max:255',
                'newPassword' => 'required|string|max:255|confirmed',
                'newPassword_confirmation' =>
                'required|string|max:255|same:newPassword'
            ],
            [
                'newPassword_confirmation.same' => '',
                'newPassword_confirmation.required' => 'The new password confirmation is required.',
                'newPassword.required' => 'The new password is requried.',
                'newPassword.confirmed' => 'Please try again. The new password and confirm new password do not match.',
                'currentPassword.required' => 'The current password is requried.'
            ]
        );


        $current_password = Auth::User()->password;
        if (Hash::check($request->currentPassword, $current_password)) {
            $id = Auth::User()->id;
            $user = User::find($id);
            $user->password = Hash::make($request->newPassword);
            $user->save();
            $activity=new Activity();
            $activity->description=$user->username." | User Password Updated";
            $activity->user_id=Auth::id();
            $activity->save();
            return response('Password updated', 200);
        } else {
            return response([
                'errors' => [
                    'currentPassword' => [
                        0 => 'Current password does not match stored value.'
                    ]
                ]
            ], 422);
        }
    }
    public function getPermissionUsers()
    {
        return $users = User::doesntHave('permission')->where('role_id', '=', 2)->orderBy('id', 'DESC')
            ->get();
    }

    public function getClient()
    {
        return User::where('role', '===', '1')->get();
    }


    public function getRole()
    {
        $user_id = Auth::id();

        $user = User::findorFail($user_id);

        return $user->role->role;
    }

    public function getPermission()
    {
        $user_id = Auth::id();

        $user = User::findorFail($user_id);

        return $user->permission;
    }


    public function getAuthenticatedUser()
    {
        $user_id = Auth::id();

        $user = User::findorFail($user_id);

        return $user;
    }

    public function getFacilitators()
    {
        $user_id = Auth::id();

        $staff = User::findorFail($user_id)->facilitator;

        return $staff;
    }
}
