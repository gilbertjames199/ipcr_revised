<?php

namespace App\Http\Controllers;

use App\Models\EmployeeSpecialDepartment;
use App\Models\Office;
use App\Models\UserEmployees;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmployeeSpecialDepartmentController extends Controller
{
    protected $esd;
    public function __construct(EmployeeSpecialDepartment $esd)
    {
        $this->esd = $esd;
    }
    public function index(Request $request)
    {
        // dd(auth()->user());
        $emp = auth()->user()->username;
        // dd('index');
        // if ($dept_code == '26' || $dept_code == '03') {
        // }
        $page = 10;
        if ($request->page) {
            $page = $request->page;
        }
        if ($emp == '2730' || $emp == '2960' || $emp == '8354' || $emp == '8510') {
            $data = $this->esd->select(
                'employee_special_departments.id',
                'employee_special_departments.employee_code',
                'employee_special_departments.department_code AS sp_dept',
                'employee_special_departments.designate_department_code AS sp_desig',
                'employee_special_departments.pgdh_cats',
                'user_employees.employee_name',
                'offices.office'
            )
                ->when($request->search, function ($query) use ($request) {
                    $query->where('user_employees.employee_name', 'LIKE', '%' . $request->search . '%');
                })
                ->leftjoin('user_employees', 'user_employees.empl_id', 'employee_special_departments.employee_code')
                ->leftjoin(DB::connection('mysql2')->getDatabaseName() . '.offices', 'offices.department_code', '=', 'employee_special_departments.department_code')
                ->paginate($page)
                ->withQueryString();
            // dd($data);
            return inertia('EmployeeSpecialDepartment/Index', [
                "data" => $data,
                "filters" => $request->only(['search']),
            ]);
        } else {
            return redirect('/forbidden')
                ->with('error', 'Access forbidden!');
        }
    }
    public function create(Request $request)
    {
        // dd("create create");
        $employees = UserEmployees::select(
            'empl_id',
            'employee_name',
            'salary_grade',
            'department_code',
            'designate_department_code',
            'active_status',
            DB::raw('NULL as office')
        )
            ->with('Office')
            ->where('active_status', 'ACTIVE')
            ->orderBy('employee_name', 'ASC')->get();

        // foreach ($employees as $employee) {
        //     $dept = $employee->department_code;
        //     dd($dept);
        //     $office = Office::where()
        // }
        // dd(count($employees));
        $offices = Office::where('office', 'LIKE', '%Office%')->orderBy('office', 'ASC')->get();
        $pgdhs = UserEmployees::where('is_pghead', '1')->get();
        // dd($pgdhs);
        return inertia('EmployeeSpecialDepartment/Create', [
            "employees" => $employees,
            "offices" => $offices,
            "pgdhs" => $pgdhs
        ]);
    }
    public function store(Request $request)
    {
        // dd("store");
        // dd($request);
        $attributes = $request->validate([
            'employee_code' => 'required',
            // 'department_code' => 'required',
            // 'designate_department_code' => 'required',
            // 'pgdh_cats' => 'required'
        ]);
        // $this->esd->create($attributes);
        //Check if employee already exists
        $cc = EmployeeSpecialDepartment::where('employee_code', $request->employee_code)->count();
        // dd($cc);
        if (intval($cc) > 0) {
            return redirect('/employee/special/department')->with('error', 'Employee already added!');
        } else {
            $esdd = new EmployeeSpecialDepartment();
            $esdd->employee_code = $request->employee_code;
            $esdd->department_code = $request->department_code;
            $esdd->designate_department_code = $request->designate_department_code;
            $esdd->pgdh_cats = $request->pgdh_cats;
            $esdd->save();
            return redirect('/employee/special/department')->with('message', 'Employee special department successfully created');
        }
    }
    public function edit(Request $request, $id)
    {
        $employees = UserEmployees::where('active_status', 'ACTIVE')->orderBy('employee_name', 'ASC')->get();
        $offices = Office::where('office', 'LIKE', '%Office%')->orderBy('office', 'ASC')->get();
        $pgdhs = UserEmployees::where('is_pghead', '1')->get();
        $editData = $this->esd->findOrFail($id);
        // dd($pgdhs);
        return inertia('EmployeeSpecialDepartment/Create', [
            "editData" => $editData,
            "employees" => $employees,
            "offices" => $offices,
            "pgdhs" => $pgdhs
        ]);
    }
    public function update(Request $request, $id)
    {
        // dd("update ESD");
        // dd($id);
        $data = $this->esd->findOrFail($request->id);
        $data->update([
            'employee_code' => $request->employee_code,
            'department_code' => $request->department_code,
            'designate_department_code' => $request->designate_department_code,
            'pgdh_cats' => $request->pgdh_cats,
        ]);
        return redirect('/employee/special/department')->with('info', 'Employee special department successfully updated!');
    }
    public function destroy(Request $request, $id)
    {
        // dd("delete: " . $id);
        $data = $this->esd->findOrFail($id);
        $data->delete();

        return redirect('/employee/special/department')->with('deleted', 'Employee special department successfully deleted!');
    }
}
