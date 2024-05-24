<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CheckDefaultPassword
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
        // dd(Auth::user()->password);
        $user = Auth::user();
        // dd($user);
        if ($user && ($user->password === md5('password1.') || $user->reset_all_password == 1)) {
            if (!in_array($request->path(), ['users/change-password', 'users/update-password', 'logout'])) {
                return redirect('/users/change-password');
            }
        }
        return $next($request);
    }
}
