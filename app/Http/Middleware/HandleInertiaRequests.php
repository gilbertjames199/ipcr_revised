<?php

namespace App\Http\Middleware;

use App\Models\Ipcr_Semestral;
use App\Models\MonthlyAccomplishment;
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
            // dd(auth()->user());
            // if (session()->has('impersonating')) {
            //     // $request->attributes->set('impersonating', true);
            //     dd('is impersonating');
            // } else {
            //     dd('no');
            // }
            $impersonating = 'no';
            if (session()->has('impersonating')) {
                // $request->attributes->set('impersonating', true);
                if (session('impersonating') == true) {
                    $impersonating = 'yes';
                } else {
                    $impersonating = 'no';
                }
            }
            $empl_code = auth()->user()->username;
            if (isset($profile->salary_grade)) {
                $sg = $profile->salary_grade;
            }
            // $targ_notif = Ipcr_Semestral::where(function ($query) use ($empl_code) {
            //     $query->where('status', '0')
            //         ->where('immediate_id', $empl_code);
            // })->orWhere(function ($query) use ($empl_code) {
            //     $query->where('status', '1')
            //         ->where('next_higher', $empl_code);
            // })->count();

            // $accomp_sem_notiff = Ipcr_Semestral::where(function ($query) use ($empl_code) {
            //     $query->where('status_accomplishment', '0')
            //         ->where('immediate_id', $empl_code);
            // })->orWhere(function ($query) use ($empl_code) {
            //     $query->where('status_accomplishment', '1')
            //         ->where('next_higher', $empl_code);
            // })->count();

            // $monthly_accomp = MonthlyAccomplishment::with('ipcrSemestral')
            //     ->whereHas('ipcrSemestral', function ($query) use ($empl_code) {

            //         $query->where(function ($query) use ($empl_code) {
            //             $query->where('ipcr__semestrals.immediate_id', $empl_code)
            //                 ->where('ipcr_monthly_accomplishments.status', '=', '0');
            //         })
            //             ->orWhere(function ($query) use ($empl_code) {
            //                 $query->where('ipcr__semestrals.next_higher', $empl_code)
            //                     ->where('ipcr_monthly_accomplishments.status', '>', '0')
            //                     ->where('ipcr_monthly_accomplishments.status', '<', '2');
            //             });
            //     })
            //     ->count();
            $targ_notif = 0;
            $accomp_sem_notiff = 0;
            $monthly_accomp = 0;
            // dd(auth()->user()->username);
            // dd($monthly_accomp);
            // dd($accomp_sem_notiff);
            // dd($impersonating);
            return array_merge(parent::share($request), [
                'auth' => auth()->user() ? [ //if there is a user
                    'user' => [
                        'username' => ucfirst(auth()->user()->username),
                        'name' => $profile,
                        'department_code' => auth()->user()->department_code,
                        'division_code' => auth()->user()->division_code,
                        'salary_grade' => $sg
                    ],
                    'targets' => $targ_notif,
                    'sem' => $accomp_sem_notiff,
                    'month' => $monthly_accomp,
                    'impersonating' => $impersonating
                ] : null,
                'flash' => [
                    'message' => fn() => $request->session()->get('message'),
                    'error' => fn() => $request->session()->get('error'),
                    'info' => fn() => $request->session()->get('info'),
                    'deleted' => fn() => $request->session()->get('deleted'),
                ],
            ]);
        }

        return [];
    }
}
