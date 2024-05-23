<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserEmployees;
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
        $user_emp = UserEmployees::where('empl_id', $request->UserName)->first();
        // dd($user);
        if (!$user_emp) {
            // User does not exist
            $mssg = 'User not found';
            return back()->withErrors(['message' => $mssg])
                ->withInput($request->only('UserName'));
        }
        if ($user_emp->active_status != 'ACTIVE') {
            // dd($user->active_status . ' Null ang active status');
            $mssg = 'Status Inactive ';
            return back()->withErrors(['message' => $mssg])
                ->withInput($request->only('UserName'));
        } else {
            if ($user) {
                $user_p = User::where('password', md5($request->UserPassword))
                    ->where('username', $request->UserName)
                    ->first();
                if ($user_p) {
                    Auth::login($user_p, true);
                    if ($request->UserPassword == 'password1.') {
                        return redirect('/users/change-password');
                    }
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
        }

        return redirect('/');
    }

    public function logout()
    {
        // dd("logout na ko!!");
        Auth::guard('web')->logout();

        request()->session()->invalidate();
        request()->session()->regenerateToken();
        //
        return inertia()->location('/');
    }

    public function showLoginForm()
    {
        $showChangePasswordModal = false;

        // Assuming you have access to the authenticated user
        if (Auth::check() && Auth::user()->password == bcrypt('password1.')) {
            $showChangePasswordModal = true;
        }

        return view('auth.login', compact('showChangePasswordModal'));
    }
}
