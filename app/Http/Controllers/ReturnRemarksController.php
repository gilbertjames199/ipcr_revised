<?php

namespace App\Http\Controllers;

use App\Models\Division;
use App\Models\EmployeeSpecialDepartment;
use App\Models\FFUNCCOD;
use App\Models\Ipcr_Semestral;
use App\Models\IPCRTargets;
use App\Models\MonthlyAccomplishment;
use App\Models\Office;
use App\Models\ProbationaryTemporaryEmployees;
use App\Models\ReturnRemarks;
use App\Models\UserEmployees;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReturnRemarksController extends Controller
{
    protected $return_remarks, $prob_tempo, $ipcr_semestral, $monthly_accomplishments;
    public function __construct(
        ReturnRemarks $return_remarks,
        ProbationaryTemporaryEmployees $prob_tempo,
        Ipcr_Semestral $ipcr_semestral,
        MonthlyAccomplishment $monthly_accomplishments
    ) {
        $this->return_remarks = $return_remarks;
        $this->prob_tempo = $prob_tempo;
        $this->ipcr_semestral = $ipcr_semestral;
        $this->monthly_accomplishments = $monthly_accomplishments;
    }

    public function index(Request $request)
    {


        $emp_code = auth()->user()->username;

        $data = ReturnRemarks::select(
            DB::raw("DATE_FORMAT(return_remarks.created_at, '%M %d, %Y %r') AS formatted_created_at"),
            'return_remarks.ipcr_monthly_accomplishment_id',
            'return_remarks.ipcr_semestral_id',
            'return_remarks.remarks',
            'return_remarks.type',
            'return_remarks.acted_by',
            'ipcr__semestrals.id',
            'ipcr__semestrals.sem',
            'ipcr__semestrals.year',
            'user_employees.id',
            'user_employees.employee_name',
            'ipcr_monthly_accomplishments.id',
            'ipcr_monthly_accomplishments.month'
        )
            ->leftjoin('ipcr_monthly_accomplishments', 'return_remarks.ipcr_monthly_accomplishment_id', '=', 'ipcr_monthly_accomplishments.id')
            ->leftjoin('user_employees', 'return_remarks.acted_by', '=', 'user_employees.empl_id')
            ->leftjoin('ipcr__semestrals', 'return_remarks.ipcr_semestral_id', '=', 'ipcr__semestrals.id')
            ->where('return_remarks.employee_code', $emp_code)
            ->orderBy('return_remarks.ipcr_semestral_id', 'ASC')
            ->orderBy('return_remarks.created_at', 'ASC')
            ->get();

        return inertia('IPCR_Tracking/Index', [
            "data" => $data,
        ]);
    }

    public function returnRemarks(Request $request)
    {
        // dd('return monthly');
        $attributes = $request->validate([
            'type' => 'required',
            'remarks' => 'required',
            'ipcr_semestral_id' => 'required',
            'employee_code' => 'required',
        ]);
        $type = $request->type;
        $id = $request->ipcr_semestral_id;
        if ($type === 'probationary/temporary') {
            $data = $this->prob_tempo->findOrFail($id);
            $data->update([
                'status' => '-2'
            ]);
        } else {
            $data = $this->ipcr_semestral->findOrFail($id);
            $data->update([
                'status' => '-2'
            ]);
        }
        $this->return_remarks->create($attributes);
        return redirect('/review/approve')
            ->with('message', 'Return remarks');
    }
    public function returnRemarksAccomplishments(Request $request)
    {
        // dd('returnRemarksAccomplishments: ' . $request->ipcr_monthly_accomplishment_id);
        $attributes = $request->validate([
            'type' => 'required',
            'remarks' => 'required',
            'ipcr_semestral_id' => 'required',
            'employee_code' => 'required',
            'ipcr_monthly_accomplishment_id' => 'required',
        ]);
        // dd("after validate");
        $type = $request->type;
        $id = $request->ipcr_monthly_accomplishment_id;
        if ($type === 'probationary/temporary') {
            $data = $this->prob_tempo->findOrFail($id);
            $data->update([
                'status' => '-2'
            ]);
        } else {
            // dd('gfdgdfgdfgdfg');
            $data = $this->monthly_accomplishments->findOrFail($id);
            // dd($data);
            $data->update([
                'status' => '-2'
            ]);
        }
        $this->return_remarks->create($attributes);
        return redirect('/approve/accomplishments')
            ->with('update', 'Return remarks');
    }
    public function returnRemarksResponsible(Request $request)
    {
        //Generate return remarks for ipcr semestrals with no entries in return_remarks table
        $ipcr_sem = Ipcr_Semestral::all();
        for ($i = 0; $i < count($ipcr_sem); $i++) {
            // dd($ipcr_sem[$i]);
            // dd($ipcr_sem[$i]);
            $idipcr = $ipcr_sem[$i]['id'];
            $employee_code = $ipcr_sem[$i]['employee_code'];
            $status = $ipcr_sem[$i]['status'];
            $status_accomplishment = $ipcr_sem[$i]['status_accomplishment'];
            $immediate_id = $ipcr_sem[$i]['immediate_id'];
            $next_higher = $ipcr_sem[$i]['next_higher'];
            //Check if ipcr_semestral targets has been reviewed
            if ($status > 0) {
                $target_rev = ReturnRemarks::where('type', 'review target')
                    ->where('ipcr_semestral_id', $idipcr)
                    ->get();
                //if the return_remarks entry is less than 1, generate return remarks
                if (count($target_rev) < 1) {
                    $target_rev_retrem = new ReturnRemarks();
                    $target_rev_retrem->type = 'review target';
                    $target_rev_retrem->remarks = '';
                    $target_rev_retrem->ipcr_semestral_id = $idipcr;
                    $target_rev_retrem->ipcr_monthly_accomplishment_id = '';
                    $target_rev_retrem->employee_code = $employee_code;
                    $target_rev_retrem->acted_by = $immediate_id;
                    $target_rev_retrem->save();
                }
            }


            //Check if approve exists (targets)

            //Check if IPCR has been approved
            if ($status > 1) {
                $target_app = ReturnRemarks::where('type', 'approve target')
                    ->where('ipcr_semestral_id', $idipcr)
                    ->get();
                //if the return_remarks entry is less than 1, generate return remarks
                if (count($target_app) < 1) {
                    $target_app_retrem = new ReturnRemarks();
                    $target_app_retrem->type = 'approve target';
                    $target_app_retrem->remarks = '';
                    $target_app_retrem->ipcr_semestral_id = $idipcr;
                    $target_app_retrem->ipcr_monthly_accomplishment_id = '';
                    $target_app_retrem->employee_code = $employee_code;
                    $target_app_retrem->acted_by = $next_higher;
                    $target_app_retrem->save();
                }
            }

            //Check if ipcr_semestral (semestral accomplishments) has been reviewed
            if ($status_accomplishment > 0) {
                $sem_accomp_rev = ReturnRemarks::where('type', 'review semestral accomplishment')
                    ->where('ipcr_semestral_id', $idipcr)
                    ->get();
                //if the return_remarks entry is less than 1, generate return remarks
                if (count($sem_accomp_rev) < 1) {
                    $sem_accomp_rev_retrem = new ReturnRemarks();
                    $sem_accomp_rev_retrem->type = 'review semestral accomplishment';
                    $sem_accomp_rev_retrem->remarks = '';
                    $sem_accomp_rev_retrem->ipcr_semestral_id = $idipcr;
                    $sem_accomp_rev_retrem->ipcr_monthly_accomplishment_id = '';
                    $sem_accomp_rev_retrem->employee_code = $employee_code;
                    $sem_accomp_rev_retrem->acted_by = $immediate_id;
                    $sem_accomp_rev_retrem->save();
                }
            }

            //Check if ipcr_semestrals (semestral accomplishments) is approved
            if ($status_accomplishment > 1) {
                $sem_accomp_rev = ReturnRemarks::where('type', 'approve semestral accomplishment')
                    ->where('ipcr_semestral_id', $idipcr)
                    ->get();
                //if the return_remarks entry is less than 1, generate return remarks
                if (count($sem_accomp_rev) < 1) {
                    $sem_accomp_rev_retrem = new ReturnRemarks();
                    $sem_accomp_rev_retrem->type = 'approve semestral accomplishment';
                    $sem_accomp_rev_retrem->remarks = '';
                    $sem_accomp_rev_retrem->ipcr_semestral_id = $idipcr;
                    $sem_accomp_rev_retrem->ipcr_monthly_accomplishment_id = '';
                    $sem_accomp_rev_retrem->employee_code = $employee_code;
                    $sem_accomp_rev_retrem->acted_by = $next_higher;
                    $sem_accomp_rev_retrem->save();
                }
            }
        }
        // dd("person responsible");
        $retrem = ReturnRemarks::all();

        for ($i = 0; $i < count($retrem); $i++) {
            $id = $retrem[$i]['id'];
            $sem_id = $retrem[$i]['ipcr_semestral_id'];
            // $ipcr_monthly_accomp_id = $retrem[$i][''];
            $rem_type = $retrem[$i]['type'];
            $ipcr_semestrals = Ipcr_Semestral::where('id', $sem_id)->first();
            $acted_by = '';
            // dd($sem_id);
            if ($ipcr_semestrals) {
                // dd($ipcr_semestrals);

                if ($rem_type == 'review target') {
                    // dd($rem_type);
                    // $acted_by = $ipcr_semestrals->ipcr;
                    $acted_by = $ipcr_semestrals->immediate_id;
                }
                if ($rem_type == 'approve target') {
                    // dd($rem_type);
                    $acted_by = $ipcr_semestrals->next_higher;
                }
                if ($rem_type == 'review accomplishment') {
                    // dd($rem_type);
                    $acted_by = $ipcr_semestrals->immediate_id;
                }
                if ($rem_type == 'approve accomplishment') {
                    // dd($rem_type);
                    $acted_by = $ipcr_semestrals->next_higher;
                }
                if ($rem_type == 'final approve accomplishment') {
                    // dd($rem_type);
                    $acted_by = $ipcr_semestrals->immediate_id;
                }
                if ($rem_type == 'return accomplishment') {
                    // dd($rem_type);
                    $acted_by = '';
                }
                if ($rem_type == 'return target') {
                    // dd($rem_type);
                    $acted_by = '';
                }
                if ($rem_type == 'review semestral accomplishment') {
                    // dd($rem_type);
                    $acted_by = $ipcr_semestrals->next_higher;
                }
                if ($rem_type == 'approve semestral accomplishment') {
                    // dd($rem_type);$acted_by = $ipcr_semestrals->immediate_id;
                    $acted_by = $ipcr_semestrals->immediate_id;
                }
                if ($rem_type == 'return semestral accomplishment') {
                    // dd($rem_type);
                    $acted_by = '';
                }
                if ($acted_by == '') {
                } else {
                    $my_ipcr = ReturnRemarks::find($id);
                    $my_ipcr->acted_by = $acted_by;
                    $my_ipcr->save();
                }
            }
            // dd($retrem[$i]);
            // dd($rem_type);
        }
    }
    public function actedParticulars(Request $request)
    {
        // dd('acted');
        $user_id = auth()->user()->username;
        $data = ReturnRemarks::where('return_remarks.acted_by', $user_id)
            ->join('user_employees', 'user_employees.empl_id', 'return_remarks.employee_code')
            ->join('ipcr__semestrals', 'ipcr__semestrals.id', 'return_remarks.ipcr_semestral_id')
            ->paginate(10);

        return inertia('Acted_Review/Index', [
            "data" => $data
        ]);
    }
    public function actedParticularsTargets(Request $request)
    {
        // at.id, dat.empl_id, dat.employee_name, dat.year, dat.sem, dat.status
        // dd('acted-targets');
        $user_id = auth()->user()->username;
        // select(
        //     'return_remarks.id',
        //     'return_remarks.type',
        //     'return_remarks.ipcr_semestral_id',
        //     'return_remarks.ipcr_monthly_accomplishment_id',
        //     'user_employees.empl_id',
        //     'return_remarks.acted_by',
        //     'user_employees.employee_name',
        //     'ipcr__semestrals.sem',
        //     'ipcr__semestrals.immediate_id',
        //     'ipcr__semestrals.next_higher',
        //     'ipcr__semestrals.position',
        //     'user_employees.salary_grade',
        //     'ipcr__semestrals.year',
        //     'ipcr__semestrals.status',
        //     'return_remarks.created_at',
        // )
        //     ->
        $data = ReturnRemarks::with('ipcrSemestral2', 'userEmployee')
            ->where('return_remarks.acted_by', $user_id)
            ->where('type', 'LIKE', '%target%')
            ->when($request->search, function ($query, $searchItem) {
                $query->where('user_employees.employee_name', 'like', '%' . $searchItem . '%');
            })
            // ->join('user_employees', 'user_employees.empl_id', 'return_remarks.employee_code')
            // ->join('ipcr__semestrals', 'ipcr__semestrals.id', 'return_remarks.ipcr_semestral_id')
            ->orderBy('return_remarks.created_at', 'DESC')
            ->paginate(10)
            ->through(function ($item) {
                // dd($item);
                return [
                    'id' => $item->id,
                    'type' => $item->type,
                    'ipcr_semestral_id' => $item->ipcr_semestral_id,
                    'ipcr_monthly_accomplishment_id' => $item->ipcr_monthly_accomplishment_id,
                    'empl_id' => $item->userEmployee ? $item->userEmployee->empl_id : "",
                    'acted_by' => $item->acted_by,
                    'employee_name' => $item->userEmployee ? $item->userEmployee->employee_name : "",
                    'sem' => $item->ipcrSemestral2 ? $item->ipcrSemestral2->sem : "",
                    'immediate_id' => $item->ipcrSemestral2 ? $item->ipcrSemestral2->immediate_id : "",
                    'next_higher' => $item->ipcrSemestral2 ? $item->ipcrSemestral2->next_higher : "",
                    'position' => $item->ipcrSemestral2 ? $item->ipcrSemestral2->position : "",
                    'salary_grade' => $item->userEmployee ? $item->userEmployee->salary_grade : "",
                    'year' => $item->ipcrSemestral2 ? $item->ipcrSemestral2->year : "",
                    'status' => $item->ipcrSemestral2 ? $item->ipcrSemestral2->status : "",
                    'created_at' => $item->created_at,
                ];
            });
        // dd($data);
        return inertia('Acted_Review/Targets', [
            "filters" => $request->only(['search']),
            "data" => $data
        ]);
    }
    public function actedParticularsAccomplishments(Request $request)
    {
        // dd('actedParticularsAccomplishments');
        // dd(md5('password1.'));
        $user_id = auth()->user()->username;
        $emp = UserEmployees::where('empl_id', auth()->user()->username)
            ->first();
        $dept = Office::where('department_code', $emp->department_code)->first();
        $pgHead = UserEmployees::where('empl_id', $dept->empl_id)->first();
        // dd($pgHead);
        $data = ReturnRemarks::with([
            'ipcrSemestral2',
            'userEmployee',
            'ipcrMonthlyAccomplishment',
            'ipcrSemestral2.immediate',
            'ipcrSemestral2.next_higher1'
        ])
            ->where('return_remarks.acted_by', $user_id)
            ->where('type', 'LIKE', '%accomplishment%')
            ->where('return_remarks.ipcr_monthly_accomplishment_id', NULL)
            ->when($request->search, function ($query) use ($request) {
                // $query->where('user_employees.employee_name', 'LIKE', '%' . $request->search . '%');
                $query->whereHas('userEmployee', function ($query) use ($request) {
                    $query->where('employee_name', 'like', '%' . $request->search . '%');
                });
            })
            ->orderBy('return_remarks.created_at', 'DESC')
            ->paginate(10)
            ->through(function ($item) use ($pgHead) {
                // $of = "";
                $div = "";
                $imm = "";
                $next = "";

                $imm_emp = $item->ipcrSemestral2->immediate;
                if ($imm_emp) {
                    $imm = $imm_emp->first_name . ' ' . $imm_emp->last_name;
                }


                $nx = $item->ipcrSemestral2->next_higher1;
                if ($nx) {
                    $next = $nx->first_name . ' ' . $nx->last_name;
                }


                $div = $item->ipcrSemestral2->division_name;

                $suff = "";
                $post = "";
                $mn = "";
                $pgHead = $item->userEmployee->Office->pgHead;
                if (
                    $pgHead->suffix_name != ''
                ) {
                    $suff = ', ' . $pgHead->suffix_name;
                }
                if (
                    $pgHead->postfix_name != ''
                ) {
                    $post = ', ' . $pgHead->postfix_name;
                }
                if (
                    $pgHead->middle_name != ''
                ) {
                    $mn = $pgHead->middle_name[0] . '. ';
                }
                $pgHead = $pgHead->first_name . ' ' . $mn  . $pgHead->last_name . '' . $suff . '' . $post;
                return [
                    // user_employees **********************************************************************
                    "empl_id" => $item->userEmployee->empl_id,
                    "employee_name" => $item->userEmployee->employee_name,
                    "position" => $item->userEmployee->position_long_title,
                    "employment_type_descr" => $item->userEmployee ? $item->userEmployee->employment_type_descr : '',
                    "pgHead" => $pgHead,
                    // ipcr__semestrals *********************************************************************
                    "year" => $item->ipcrSemestral2 ? $item->ipcrSemestral2->year : '',
                    "sem" => $item->ipcrSemestral2 ? $item->ipcrSemestral2->sem : '',
                    "a_status" => $item->ipcrSemestral2 ? $item->ipcrSemestral2->status_accomplishment : '',
                    "office" => $item->ipcrSemestral2 ? $item->ipcrSemestral2->department : '',
                    "immediate" => $imm,
                    "next_higher" => $next,
                    "division" => $div,
                    // ipcr_monthly_accomplishments **********************************************************
                    "accomp_id" => $item->ipcrMonthlyAccomplishment ? $item->ipcrMonthlyAccomplishment->id : '',
                    "month" => $item->ipcrMonthlyAccomplishment ? $item->ipcrMonthlyAccomplishment->month : '',
                    "ipcr_monthly_accomplishments" => $item->ipcrMonthlyAccomplishment ? $item->ipcrMonthlyAccomplishment : '',
                    // return_remarks *************************************************************************
                    "ipcr_semestral_id" => $item->ipcr_semestral_id,
                    "ipcr_monthly_accomplishment_id" => $item->ipcr_monthly_accomplishment_id,
                    "remarks" => $item->remarks,
                    "type" => $item->type,
                    "created_at" => $item->created_at

                ];
            })
            ->withQueryString();

        $pgHeadn = $pgHead->first_name . ' ' . $pgHead->middle_name[0] . '. ' . $pgHead->last_name;
        if ($pgHead->suffix_name != NULL) {
            $pgHeadn = $pgHeadn . ', ' . $pgHead->suffix_name;
        }
        if ($pgHead->postfix_name != NULL) {
            $pgHeadn = $pgHeadn . ', ' . $pgHead->postfix_name;
        }
        return inertia('Acted_Review/Accomplishments', [
            "data" => $data,
            'pghead' => $pgHeadn,
            "filters" => $request->only(['search']),
        ]);
    }
    public function actedParticularsAccomplishmentsMonthly(Request $request)
    {
        $user_id = auth()->user()->username;
        $imm =  NULL;
        $next = NULL;
        $dv = NULL;
        // dd('dv');
        // $data = ReturnRemarks::select(
        //     'user_employees.empl_id',
        //     'user_employees.employee_name',
        //     'return_remarks.ipcr_semestral_id',
        //     'return_remarks.ipcr_monthly_accomplishment_id',
        //     'return_remarks.remarks',
        //     'ipcr__semestrals.year',
        //     'ipcr__semestrals.sem',
        //     'ipcr__semestrals.status_accomplishment AS a_status',
        //     'ipcr_monthly_accomplishments.id AS accomp_id',
        //     'ipcr_monthly_accomplishments.month',
        //     'user_employees.position_long_title AS position',
        //     'user_employees.division_code',
        //     // DB::raw($dv . ' as division'),
        //     'user_employees.department_code',
        //     'ipcr__semestrals.immediate_id AS immediate',
        //     'ipcr__semestrals.next_higher',
        //     'user_employees.employment_type_descr',
        //     'ipcr_monthly_accomplishments.id AS ipcr_monthly_accomplishments',
        //     'return_remarks.type',
        // )
        //     ->where('return_remarks.acted_by', $user_id)
        //     ->where('type', 'LIKE', '%accomplishment%')
        //     ->where('return_remarks.ipcr_monthly_accomplishment_id', '<>', '')
        //     ->leftjoin('user_employees', 'user_employees.empl_id', 'return_remarks.employee_code')
        //     ->leftjoin('ipcr__semestrals', 'ipcr__semestrals.id', 'return_remarks.ipcr_semestral_id')
        //     ->leftjoin('ipcr_monthly_accomplishments', 'ipcr_monthly_accomplishments.id', 'return_remarks.ipcr_monthly_accomplishment_id')
        //     ->orderBy('return_remarks.created_at', 'DESC')
        //     ->paginate(10)
        //     ->through(function ($item) {
        //         $of = "";
        //         $div = "";
        //         $imm = "";
        //         $next = "";

        //         $imm_emp = UserEmployees::where('empl_id', $item->immediate)->first();
        //         if ($imm_emp) {
        //             $imm = $imm_emp->first_name . ' ' . $imm_emp->last_name;
        //         }


        //         $nx = UserEmployees::where(
        //             'empl_id',
        //             $item->next_higher
        //         )->first();
        //         if ($nx) {
        //             $next = $nx->first_name . ' ' . $nx->last_name;
        //         }

        //         if (!$item->division) {
        //             // dd(': ' . $item->division);
        //             if ($imm_emp) {
        //                 if ($imm_emp->division_code) {
        //                     $div = $imm_emp->division_code;
        //                     // dd("imm: " . $div);
        //                 } else {
        //                     if ($nx) {
        //                         if ($nx->division_code) {
        //                             $div = $nx->division_code;
        //                             // dd($div);
        //                         }
        //                     }
        //                 }
        //             }
        //         }

        //         $dv = Division::where('division_code', $div)->first();
        //         if ($dv) {
        //             $div = $dv->division_name1;
        //         }
        //         $esd = EmployeeSpecialDepartment::where('employee_code', $item->empl_id)->first();
        //         if ($esd) {
        //             if ($esd->department_code) {
        //                 // $office = FFUNCCOD::where('department_code', $esd->department_code)->first();
        //                 $of = Office::where('department_code', $esd->department_code)->first();
        //             } else {
        //                 // $office = FFUNCCOD::where('department_code', $item->department_code)->first();
        //                 $of = Office::where('department_code', $item->department_code)->first();
        //             }

        //             if ($esd->pgdh_cats) {

        //                 $pgHead = UserEmployees::where('empl_id', $esd->pgdh_cats)->first();
        //             } else {

        //                 $pgHead = UserEmployees::where('empl_id', $of->empl_id)->first();
        //             }
        //         } else {
        //             // dd("officeee");
        //             $of = Office::where('department_code', $item->department_code)->first();
        //             // $dept = Office::where('department_code', $item->department_code)->first();
        //             // $pgHead = UserEmployees::where('empl_id', $dept->empl_id)->first();
        //         }
        //         // $of = FFUNCCOD::where('department_code', $item->department_code)->first();
        //         if ($of) {
        //             $off = $of->office;
        //         }
        //         // dd($item->department_code);
        //         // $item['office'] = $off;
        //         // $item['division'] = $div; // Set division based on some condition or calculation
        //         // $item['immediate'] = $imm;
        //         // $item['next_higher'] = $next;
        //         // dd($off);
        //         // return $item;
        //         return [
        //             "empl_id" => $item->empl_id,
        //             "employee_name" => $item->employee_name,
        //             "ipcr_semestral_id" => $item->ipcr_semestral_id,
        //             "ipcr_monthly_accomplishment_id" => $item->ipcr_monthly_accomplishment_id,
        //             "remarks" => $item->remarks,
        //             "year" => $item->year,
        //             "sem" => $item->sem,
        //             "a_status" => $item->a_status,
        //             "accomp_id" => $item->accomp_id,
        //             "month" => $item->month,
        //             "position" => $item->position,
        //             "office" => $off,
        //             "immediate" => $imm,
        //             "next_higher" => $next,
        //             "employment_type_descr" => $item->employment_type_descr,
        //             "ipcr_monthly_accomplishments" => $item->ipcr_monthly_accomplishments,
        //             "type" => $item->type,
        //             "division" => $div
        //         ];
        //     });
        // dd("monthly");
        $data = ReturnRemarks::with(
            [
                'ipcrSemestral2',
                'userEmployee',
                'ipcrMonthlyAccomplishment'
            ]
        )
            ->where('return_remarks.acted_by', $user_id)
            ->where('type', 'LIKE', '%accomplishment%')
            ->where('return_remarks.ipcr_monthly_accomplishment_id', '<>', '')
            ->when($request->search, function ($query, $searchItem) use ($request) {
                return $query->whereHas('userEmployee', function ($query) use ($request) {
                    $query->where('employee_name', 'like', '%' . $request->search . '%');
                });
            })
            ->orderBy('return_remarks.created_at', 'DESC')
            ->paginate(10)
            ->through(function ($item) {
                $suff_imm = "";
                $post_imm = "";

                $suff_next = "";
                $post_next = "";

                $imm = "";
                $next = "";
                $imm_emp = $item->ipcrSemestral2->immediate;
                if ($imm_emp) {
                    if ($imm_emp->suffix_name) {
                        $suff_imm = ', ' . $imm_emp->suffix_name;
                    }
                    if ($imm_emp->postfix_name) {
                        $post_imm = ', ' . $imm_emp->postfix_name;
                    }
                    $imm = $imm_emp->first_name . ' ' . $imm_emp->last_name . '' . $suff_imm . '' . $post_imm;
                }

                // dd($item->userEmployee->position_long_title);
                $nx = $item->ipcrSemestral2->next_higher1;
                if ($nx) {
                    if ($nx->suffix_name) {
                        $suff_next = ', ' . $nx->suffix_name;
                    }
                    if ($nx->postfix_name) {
                        $post_next = ', ' . $nx->postfix_name;
                    }
                    $next = $nx->first_name . ' ' . $nx->last_name . '' . $suff_next . '' . $post_next;
                }

                // dd($item);
                return [
                    "empl_id" => $item->ipcrSemestral2->userEmployee->empl_id,
                    "employee_name" => $item->ipcrSemestral2->userEmployee->employee_name,
                    "ipcr_semestral_id" => $item->ipcr_semestral_id,
                    "ipcr_monthly_accomplishment_id" => $item->ipcr_monthly_accomplishment_id,
                    "remarks" => $item->remarks,
                    "year" => $item->ipcrSemestral2->year,
                    "sem" => $item->sem,
                    "a_status" => $item->a_status,
                    "accomp_id" => $item->ipcr_monthly_accomplishment_id,
                    "month" => $item->ipcrMonthlyAccomplishment ? $item->ipcrMonthlyAccomplishment->month : '',
                    "position" => $item->userEmployee->position_long_title,
                    "office" => $item->ipcrSemestral2 ? $item->ipcrSemestral2->department : '',
                    "immediate" => $imm,
                    "next_higher" => $next,
                    "employment_type_descr" => $item->userEmployee ? $item->userEmployee->employment_type_descr : '',
                    "ipcr_monthly_accomplishments" => $item->ipcr_monthly_accomplishments,
                    "type" => $item->type,
                    "division" => $item->ipcrSemestral2 ? $item->ipcrSemestral2->division_name : '',
                    "date_acted" => $item->created_at
                ];
            });
        // dd($data);
        return inertia('Acted_Review/AccomplishmentsMonthly', [
            "filters" => $request->only(['search']),
            "data" => $data
        ]);
    }
    // _BackupOnly
    public function actedParticularsAccomplishmentsMonthly_BackupOnly(Request $request)
    {
        $user_id = auth()->user()->username;
        $imm =  NULL;
        $next = NULL;
        $dv = NULL;
        // dd('dv');
        $data = ReturnRemarks::select(
            'user_employees.empl_id',
            'user_employees.employee_name',
            'return_remarks.ipcr_semestral_id',
            'return_remarks.ipcr_monthly_accomplishment_id',
            'return_remarks.remarks',
            'ipcr__semestrals.year',
            'ipcr__semestrals.sem',
            'ipcr__semestrals.status_accomplishment AS a_status',
            'ipcr_monthly_accomplishments.id AS accomp_id',
            'ipcr_monthly_accomplishments.month',
            'user_employees.position_long_title AS position',
            'user_employees.division_code',
            // DB::raw($dv . ' as division'),
            'user_employees.department_code',
            'ipcr__semestrals.immediate_id AS immediate',
            'ipcr__semestrals.next_higher',
            'user_employees.employment_type_descr',
            'ipcr_monthly_accomplishments.id AS ipcr_monthly_accomplishments',
            'return_remarks.type',
        )
            ->where('return_remarks.acted_by', $user_id)
            ->where('type', 'LIKE', '%accomplishment%')
            ->where('return_remarks.ipcr_monthly_accomplishment_id', '<>', '')
            ->leftjoin('user_employees', 'user_employees.empl_id', 'return_remarks.employee_code')
            ->leftjoin('ipcr__semestrals', 'ipcr__semestrals.id', 'return_remarks.ipcr_semestral_id')
            ->leftjoin('ipcr_monthly_accomplishments', 'ipcr_monthly_accomplishments.id', 'return_remarks.ipcr_monthly_accomplishment_id')
            ->orderBy('return_remarks.created_at', 'DESC')
            ->paginate(10)
            ->through(function ($item) {
                $of = "";
                $div = "";
                $imm = "";
                $next = "";

                $imm_emp = UserEmployees::where('empl_id', $item->immediate)->first();
                if ($imm_emp) {
                    $imm = $imm_emp->first_name . ' ' . $imm_emp->last_name;
                }


                $nx = UserEmployees::where(
                    'empl_id',
                    $item->next_higher
                )->first();
                if ($nx) {
                    $next = $nx->first_name . ' ' . $nx->last_name;
                }

                if (!$item->division) {
                    // dd(': ' . $item->division);
                    if ($imm_emp) {
                        if ($imm_emp->division_code) {
                            $div = $imm_emp->division_code;
                            // dd("imm: " . $div);
                        } else {
                            if ($nx) {
                                if ($nx->division_code) {
                                    $div = $nx->division_code;
                                    // dd($div);
                                }
                            }
                        }
                    }
                }

                $dv = Division::where('division_code', $div)->first();
                if ($dv) {
                    $div = $dv->division_name1;
                }
                $esd = EmployeeSpecialDepartment::where('employee_code', $item->empl_id)->first();
                if ($esd) {
                    if ($esd->department_code) {
                        // $office = FFUNCCOD::where('department_code', $esd->department_code)->first();
                        $of = Office::where('department_code', $esd->department_code)->first();
                    } else {
                        // $office = FFUNCCOD::where('department_code', $item->department_code)->first();
                        $of = Office::where('department_code', $item->department_code)->first();
                    }

                    if ($esd->pgdh_cats) {

                        $pgHead = UserEmployees::where('empl_id', $esd->pgdh_cats)->first();
                    } else {

                        $pgHead = UserEmployees::where('empl_id', $of->empl_id)->first();
                    }
                } else {
                    // dd("officeee");
                    $of = Office::where('department_code', $item->department_code)->first();
                    // $dept = Office::where('department_code', $item->department_code)->first();
                    // $pgHead = UserEmployees::where('empl_id', $dept->empl_id)->first();
                }
                // $of = FFUNCCOD::where('department_code', $item->department_code)->first();
                if ($of) {
                    $off = $of->office;
                }
                // dd($item->department_code);
                // $item['office'] = $off;
                // $item['division'] = $div; // Set division based on some condition or calculation
                // $item['immediate'] = $imm;
                // $item['next_higher'] = $next;
                // dd($off);
                // return $item;
                return [
                    "empl_id" => $item->empl_id,
                    "employee_name" => $item->employee_name,
                    "ipcr_semestral_id" => $item->ipcr_semestral_id,
                    "ipcr_monthly_accomplishment_id" => $item->ipcr_monthly_accomplishment_id,
                    "remarks" => $item->remarks,
                    "year" => $item->year,
                    "sem" => $item->sem,
                    "a_status" => $item->a_status,
                    "accomp_id" => $item->accomp_id,
                    "month" => $item->month,
                    "position" => $item->position,
                    "office" => $off,
                    "immediate" => $imm,
                    "next_higher" => $next,
                    "employment_type_descr" => $item->employment_type_descr,
                    "ipcr_monthly_accomplishments" => $item->ipcr_monthly_accomplishments,
                    "type" => $item->type,
                    "division" => $div
                ];
            });

        // $data->getCollection()->transform(function ($item) {
        //     // Modify the item as needed
        //     $of = "";
        //     $div = "";
        //     $imm = "";
        //     $next = "";
        //     $dv = Division::where('division_code', $item->division_code)->first();
        //     if ($dv) {
        //         $div = $dv->division_name1;
        //     }
        //     $imm_emp = UserEmployees::where('empl_id', $item->immediate)->first();
        //     if ($imm_emp) {
        //         $imm = $imm_emp->first_name . ' ' . $imm_emp->last_name;
        //     }


        //     $nx = UserEmployees::where(
        //         'empl_id',
        //         $item->next_higher
        //     )->first();
        //     if ($nx) {
        //         $next = $nx->first_name . ' ' . $nx->last_name;
        //     }

        //     $of = FFUNCCOD::where(
        //         'department_code',
        //         $item->department_code
        //     )->first();
        //     if ($of) {
        //         $off = $of->FFUNCTION;
        //     }
        //     $item['office'] = $off;
        //     $item['division'] = $div; // Set division based on some condition or calculation
        //     $item['immediate'] = $imm;
        //     $item['next_higher'] = $next;

        //     return $item;
        // });
        dd($data);
        return inertia('Acted_Review/AccomplishmentsMonthly', [
            "data" => $data
        ]);
    }

    //BACKUP SEMESTRAL
    public function actedParticularsAccomplishmentsBackup(Request $request)
    {
        // dd('actedParticularsAccomplishments');
        // dd(md5('password1.'));
        $user_id = auth()->user()->username;
        $emp = UserEmployees::where('empl_id', auth()->user()->username)
            ->first();
        $dept = Office::where('department_code', $emp->department_code)->first();
        $pgHead = UserEmployees::where('empl_id', $dept->empl_id)->first();
        // dd($pgHead);
        $data = ReturnRemarks::with([
            'ipcrSemestral',
            'userEmployee',
            'ipcrMonthlyAccomplishment'
        ])
            ->select(
                'user_employees.empl_id',
                'user_employees.employee_name',
                'return_remarks.ipcr_semestral_id',
                'return_remarks.ipcr_monthly_accomplishment_id',
                'return_remarks.remarks',
                'ipcr__semestrals.year',
                'ipcr__semestrals.sem',
                'ipcr__semestrals.status_accomplishment AS a_status',
                'ipcr_monthly_accomplishments.id AS accomp_id',
                'ipcr_monthly_accomplishments.month',
                'user_employees.position_long_title AS position',
                'user_employees.division_code',
                // DB::raw($dv . ' as division'),
                'user_employees.department_code',
                'ipcr__semestrals.immediate_id AS immediate',
                'ipcr__semestrals.next_higher',
                'user_employees.employment_type_descr',
                'ipcr_monthly_accomplishments.id AS ipcr_monthly_accomplishments',
                'return_remarks.type',
            )
            ->where('return_remarks.acted_by', $user_id)
            ->where('type', 'LIKE', '%accomplishment%')
            ->where('return_remarks.ipcr_monthly_accomplishment_id', NULL)
            ->when($request->search, function ($query) use ($request) {
                $query->where('user_employees.employee_name', 'LIKE', '%' . $request->search . '%');
            })
            ->leftjoin('user_employees', 'user_employees.empl_id', 'return_remarks.employee_code')
            ->leftjoin('ipcr__semestrals', 'ipcr__semestrals.id', 'return_remarks.ipcr_semestral_id')
            ->leftjoin('ipcr_monthly_accomplishments', 'ipcr_monthly_accomplishments.id', 'return_remarks.ipcr_monthly_accomplishment_id')
            ->orderBy('return_remarks.created_at', 'DESC')
            ->paginate(10)
            ->through(function ($item) use ($pgHead) {
                $of = "";
                $div = "";
                $imm = "";
                $next = "";

                $imm_emp = UserEmployees::where('empl_id', $item->immediate)->first();
                if ($imm_emp) {
                    $imm = $imm_emp->first_name . ' ' . $imm_emp->last_name;
                }


                $nx = UserEmployees::where(
                    'empl_id',
                    $item->next_higher
                )->first();
                if ($nx) {
                    $next = $nx->first_name . ' ' . $nx->last_name;
                }

                if (!$item->division) {
                    // dd(': ' . $item->division);
                    if ($imm_emp) {
                        if ($imm_emp->division_code) {
                            $div = $imm_emp->division_code;
                            // dd("imm: " . $div);
                        } else {
                            if ($nx) {
                                if ($nx->division_code) {
                                    $div = $nx->division_code;
                                    // dd($div);
                                }
                            }
                        }
                    }
                }

                $dv = Division::where('division_code', $div)->first();
                if ($dv) {
                    $div = $dv->division_name1;
                }
                $esd = EmployeeSpecialDepartment::where('employee_code', $item->empl_id)->first();
                if ($esd) {
                    if ($esd->department_code) {
                        // $office = FFUNCCOD::where('department_code', $esd->department_code)->first();
                        $of = Office::where('department_code', $esd->department_code)->first();
                    } else {
                        // $office = FFUNCCOD::where('department_code', $item->department_code)->first();
                        $of = Office::where('department_code', $item->department_code)->first();
                    }

                    if ($esd->pgdh_cats) {

                        $pgHead = UserEmployees::where('empl_id', $esd->pgdh_cats)->first();
                    } else {

                        $pgHead = UserEmployees::where('empl_id', $of->empl_id)->first();
                    }
                } else {
                    $dept = FFUNCCOD::where('department_code', $item->department_code)->first();
                    $of = Office::where('department_code', $item->department_code)->first();
                    // dd("dept: " . $item->department_code);
                    // dd($of->empl_id);
                    $dept_id = "";
                    if ($dept->empl_id) {
                        // dd($dept->empl_id);
                        $dept_id = $dept->empl_id;
                    } else {
                        // dd($of->empl_id);
                        $dept_id = $of->empl_id;
                    }
                    $pgHead = UserEmployees::where('empl_id', $dept_id)->first();
                }
                // $of = FFUNCCOD::where('department_code', $item->department_code)->first();
                if ($of) {
                    $off = $of->office;
                }
                // $item['office'] = $off;
                // $item['division'] = $div; // Set division based on some condition or calculation
                // $item['immediate'] = $imm;
                // $item['next_higher'] = $next;
                // dd($off);
                // return $item;
                $suff = "";
                $post = "";
                $mn = "";
                // dd($pgHead);
                if (
                    $pgHead->suffix_name != ''
                ) {
                    $suff = ', ' . $pgHead->suffix_name;
                }
                if (
                    $pgHead->postfix_name != ''
                ) {
                    $post = ', ' . $pgHead->postfix_name;
                }
                if (
                    $pgHead->middle_name != ''
                ) {
                    $mn = $pgHead->middle_name[0] . '. ';
                }
                $pgHead = $pgHead->first_name . ' ' . $mn  . $pgHead->last_name . '' . $suff . '' . $post;
                return [
                    "empl_id" => $item->empl_id,
                    "employee_name" => $item->employee_name,
                    "ipcr_semestral_id" => $item->ipcr_semestral_id,
                    "ipcr_monthly_accomplishment_id" => $item->ipcr_monthly_accomplishment_id,
                    "remarks" => $item->remarks,
                    "year" => $item->year,
                    "sem" => $item->sem,
                    "a_status" => $item->a_status,
                    "accomp_id" => $item->accomp_id,
                    "month" => $item->month,
                    "position" => $item->position,
                    "office" => $off,
                    "immediate" => $imm,
                    "next_higher" => $next,
                    "employment_type_descr" => $item->employment_type_descr,
                    "ipcr_monthly_accomplishments" => $item->ipcr_monthly_accomplishments,
                    "type" => $item->type,
                    "division" => $div,
                    "pgHead" => $pgHead
                ];
            })
            ->withQueryString();

        $pgHeadn = $pgHead->first_name . ' ' . $pgHead->middle_name[0] . '. ' . $pgHead->last_name;
        if ($pgHead->suffix_name != NULL) {
            $pgHeadn = $pgHeadn . ', ' . $pgHead->suffix_name;
        }
        if ($pgHead->postfix_name != NULL) {
            $pgHeadn = $pgHeadn . ', ' . $pgHead->postfix_name;
        }
        return inertia('Acted_Review/Accomplishments', [
            "data" => $data,
            'pghead' => $pgHeadn,
            "filters" => $request->only(['search']),
        ]);
    }
}
