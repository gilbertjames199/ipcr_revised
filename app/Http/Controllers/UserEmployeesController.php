<?php

namespace App\Http\Controllers;

use App\Models\ChangeLog;
use App\Models\Division;
use App\Models\EmailChangeLog;
use App\Models\Office;
use App\Models\UserEmployeeCredential;
use App\Models\UserEmployees;
use Exception;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Session\Session as SessionSession;

class UserEmployeesController extends Controller
{
    protected $us_emp;
    public function _construct(UserEmployees $us_emp)
    {
        $this->us_emp = $us_emp;
    }
    public function index(Request $request)
    {
        $logged_emp = UserEmployees::where('empl_id', auth()->user()->username)
            ->first();
        // dd($logged_emp);
        $dept_code = $logged_emp->department_code;

        $sg = $logged_emp->salary_grade;
        if (intval($sg) >= 0) {
            $data = UserEmployees::with('Division')->with('Office')->where('department_code', $dept_code)
                ->when($request->EmploymentStatus, function ($query, $searchItem) {
                    $query->where('employment_type_descr', 'LIKE', '%' . $searchItem . '%');
                })
                ->orderBy('user_employees.employee_name', 'ASC')
                ->paginate(10)
                ->withQueryString();
            // ->through(function($item){
            //     return [
            //         'empl_id'=>$item,
            //         'employee_name'=>$item,
            //         'employment_type_descr'=>$item,
            //         'position_long_title'=>$item,
            //         'division'=>$item,
            //         'office'=>$item,
            //     ];
            // })
            return inertia(
                'Employees/Index',
                [
                    "users" => $data
                ]
            );
        } else {
            return redirect('/forbidden')
                ->with('error', 'Access forbidden!');
        }
    }
    public function all_employees(Request $request)
    {
        // dd(auth()->user()->department_code);
        $dept = auth()->user()->department_code;
        $usn = auth()->user()->username;
        // dd($request->search);

        if ($dept == '26' && ($usn == '8510' || $usn == '8354' || $usn == '2003' || $usn == '8447' || $usn == '8753')) {
            $cats = auth()->user()->username;
            $data = UserEmployees::with('Division', 'Office', 'credential')
                ->when($request->EmploymentStatus, function ($query, $searchItem) {
                    $query->where('employment_type_descr', 'LIKE', '%' . $searchItem . '%');
                })
                ->when($request->office, function ($query) use ($request) {
                    $query->where('department_code',  $request->office);
                })
                ->when($request->division, function ($query) use ($request) {
                    // dd($request->division);
                    $query->where('division_code',  $request->division);
                })
                ->when($request->search, function ($query) use ($request) {
                    $query->where(function ($query) use ($request) {
                        $query->where('employee_name', 'LIKE', '%' . $request->search . '%')
                            ->where('user_employees.active_status', 'ACTIVE')
                            ->OrWhere(Division::select('division_name1')->whereColumn('divisions.division_code', 'user_employees.division_code'), 'LIKE', '%' . $request->search . '%')
                            ->OrWhere(Office::select('office')->whereColumn('offices.department_code', 'user_employees.department_code'), 'LIKE', '%' . $request->search . '%');
                    })
                        ->Orwhere(function ($query) use ($request) {
                            $query->where('empl_id', 'LIKE', '%' . $request->search . '%')
                                ->where('user_employees.active_status', 'ACTIVE')
                                ->OrWhere(Division::select('division_name1')->whereColumn('divisions.division_code', 'user_employees.division_code'), 'LIKE', '%' . $request->search . '%')
                                ->OrWhere(Office::select('office')->whereColumn('offices.department_code', 'user_employees.department_code'), 'LIKE', '%' . $request->search . '%');
                        });
                })
                ->where('user_employees.active_status', 'ACTIVE')
                ->orderBy('user_employees.employee_name', 'ASC')
                ->paginate(10)
                ->withQueryString();

            // $divisions = Division::all();
            $offices = Office::where(function ($query) {
                $query->where('office', 'LIKE', '%Office%')
                    ->orWhere('office', 'Like', '%Hospital%');
            })
                ->where('office', '<>', 'NO OFFICE')
                ->orderBy('office', 'ASC')
                ->get();
            // dd($divisions);
            return inertia(
                'Employees/All/Index',
                [
                    "users" => $data,
                    "filters" => $request->only(['search']),
                    // "divisions" => $divisions,
                    "offices" => $offices
                ]
            );
        } else {
            return redirect('forbidden')->with('error', 'You are forbidden to access this page!');
        }
    }
    public function resetpass(Request $request, $id)
    {
        // dd($id);
        // dd($request);
        $user_val = 'password1.';
        $pass_encrypt = md5($user_val);
        $user = UserEmployeeCredential::find($id);
        if ($user) {
            $rb = "";
            if ($request->requestor_id) {
                $rb = UserEmployees::where('empl_id', $request->requestor_id)->first()->employee_name;
            } else {
                $rb = UserEmployees::where('empl_id', $user->username)->first()->employee_name;
            }
            $host = "";
            $add = "";
            try {
                $host = $request->header('User-Agent');
                $add = $request->ip();
            } catch (Exception $ex) {
            }

            $previous = $user->password;
            $user->update(['password' => $pass_encrypt]);
            $pass_log = new ChangeLog();
            $pass_log->employee_cats = $user->username;
            $pass_log->acted_by = Auth::user()->username;
            $pass_log->previous = $previous;
            $pass_log->current = $pass_encrypt;
            $pass_log->requested_by = $rb;
            $pass_log->address = $add;
            $pass_log->host = $host;
            $pass_log->save();
            return back()->with('message', 'password reset successful');
        } else {
            return back()->with('error', 'user not found, unable to reset password');
        }
        // UserEmployeeCredential::where()
    }
    private function invalidateOtherSessions($userId)
    {
        // Get the user's current session ID
        $currentSessionId = session()->getId();

        // Get all active sessions for the user
        $sessions = session()->where('user_id', $userId)->get();

        // Invalidate all other sessions
        foreach ($sessions as $session) {
            if ($session->id !== $currentSessionId) {
                $session->invalidate();
            }
        }
    }
    public function resetEmail(Request $request)
    {
        // dd('update email');
        $curr = auth()->user();

        $em = UserEmployeeCredential::where('email', $request->email)->first();
        // dd($request->id);
        if ($em) {
            // dd('unsuccessful kay existing na po!!!!');
            return redirect('/employees/all')->with('error', 'Please use a different email');
        }
        $host = "";
        $add = "";
        try {
            $host = $request->header('User-Agent');
            $add = $request->ip();
        } catch (Exception $ex) {
        }
        $user_cred = UserEmployeeCredential::where('username', $request->id)->first();
        if ($user_cred) {
            $prev_mail = $user_cred->email;
            $uname = $user_cred->username;
            $user_cred->email = $request->email;
            $user_cred->save();
            // dd($uname);
            $emp = UserEmployees::where('empl_id', $uname)->first();
            $useremp = UserEmployees::where('empl_id', $curr->username)->first();
            // dd($request->email);
            $emlog = new EmailChangeLog();
            $emlog->prev_email = $prev_mail;
            $emlog->new_email = $request->email;
            $emlog->username = $uname;
            $emlog->edited_by_cats = $curr->username;
            $emlog->username_long = $useremp->employee_name;
            $emlog->edited_by_name = $emp->employee_name;
            $emlog->host = $host;
            $emlog->address = $add;
            $emlog->save();
            $msg = 'Email of ' . $emp->employee_name . ' successfully updated!';
            return back()->with('message', $msg);
        } else {
            // return redirect()->back()->with('error', 'User not found!');
            return redirect('/employees/all')->with('error', 'User not found!');
        }
        // dd($request->id);
    }
    public function set_my_email(Request $request)
    {
        // dd('email');
        return inertia(
            'Users/ChangeEmail',
            [
                "email" => auth()->user()->email
            ]
        );
    }
    public function update_email(Request $request)
    {
        // dd('email update');
        // dd($request);
        $empl_id = auth()->user()->username;

        $e_find = UserEmployeeCredential::where('email', $request->email)->first();
        if ($e_find && ($request->email != '' || $request->email != NULL)) {
            // dd('efind');
            dd($e_find);
            return back()->with('error', 'Please type a unique email');
        } else {
            $us = UserEmployeeCredential::where('username', $empl_id)->first();
            $us->email = $request->email;
            $us->save();
            return back()->with('message', 'Email successfully updated');
        }
    }
    public function get_division(Request $request, $dept_code)
    {
        // dd($dept_code);
        return Division::where('department_code', $dept_code)
            ->get();
    }
    public function email_log(Request $request)
    {
        // dd('log');
        $emlog = EmailChangeLog::simplePaginate(10);
        // dd($emlog);
        return inertia('Employees/EmailChangeLog/Index', [
            'emlog' => $emlog
        ]);
    }
}
