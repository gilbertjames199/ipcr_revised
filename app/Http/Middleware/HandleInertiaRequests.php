<?php

namespace App\Http\Middleware;

use App\Models\User;
use App\Models\UserEmployees;
use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    protected $rootView = 'app';

    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    public function share(Request $request): array
    {
        if (auth()->check()) {
            $profile =  UserEmployees::where('empl_id', auth()->user()->username)
                ->first();
            $sg = '0';
            if (isset($profile->salary_grade)) {
                $sg = $profile->salary_grade;
            }
            return array_merge(parent::share($request), [
                'auth' => auth()->user() ? [ //if there is a user
                    'user' => [
                        'username' => ucfirst(auth()->user()->username),
                        'name' => $profile,
                        'department_code' => auth()->user()->department_code,
                        'division_code' => auth()->user()->division_code,
                        'salary_grade' => $sg
                    ]
                ] : null,
                'flash' => [
                    'message' => fn () => $request->session()->get('message'),
                    'error' => fn () => $request->session()->get('error'),
                    'info' => fn () => $request->session()->get('info'),
                    'deleted' => fn () => $request->session()->get('deleted'),
                ],
            ]);
        }

        return [];
    }
}
