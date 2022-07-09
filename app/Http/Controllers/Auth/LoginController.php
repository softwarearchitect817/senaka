<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Auth;
use Config;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required',
        ]);

        if(auth()->attempt(["username" => $request->username, 'password' => $request->password],$request->has("remember")))
        {
            $user = Auth::user();
            $routes = Config::get("constant.LANDING_PAGE_ROUTE_NAME");
            $route = (isset($routes[$user->landing_page]))?$routes[$user->landing_page]:"home";
            return redirect()->route($route);
        }else{
            $request->session()->flash("error_message",'Username or Password is Wrong.');
            return redirect()->route('login');
        }

    }

}
