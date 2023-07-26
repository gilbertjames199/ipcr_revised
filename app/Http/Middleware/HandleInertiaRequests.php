<?php

namespace App\Http\Middleware;

use App\Models\User;
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
            //$profile =  User::where('id', auth()->user()->id)->first()->getFirstMedia('avatars');

            return array_merge(parent::share($request), [
                'auth' => auth()->user() ? [ //if there is a user
                    'user' => [
                        'empl_id' => ucfirst(auth()->user()->empl_id),
                        'employee_name' =>auth()->user()->employee_name,
                        'department_code' =>auth()->user()->department_code,
                        'division_code' =>auth()->user()->division_code,

                    ]
                ] : null,
                'flash' => [
                    'message' => fn () => $request->session()->get('message'),
                    'error' => fn () => $request->session()->get('error'),
                ],
            ]);
        }

        return [];

    }
}
