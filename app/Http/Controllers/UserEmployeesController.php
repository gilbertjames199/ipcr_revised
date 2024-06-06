<?php

namespace App\Http\Controllers;

use App\Models\ChangeLog;
use App\Models\Division;
use App\Models\Office;
use App\Models\UserEmployeeCredential;
use App\Models\UserEmployees;
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

        if ($dept == '26' && ($usn == '8510' || $usn == '8354')) {
            $cats = auth()->user()->username;
            $data = UserEmployees::with('Division', 'Office')
                ->when($request->EmploymentStatus, function ($query, $searchItem) {
                    $query->where('employment_type_descr', 'LIKE', '%' . $searchItem . '%');
                })
                ->when($request->department_code, function ($query) use ($request) {
                    $query->where('employment_type_descr', 'LIKE', '%' . $request->department_code . '%');
                })
                ->when($request->search, function ($query, $searchItem) {
                    $query->where('employee_name', 'LIKE', '%' . $searchItem . '%')
                        ->where('user_employees.active_status', 'ACTIVE')
                        ->OrWhere(Division::select('division_name1')->whereColumn('divisions.division_code', 'user_employees.division_code'), 'LIKE', '%' . $searchItem . '%')
                        ->OrWhere(Office::select('office')->whereColumn('offices.department_code', 'user_employees.department_code'), 'LIKE', '%' . $searchItem . '%');
                })
                ->where('user_employees.active_status', 'ACTIVE')
                ->orderBy('user_employees.employee_name', 'ASC')
                ->paginate(10)
                ->withQueryString();
            return inertia(
                'Employees/All/Index',
                [
                    "users" => $data,
                    "filters" => $request->only(['search']),
                ]
            );
        } else {
            return redirect('forbidden')->with('error', 'You are forbidden to access this page!');
        }
    }
    public function resetpass(Request $request, $id)
    {
        // dd($id);
        $user_val = 'password1.';
        $pass_encrypt = md5($user_val);
        $user = UserEmployeeCredential::find($id);
        if ($user) {
            $rb = "";
            if ($request->requested_by) {
                $rb = $request->requested_by;
            } else {
                $rb = UserEmployees::where('empl_id', $user->username)->first()->employee_name;
            }
            $previous = $user->password;
            $user->update(['password' => $pass_encrypt]);
            $pass_log = new ChangeLog();
            $pass_log->employee_cats = $user->username;
            $pass_log->acted_by = Auth::user()->username;
            $pass_log->previous = $previous;
            $pass_log->current = $pass_encrypt;
            $pass_log->requested_by = $rb;
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
}
