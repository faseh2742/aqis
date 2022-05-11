<?php

namespace App\Http\Controllers;

use App\Permission;
use App\User;

use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function index()
    {
        $permissions = Permission::with('user')->paginate(10);
        return $permissions;
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'user_id' => 'required|integer',
            ],
            [
                'user_id.required' => 'Please select a staff member'
            ]
        );

        $user = User::findorFail($request->user_id);
        $permission = new Permission();
        $permission->user_id = $request->user_id;
        $permission->clients = $request->clients;
        $permission->facilitators = $request->facilitators;
        $permission->aptemplates = $request->aptemplates;
        $permission->schedules = $request->schedules;
        $permission->reports = $request->reports;
        $permission->dropdowns = $request->dropdowns;
        $permission->permissions = $request->permissions;
        $permission->outcomes = $request->outcomes;
        $permission->referrals = $request->referrals;

        $user->permission()->save($permission);
        $user->permission_id = $permission->id;
        $user->save();
        $permission->user = $user;

        return $permission;
    }

    public function show($id)
    {
        $permission = Permission::findorFail($id);
        $permission->user = $permission->user()->get();

        return $permission;
    }


    public function update(Request $request, $id)
    {
        $request->validate(
            [
                'user_id' => 'required|integer',
            ],
            [
                'user_id.required' => 'Please select a staff member'
            ]
        );

        $permission = Permission::with('user')->findorFail($id);
        $permission->update($request->all());

        return $permission;
    }


    public function destroy($id)
    {
        $permission = Permission::findorFail($id);
        $user = $permission->user();
        $user->permission_id = null;
        $permission->delete();

        return 204;
    }

    public function search(Request $request)
    {
        $keyword = explode(" ", $request->input('string'));
        $querySize = $request->querySize;
        $resultAdults = Permission::with('user')->whereHas('user', function ($query) use ($keyword, $querySize) {
            foreach ($keyword as $word) {
                $query->where('firstName', 'LIKE', '%' . $word . '%')
                    ->orWhere('lastName', 'LIKE', '%' . $word . '%')
                    ->orWhere('email', 'LIKE', '%' . $word . '%')
                    ->orWhere('username', 'LIKE', '%' . $word . '%')
                    ->take($querySize);
            }
        })->paginate(10);;

        return $resultAdults;
    }
}
