<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        if (!Auth::check()) {
            abort(403, 'Denied Access');
        }

        if ($role == 'Facilitator') {
            if (Auth::user()->userAdmin() || Auth::user()->userFac()) {
                return $next($request);
            }
            abort(403, 'Denied Access Not Fac or Admin');
        } 

        return $next($request);
    }
}
