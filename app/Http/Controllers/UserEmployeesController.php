<?php

namespace App\Http\Controllers;

use App\Models\UserEmployees;
use Illuminate\Http\Request;

class UserEmployeesController extends Controller
{
    protected $us_emp;
    public function _construct(UserEmployees $us_emp){
        $this->us_emp = $us_emp;
    }
    public function index(Request $request){
        //dd('employees');

        $dept_code = auth()->user()->department_code;
        $logged_emp = UserEmployees::where('empl_id', auth()->user()->username)
                        ->first();
        $sg=$logged_emp->salary_grade;
        if(intval($sg)>=0){

                $data = UserEmployees::with('Division')->with('Office')->where('department_code',$dept_code)
                    ->when($request->EmploymentStatus, function($query, $searchItem){
                        $query->where('employment_type_descr','LIKE','%'.$searchItem.'%');
                        // dd($searchItem);
                    })
                    ->paginate(10);
                //dd($data);
                return inertia('Employees/Index',
                    [
                        "users"=>$data
                    ]
                );
        }else{
            return redirect('/forbidden')
                ->with('error','Access forbidden!');
        }


    }
}
