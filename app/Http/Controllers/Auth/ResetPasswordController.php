<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\ChangeLog;
use App\Models\User;
use App\Models\UserEmployeeCredential;
use App\Models\UserEmployees;
use App\Providers\RouteServiceProvider;
use Exception;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    public function reset(Request $request)
    {
        //GET EMAIL AND OTP
        $email = $request->email;
        $otp = $request->otp;
        // dd($otp);
        // dd($request);
        // SET PASSWORD AND CONFIRM PASSWORD TO PASSWORD1.
        $uec = UserEmployeeCredential::where('email', $email)->where('otp', $otp)->first();
        if ($uec) {
            //CATS as username
            $cats = $uec->username;
            //UPDATE fields you need to change
            $uec->otp = '';
            $uec->otp_created_at = '';
            $uec->password = md5('password1.');
            $uec->save();
            $user_p = User::where('username', $cats)
                ->where('email', $email)
                ->first();
            if ($user_p) {
                Auth::login($user_p, true);
            } else {
                $mssg = 'Invalid password ';
                return back()->withErrors(['message' => $mssg])
                    ->withInput($request->only('UserName'));
            }
        } else {
            $mssg = 'You may have typed a wrong OTP or the link is invalid!';
            return back()->withErrors(['message' => $mssg])
                ->withInput($request->only('UserName'));
        }
        return redirect('/')->with('message', 'Password reset successefully');
    }

    public function showResetForm(Request $request)
    {
        // dd('resetform show');
        $token = $request->route()->parameter('token');
        $email = $request->input('email'); // or use $request->query('email') if it's a query parameter

        // Query the password_resets table to find the hashed token
        $passwordReset = DB::table('password_resets')->where('email', $email)->first();
        if ($passwordReset) {
            $currentDateTime = Carbon::now();
            $createdAt = Carbon::parse($passwordReset->created_at);
            // dd($currentDateTime);
            // Compare if the dates are the same and the current time is within 5 minutes of the created_at time

            $uec = UserEmployeeCredential::where('email', $request->email)->first();
            if ($uec) {
                if ($uec->otp != '') {
                    if (
                        $currentDateTime->toDateString() === $createdAt->toDateString() &&
                        $currentDateTime->diffInMinutes($createdAt) <= 15
                    ) {
                        if ($passwordReset && Hash::check($token, $passwordReset->token)) {
                            return view('auth.passwords.reset')->with(
                                ['token' => $token, 'email' => $email]
                            );
                        } else {
                            // Handle the case where the token is invalid or expired
                            return redirect()->route('invalid-reset-link');
                            // return redirect()->route('password.request')->withErrors(['token' => 'Invalid or expired token.']);
                        }
                    } else {
                        return redirect()->route('invalid-reset-link');
                    }
                } else {
                    return redirect()->route('invalid-reset-link');
                }
            } else {
                return redirect()->route('invalid-reset-link');
            }
        } else {
            return redirect()->route('invalid-reset-link');
        }



        // dd($token);
        // dd($request);
        // $hashedToken = Hash::make($token);
        // $passwordReset = DB::table('password_resets')->where('token', Hash::make($token))->first();
        // if ($passwordReset) {
        //     dd($passwordReset->email);
        // }
        // // dd($request);
        // // $password_resets =DB::select
        // // dd($request);
        // return view('auth.passwords.reset')->with(
        //     ['token' => $token, 'email' => $request->email]
        // );
    }
    // public function reset(Request $request)
    // {
    //     // dd($request);

    //     //GET EMAIL AND OTP
    //     $email = $request->email;
    //     $otp = $request->otp;
    //     // $password = $request->password;
    //     // $password_confirm = $request->password_confirmation;

    //     // SET PASSWORD AND CONFIRM PASSWORD TO PASSWORD1.
    //     $password = 'password1.';
    //     // $password_confirm = 'password1.';
    //     $uec = UserEmployeeCredential::where('email', $email)->where('otp', $otp)->first();
    //     if ($uec) {
    //         // dd($uec);
    //         // $emp = UserEmployeeCredential::where('email', $email)->first();
    //         // $old_pass = $emp->password;
    //         //set password to password1.

    //         //CATS as username
    //         $cats = $uec->username;

    //         //UPDATE fields you need to change
    //         $uec->otp = '';
    //         $uec->otp_created_at = '';
    //         $uec->password = md5('password1.');
    //         $uec->save();
    //         $user_p = User::where('username', $cats)
    //             ->where('email', $email)
    //             ->first();
    //         // $add = "";
    //         // try {
    //         //     $host = $request->header('User-Agent');
    //         //     $add = $request->ip();
    //         // } catch (Exception $ex) {
    //         // }
    //         if ($user_p) {
    //             // $name = UserEmployees::where('empl_id', $user_p->username)->first()->employee_name;
    //             // $pass_log = new ChangeLog();
    //             // $pass_log->employee_cats = $cats;
    //             // $pass_log->acted_by = $cats;
    //             // $pass_log->previous = $old_pass;
    //             // $pass_log->current = md5($password);
    //             // $pass_log->requested_by = $name;
    //             // $pass_log->address = $add;
    //             // $pass_log->host = $host;
    //             // $pass_log->save();
    //             Auth::login($user_p, true);
    //             // if ($password == 'password1.') {
    //             //     return redirect('/users/change-password');
    //             // }
    //         } else {
    //             $mssg = 'Invalid password ';
    //             return back()->withErrors(['message' => $mssg])
    //                 ->withInput($request->only('UserName'));
    //         }
    //     } else {
    //         $mssg = 'Invalid password ';
    //         return back()->withErrors(['message' => $mssg])
    //             ->withInput($request->only('UserName'));
    //     }



    //     return redirect('/')->with('message', 'Password reset successefully');
    // }
    // public function sendResetLinkEmail(Request $request)
    // {
    //     // dd('resent');
    //     $request->validate(['email' => 'required|email']);

    //     $user = DB::table('user_employee_credentials')->where('email', $request->email)->first();

    //     if (!$user) {
    //         return back()->withErrors(['email' => trans('passwords.user')]);
    //     }

    //     $status = Password::sendResetLink(
    //         $request->only('email')
    //     );

    //     if ($status == Password::RESET_LINK_SENT) {
    //         return back()->with(['status' => __($status)]);
    //     } else {
    //         return back()->withErrors(['email' => __($status)]);
    //     }
    // }
    function laravelOutput()
    {
        $array = [
            [1, 3, 5],
            [
                1, 6, 4
            ],
            [8, 5, 4]
        ];

        // Flatten the array
        $flattenedArray = array_merge(...$array);

        // Convert the array to a string
        $output = implode(' ', $flattenedArray);
        dd($output);
        // Print the output
        return $output;
    }
    function filamentStyle()
    {
        $input = 5; // you can change this to any number
        $output = '';

        for ($i = 0; $i <= $input; $i++) {
            for ($j = 0; $j < $input; $j++) {
                if ($j >= $input - $i) {
                    $output .= '* ';
                } else {
                    $output .= '  ';
                }
                $output .= "\n";
            }
        }

        // Dump and die the output
        dd($output);

        $num = [
            1, 2, 3, 4, 5, 6, 7, 8, 9, 10
        ];

        // Initialize arrays
        $arr1 = [];
        $arr2 = [];

        // Loop through the array
        foreach ($num as $temp) {
            if ($temp % 2 == 0) {
                $arr1[] = $temp;
            } else {
                $arr2[] = $temp;
            }
        }

        // Dump and die the results
        dd($arr1, $arr2);
        // dd($request);

    }
}
