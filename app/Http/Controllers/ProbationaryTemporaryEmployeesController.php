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
        $this->model=$model;
    }
    public function index(Request $request){
        $dept_code = auth()->user()->department_code;
        $logged_emp = UserEmployees::where('empl_id', auth()->user()->username)
                        ->first();
                        // dd($logged_emp);

        $sg=$logged_emp->salary_grade;
        if($dept_code=='26'){
                $offices = Office::get();
                $divisions = Division::get();
                $data = UserEmployees::with('Division')->with('Office')
                    ->when($request->EmploymentStatus, function($query, $searchItem){
                        $query->where('employment_type_descr','LIKE','%'.$searchItem.'%');
                        // dd($searchItem);
                    })
                    ->when($request->department_code, function($query, $department_code){
                        $query->where('department_code',$department_code);
                    })
                    ->join('probationary_temporary_employees','probationary_temporary_employees.employee_code','user_employees.empl_id')
                    ->paginate(10);
                //dd($data);
                return inertia('Employees/ProbationaryFlex/Index',
                    [
                        "offices"=>$offices,
                        "divisions"=>$divisions,
                        "users"=>$data
                    ]
                );
        }else{
            return redirect('/forbidden')
                ->with('error','Access forbidden!');
        }
    }
    public function create(Request $request){
        $offices = Office::get();
        $divisions = Division::get();
        $employees = UserEmployees::get();
        return inertia('Employees/ProbationaryFlex/Create',[
            'offices'=>$offices,
            'divisions'=>$divisions,
            'employees'=>$employees
        ]);
    }
    public function store(Request $request){
        dd($request->date_from);
        $attributes=$request->validate([
            'employee_code' => 'required',
            'prob_status' => 'required',
            'no_of_months' => 'required|integer|min:1',
        ]);
        $pbt = new ProbationaryTemporaryEmployees;
        $pbt->employee_code = $request->employee_code;
        $pbt->prob_status = $request->prob_status;
        $pbt->no_of_months = $request->no_of_months;
        $pbt->save();
        //$this->model->create($attributes);
        //for($i)
        return redirect('/probationary/temporary')
                ->with('message','Probationary/Temporary Employee Added');
    }
}
