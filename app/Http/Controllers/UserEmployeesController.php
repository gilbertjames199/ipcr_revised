<?php

namespace App\Http\Controllers;

use App\Models\Division;
use App\Models\Office;
use App\Models\UserEmployeeCredential;
use App\Models\UserEmployees;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
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
        $dept_code = auth()->user()->department_code;
        $logged_emp = UserEmployees::where('empl_id', auth()->user()->username)
            ->first();
        $sg = $logged_emp->salary_grade;
        if (intval($sg) >= 0) {
            $data = UserEmployees::with('Division')->with('Office')->where('department_code', $dept_code)
                ->when($request->EmploymentStatus, function ($query, $searchItem) {
                    $query->where('employment_type_descr', 'LIKE', '%' . $searchItem . '%');
                })
                ->paginate(10);
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
        if ($dept == '26') {
            // dd('rrr:' . $dept);  || $dept == '03'
            $cats = auth()->user()->username;
            // if ($dept == '03') {
            //     if ($cats == '2730' || $cats = '') {
            //     }
            // }
            // dd(auth()->user());
            $data = UserEmployees::with('Division', 'Office')
                ->when($request->EmploymentStatus, function ($query, $searchItem) {
                    $query->where('employment_type_descr', 'LIKE', '%' . $searchItem . '%');
                })
                ->when($request->search, function ($query, $searchItem) {
                    $query->where('employee_name', 'LIKE', '%' . $searchItem . '%')
                        ->OrWhere(Division::select('division_name1')->whereColumn('divisions.division_code', 'user_employees.division_code'), 'LIKE', '%' . $searchItem . '%')
                        ->OrWhere(Office::select('office')->whereColumn('offices.department_code', 'user_employees.department_code'), 'LIKE', '%' . $searchItem . '%');
                })
                ->orderBy('user_employees.employee_name', 'ASC')
                ->paginate(10);
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
            $user->update(['password' => $pass_encrypt]);
            $this->invalidateOtherSessions($user->username);
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
