<?php
namespace App\Http\Middleware;
use App\Providers\RouteServiceProvider;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle($request, Closure $next, $role)
    {
        if (Auth::guard('web')->check()) {
             return $next($request);
        }

        return redirect('/login')->withErrors('You do not have access to this page.');
    }
}
