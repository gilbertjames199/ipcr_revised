<?php

namespace App\Http\Middleware;

use App\Models\Ipcr_Semestral;
use App\Models\MonthlyAccomplishment;
use App\Models\User;
use App\Models\UserEmployees;
use Carbon\Carbon;
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
            $targ_notif = 0;
            $accomp_sem_notiff = 0;
            $monthly_accomp = 0;
            $should_update_password = "no";
            // $profile =  UserEmployees::where('empl_id', auth()->user()->username)
            //     ->first();
            $profile = auth()->user()->load(['userEmployee', 'passwordChangeLog' => function ($query) {
                $query->latest()->first();
            }]);
            // dd($profile);

            if ($profile->passwordChangeLog->isNotEmpty()) {
                $updated_at = Carbon::parse($profile->passwordChangeLog->first()->updated_at->format('Y-m-d'));
                $now = Carbon::now();
                // dd($updated_at->lt($now->subMonths(6)));
                if ($updated_at->lt($now->subMonths(6))) {
                    // dd($updated_at);
                    $this->update_password_compulsory();
                    $should_update_password = "yes";
                }
                // dd($profile->passwordChangeLog->first()->updated_at);
            } else {
                //update reset password to one
                $this->update_password_compulsory();
                $should_update_password = "yes";
            }
            $profile = $profile->userEmployee;
            // dd($profile->userEmployee);
            // dd($profile);

            $sg = '0';
            // dd(auth()->user());
            // if (session()->has('impersonating')) {
            //     // $request->attributes->set('impersonating', true);
            //     dd('is impersonating');
            // } else {
            //     dd('no');
            // }
            $mssg = "";
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
            // $targ_notif_query = $profile->getTargNotifQueryAttribute;
            // dd($targ_notif_query);
            // $targ_notif_query = Ipcr_Semestral::query()
            //     ->where(function ($query) use ($empl_code) {
            //         $query->where('status', '0')
            //             ->where('immediate_id', $empl_code);
            //     })
            //     ->orWhere(function ($query) use ($empl_code) {
            //         $query->where('status', '1')
            //             ->where('next_higher', $empl_code);
            //     });

            // $accomp_sem_notiff_query = Ipcr_Semestral::query()
            //     ->where(function ($query) use ($empl_code) {
            //         $query->where('status_accomplishment', '0')
            //             ->where('immediate_id', $empl_code);
            //     })
            //     ->orWhere(function ($query) use ($empl_code) {
            //         $query->where('status_accomplishment', '1')
            //             ->where('next_higher', $empl_code);
            //     });

            // $monthly_accomp_query = MonthlyAccomplishment::with('ipcrSemestral')
            //     ->whereHas('ipcrSemestral', function ($query) use ($empl_code) {
            //         $query->where(function ($query) use ($empl_code) {
            //             $query->where('ipcr__semestrals.immediate_id', $empl_code)
            //                 ->where('ipcr_monthly_accomplishments.status', '0');
            //         })
            //             ->orWhere(function ($query) use ($empl_code) {
            //                 $query->where('ipcr__semestrals.next_higher', $empl_code)
            //                     ->where('ipcr_monthly_accomplishments.status', '>', '0')
            //                     ->where('ipcr_monthly_accomplishments.status', '<', '2');
            //             });
            //     });

            // $targ_notif = $targ_notif_query->count();
            // $accomp_sem_notiff = $accomp_sem_notiff_query->count();
            // $monthly_accomp = $monthly_accomp_query->count();


            // dd(auth()->user()->username);
            // dd($monthly_accomp);
            // dd($accomp_sem_notiff);
            // dd($impersonating);
            // dd(auth()->user());
            $us = auth()->user()->load('userEmployee');
            // dd($us->userEmployee->ao_status);
            return array_merge(parent::share($request), [
                'auth' => auth()->user() ? [ //if there is a user
                    'user' => [
                        'username' => ucfirst(auth()->user()->username),
                        'name' => $profile,
                        'department_code' => auth()->user()->department_code,
                        'division_code' => auth()->user()->division_code,
                        'salary_grade' => $sg,
                        'ao_status' => $us->userEmployee ? $us->userEmployee->ao_status : ""
                    ],
                    'targets' => $targ_notif,
                    'sem' => $accomp_sem_notiff,
                    'month' => $monthly_accomp,
                    'impersonating' => $impersonating,
                    'message_for_password' => $mssg,
                    'shoud_update_password' => $should_update_password
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
    public function update_password_compulsory()
    {
        $us = User::find(auth()->user()->id);
        $us->reset_all_password = 1;
        $us->save();
    }
    // public function share(Request $request): array
    // {
    //     if (auth()->check()) {
    //         $targ_notif = 0;
    //         $accomp_sem_notiff = 0;
    //         $monthly_accomp = 0;
    //         // $profile =  UserEmployees::where('empl_id', auth()->user()->username)
    //         //     ->first();
    //         $profile = auth()->user()->load('userEmployee');
    //         $profile = $profile->userEmployee;
    //         // dd($profile->userEmployee);
    //         // dd($profile);
    //         $sg = '0';
    //         $empl_code = auth()->user()->username;
    //         if (isset($profile->salary_grade)) {
    //             $sg = $profile->salary_grade;
    //         }
    //         // $targ_notif = Ipcr_Semestral::where(function ($query) use ($empl_code) {
    //         //     $query->where('status', '0')
    //         //         ->where('immediate_id', $empl_code);
    //         // })->orWhere(function ($query) use ($empl_code) {
    //         //     $query->where('status', '1')
    //         //         ->where('next_higher', $empl_code);
    //         // })->count();

    //         // $accomp_sem_notiff = Ipcr_Semestral::where(function ($query) use ($empl_code) {
    //         //     $query->where('status_accomplishment', '0')
    //         //         ->where('immediate_id', $empl_code);
    //         // })->orWhere(function ($query) use ($empl_code) {
    //         //     $query->where('status_accomplishment', '1')
    //         //         ->where('next_higher', $empl_code);
    //         // })->count();

    //         // $monthly_accomp = MonthlyAccomplishment::with('ipcrSemestral')
    //         //     ->whereHas('ipcrSemestral', function ($query) use ($empl_code) {

    //         //         $query->where(function ($query) use ($empl_code) {
    //         //             $query->where('ipcr__semestrals.immediate_id', $empl_code)
    //         //                 ->where('ipcr_monthly_accomplishments.status', '=', '0');
    //         //         })
    //         //             ->orWhere(function ($query) use ($empl_code) {
    //         //                 $query->where('ipcr__semestrals.next_higher', $empl_code)
    //         //                     ->where('ipcr_monthly_accomplishments.status', '>', '0')
    //         //                     ->where('ipcr_monthly_accomplishments.status', '<', '2');
    //         //             });
    //         //     })
    //         //     ->count();

    //         // dd(auth()->user()->username);
    //         // dd($monthly_accomp);
    //         // dd($accomp_sem_notiff);
    //         return array_merge(parent::share($request), [
    //             'auth' => auth()->user() ? [ //if there is a user
    //                 'user' => [
    //                     'username' => ucfirst(auth()->user()->username),
    //                     'name' => $profile,
    //                     'department_code' => auth()->user()->department_code,
    //                     'division_code' => auth()->user()->division_code,
    //                     'salary_grade' => $sg
    //                 ],
    //                 'targets' => $targ_notif,
    //                 'sem' => $accomp_sem_notiff,
    //                 'month' => $monthly_accomp
    //             ] : null,
    //             'flash' => [
    //                 'message' => fn() => $request->session()->get('message'),
    //                 'error' => fn() => $request->session()->get('error'),
    //                 'info' => fn() => $request->session()->get('info'),
    //                 'deleted' => fn() => $request->session()->get('deleted'),
    //             ],
    //         ]);
    //     }

    //     return [];
    // }
}
