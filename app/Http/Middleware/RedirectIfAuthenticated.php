<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Support\Facades\Auth;
use Config;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            
            $user = Auth::user();
            $routes = Config::get("constant.LANDING_PAGE_ROUTE_NAME");
            $route = (isset($routes[$user->landing_page]))?$routes[$user->landing_page]:"home";
            return redirect()->route($route);
        }

        return $next($request);
    }
}
