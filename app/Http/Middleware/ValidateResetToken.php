<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ValidateResetToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        return $next($request);
        $token = $request->route('token'); // Extract token from route parameter
        $email = $request->input('email'); // Extract email from request input

        if (!$token || !$email) {
            // dd($email);
            return redirect()->route('invalid-reset-link');
        }
        $hashedToken = Hash::make($token);
        // dd($hashedToken);
        $record = DB::table('password_resets')
            ->where('email', $email)
            ->where('token', $hashedToken) // assuming token is hashed
            ->first();

        if (!$record) {
            return redirect()->route('invalid-reset-link');
        }

        $tokenExpiration = config('auth.passwords.users.expire', 60); // typically 60 minutes
        $expiresAt = Carbon::parse($record->created_at)->addMinutes($tokenExpiration);

        if (Carbon::now()->greaterThan($expiresAt)) {
            return redirect()->route('invalid-reset-link');
        }

        return $next($request);
    }
}
