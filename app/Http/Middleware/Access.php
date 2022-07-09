<?php

namespace App\Http\Middleware;
use Auth;
use Closure;
use App\User;

class Access
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $page)
    {
        if(Auth::check() && $this->checkAccess($page)){
            return $next($request);
        }

        return redirect()->route('home');
    }

    private function checkAccess(int $page):bool
    {
        return User::whereId(Auth::id())->whereHas('pagesAccess', function ($query) use($page){
            $query->where('pages.id',$page);
        })->exists();
    }
}
