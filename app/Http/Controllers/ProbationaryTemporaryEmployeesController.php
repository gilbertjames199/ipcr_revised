<?php

namespace App\Http\Controllers;

use App\Models\Division;
use App\Models\Office;
use App\Models\ProbationaryTemporaryEmployees;
use App\Models\UserEmployees;
use Illuminate\Http\Request;

class ProbationaryTemporaryEmployeesController extends Controller
{
    protected $model;
    public function __construct(ProbationaryTemporaryEmployees $model)
    {
        $this->model = $model;
    }
    public function index(Request $request)
    {
        $dept_code = auth()->user()->department_code;
        $logged_emp = UserEmployees::where('empl_id', auth()->user()->username)
            ->first();
        // dd($logged_emp);

        $sg = $logged_emp->salary_grade;
        if ($dept_code == '26') {
            $offices = Office::get();
            $divisions = Division::get();

            $data = UserEmployees::select(
                'user_employees.id',
                'user_employees.employee_name',
                'probationary_temporary_employees.id AS p_id',
                'probationary_temporary_employees.date_from',
                'probationary_temporary_employees.date_to',
                'probationary_temporary_employees.prob_status',
                'user_employees.division_code',
                'user_employees.department_code'
            )
                ->with('Division')->with('Office')
                ->when($request->EmploymentStatus, function ($query, $searchItem) {
                    $query->where('employment_type_descr', 'LIKE', '%' . $searchItem . '%');
                    // dd($searchItem);
                })
                ->when($request->department_code, function ($query, $department_code) {
                    $query->where('department_code', $department_code);
                })
                ->join('probationary_temporary_employees', 'probationary_temporary_employees.employee_code', 'user_employees.empl_id')
                ->paginate(10);
            // dd($data);
            return inertia(
                'Employees/ProbationaryFlex/Index',
                [
                    "offices" => $offices,
                    "divisions" => $divisions,
                    "users" => $data
                ]
            );
        } else {
            return redirect('/forbidden')
                ->with('error', 'Access forbidden!');
        }
    }
    public function create(Request $request)
    {
        $offices = Office::get();
        $divisions = Division::get();
        $employees = UserEmployees::get();
        $supervisors = UserEmployees::get();
        return inertia('Employees/ProbationaryFlex/Create', [
            'offices' => $offices,
            'divisions' => $divisions,
            'employees' => $employees,
            'supervisors' => $supervisors
        ]);
    }
    public function store(Request $request)
    {
        // dd($request->quantity[3]);
        // dd($request);
        $request->validate([
            'employee_code' => 'required',
            'prob_status' => 'required',
            'no_of_months' => 'required|integer|min:1',
            'date_from' => 'required',
            'date_to' => 'required',
            'immediate_cats' => 'required',
            'next_higher_cats' => 'required'
        ]);
        $pbt = new ProbationaryTemporaryEmployees;
        $pbt->employee_code = $request->employee_code;
        $pbt->prob_status = $request->prob_status;
        $pbt->no_of_months = $request->no_of_months;
        $pbt->date_from = json_encode($request->date_from);
        $pbt->date_to = json_encode($request->date_to);
        $pbt->immediate_cats = $request->immediate_cats;
        $pbt->next_higher_cats = $request->next_higher_cats;
        $pbt->status = "-1";
        $pbt->save();
        // $id=$pbt->id;
        // for($i=0; $i<$request->no_of_months; $i++){
        //     $mo = new ProbationaryTemporaryMonths();
        //     $mo->probationary_temporary_employees_id=$id;
        //     $mo->quantity ='0';
        //     $mo->date_from	=$request->date_from[$i];
        //     $mo->date_to	=$request->date_to[$i];
        //     $mo->save();
        // }

        return redirect('/probationary')
            ->with('message', 'Probationary/Temporary Employee Added');
    }
    public function edit(Request $request, $id)
    {
        $offices = Office::get();
        $divisions = Division::get();
        $employees = UserEmployees::get();
        $data = ProbationaryTemporaryEmployees::where('id', $id)
            ->first();
        $date_from = json_decode($data->date_from);
        $date_to = json_decode($data->date_to);
        // dd($date_from);
        //$quantity = $monthly->pluck('quantity');
        return inertia('Employees/ProbationaryFlex/Create', [
            'offices' => $offices,
            'divisions' => $divisions,
            'employees' => $employees,
            'editData' => $data,
            'date_from' => $date_from,
            'date_to' => $date_to,
        ]);
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'employee_code' => 'required',
            'prob_status' => 'required',
            'no_of_months' => 'required|integer|min:1',
            'date_from' => 'required',
            'date_to' => 'required',
            'immediate_cats' => 'required',
            'next_higher_cats' => 'required'
        ]);
        $data = $this->model->findOrFail($id);
        $data->update([
            'employee_code' => $request->employee_code,
            'no_of_months' => $request->no_of_months,
            'prob_status' => $request->prob_status,
            'date_from' => json_encode($request->date_from),
            'date_to' => json_encode($request->date_to),
            'immediate_cats' => $request->immediate_cats,
            'next_higher_cats' => $request->next_higher_cats,
        ]);

        return redirect('/probationary')
            ->with('message', 'Data updated');
    }
    public function destroy(Request $request, $id)
    {
        // ProbationaryTemporaryMonths::where('probationary_temporary_employees_id', $request->id)
        //     ->delete();
        ProbationaryTemporaryEmployees::where('id', $request->id)->delete();
        return redirect('/probationary')
            ->with('message', 'Data deleted');
    }
    public function individual(Request $request)
    {
        //dd("indiv");
        $logged_emp = UserEmployees::where('empl_id', auth()->user()->username)
            ->first();

        $offices = Office::get();
        $divisions = Division::get();
        $data = UserEmployees::with(['Division', 'Office'])
            ->when($request->EmploymentStatus, function ($query, $searchItem) {
                $query->where('employment_type_descr', 'LIKE', '%' . $searchItem . '%');
            })
            ->when($request->department_code, function ($query, $department_code) {
                $query->where('department_code', $department_code);
            })
            ->where('probationary_temporary_employees.employee_code', $logged_emp->empl_id)
            ->join('probationary_temporary_employees', 'probationary_temporary_employees.employee_code', '=', 'user_employees.empl_id')
            ->paginate(10);

        // ->where('return_remarks.type', 'probationary/temporary')
        // ->join('return_remarks', 'return_remarks.ipcr_semestral_id', 'probationary_temporary_employees.id')

        // dd($logged_emp->empl_id);
        // $data = UserEmployees::with('Division')->with('Office')
        //     ->when($request->EmploymentStatus, function($query, $searchItem){
        //         $query->where('employment_type_descr','LIKE','%'.$searchItem.'%');
        //     })
        //     ->when($request->department_code, function($query, $department_code){
        //         $query->where('department_code',$department_code);
        //     })
        //     ->where('return_remarks.type','probationary/temporary')
        //     ->where('probationary_temporary_employees.employee_code',$logged_emp->empl_id)
        //     ->join('probationary_temporary_employees','probationary_temporary_employees.employee_code','user_employees.empl_id')
        //     ->join('return_remarks','return_remarks.ipcr_semestral_id','probationary_temporary_employees.id')
        //     ->paginate(10);
        //->where('return_remarks.ipcr_semestral_id','probationary/temporary')
        return inertia(
            'Employees/ProbationaryFlex/Individual',
            [
                "offices" => $offices,
                "divisions" => $divisions,
                "users" => $data
            ]
        );
    }
}
