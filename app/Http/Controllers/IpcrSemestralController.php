<?php

namespace App\Http\Controllers;

use App\Helpers\PaginationHelper;
use App\Models\Daily_Accomplishment;
use App\Models\Division;
use App\Models\EmployeeSpecialDepartment;
use App\Models\FFUNCCOD;
use App\Models\IndividualFinalOutput;
use App\Models\Ipcr_Semestral;
use App\Models\IPCRTargets;
use App\Models\MonthlyAccomplishment;
use App\Models\Office;
use App\Models\ReturnRemarks;
use App\Models\UserEmployeeCredential;
use App\Models\UserEmployees;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

class IpcrSemestralController extends Controller
{
    protected $ipcr_sem;
    public function __construct(Ipcr_Semestral $ipcr_sem)
    {
        $this->ipcr_sem = $ipcr_sem;
    }
    public function index(Request $request, $id, $source)
    {
        // dd();

        // $emp = UserEmployees::where('id', $id)
        //     ->first();
        $emp_main = auth()->user()->load(['userEmployee', 'employeeSpecialDepartment']);
        $emp = $emp_main->userEmployee;
        $emp_code = $emp->empl_id;
        $esd = $emp_main->employeeSPecialDepartment;
        // EmployeeSpecialDepartment::where('employee_code', $emp_code)->first();
        // dd($esd);
        // dd('444');
        // dd($emp_main->employeeSPecialDepartment);
        $division = "";
        if ($emp->division_code) {
            $division = Division::where('division_code', $emp->division_code)
                ->first()->division_name1;
        }
        // dd('ipcr');
        // dd($esd);

        if ($esd) {
            if ($esd->department_code && $esd->department_code != '27') {
                $office = FFUNCCOD::where('department_code', $esd->department_code)->first();
                $dept = Office::where('department_code', $esd->department_code)->first();
            } else if ($esd->department_code == '27') {
                // dd('office 27');
                $office = FFUNCCOD::where('department_code', $emp->department_code)->first();
                $dept = Office::where('department_code', $emp->department_code)->first();
            } else {
                $office = FFUNCCOD::where('department_code', $emp->department_code)->first();
                $dept = Office::where('department_code', $emp->department_code)->first();
            }
            if ($esd->pgdh_cats) {
                $pgHead = UserEmployees::where('empl_id', $esd->pgdh_cats)->first();
            } else {
                $pgHead = UserEmployees::where('empl_id', $dept->empl_id)->first();
            }
        } else {
            $office = FFUNCCOD::where('department_code', $emp->department_code)->first();
            $dept = Office::where('department_code', $emp->department_code)->first();
            $pgHead = UserEmployees::where('empl_id', $dept->empl_id)->first();
        }


        $suff = "";
        $post = "";
        $mn = "";
        if ($pgHead->suffix_name != '') {
            $suff = ', ' . $pgHead->suffix_name;
        }
        if ($pgHead->postfix_name != '') {
            $post = ', ' . $pgHead->postfix_name;
        }
        if ($pgHead->middle_name != '') {
            $mn = $pgHead->middle_name[0] . '. ';
        }
        $pgHead = $pgHead->first_name . ' ' . $mn  . $pgHead->last_name . '' . $suff . '' . $post;

        $is_add = '';

        $sem_data
            = Ipcr_Semestral::select(
                'ipcr__semestrals.id as ipcr_sem_id',
                DB::raw('NULL as id_target'),
                'ipcr__semestrals.employee_code',
                'ipcr__semestrals.immediate_id',
                'ipcr__semestrals.next_higher',
                'ipcr__semestrals.sem',
                'ipcr__semestrals.status',
                'ipcr__semestrals.year',
                'ipcr__semestrals.pg_dept_head',
                'ipcr__semestrals.department',
                'ipcr__semestrals.division_name',
                DB::raw('NULL as ipcr_code'),
                DB::raw('NULL as individual_output'),
                DB::raw('NULL as is_additional_target'),
                DB::raw('NULL as target_status')
            )
            ->with(['immediate', 'next_higher1', 'latestReturnRemark'])
            ->where('ipcr__semestrals.employee_code', $emp_code)
            ->union(
                Ipcr_Semestral::select(
                    'ipcr__semestrals.id as ipcr_sem_id',
                    'i_p_c_r_targets.id as id_target',
                    'ipcr__semestrals.employee_code',
                    'ipcr__semestrals.immediate_id',
                    'ipcr__semestrals.next_higher',
                    'ipcr__semestrals.sem',
                    'ipcr__semestrals.status',
                    'ipcr__semestrals.year',
                    'ipcr__semestrals.pg_dept_head',
                    'ipcr__semestrals.department',
                    'ipcr__semestrals.division_name',
                    'individual_final_outputs.ipcr_code',
                    'individual_final_outputs.individual_output',
                    'i_p_c_r_targets.is_additional_target',
                    'i_p_c_r_targets.status AS target_status',
                )
                    ->with(['immediate', 'next_higher1', 'latestReturnRemark', 'IPCRTargets'])
                    ->leftJoin('i_p_c_r_targets', 'ipcr__semestrals.id', '=', 'i_p_c_r_targets.ipcr_semester_id')
                    ->leftJoin('individual_final_outputs', 'individual_final_outputs.ipcr_code', '=', 'i_p_c_r_targets.ipcr_code')
                    ->where('i_p_c_r_targets.is_additional_target', 1)
                    ->where('ipcr__semestrals.employee_code', $emp_code)
            )
            ->orderBy('year', 'DESC')
            ->orderBy('sem', 'DESC')
            ->orderBy('is_additional_target', 'asc')
            ->get()
            ->map(function ($item) {
                $rem = $item->latestReturnRemark;
                // $rem_next = $item->latestReturnRemarkNextHigher;
                $immediate = $item->immediate;
                $next_higher = $item->next_higher1;
                $divv = $item->division_name;

                // dd($item->ipcr_sem_id);
                // $divcode = $item->division_code;
                // dd($item);

                // ReturnRemarks::where('ipcr_semestral_id', $item->ipcr_sem_id)
                //     ->where('type', 'LIKE', '%target%')
                //     ->orderBy('created_at', 'DESC')
                //     ->first();

                // UserEmployees::where('empl_id', $item->immediate_id)
                //     ->first();
                // dd($immediate);

                // UserEmployees::where('empl_id', $item->next_higher)
                //     ->first();
                // if ($item->division_code) {
                // } else {

                //     try {
                //         if ($immediate->division_code) {
                //             $divcode = $immediate->division_code;
                //         }
                //         if ($next_higher->division_code) {
                //             $divcode = $next_higher->division_code;
                //         }
                //     } catch (Exception $e) {
                //     }
                // }

                // $divv = "";

                // Division::where('division_code', $divcode)->first();
                // if ($div) {
                //     $divv = $div->division_name1;
                // }
                return [
                    'ipcr_sem_id' => $item->ipcr_sem_id,
                    'ipcr_target_id' => $item->id_target,
                    'employee_code' => $item->employee_code,
                    'immediate_id' => $item->immediate_id,
                    'next_higher' => $item->next_higher,
                    "imm" => $immediate,
                    "next" => $next_higher,
                    'sem' => $item->sem,
                    'status' => $item->status,
                    'year' => $item->year,
                    'rem' => $rem,
                    'ipcr_code' => $item->ipcr_code,
                    'individual_output' => $item->individual_output,
                    'is_additional_target' => $item->is_additional_target,
                    'target_status' => $item->target_status,
                    'division' => $divv ? $divv : '',
                    'office' => $item->department,
                    'pgHead' => $item->pg_dept_head,
                ];
            });

        $showPerPage = 10;

        $sem_data = PaginationHelper::paginate($sem_data, $showPerPage);
        // dd($office);
        return inertia('IPCR/Semestral/Index', [
            "id" => $id,
            "sem_data" => $sem_data,
            "division" => $division,
            "emp" => $emp,
            "source" => $source,
            "office" => $office,
            "pgHead" => $pgHead,
        ]);
    }
    public function create(Request $request, $id, $source)
    {
        $emp = UserEmployees::where('id', $id)
            ->first();
        // dd($emp);
        $sg = $emp->salary_grade;
        $dept_code = $emp->department_code;
        $desig_dept = $emp->designate_department_code;
        $division_code = $emp->division_code;
        $supervisors = UserEmployees::where('salary_grade', '>=', $sg)
            ->where('user_employees.active_status', 'ACTIVE')
            ->where('user_employees.department_code', $dept_code)
            ->get();
        ///************************************************* */
        $my_superv = UserEmployees::where('salary_grade', '>=', $sg)
            ->where('user_employees.active_status', 'ACTIVE')
            ->where('user_employees.designate_department_code', $dept_code)
            ->get();
        $supervisors = $supervisors->concat($my_superv);
        //************************** */
        if (isset($desig_dept) && $desig_dept != "" && $desig_dept != $dept_code) {
            $superv = UserEmployees::where('salary_grade', '>=', $sg)
                ->where('user_employees.active_status', 'ACTIVE')
                ->where('user_employees.department_code', $desig_dept)
                ->get();

            // ->OrWhere('user_employees.designate_department_code', $desig_dept)
            // dd($sg);
            // dd($desig_dept);
            // dd($superv->pluck('employee_name'));
            // dd($superv[0]);
            $supervisors = $supervisors->concat($superv);

            $superv = UserEmployees::where('salary_grade', '>=', $sg)
                ->where('user_employees.active_status', 'ACTIVE')
                ->where('user_employees.designate_department_code', $desig_dept)
                ->get();
            // dd($sg);
            // dd($superv->pluck('employee_name'));
            // dd($superv[0]);
            $supervisors = $supervisors->concat($superv);
        }

        //VGO or SP
        if ($dept_code == 19) {
            // dd("SP");
            $superv = UserEmployees::where('salary_grade', '>=', $sg)
                ->where('user_employees.department_code', '18')
                ->where('user_employees.active_status', 'ACTIVE')
                ->get();
            // dd($superv[0]);
            $supervisors = $supervisors->concat($superv);
        }

        if ($dept_code == 18) {
            // dd("SP");
            $superv = UserEmployees::where('salary_grade', '>=', $sg)
                ->where('user_employees.department_code', '19')
                ->where('user_employees.active_status', 'ACTIVE')
                ->get();
            // dd($superv[0]);
            $supervisors = $supervisors->concat($superv);
        }

        if ($dept_code == 21 || $dept_code == 22 || $dept_code == 23 || $dept_code == 24) {
            $peemo = UserEmployees::where('salary_grade', '>=', $sg)
                ->where('user_employees.active_status', 'ACTIVE')
                ->where('user_employees.designate_department_code', 20)
                ->get();
            $supervisors = $supervisors->concat($peemo);
        }
        if ($dept_code == '01') {
            $pgo_add = UserEmployees::where('empl_id', '10106')
                ->orWhere('empl_id', '0361')
                ->get();
            $supervisors = $supervisors->merge($pgo_add);
        }

        if ($division_code == '057') {
            $superv = UserEmployees::where('empl_id', '10060')
                ->get();
            $supervisors = $supervisors->concat($superv);
        }
        $special_dept = EmployeeSpecialDepartment::where('employee_special_departments.employee_code', $emp->empl_id)
            ->get()->pluck('department_code');
        if (count($special_dept) > 0) {
            $superv_special = UserEmployees::where('salary_grade', '>=', $sg)
                ->where('user_employees.active_status', 'ACTIVE')
                ->get();
            $supervisors = $supervisors->concat($superv_special);
        }

        // dd($special_dept);
        return inertia('IPCR/Semestral/Create', [
            'supervisors' => $supervisors,
            'id' => $id,
            'emp' => $emp,
            'dept_code' => $dept_code,
            'source' => $source
        ]);
    }
    public function store(Request $request)
    {
        //dd($request->source);
        $emp = UserEmployees::with(
            'Division',
            'Office',
            'Office.pgHead',
            'employeeSpecialDepartment',
            'employeeSpecialDepartment.Office',
            'employeeSpecialDepartment.PGDH',
        )
            ->where('empl_id', $request->employee_code)
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
            $sup = UserEmployees::with('Division')->where('empl_id', $request->immediate_id)
                ->orWhere('empl_id', $request->next_higher)
                ->get();
            $imm = $sup->firstWhere('empl_id', $request->immediate_id);
            $next = $sup->firstWhere('empl_id', $request->next_higher);

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
        // dd(auth()->user());
        //For Automatic approved ra ni
        // $request['status'] = 2;

        $attributes = $request->validate([
            'sem' => 'required',
            'employee_code' => 'required',
            'immediate_id' => 'required',
            'next_higher' => 'required',
            'year' => 'required',
            'status' => 'required',
            // ''
        ]);
        $ipcr_targg = Ipcr_Semestral::where('employee_code', $request->employee_code)
            ->where('year', $request->year)
            ->where('sem', $request->sem)
            ->get();
        if (count($ipcr_targg) < 1) {
            // $this->ipcr_sem->create($attributes);
            $ipcrsem = new Ipcr_Semestral;
            $ipcrsem->sem = $request->sem;
            $ipcrsem->employee_code = $request->employee_code;
            $ipcrsem->immediate_id = $request->immediate_id;
            $ipcrsem->next_higher = $request->next_higher;
            $ipcrsem->employee_name = $emp->employee_name;
            $ipcrsem->position = $emp->position_title1;
            $ipcrsem->employment_type = $emp_type;
            $ipcrsem->salary_grade = $emp->salary_grade;
            $ipcrsem->division = $div_code;
            $ipcrsem->year = $request->year;
            $ipcrsem->status = $request->status;
            $ipcrsem->status_accomplishment = '-1';
            $ipcrsem->department_code = $dept_code;
            $ipcrsem->department = $dept_name;
            $ipcrsem->division_name = $div_name;
            $ipcrsem->pg_dept_head = $pgdh;
            $ipcrsem->save();
            //CREATE MONTHLY ACCOMPLISHMENT
            $ipcr_m_id = $ipcrsem->id;
            $sem = $request->sem;
            $year = $request->year;
            // Define the months based on the semester value
            $months = ($sem == 1) ? ['1', '2', '3', '4', '5', '6'] : ['7', '8', '9', '10', '11', '12'];

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
            return redirect('/ipcrsemestral/' . $id . '/' . $request->source)
                ->with('message', 'Semestral target added');
        } else {
            return redirect('/ipcrsemestral/' . $id . '/' . $request->source)
                ->with('error', 'Error adding semestral target');
        }
    }
    public function edit(Request $request, $semid, $source)
    {
        //GET DATA FOR EDITING**************************************************_
        $data = Ipcr_Semestral::with(['immediate', 'next_higher1'])
            ->where('id', $semid)
            ->first();

        $id = $data->employee_code;

        // USER DETAILS***********************************************************
        $uss = auth()->user()->load('UserEmployee');
        $emp = $uss->userEmployee;
        $is_pghead = $emp->is_pghead;
        $division_code = $emp->division_code;
        $sg = $emp->salary_grade;
        $dept_code = $emp->department_code;
        $desig_dept = $emp->designate_department_code;

        // dd($id . ' - ' . $uss->username);
        if ($id == $uss->username) {
            // dd('equal sila: ' . $id . ' - ' . $uss->username);
            //SUPERVISORS*************************************************************-
            $supervisors = UserEmployees::where('salary_grade', '>=', $sg)
                ->where('user_employees.active_status', 'ACTIVE')
                ->where(function ($query) use ($dept_code) {
                    $query->where('user_employees.department_code', $dept_code)
                        ->orWhere('user_employees.designate_department_code', $dept_code);
                })
                ->get();
            //********************************************************************/
            if (isset($desig_dept) && $desig_dept != "" && $desig_dept != $dept_code) {
                $superv = UserEmployees::where('salary_grade', '>=', $sg)
                    ->where('user_employees.active_status', 'ACTIVE')
                    ->where('user_employees.designate_department_code', $desig_dept)
                    ->get();
                $supervisors = $supervisors->concat($superv);
            }

            //VGO or SP**************************************************************
            if (in_array($dept_code, [18, 19])) {
                $other_dept_code = $dept_code == 19 ? 18 : 19;
                $superv = UserEmployees::where('salary_grade', '>=', $sg)
                    ->whereIn('user_employees.department_code', [$other_dept_code])
                    ->where('user_employees.active_status', 'ACTIVE')
                    ->get();
                $supervisors = $supervisors->concat($superv);
            }
            //Hospitals************************************************************************
            if ($dept_code == 21 || $dept_code == 22 || $dept_code == 23 || $dept_code == 24) {
                $peemo = UserEmployees::where('salary_grade', '>=', $sg)
                    ->where('user_employees.active_status', 'ACTIVE')
                    ->where('user_employees.designate_department_code', 20)
                    ->get();
                $supervisors = $supervisors->concat($peemo);
            }

            //PGO******************************************************************************************************
            if ($dept_code == '01') {
                $pgo_add = UserEmployees::where('empl_id', '10106')
                    ->orWhere('empl_id', '0361')
                    ->get();
                $supervisors = $supervisors->merge($pgo_add);
            }

            //FOR Employee Special Departments**************************************************************************
            $special_dept = EmployeeSpecialDepartment::where('employee_special_departments.employee_code', $emp->empl_id)
                ->get()->pluck('department_code');
            if (count($special_dept) > 0) {
                $superv_special = UserEmployees::where('salary_grade', '>=', $sg)
                    ->where('user_employees.active_status', 'ACTIVE')
                    ->get();
                $supervisors = $supervisors->concat($superv_special);
            }

            //For Acting PG Department Heads*****************************************************************************
            if ($is_pghead == '1') {
                $ids = $supervisors->pluck('empl_id');
                // dd($ids);
                $supp = UserEmployees::where('salary_grade', '>=', $sg)
                    ->where('user_employees.active_status', 'ACTIVE')
                    ->whereNotIn('empl_id', $ids)
                    ->get();
                $supervisors = $supervisors->concat($supp);
            }

            if ($division_code == '057') {
                $superv = UserEmployees::where('empl_id', '10060')
                    ->get();
                $supervisors = $supervisors->concat($superv);
            }
            $imm_id = $data->immediate_id;
            $next_id = $data->next_higher;
            $imm_f = 0;
            $next_f = 0;

            //CHECKING IF immediate or next higher selected exists ******************************************************
            foreach ($supervisors as $item) {

                if ($item['empl_id'] == $imm_id) {
                    $imm_f = 1;
                }
                if ($item['empl_id'] == $next_id) {
                    $next_f = 1;
                }
            }

            //PUSH immediate and/or nexthigher details to the supervisors variable if not found***********************
            if ($imm_f == 0) {
                $supervisors->push($data->immediate);
            }
            if ($next_f == 0) {
                $supervisors->push($data->next_higher1);
            }

            //*************************************************************************************************
            return inertia('IPCR/Semestral/Create', [
                'supervisors' => $supervisors,
                'id' => $id,
                'emp' => $emp,
                'dept_code' => $dept_code,
                'source' => $source,
                'editData' => $data
            ]);
        } else {
            // dd('dili sila equal' . $id . ' - ' . $uss->username);
            return redirect('/forbidden')->with('error', 'You are not allowed to edit this IPCR!!');
        }
    }
    public function edit2_previous_code_not_used(Request $request, $semid, $source)
    {
        $data = Ipcr_Semestral::with(['immediate', 'next_higher1'])
            ->where('id', $semid)
            ->first();

        $id = $data->employee_code;
        $emp = UserEmployees::where('empl_id', $id)
            ->first();
        $is_pghead = $emp->is_pghead;
        // dd($emp);
        $sg = $emp->salary_grade;
        $dept_code = $emp->department_code;
        $desig_dept = $emp->designate_department_code;
        $supervisors = UserEmployees::where('salary_grade', '>=', $sg)
            ->where('user_employees.active_status', 'ACTIVE')
            ->where('user_employees.department_code', $dept_code)
            ->get();
        ///************************************************* */
        //For supervisors designated to a different department
        $my_superv = UserEmployees::where('salary_grade', '>=', $sg)
            ->where('user_employees.active_status', 'ACTIVE')
            ->where('user_employees.designate_department_code', $dept_code)
            ->get();
        $supervisor1 = $supervisors->concat($my_superv);

        $supervisors = UserEmployees::where('salary_grade', '>=', $sg)
            ->where('user_employees.active_status', 'ACTIVE')
            ->where(function ($query) use ($dept_code) {
                $query->where('user_employees.department_code', $dept_code)
                    ->orWhere('user_employees.designate_department_code', $dept_code);
            })
            ->get();
        //************************** */
        if (isset($desig_dept) && $desig_dept != "" && $desig_dept != $dept_code) {
            // $superv = UserEmployees::where('salary_grade', '>=', $sg)
            //     ->where('user_employees.active_status', 'ACTIVE')
            //     ->where('user_employees.department_code', $desig_dept)
            //     ->get();

            // $supervisors = $supervisors->concat($superv);

            $superv = UserEmployees::where('salary_grade', '>=', $sg)
                ->where('user_employees.active_status', 'ACTIVE')
                ->where('user_employees.designate_department_code', $desig_dept)
                ->get();
            $supervisors = $supervisors->concat($superv);
        }

        //VGO or SP
        // if ($dept_code == 19) {
        //     $superv = UserEmployees::where('salary_grade', '>=', $sg)
        //         ->where('user_employees.department_code', '18')
        //         ->where('user_employees.active_status', 'ACTIVE')
        //         ->get();
        //     $supervisors = $supervisors->concat($superv);
        // }

        // if ($dept_code == 18) {
        //     $superv = UserEmployees::where('salary_grade', '>=', $sg)
        //         ->where('user_employees.department_code', '19')
        //         ->where('user_employees.active_status', 'ACTIVE')
        //         ->get();
        //     $supervisors = $supervisors->concat($superv);
        // }
        if (in_array($dept_code, [18, 19])) {
            $other_dept_code = $dept_code == 19 ? 18 : 19;
            $superv = UserEmployees::where('salary_grade', '>=', $sg)
                ->whereIn('user_employees.department_code', [$other_dept_code])
                ->where('user_employees.active_status', 'ACTIVE')
                ->get();
            $supervisors = $supervisors->concat($superv);
        }
        //Hospitals
        if ($dept_code == 21 || $dept_code == 22 || $dept_code == 23 || $dept_code == 24) {
            $peemo = UserEmployees::where('salary_grade', '>=', $sg)
                ->where('user_employees.active_status', 'ACTIVE')
                ->where('user_employees.designate_department_code', 20)
                ->get();
            $supervisors = $supervisors->concat($peemo);
        }

        //PGO
        if ($dept_code == '01') {
            $pgo_add = UserEmployees::where('empl_id', '10106')
                ->orWhere('empl_id', '0361')
                ->get();
            $supervisors = $supervisors->merge($pgo_add);
        }
        $special_dept = EmployeeSpecialDepartment::where('employee_special_departments.employee_code', $emp->empl_id)
            ->get()->pluck('department_code');
        if (count($special_dept) > 0) {
            $superv_special = UserEmployees::where('salary_grade', '>=', $sg)
                ->where('user_employees.active_status', 'ACTIVE')
                ->get();
            $supervisors = $supervisors->concat($superv_special);
        }

        //For Acting PG Department Heads
        if ($is_pghead == '1') {
            $ids = $supervisors->pluck('empl_id');
            // dd($ids);
            $supp = UserEmployees::where('salary_grade', '>=', $sg)
                ->where('user_employees.active_status', 'ACTIVE')
                ->whereNotIn('empl_id', $ids)
                ->get();
            $supervisors = $supervisors->concat($supp);
        }
        $imm_id = $data->immediate_id;
        $next_id = $data->next_higher;
        $imm_f = 0;
        $next_f = 0;
        // dd($data);


        foreach ($supervisors as $item) {
            // if (in_array($item['ipcr_code'], $ipcrCodes)) {
            // dd($item);
            if ($item['empl_id'] == $imm_id) {
                $imm_f = 1;
                // dd($item);
            }
            if ($item['empl_id'] == $next_id) {
                $next_f = 1;
            }
            // }
        }
        dd($data);
        // dd($imm_f);
        // $supervisors = $supervisors->toArray();

        // // dd($data->immediate->toArray());
        // if ($imm_f < 1) {
        //     // dd($imm_f);
        //     // $supervisors->concat($data->immediate->toArray);
        //     array_push($supervisors, $data->immediate->toArray);
        // }
        // // dd($imm_f . ' next: ' . $next_f);
        // // dd($dept_code);
        // // dd($data->immediate);
        // foreach ($supervisors as $item) {
        //     // if (in_array($item['ipcr_code'], $ipcrCodes)) {
        //     // dd($item);
        //     // dd('$item[empl_id] '.$item['empl_id'] . ' $imm_id: ' . $imm_id);
        //     // dd($imm_id);
        //     if (isset($item)) {
        //         if ($item['empl_id'] == $imm_id) {
        //             $imm_f = 1;
        //             // dd($item);
        //         }
        //         if ($item['empl_id'] === $next_id) {
        //             $next_f = 1;
        //         }
        //     }

        //     // }
        // }
        // $supervisors = collect($supervisors);
        return inertia('IPCR/Semestral/Create', [
            'supervisors' => $supervisors,
            'id' => $id,
            'emp' => $emp,
            'dept_code' => $dept_code,
            'source' => $source,
            'editData' => $data
        ]);
    }
    public function update(Request $request, $id)
    {
        // dd($request);
        $attributes = $request->validate([
            'immediate_id' => 'required',
            'next_higher' => 'required',
            'year' => 'required',
            'sem' => 'required',
        ]);
        $data = $this->ipcr_sem->findOrFail($id);
        // dd($data);
        $curr_sem = $data->sem;
        $new_sem = $request->sem;
        $curr_year = $data->year;
        $new_year = $request->year;
        // UserEmployees::where('empl_id', $request->employee_code)
        //     ->first();
        $user = UserEmployees::with(
            'Division',
            'Office',
            'Office.pgHead',
            'employeeSpecialDepartment',
            'employeeSpecialDepartment.Office',
            'employeeSpecialDepartment.PGDH',
        )
            ->where('empl_id', $request->employee_code)
            ->first();
        $ipcr_targg = Ipcr_Semestral::where('employee_code', $request->employee_code)
            ->where('year', $request->year)
            ->where('sem', $request->sem)
            ->where('id', '<>', $id)
            ->get();
        // dd(count($ipcr_targg) >= 1);
        // dd(count($ipcr_targg));
        $div_code = null;
        $div_name = null;
        if ($user) {
            if ($user->Division) {
                $div_code = $user->Division->division_code;
                $div_name = $user->Division->division_name1;
            }
        }
        if (!$div_name) {
            $sup = UserEmployees::with('Division')->where('empl_id', $request->immediate_id)
                ->orWhere('empl_id', $request->next_higher)
                ->get();
            $imm = $sup->firstWhere('empl_id', $request->immediate_id);
            $next = $sup->firstWhere('empl_id', $request->next_higher);
            // dd($imm);
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
        $user_id = $user->id;
        $typ = "info";
        $msg = "IPCR Semestral updated!";
        if (count($ipcr_targg) < 1) {
            // dd("here: " . count($ipcr_targg));
            // if ($curr_sem != $new_sem && $curr_year != $new_year) {
            $monthly_accomplishment = MonthlyAccomplishment::where("ipcr_semestral_id", $id)
                ->orderByRaw('CAST(month AS UNSIGNED)', 'ASC')
                ->get();

            for ($i = 0; $i < count($monthly_accomplishment); $i++) {
                $curr_mon_sem = MonthlyAccomplishment::where('id', $monthly_accomplishment[$i]['id'])->first();
                $prevmon = $curr_mon_sem->month;
                $monthval = 0;
                if ($new_sem == "2") {
                    $monthval = (int)$i + 7;
                } else {
                    $monthval = (int)$i + 1;
                }
                $monthly_acc = MonthlyAccomplishment::find($monthly_accomplishment[$i]['id']);
                $monthly_acc->month = $monthval;
                $monthly_acc->year = $new_year;
                $monthly_acc->save();
            }
            $ipcr_sem = Ipcr_Semestral::find($id);
            $ipcr_sem->immediate_id = $request->immediate_id;
            $ipcr_sem->next_higher = $request->next_higher;
            $ipcr_sem->year = $request->year;
            $ipcr_sem->sem = $request->sem;
            $ipcr_sem->division = $div_code;
            $ipcr_sem->division_name = $div_name;
            $ipcr_sem->save();
            // ->map(function ($item) use ($new_sem, $curr_sem, $new_year) {
            // $curr_mon_sem = MonthlyAccomplishment::where('id', $item->id)->first();
            // $prevmon = $curr_mon_sem->month;
            // $monthval = 0;
            // dd($new_year);
            // if ($new_sem == "2") {
            // dd("new_sem: " . $new_sem);
            // if ($curr_sem == "1") {
            //     $monthval = (int)$prevmon + 6;
            // } else {
            //     $monthval = (int)$prevmon;
            // }
            //     if ((int)$prevmon < 7) {
            //         $monthval = (int)$prevmon + 6;
            //     } else {
            //         $monthval = (int)$prevmon;
            //     }
            // } else {
            //     if ((int)$prevmon < 7) {
            //         $monthval = (int)$prevmon;
            //     } else {
            //         $monthval = (int)$prevmon + 6;
            //     }
            // }
            // dd("current: " . $monthval . " prevmon: " . $prevmon);
            // dd($item->id);

            // $monthly_acc = MonthlyAccomplishment::find($item->id);
            // if ($item->id == '1') {
            //     dd($monthly_acc);
            // }
            // $monthly_acc->month = $monthval;
            // $monthly_acc->year = $new_year;
            // $monthly_acc->save();
            // dd($new_year);
            // MonthlyAccomplishment::where('id', $item->id)
            //     ->update([
            //         "month" => $monthval,
            //         "year" => $new_year
            //     ]);
            // });
            // }
            // dd($request->year);
            // dd($data);
            // $ipcr_sem = Ipcr_Semestral::find($id);
            // dd($ipcr_sem);
            // $ipcr_sem->immediate_id = $request->immediate_id;
            // $ipcr_sem->next_higher = $request->next_higher;
            // $ipcr_sem->year = $request->year;
            // $ipcr_sem->sem = $request->sem;
            // $ipcr_sem->save();
            // IPCRTargets::where("ipcr_semester_id", $id)
            //     ->update([
            //         'semester' => $request->sem,
            //         'year' => $request->year
            //     ]);
            // $data = $this->ipcr_sem->findOrFail($request->id);
            // dd($data);
        } else {
            $typ = "error";
            $msg = "Update results to duplication of an existing IPCR! Update unsuccessful.";
        }


        return redirect('/ipcrsemestral/' . $user_id . '/' . $request->source)
            ->with($typ, $msg);
    }
    // if (count($ipcr_targg) == 1) {
    //     // dd("count");

    // } else {
    //     return redirect('/ipcrsemestral/' . $user_id . '/' . $request->source)
    //         ->with('error', 'Error updating semestral target!');
    // }
    // $data->update([
    //     'sem' => $request->sem,
    //     'employee_code' => $request->employee_code,
    //     'immediate_id' => $request->immediate_id,
    //     'next_higher' => $request->next_higher,
    //     'ipcr_semester_id' => $request->ipcr_semester_id,
    //     'status' => $request->status,
    //     'year' => $request->year,
    // ]);
    public function destroy(Request $request, $id, $source)
    {
        // dd('delete : '.$id);
        // $daily = Daily_Accomplishment::where('')
        $emp_code = auth()->user()->username;
        $emp = UserEmployees::where('empl_id', $emp_code)
            ->first()->id;

        $data = $this->ipcr_sem->findOrFail($id);
        $daily = Daily_Accomplishment::where('sem_id', $id)
            ->get();
        if (count($daily) > 0) {
            return redirect('/ipcrsemestral/' . $emp . '/' . $source)
                ->with('deleted', 'Warning: You cannot delete this record because it has related daily accomplishments. Please remove those entries first.');
        } else {
            $data->delete();

            $ipcr_monthly_accomp = MonthlyAccomplishment::where('ipcr_semestral_id', $id)->delete();
            $ipcr_targ = IPCRTargets::where('ipcr_semester_id', $id)->delete();
            return redirect('/ipcrsemestral/' . $emp . '/' . $source)
                ->with('message', 'Employee IPCR Deleted!');
        }
    }
    public function submission(Request $request, $id, $source)
    {
        // dd(auth()->user()->username);
        $data = $this->ipcr_sem->findOrFail($id);
        $user = UserEmployees::where('empl_id', $data->employee_code)
            ->first();
        $user_id = $user->id;
        $data->update([
            'status' => '0',
        ]);
        $rem = new ReturnRemarks();
        $rem->type = "Submitted semestral target";
        $rem->ipcr_semestral_id = $id;
        $rem->employee_code = auth()->user()->username;
        $rem->save();
        if ($source == 'targets') {
            return redirect('/ipcrtargets/' . $id)
                ->with('message', 'IPCR submitted');
        } else {
            return redirect('/ipcrsemestral/' . $user_id . '/' . $request->source)
                ->with('message', 'IPCR submitted');
        }
    }
    public function copyIpcr(Request $request, $ipcr_id_copied, $ipcr_id_passed)
    {
        // dd(" ipcr_id_copied: " . $ipcr_id_copied . " ipcr_id_passed: " . $ipcr_id_passed);
        $targetsForCopy = IPCRTargets::where('ipcr_semester_id', $ipcr_id_copied)
            ->get()
            ->map(function ($item) use ($ipcr_id_passed) {
                $sem_s = IPCRTargets::where('ipcr_semester_id', $ipcr_id_passed)
                    ->where('ipcr_code', $item->ipcr_code)
                    ->first();
                if (empty($sem_s)) {
                    $sem = Ipcr_Semestral::where('id', $ipcr_id_passed)->first();
                    $my_new = new IPCRTargets();
                    $my_new->employee_code = $sem->employee_code;
                    $my_new->ipcr_code = $item->ipcr_code;
                    $my_new->semester = $sem->sem;
                    $my_new->ipcr_type = $item->ipcr_type;
                    $my_new->is_additional_target = '';
                    $my_new->ipcr_semester_id = $ipcr_id_passed;
                    $my_new->quantity_sem = $item->quantity_sem;
                    $my_new->month_1 = $item->month_1;
                    $my_new->month_2 = $item->month_2;
                    $my_new->month_3 = $item->month_3;
                    $my_new->month_4 = $item->month_4;
                    $my_new->month_5 = $item->month_5;
                    $my_new->month_6 = $item->month_6;
                    $my_new->year = $item->year;
                    $my_new->remarks = $item->remarks;
                    $my_new->deleted_at = $item->deleted_at;
                    $my_new->created_at = $item->created_at;
                    $my_new->updated_at = $item->updated_at;
                    $my_new->save();
                }
            });

        return back()->with('message', 'Successfully copied targets');
    }
    public function index2(Request $request)
    {
        // dd();
        // $emp = UserEmployees::where('id', $id)
        //     ->first();
        // dd($id);
        $empl_id = $request->value;
        // dd($empl_id);
        // Fetch all employees and search for the match
        // $decodedHash = base64_decode(str_replace(['-', '_'], ['+', '/'], $empl_id));
        $decodedHash = base64_decode(str_replace(['-', '_'], ['+', '/'], $empl_id));
        // dd($decodedHash);
        // $emp_main = UserEmployeeCredential::with(['userEmployee', 'employeeSpecialDepartment'])->get()->first(function ($employee) use ($decodedHash) {
        //     // Hash the empl_id and check if it matches the hashedId
        //     return Hash::check($employee->userEmployee->empl_id, $decodedHash);
        // });

        $emp_main = UserEmployeeCredential::with(['userEmployee', 'employeeSpecialDepartment'])
            ->whereHas('userEmployee', function ($query) use ($empl_id) {
                $query->whereRaw("
                    REPLACE(
                        REPLACE(
                            REPLACE(
                                REPLACE(
                                    TO_BASE64(SHA2(user_employees.empl_id, 256)),
                                    '+', '-'
                                ),
                                '/', '_'
                            ),
                            '=', ''
                        ),
                        CHAR(10), ''
                    ) = ?", [$empl_id]);
            })
            ->first();

        // dd($emp_main->empl_id_hashed . ' empl_id:' . $empl_id);
        // $emp_main = auth()->user()->load(['userEmployee', 'employeeSpecialDepartment']);
        $id = $emp_main->id;
        $emp = $emp_main->userEmployee;
        $emp_code = $emp->empl_id;
        $esd = $emp_main->employeeSPecialDepartment;
        // EmployeeSpecialDepartment::where('employee_code', $emp_code)->first();
        // dd($esd);
        // dd('444');
        // dd($emp_main->employeeSPecialDepartment);
        $division = "";
        if ($emp->division_code) {
            $division = Division::where('division_code', $emp->division_code)
                ->first()->division_name1;
        }
        // dd('ipcr');
        // dd($esd);

        if ($esd) {
            if ($esd->department_code && $esd->department_code != '27') {
                $office = FFUNCCOD::where('department_code', $esd->department_code)->first();
                $dept = Office::where('department_code', $esd->department_code)->first();
            } else if ($esd->department_code == '27') {
                // dd('office 27');
                $office = FFUNCCOD::where('department_code', $emp->department_code)->first();
                $dept = Office::where('department_code', $emp->department_code)->first();
            } else {
                $office = FFUNCCOD::where('department_code', $emp->department_code)->first();
                $dept = Office::where('department_code', $emp->department_code)->first();
            }
            if ($esd->pgdh_cats) {
                $pgHead = UserEmployees::where('empl_id', $esd->pgdh_cats)->first();
            } else {
                $pgHead = UserEmployees::where('empl_id', $dept->empl_id)->first();
            }
        } else {
            $office = FFUNCCOD::where('department_code', $emp->department_code)->first();
            $dept = Office::where('department_code', $emp->department_code)->first();
            $pgHead = UserEmployees::where('empl_id', $dept->empl_id)->first();
        }


        $suff = "";
        $post = "";
        $mn = "";
        if ($pgHead->suffix_name != '') {
            $suff = ', ' . $pgHead->suffix_name;
        }
        if ($pgHead->postfix_name != '') {
            $post = ', ' . $pgHead->postfix_name;
        }
        if ($pgHead->middle_name != '') {
            $mn = $pgHead->middle_name[0] . '. ';
        }
        $pgHead = $pgHead->first_name . ' ' . $mn  . $pgHead->last_name . '' . $suff . '' . $post;

        $is_add = '';

        $sem_data
            = Ipcr_Semestral::select(
                'ipcr__semestrals.id as ipcr_sem_id',
                DB::raw('NULL as id_target'),
                'ipcr__semestrals.employee_code',
                'ipcr__semestrals.immediate_id',
                'ipcr__semestrals.next_higher',
                'ipcr__semestrals.sem',
                'ipcr__semestrals.status',
                'ipcr__semestrals.year',
                'ipcr__semestrals.pg_dept_head',
                'ipcr__semestrals.department',
                'ipcr__semestrals.division_name',
                DB::raw('NULL as ipcr_code'),
                DB::raw('NULL as individual_output'),
                DB::raw('NULL as is_additional_target'),
                DB::raw('NULL as target_status'),
                DB::raw("
                    REPLACE(
                        REPLACE(
                            REPLACE(
                                REPLACE(
                                    TO_BASE64(SHA2(ipcr__semestrals.id, 256)),
                                    '+', '-'
                                ),
                                '/', '_'
                            ),
                            '=', ''
                        ),
                        CHAR(10), ''
                    ) AS sem_id_hashed
                ")
            )
            ->with(['immediate', 'next_higher1', 'latestReturnRemark'])
            ->where('ipcr__semestrals.employee_code', $emp_code)
            ->union(
                Ipcr_Semestral::select(
                    'ipcr__semestrals.id as ipcr_sem_id',
                    'i_p_c_r_targets.id as id_target',
                    'ipcr__semestrals.employee_code',
                    'ipcr__semestrals.immediate_id',
                    'ipcr__semestrals.next_higher',
                    'ipcr__semestrals.sem',
                    'ipcr__semestrals.status',
                    'ipcr__semestrals.year',
                    'ipcr__semestrals.pg_dept_head',
                    'ipcr__semestrals.department',
                    'ipcr__semestrals.division_name',
                    'individual_final_outputs.ipcr_code',
                    'individual_final_outputs.individual_output',
                    'i_p_c_r_targets.is_additional_target',
                    'i_p_c_r_targets.status AS target_status',
                    DB::raw("
                        REPLACE(
                            REPLACE(
                                REPLACE(
                                    REPLACE(
                                        TO_BASE64(SHA2(ipcr__semestrals.id, 256)),
                                        '+', '-'
                                    ),
                                    '/', '_'
                                ),
                                '=', ''
                            ),
                            CHAR(10), ''
                        ) AS sem_id_hashed
                    ")
                )

                    ->with(['immediate', 'next_higher1', 'latestReturnRemark', 'IPCRTargets'])
                    ->leftJoin('i_p_c_r_targets', 'ipcr__semestrals.id', '=', 'i_p_c_r_targets.ipcr_semester_id')
                    ->leftJoin('individual_final_outputs', 'individual_final_outputs.ipcr_code', '=', 'i_p_c_r_targets.ipcr_code')
                    ->where('i_p_c_r_targets.is_additional_target', 1)
                    ->where('ipcr__semestrals.employee_code', $emp_code)
            )
            ->orderBy('year', 'DESC')
            ->orderBy('sem', 'DESC')
            ->orderBy('is_additional_target', 'asc')
            ->get()
            ->map(function ($item) {
                $rem = $item->latestReturnRemark;
                // $rem_next = $item->latestReturnRemarkNextHigher;
                $immediate = $item->immediate;
                $next_higher = $item->next_higher1;
                $divv = $item->division_name;

                // dd($item->ipcr_sem_id);
                // $divcode = $item->division_code;
                // dd($item);

                // ReturnRemarks::where('ipcr_semestral_id', $item->ipcr_sem_id)
                //     ->where('type', 'LIKE', '%target%')
                //     ->orderBy('created_at', 'DESC')
                //     ->first();

                // UserEmployees::where('empl_id', $item->immediate_id)
                //     ->first();
                // dd($immediate);

                // UserEmployees::where('empl_id', $item->next_higher)
                //     ->first();
                // if ($item->division_code) {
                // } else {

                //     try {
                //         if ($immediate->division_code) {
                //             $divcode = $immediate->division_code;
                //         }
                //         if ($next_higher->division_code) {
                //             $divcode = $next_higher->division_code;
                //         }
                //     } catch (Exception $e) {
                //     }
                // }

                // $divv = "";

                // Division::where('division_code', $divcode)->first();
                // if ($div) {
                //     $divv = $div->division_name1;
                // }
                return [
                    'sem_id_hashed' => $item->sem_id_hashed,
                    'ipcr_sem_id' => $item->ipcr_sem_id,
                    'ipcr_target_id' => $item->id_target,
                    'employee_code' => $item->employee_code,
                    'immediate_id' => $item->immediate_id,
                    'next_higher' => $item->next_higher,
                    "imm" => $immediate,
                    "next" => $next_higher,
                    'sem' => $item->sem,
                    'status' => $item->status,
                    'year' => $item->year,
                    'rem' => $rem,
                    'ipcr_code' => $item->ipcr_code,
                    'individual_output' => $item->individual_output,
                    'is_additional_target' => $item->is_additional_target,
                    'target_status' => $item->target_status,
                    'division' => $divv ? $divv : '',
                    'office' => $item->department,
                    'pgHead' => $item->pg_dept_head,
                ];
            });

        $showPerPage = 10;

        $sem_data = PaginationHelper::paginate($sem_data, $showPerPage);
        // dd($office);
        return inertia('IPCR/Semestral2/Index', [
            "id" => $empl_id,
            "sem_data" => $sem_data,
            "division" => $division,
            "emp" => $emp,
            "source" => 'direct',
            "office" => $office,
            "pgHead" => $pgHead,
        ]);
    }
    public function create2(Request $request, $id)
    {
        // dd("create 2: " . $id);
        //GET DATA FOR EDITING**************************************************_
        $data = Ipcr_Semestral::with(['immediate', 'next_higher1'])
            ->whereRaw("
                    REPLACE(
                        REPLACE(
                            REPLACE(
                                REPLACE(
                                    TO_BASE64(SHA2(ipcr__semestrals.id, 256)),
                                    '+', '-'
                                ),
                                '/', '_'
                            ),
                            '=', ''
                        ),
                        CHAR(10), ''
                    ) = ?", [$id])
            ->first();
        // dd($data);
        $id = $data->employee_code;

        // USER DETAILS***********************************************************
        // $uss = auth()->user()->load('UserEmployee');
        $uss = UserEmployeeCredential::with('UserEmployee')->where('username', $data->employee_code)->first();
        $emp = $uss->userEmployee;
        $is_pghead = $emp->is_pghead;
        $division_code = $emp->division_code;
        $sg = $emp->salary_grade;
        $dept_code = $emp->department_code;
        $desig_dept = $emp->designate_department_code;

        // dd($id . ' - ' . $uss->username);
        // dd('equal sila: ' . $id . ' - ' . $uss->username);
        //SUPERVISORS*************************************************************-
        $supervisors = UserEmployees::where('salary_grade', '>=', $sg)
            ->where('user_employees.active_status', 'ACTIVE')
            ->where(function ($query) use ($dept_code) {
                $query->where('user_employees.department_code', $dept_code)
                    ->orWhere('user_employees.designate_department_code', $dept_code);
            })
            ->get();
        //********************************************************************/
        if (isset($desig_dept) && $desig_dept != "" && $desig_dept != $dept_code) {
            $superv = UserEmployees::where('salary_grade', '>=', $sg)
                ->where('user_employees.active_status', 'ACTIVE')
                ->where('user_employees.designate_department_code', $desig_dept)
                ->get();
            $supervisors = $supervisors->concat($superv);
        }

        //VGO or SP**************************************************************
        if (in_array($dept_code, [18, 19])) {
            $other_dept_code = $dept_code == 19 ? 18 : 19;
            $superv = UserEmployees::where(
                'salary_grade',
                '>=',
                $sg
            )
                ->whereIn('user_employees.department_code', [$other_dept_code])
                ->where('user_employees.active_status', 'ACTIVE')
                ->get();
            $supervisors = $supervisors->concat($superv);
        }
        //Hospitals************************************************************************
        if (
            $dept_code == 21 || $dept_code == 22 || $dept_code == 23 || $dept_code == 24
        ) {
            $peemo = UserEmployees::where('salary_grade', '>=', $sg)
                ->where('user_employees.active_status', 'ACTIVE')
                ->where('user_employees.designate_department_code', 20)
                ->get();
            $supervisors = $supervisors->concat($peemo);
        }

        //PGO******************************************************************************************************
        if ($dept_code == '01') {
            $pgo_add = UserEmployees::where('empl_id', '10106')
                ->orWhere('empl_id', '0361')
                ->get();
            $supervisors = $supervisors->merge($pgo_add);
        }

        //FOR Employee Special Departments**************************************************************************
        $special_dept = EmployeeSpecialDepartment::where('employee_special_departments.employee_code', $emp->empl_id)
            ->get()->pluck('department_code');
        if (count($special_dept) > 0) {
            $superv_special = UserEmployees::where('salary_grade', '>=', $sg)
                ->where('user_employees.active_status', 'ACTIVE')
                ->get();
            $supervisors = $supervisors->concat($superv_special);
        }

        //For Acting PG Department Heads*****************************************************************************
        if ($is_pghead == '1') {
            $ids = $supervisors->pluck('empl_id');
            // dd($ids);
            $supp = UserEmployees::where('salary_grade', '>=', $sg)
                ->where('user_employees.active_status', 'ACTIVE')
                ->whereNotIn('empl_id', $ids)
                ->get();
            $supervisors = $supervisors->concat($supp);
        }

        if ($division_code == '057') {
            $superv = UserEmployees::where('empl_id', '10060')
                ->get();
            $supervisors = $supervisors->concat($superv);
        }
        $imm_id = $data->immediate_id;
        $next_id = $data->next_higher;
        $imm_f = 0;
        $next_f = 0;

        //CHECKING IF immediate or next higher selected exists ******************************************************
        foreach ($supervisors as $item) {

            if ($item['empl_id'] == $imm_id) {
                $imm_f = 1;
            }
            if ($item['empl_id'] == $next_id) {
                $next_f = 1;
            }
        }

        //PUSH immediate and/or nexthigher details to the supervisors variable if not found***********************
        if ($imm_f == 0) {
            $supervisors->push($data->immediate);
        }
        if (
            $next_f == 0
        ) {
            $supervisors->push($data->next_higher1);
        }
        $offices = Office::where('office', 'LIKE', '%OFFICE%')->orWhere('office', 'LIKE', '%HOSPITAL%')->get();
        $pghead = UserEmployees::where('is_pghead', '1')->get()
            ->map(function ($pgHead) {
                $suff = "";
                $post = "";
                $mn = "";
                if ($pgHead->suffix_name != '') {
                    $suff = ', ' . $pgHead->suffix_name;
                }
                if ($pgHead->postfix_name != '') {
                    $post = ', ' . $pgHead->postfix_name;
                }
                if ($pgHead->middle_name != '') {
                    $mn = $pgHead->middle_name[0] . '. ';
                }
                $name = $pgHead->first_name . ' ' . $mn  . $pgHead->last_name . '' . $suff . '' . $post;
                return [
                    'empl_id' => $pgHead->empl_id,
                    'employee_name' => $name,
                ];
            });
        // dd($pghead->pluck('employee_name'));
        // dd($offices->pluck('office'));
        //*************************************************************************************************
        return inertia('IPCR/Semestral2/Create', [
            'supervisors' => $supervisors,
            'id' => $id,
            'emp' => $emp,
            'dept_code' => $dept_code,
            'source' => 'direct',
            'offices' => $offices,
            'editData' => $data,
            'pgheads' => $pghead
        ]);
    }

    // public function update(){}
    public function update2(Request $request, $id)
    {
        // dd($request);
        $attributes = $request->validate([
            'sem' => 'required',
            'employee_code' => 'required',
            'immediate_id' => 'required',
            'next_higher' => 'required',
            'employee_name' => 'required',
            'position' => 'required',
            'employment_type' => 'required',
            'salary_grade' => 'required',
            'division' => 'required',
            'year' => 'required',
            'status' => 'required',
            'status_accomplishment' => 'required',
            'department_code' => 'required',
            'department' => 'required',
            'division_name' => 'required',
            'pg_dept_head' => 'required',
        ]);
        $data = $this->ipcr_sem->findOrFail($id);
        // dd($data);
        $curr_sem = $data->sem;
        $new_sem = $request->sem;
        $curr_year = $data->year;
        $new_year = $request->year;
        // UserEmployees::where('empl_id', $request->employee_code)
        //     ->first();
        $user = UserEmployees::with(
            'Division',
            'Office',
            'Office.pgHead',
            'employeeSpecialDepartment',
            'employeeSpecialDepartment.Office',
            'employeeSpecialDepartment.PGDH',
        )
            ->where('empl_id', $request->employee_code)
            ->first();
        $ipcr_targg = Ipcr_Semestral::where('employee_code', $request->employee_code)
            ->where('year', $request->year)
            ->where('sem', $request->sem)
            ->where('id', '<>', $id)
            ->get();
        // dd(count($ipcr_targg) >= 1);
        // dd(count($ipcr_targg));
        $div_code = null;
        $div_name = null;
        if ($user) {
            if ($user->Division) {
                $div_code = $user->Division->division_code;
                $div_name = $user->Division->division_name1;
            }
        }
        // if (!$div_name) {
        //     $sup = UserEmployees::with('Division')->where('empl_id', $request->immediate_id)
        //         ->orWhere('empl_id', $request->next_higher)
        //         ->get();
        //     $imm = $sup->firstWhere('empl_id', $request->immediate_id);
        //     $next = $sup->firstWhere('empl_id', $request->next_higher);
        //     // dd($imm);
        //     if ($imm) {
        //         if ($imm->Division) {
        //             $div_code = $imm->division_code;
        //             $div_name = $imm->Division->division_name1;
        //         } else {
        //             if ($next) {
        //                 if ($next->Division) {
        //                     $div_code = $next->division_code;
        //                     $div_name = $next->Division->division_name1;
        //                 }
        //             }
        //         }
        //     }
        // }
        $user_id = $user->id;
        $typ = "info";
        $msg = "IPCR Semestral updated!";
        if (count($ipcr_targg) < 1) {
            // dd("here: " . count($ipcr_targg));
            // if ($curr_sem != $new_sem && $curr_year != $new_year) {
            $monthly_accomplishment = MonthlyAccomplishment::where("ipcr_semestral_id", $id)
                ->orderByRaw('CAST(month AS UNSIGNED)', 'ASC')
                ->get();

            for ($i = 0; $i < count($monthly_accomplishment); $i++) {
                $curr_mon_sem = MonthlyAccomplishment::where('id', $monthly_accomplishment[$i]['id'])->first();
                $prevmon = $curr_mon_sem->month;
                $monthval = 0;
                if ($new_sem == "2") {
                    $monthval = (int)$i + 7;
                } else {
                    $monthval = (int)$i + 1;
                }
                $monthly_acc = MonthlyAccomplishment::find($monthly_accomplishment[$i]['id']);
                $monthly_acc->month = $monthval;
                $monthly_acc->year = $new_year;
                $monthly_acc->save();
            }
            $ipcr_sem = Ipcr_Semestral::find($id);
            $ipcr_sem->immediate_id = $request->immediate_id;
            $ipcr_sem->next_higher = $request->next_higher;
            $ipcr_sem->year = $request->year;
            $ipcr_sem->sem = $request->sem;
            $ipcr_sem->division = $div_code;
            $ipcr_sem->division_name = $div_name;
            $ipcr_sem->save();
        } else {
            $typ = "error";
            $msg = "Update results to duplication of an existing IPCR! Update unsuccessful.";
        }


        return redirect('/ipcrsemestral2/' . $user_id . '/' . $request->source)
            ->with($typ, $msg);
    }
    function generateUrlSafeHash($input)
    {
        // Generate a SHA-256 hash
        $hash = hash('sha256', $input, true); // Raw binary output
        // Base64 encode and make it URL-safe
        $urlSafeHash = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($hash));
        return $urlSafeHash;
    }

    function verifyUrlSafeHash($input, $urlSafeHash)
    {
        // Decode the URL-safe hash
        $decodedHash = base64_decode(str_replace(['-', '_'], ['+', '/'], $urlSafeHash));
        // Generate the hash of the input and compare
        return hash('sha256', $input, true) === $decodedHash;
    }

    function divisions($office_code)
    {
        return Division::where('department_code', $office_code)->get();
    }
}
