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
        // dd($request);
        if($request->prob_status=='Temporary'){
            // dd("temporary");
            $request->validate([
                'employee_code' => 'required',
                'prob_status' => 'required',
                'rating_period_from' => 'required',
                'rating_period_to' => 'required',
                'rating_period_from_2' => 'required',
                'rating_period_to_2' => 'required',
                'rating_period_from_3' => 'required',
                'rating_period_to_3' => 'required',
                'rating_period_from_4' => 'required',
                'rating_period_to_4' => 'required',
                'rating_period_from_5' => 'required',
                'rating_period_to_5' => 'required',
                'rating_period_from_6' => 'required',
                'rating_period_to_6' => 'required',
                'rating_period_from_7' => 'required',
                'rating_period_to_7' => 'required',
                'rating_period_from_8' => 'required',
                'rating_period_to_8' => 'required',
                'rating_period_from_9' => 'required',
                'rating_period_to_9' => 'required',
                'rating_period_from_10' => 'required',
                'rating_period_to_10' => 'required',
            ]);
        }else{
            // dd($request);
            $request->validate([
                'employee_code' => 'required',
                'prob_status' => 'required',
                'rating_period_from' => 'required',
                'rating_period_to' => 'required',
                'rating_period_from_2' => 'required',
                'rating_period_to_2' => 'required',
                'rating_period_from_3' => 'required',
                'rating_period_to_3' => 'required',
                'rating_period_from_4' => 'required',
                'rating_period_to_4' => 'required',
                'rating_period_from_5' => 'required',
                'rating_period_to_5' => 'required',
                'rating_period_from_6' => 'required',
                'rating_period_to_6' => 'required'
            ]);
            // dd('probationary');
        }

        // dd($request);
        $this->prob_tempo->create($request->all());

        return redirect('/probationary/temporary')
                ->with('message','Probationary/Temporary Employee Added');
    }
    public function edit(Request $request, $id){
        // dd($id);
        $data = $this->prob_tempo->where('id', $id)->first([
            'id',
            'employee_code',
            'prob_status',
            'rating_period_from',
            'rating_period_to',
            'rating_period_from_2',
            'rating_period_to_2',
            'rating_period_from_3',
            'rating_period_to_3',
            'rating_period_from_4',
            'rating_period_to_4',
            'rating_period_from_5',
            'rating_period_to_5',
            'rating_period_from_6',
            'rating_period_to_6',
            'rating_period_from_7',
            'rating_period_to_7',
            'rating_period_from_8',
            'rating_period_to_8',
            'rating_period_from_9',
            'rating_period_to_9',
            'rating_period_from_10',
            'rating_period_to_10',
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
            'rating_period_to'=>$request->rating_period_to,
            'rating_period_from_2'=>$request->rating_period_from_2,
            'rating_period_to_2'=>$request->rating_period_to_2,
            'rating_period_from_3'=>$request->rating_period_from_3,
            'rating_period_to_3'=>$request->rating_period_to_3,
            'rating_period_from_4'=>$request->rating_period_from_4,
            'rating_period_from_4'=>$request->rating_period_from_4,
            'rating_period_from_5'=>$request->rating_period_from_5,
            'rating_period_to_5'=>$request->rating_period_to_5,
            'rating_period_from_6'=>$request->rating_period_from_6,
            'rating_period_to_6'=>$request->rating_period_to_6,
            'rating_period_from_7'=>$request->rating_period_from_7,
            'rating_period_to_7'=>$request->rating_period_to_7,
            'rating_period_from_8'=>$request->rating_period_from_8,
            'rating_period_to_8'=>$request->rating_period_to_8,
            'rating_period_from_9'=>$request->rating_period_from_9,
            'rating_period_to_9'=>$request->rating_period_to_9,
            'rating_period_from_10'=>$request->rating_period_from_10,
            'rating_period_to_10'=>$request->rating_period_to_10,
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
    public function individual(Request $request){
        //$dept_code = auth()->user()->department_code;
        $logged_emp = UserEmployees::where('empl_id', auth()->user()->username)
                        ->first();
                        // dd($logged_emp);

        //$sg=$logged_emp->salary_grade;
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
            ->where('employee_code',$logged_emp->empl_id)
            ->join('prob_tempo_employees','prob_tempo_employees.employee_code','user_employees.empl_id')
            ->paginate(10);
        //dd($data);
        return inertia('Employees/Probationary/Individual',
            [
                "offices"=>$offices,
                "divisions"=>$divisions,
                "users"=>$data
            ]
        );

    }
}
