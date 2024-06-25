<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Jobs\updateUserEmployeeCredentialOTP;
use App\Models\UserEmployeeCredential;
use App\Notifications\ResetPassword;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    public function sendResetLinkEmail(Request $request)
    {
        $this->generateRandomString();
        $request->validate(['email' => 'required|email']);

        $user = DB::table('user_employee_credentials')->where('email', $request->email)->first();
        // dd($user);

        if (!$user) {
            return back()->withErrors(['email' => trans('passwords.user')]);
        }
        $id = $user->id;
        $username = $user->username;
        $my_one = $this->generateRandomString();

        $my_mail = UserEmployeeCredential::find($id);
        // dd($my_mail);
        $my_mail->otp = $my_one;
        $my_mail->otp_created_at = date('Y-m-d H:i:s');
        $my_mail->save();

        // updateUserEmployeeCredentialOTP::dispatch($id, $username)->delay(now()->addMinutes(1));
        // dd($token);
        // Generate and save the password reset token
        // $token = Password::broker()->createToken($user);
        $string_tokenizer = '';
        $status = Password::broker()->sendResetLink(
            $request->only('email'),
            function ($user, $token) use ($my_one) {
                $user->notify(new ResetPassword($token, $user, $my_one));
            }
        );

        if ($status == Password::RESET_LINK_SENT) {
            return back()->with(['status' => __($status)]);
            // return
        } else {
            return back()->withErrors(['email' => __($status)]);
        }
    }

    function generateRandomString()
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
        $charactersLength = strlen($characters);
        $randomString = '';

        for ($i = 0; $i < 6; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }

        return $randomString;
    }
}
