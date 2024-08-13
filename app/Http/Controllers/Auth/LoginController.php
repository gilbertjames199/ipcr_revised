<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserEmployees;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
// use Illuminate\Foundation\Auth\ThrottlesLogins;
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
    // use ThrottlesLogins;

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
        $request->validate([
            'UserName' => 'required|string',
            'UserPassword' => 'required|string',
        ]);
        $user = User::with('userEmployee')
            ->where('username', $request->UserName)
            ->first();
        // dd($user->userEmployee->active_status);

        // $user_emp = UserEmployees::where('empl_id', $request->UserName)->first();
        // dd($user);
        if (!$user) {
            // User does not exist
            $mssg = 'User not found';
            return back()->withErrors(['message' => $mssg])
                ->withInput($request->only('UserName'));
        }
        if ($user->userEmployee) {
            $act_status = $user->userEmployee->active_status;
            if ($act_status != 'ACTIVE') {
                $mssg = 'Status Inactive ';
                return back()->withErrors(['message' => $mssg])
                    ->withInput($request->only('UserName'));
            } else {
                if ($user) {

                    if ($user && md5($request->UserPassword) === $user->password) {

                        Auth::login($user, true);
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
        } else {
            $mssg = 'User profile not found';
            return back()->withErrors(['message' => $mssg])
                ->withInput($request->only('UserName'));
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
