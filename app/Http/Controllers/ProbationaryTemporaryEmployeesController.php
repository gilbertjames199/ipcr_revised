<?php

namespace App\Http\Controllers;

use App\Models\Division;
use App\Models\Office;
use App\Models\ProbationaryTemporaryEmployees;
use App\Models\UserEmployees;
use Illuminate\Http\Request;
use App\Models\Ipcr_Semestral;
use App\Models\MonthlyAccomplishment;
use Illuminate\Support\Str;
use Carbon\Carbon;


// Ipcr_Semestral
// Str
// MonthlyAccomplishment

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
        if ($dept_code == '26' || $dept_code == '03') {
            $offices = Office::get();
            $divisions = Division::get();

            $data = UserEmployees::select(
                'user_employees.id',
                'user_employees.employee_name',
                'probationary_temporary_employees.id AS p_id',
                'probationary_temporary_employees.date_from',
                'probationary_temporary_employees.date_to',
                'probationary_temporary_employees.prob_status',
                'probationary_temporary_employees.immediate_cats',
                'probationary_temporary_employees.next_higher_cats',
                'probationary_temporary_employees.sem_id',
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
                ->when($request->search, function ($query, $search) {
                    $query->where('employee_name', 'LIKE', '%' . $search . '%');
                })
                ->join('probationary_temporary_employees', 'probationary_temporary_employees.employee_code', 'user_employees.empl_id')
                ->paginate(10);
            // dd($data);
            return inertia(
                'Employees/ProbationaryFlex/Index',
                [
                    "offices" => $offices,
                    "divisions" => $divisions,
                    "users" => $data,
                    "filters" => $request->only(['search'])
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
            'half_indicator' => 'required',
            // 'immediate_cats' => 'required',
            // 'next_higher_cats' => 'required'
        ]);
        $year_date = Carbon::parse($request->date_from[0])->year;
        // $sem=$this->generateIPCRSemestral(
        //     $request->employee_code,
        //     $year_date,
        //     1,
        //     0,
        //     0,
        //     '-1',
        //     $request->no_of_months,
        //     $request->prob_status
        // );
        // dd($sem->id);
        $pbt = new ProbationaryTemporaryEmployees;
        $pbt->employee_code = $request->employee_code;
        $pbt->prob_status = $request->prob_status;
        $pbt->no_of_months = $request->no_of_months;
        $pbt->date_from = json_encode($request->date_from);
        $pbt->date_to = json_encode($request->date_to);
        // $pbt->sem_id=$sem->id;
        $pbt->immediate_cats = "";
        // $request->immediate_cats;
        $pbt->next_higher_cats = "";
        // $request->next_higher_cats;
        $pbt->status = "-1";
        $pbt->half_indicator = $request->half_indicator;
        // dd($pbt);
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
        $employees = UserEmployees::where('active_status','ACTIVE')->get();
        $data = ProbationaryTemporaryEmployees::where('id', $id)
            ->first();
        // dd($data, $id);
        $date_from = json_decode($data->date_from);
        $date_to = json_decode($data->date_to);
        $prob_type = $request->prob_type;
        // dd($prob_type);
        // dd($date_from);
        //$quantity = $monthly->pluck('quantity');
        return inertia('Employees/ProbationaryFlex/Create', [
            'offices' => $offices,
            'divisions' => $divisions,
            'employees' => $employees,
            'editData' => $data,
            'date_from' => $date_from,
            'date_to' => $date_to,
            'prob_type' =>$prob_type
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
            'next_higher_cats' => 'required',
            'half_indicator' => 'required'
        ]);
        $data = $this->model->findOrFail($id);
        // dd($data);
        $sem = null;
    // dd($request);
        if (!is_null($data) && !is_null($data->sem_id)) {
            // dd($data);
            $sem = Ipcr_Semestral::where('id', $data->sem_id)->first();
            // dd($sem);
            if($sem){
                $sem->immediate_id = $request->immediate_cats;
                $sem->next_higher = $request->next_higher_cats;
                $sem->save();
                // dd($data);
                $data->update([
                    'employee_code' => $request->employee_code,
                    'no_of_months' => $request->no_of_months,
                    'prob_status' => $request->prob_status,
                    'date_from' => json_encode($request->date_from),
                    'date_to' => json_encode($request->date_to),
                    'immediate_cats' => $request->immediate_cats,
                    'next_higher_cats' => $request->next_higher_cats,
                    'half_indicator' => $request->half_indicator
                ]);
            }else{

                $data->update([
                    'employee_code' => $request->employee_code,
                    'no_of_months' => $request->no_of_months,
                    'prob_status' => $request->prob_status,
                    'date_from' => json_encode($request->date_from),
                    'date_to' => json_encode($request->date_to),
                    'immediate_cats' => $request->immediate_cats,
                    'next_higher_cats' => $request->next_higher_cats,
                    'half_indicator' => $request->half_indicator
                ]);
                $this->generateIpcrSemestral($id);
                // $sem_id= Ipcr_Semestral
            }
        }


        // return redirect('/probationary')
        //     ->with('info', 'Data updated');
        return redirect()->back()->with('message', 'Successfully updated');
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
        // dd("indiv");
        $logged_emp = UserEmployees::where('empl_id', auth()->user()->username)
            ->first();

        $offices = Office::get();
        $divisions = Division::get();
        $data = ProbationaryTemporaryEmployees::with(['user','user.Division', 'user.Office','ipcrSemestral'])
            ->when($request->EmploymentStatus, function ($query, $searchItem) {
                $query->where('employment_type_descr', 'LIKE', '%' . $searchItem . '%');
            })
            ->when($request->department_code, function ($query, $department_code) {
                $query->where('department_code', $department_code);
            })
            ->where('employee_code', $logged_emp->empl_id)
            // ->where('probationary_temporary_employees.employee_code', $logged_emp->empl_id)
            // ->join('probationary_temporary_employees', 'probationary_temporary_employees.employee_code', '=', 'user_employees.empl_id')
            ->paginate(10)
            ->through(function($item){
                // dd($item);
                return [
                    'id'=>optional(optional($item)->user)->id,
                    'employee_name'=>optional(optional($item)->user)->employee_name,
                    'employee_code'=>optional(optional($item)->user)->employee_code,
                    'status'=>$item->status,
                    'date_from'=>$item->date_from,
                    'date_to'=>$item->date_to,
                    'immediate_cats'=>$item->immediate_cats,
                    'next_higher_cats'=>$item->next_higher_cats,
                    'prob_status'=>$item->prob_status,
                    'prob_id'=>$item->id,
                    'division'=>optional(optional($item)->user)->Division,
                    'Office'=>optional(optional($item)->user)->Office,
                    'ipcrSemestral'=>$item->ipcrSemestral
                ];
            });

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

    public function generateIpcrSemestral($prob_id){
        $prob = ProbationaryTemporaryEmployees::where('id', $prob_id)->first();
        // dd($prob,"prob");
        // Convert JSON string to PHP array
        $dates = json_decode($prob->date_from, true);
        // 1️⃣ First element
        $firstDate = $dates[0];

        // dd($firstDate);
        // 2️⃣ Get the month of the first element
        $month = Carbon::parse($firstDate)->month; // 3 for March

        // 3️⃣ Determine semester
        $sem = ($month < 7) ? 1 : 2;

        // 4️⃣ Count number of elements
        $no_of_months = count($dates);
        // dd($no_of_months);
        $sem = $this->generateIPCRSemestralActual(
            $prob->employee_code,
            Carbon::parse($firstDate)->year,
                $sem,
            $prob->immediate_cats,
            $prob->next_higher_cats,
            $prob->status,
            $no_of_months,
            $prob->prob_status
        );
        $prob->sem_id = $sem->id;
        $prob->save();
        return redirect()->back()->with('message','Successfully generated IPCR');
        // dd($prob);
    }
    // IPCR SEMESTRALS
    public function generateIPCRSemestralActual(
        $employee_code,
        $year,
        $sem,
        $immediate_id,
        $next_higher,
        $status,
        $no_of_months,
        $prob_type
    ){
        $emp = UserEmployees::with(
            'Division',
            'Office',
            'Office.pgHead',
            'employeeSpecialDepartment',
            'employeeSpecialDepartment.Office',
            'employeeSpecialDepartment.PGDH',
        )
            ->where('empl_id', $employee_code)
            ->first();


        //VARIABLE DECLARATION
        $dept_name = NULL;
        $dept_code = NULL;
        $div_code = NULL;
        $div_name = NULL;
        $emp_type = NULL;


        $pgdh = NULL;
        $pgdh_post = NULL;
        $pgdh_suff = NULL;
        $mid = NULL;

        if ($emp) {
            //EMPLOYMENT TYPE
            $emp_type = $emp->employment_type_descr;
            //Office
            if ($emp->Office) {
                $dept_name = $emp->Office->office;
                $dept_code = $emp->Office->department_code;
                // dd($emp->Office);
                //PGDH
                if ($emp->Office) {
                    if ($emp->Office->pgHead) {
                        //MIDDLE INITIAL
                        if ($emp->Office->pgHead->middle_name) {
                            $mid = $emp->Office->pgHead->middle_name[0] . '.';
                        }
                        //SUFFIX
                        if ($emp->Office->pgHead->suffix_name) {
                            $pgdh_suff = ', ' . $emp->Office->pgHead->suffix_name;
                        }
                        //POSTFIX
                        if ($emp->Office->pgHead->postfix_name) {
                            $pgdh_post = ', ' . $emp->Office->pgHead->postfix_name;
                        }
                        $pgdh = $emp->Office->pgHead->first_name . ' ' . $mid . ' ' .
                            $emp->Office->pgHead->last_name . $pgdh_suff . $pgdh_post;
                    }
                }
            }

            //Division
            if ($emp->Division) {
                $div_code = $emp->Division->division_code;
                $div_name = $emp->Division->division_name1;
            }
            //EMPLOYEE SPECIAL DEPARTMENTS
            if ($emp->employeeSpecialDepartment) {
                //DEPARTMENT
                if ($emp->employeeSpecialDepartment->Office) {
                    $dept_code = $emp->employeeSpecialDepartment->Office->department_code;
                    $dept_name = $emp->employeeSpecialDepartment->Office->office;
                }
                //PG DEPARTMENTHEAD
                if ($emp->employeeSpecialDepartment->PGDH) {
                    // dd('naay pgdh');

                    // dd($target->userEmployee->employeeSpecialDepartment->PGDH);
                    //MIDDLE INITIAL
                    if ($emp->employeeSpecialDepartment->PGDH->middle_name) {

                        $mid = $emp->employeeSpecialDepartment->PGDH->middle_name[0] . '.';
                    }
                    //SUFFIX
                    if ($emp->employeeSpecialDepartment->PGDH->suffix_name) {
                        $pgdh_suff = ', ' . $emp->employeeSpecialDepartment->PGDH->suffix_name;
                    }
                    //POSTFIX
                    if ($emp->employeeSpecialDepartment->PGDH->postfix_name) {
                        $pgdh_post = ', ' . $emp->employeeSpecialDepartment->PGDH->postfix_name;
                    }
                    $pgdh = $emp->employeeSpecialDepartment->PGDH->first_name . ' ' . $mid . ' ' .
                        $emp->employeeSpecialDepartment->PGDH->last_name .  $pgdh_suff .  $pgdh_post;
                }
            }
        }
        if (!$div_name) {
            $sup = UserEmployees::with('Division')->where('empl_id', $immediate_id)
                ->orWhere('empl_id', $next_higher)
                ->get();
            $imm = $sup->firstWhere('empl_id', $immediate_id);
            $next = $sup->firstWhere('empl_id', $next_higher);

            if ($imm) {
                if ($imm->Division) {
                    $div_code = $imm->division_code;
                    $div_name = $imm->Division->division_name1;
                } else {
                    if ($next) {
                        if ($next->Division) {
                            $div_code = $next->division_code;
                            $div_name = $next->Division->division_name1;
                        }
                    }
                }
            }
        }

        // dd($emp);
        $id = $emp->id;

        $ipcr_targg = Ipcr_Semestral::where('employee_code', $employee_code)
            ->where('year', $year)
            ->where('sem', $sem)
            ->get();

        $months = range(1, $no_of_months);
        // dd($months);
        // if (count($ipcr_targg) < 1) {
        // $this->ipcr_sem->create($attributes);
        $random = Str::random(7 * 2);
        $append = substr(preg_replace('/[^a-z1-3]/', '', $random), 0, 7);
        $slugBase = Str::slug($emp->employee_name . '-' . $append . '-' . $sem . '-' . $year);

        $slug = $slugBase;
        $ipcrsem = new Ipcr_Semestral;
        $ipcrsem->sem = $sem;
        $ipcrsem->employee_code = $employee_code;
        $ipcrsem->immediate_id = $immediate_id;
        $ipcrsem->next_higher = $next_higher;
        $ipcrsem->employee_name = $emp->employee_name;
        $ipcrsem->position = $emp->position_title1;
        $ipcrsem->employment_type = $emp_type;
        $ipcrsem->salary_grade = $emp->salary_grade;
        $ipcrsem->division = $div_code;
        $ipcrsem->year = $year;
        $ipcrsem->status = $status;
        $ipcrsem->status_accomplishment = '-1';
        $ipcrsem->department_code = $dept_code;
        $ipcrsem->slug = $slug;
        $ipcrsem->department = $dept_name;
        $ipcrsem->division_name = $div_name;
        $ipcrsem->pg_dept_head = $pgdh;
        $ipcrsem->prob_type = $prob_type;
        $ipcrsem->save();
        //CREATE MONTHLY ACCOMPLISHMENT
        $ipcr_m_id = $ipcrsem->id;
        $sem = $sem;
        $year = $year;
        // Define the months based on the semester value
        // $months = ($sem == 1) ? ['1', '2', '3', '4', '5', '6'] : ['7', '8', '9', '10', '11', '12'];

        // Create Ipcr_monthly records for each month
        foreach ($months as $month) {
            $existingRecord = MonthlyAccomplishment::where('ipcr_semestral_id', $ipcr_m_id)
                ->where('month', $month)
                ->first();
            if (!$existingRecord) {
                MonthlyAccomplishment::create([
                    'month' => $month,
                    'year' => $year,
                    'ipcr_semestral_id' => $ipcr_m_id, // Reference to the parent semestral record
                    'status' => '-1'
                    // Add other fields as needed
                ]);
            }
            // $existingRecord=MonthlyAccomplishment::create([
            //     'month' => $month,
            //     'year' => $year,
            //     'ipcr_semestral_id' => $id, // Reference to the parent semestral record
            //     'status' => '-1'
            //     // Add other fields as needed
            // ]);

        }
        return $ipcrsem;
        // } else {
        //     return redirect('/ipcrsemestral/' . $id . '/' . $source)
        //         ->with('error', 'Error adding semestral target');
        // }
    }
}
