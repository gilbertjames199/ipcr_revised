<?php

namespace App\Http\Controllers;

use App\Models\Division;
use App\Models\Office;
use App\Models\ProbTempoEmployees;
use App\Models\UserEmployees;
use Illuminate\Http\Request;

class ProbTempoEmployeesController extends Controller
{
    protected $prob_tempo;
    public function __construct(ProbTempoEmployees $prob_tempo){
        $this->prob_tempo=$prob_tempo;
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
                    ->join('prob_tempo_employees','prob_tempo_employees.employee_code','user_employees.empl_id')
                    ->paginate(10);
                //dd($data);
                return inertia('Employees/Probationary/Index',
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
        // dd("create");
        $offices = Office::get();
        $divisions = Division::get();
        $employees = UserEmployees::get();
        return inertia('Employees/Probationary/Create',[
            'offices'=>$offices,
            'divisions'=>$divisions,
            'employees'=>$employees
        ]);
    }
    public function store(Request $request){
        $request->validate([
            'employee_code' => 'required',
            'prob_status' => 'required',
            'rating_period_from' => 'required',
            'rating_period_to' => 'required',
        ]);
        $this->prob_tempo->create($request->all());
        return redirect('/probationary/temporary')
                ->with('message','Probationary/Temporary Employee Added');
    }
    public function edit(Request $request, $id){
        $data = $this->prob_tempo->where('id', $id)->first([
            'id',
            'employee_code',
            'prob_status',
            'rating_period_from',
            'rating_period_to'
        ]);
        // dd($data);
        // $offices = Office::get();
        // $divisions = Division::get();
        $employees = UserEmployees::get();
        // dd($data);
        return inertia('Employees/Probationary/Create', [
            "employees" => $employees,
            "editData" => $data,
        ]);
    }
    public function update(Request $request, $id){
        $data = $this->prob_tempo->findOrFail($id);
        $data->update([
            'employee_code'=>$request->employee_code,
            'prob_status'=>$request->prob_status,
            'rating_period_from'=>$request->rating_period_from,
            'rating_period_to'=>$request->rating_period_to
        ]);
        return redirect('/probationary/temporary')
                ->with('message','Data updated');
    }
    public function destroy(Request $request, $id){
        $data = $this->prob_tempo->findOrFail($id);
        $data->delete();
        return redirect('/probationary/temporary')
                ->with('error','Employee Target Deleted!');
    }
}
