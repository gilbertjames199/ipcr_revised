<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $user = User::where('username', $request->UserName)
            ->first();
        // dd($user);
        if ($user) {
            $user_p = User::where('password', md5($request->UserPassword))
                ->first();
            if ($user_p) {
                Auth::login($user, true);
            } else {
                $mssg = 'Invalid password ';
                return back()->withErrors(['message' => $mssg])
                    ->withInput($request->only('UserName'));
            }
        } else {
            $mssg = 'Invalid username ';
            return back()->withErrors(['message' => $mssg])
                ->withInput($request->only('UserName'));
        }
        return redirect('/');
    }

    public function logout()
    {
        Auth::guard('web')->logout();
        request()->session()->invalidate();
        return inertia()->location('/');
    }
}
