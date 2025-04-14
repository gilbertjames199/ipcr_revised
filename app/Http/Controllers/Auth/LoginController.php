<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\ChangeLog;
use App\Models\Office;
use App\Models\User;
use App\Models\UserEmployeeCredential;
use App\Models\UserEmployees;
use App\Providers\RouteServiceProvider;
use Exception;
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
    public function passwordsetter()
    {
        // dd("resetter");
        $offices = Office::select('office', 'department_code')
            ->where(function ($query) {
                $query->where('office', 'LIKE', '%Office%')
                    ->orWhere('office', 'LIKE', '%Hospital%');
            })
            ->where('office', '<>', 'No Office')
            ->orderBy('office', 'asc')
            ->get();
        // dd($offices);
        return view('auth.reset_password', compact('offices'));
    }
    public function postpasswordsetter(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'empl_id'    => 'required',
            'first_name' => 'required',
            'last_name'  => 'required',
            'birth_date' => 'required|date',
            'department_code'     => 'required',
        ]);

        $user = UserEmployees::where('empl_id', $request->empl_id)
            ->where('first_name', $request->first_name)
            ->where('last_name', $request->last_name)
            ->where('birth_date', $request->birth_date)
            ->where('department_code', $request->department_code)
            ->first();

        if ($user) {
            // Reset password in UserEmployeeCredentials
            $pass_encrypt = md5('password1.');
            // UserEmployeeCredential::where('username', $user->empl_id)->update([
            //     'password' => md5('password1.')
            // ]);
            $user = UserEmployeeCredential::where('username', $user->empl_id)->first();
            $old_pass = $user->password;
            $user->password = $pass_encrypt;
            $user->save();

            //SAVING INTO PASSWORD CHANGE LOG
            $host = "";
            $add = "";
            try {
                $host = $request->header('User-Agent');
                $add = $request->ip();
            } catch (Exception $ex) {
            }
            $pass_log = new ChangeLog();
            $pass_log->employee_cats = $request->empl_id;
            $pass_log->acted_by = '';
            $pass_log->previous = $old_pass;
            $pass_log->current = $pass_encrypt;
            $pass_log->requested_by = '';
            $pass_log->impersonated_by = '';
            $pass_log->address = $add;
            $pass_log->host = $host;
            $pass_log->save();
            // Redirect to login page
            return redirect()->route('login')->with('success', 'Password has been reset. Please log in.');
        } else {
            // Return back with error message
            return redirect()->back()->withInput()->withErrors([
                'credentials' => 'Your details do not match any of our records.',
            ]);
        }
    }
}
