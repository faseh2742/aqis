<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use App\Permission;
use Illuminate\Support\Facades\Log;


class CheckPermissions
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

    protected   $data = [
        'clients' => 2,
        'facilitators' => 3,
        'aptemplates' => 3,
        'reports' => 3,
        'dropdowns' => 3,
        'languages' => 3,
        'outcomes' =>  3,
        'referrals' => 3,
        'permissions' => 3
    ];
    public function handle($request, Closure $next, $permissionName)
    {
        $permissions = new Permission();
        $permissionType =  Permission::whereUserId($request->user()->id)->first();
        $permissionLevel = $permissions->getPermissionLevel($request->method());

        if ($permissionType) {
            if ($permissionType[$permissionName] >= $permissionLevel) {
                return $next($request);
            } else {
                abort(403, 'Denied Access Permission');
            }
        } else if ($request->user()->role_id >= $this->data[$permissionName]) {
            return $next($request);
        }
        abort(403, 'Denied Access Permission Role');
    }
}
