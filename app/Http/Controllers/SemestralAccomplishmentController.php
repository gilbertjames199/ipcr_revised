<?php

namespace App\Http\Controllers;

use App\Models\Daily_Accomplishment;
use App\Models\Division;
use App\Models\EmployeeSpecialDepartment;
use App\Models\FFUNCCOD;
use App\Models\IndividualFinalOutput;
use App\Models\Ipcr_Semestral;
use App\Models\IPCRTargets;
use App\Models\MonthlyAccomplishment;
use App\Models\Office;
use App\Models\ProbationaryTemporaryEmployees;
use App\Models\ReturnRemarks;
use App\Models\SemestralAccomplishmentRating;
use App\Models\TimeRange;
use App\Models\UserEmployees;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Collection;


class SemestralAccomplishmentController extends Controller
{
    protected $model, $ipcr_sem;
    public function __construct(MonthlyAccomplishment $model, Ipcr_Semestral $ipcr_sem)
    {
        $this->model = $model;
        $this->ipcr_sem = $ipcr_sem;
    }
    public function approve_monthly(Request $request)
    {
        // dd("sem");
        $us_emp = auth()->user()->load(['userEmployee', 'userEmployee.Office', 'userEmployee.Office.pgHead']);
        $empl_code = $us_emp->username;
        $accomp = $this->ipcr_sem
            ->with([
                'userEmployee', 'userEmployee.Office',
                'immediate', 'next_higher1'
            ])
            ->select(
                'ipcr__semestrals.id AS id',
                'ipcr__semestrals.status AS status',
                'ipcr__semestrals.status_accomplishment',
                'ipcr__semestrals.year AS year',
                'ipcr__semestrals.sem AS sem',
                'ipcr__semestrals.employee_code',
                'user_employees.employee_name',
                'user_employees.empl_id',
                'user_employees.position_long_title',
                'user_employees.department_code',
                'user_employees.division_code',
                'ipcr__semestrals.immediate_id',
                'ipcr__semestrals.next_higher',
                'user_employees.employment_type_descr',
                'ipcr__semestrals.pg_dept_head'
            )
            ->where(function ($query) use ($empl_code) {
                $query->where(function ($query) use ($empl_code) {
                    //IMMEDIATE*******************************************************
                    $query->where('ipcr__semestrals.immediate_id', $empl_code)
                        ->where('ipcr__semestrals.status_accomplishment', '0');
                })
                    ->orWhere(function ($query) use ($empl_code) {
                        //NEXT HIGHER***************************************************
                        $query->where('ipcr__semestrals.status_accomplishment',  '1')
                            ->where('ipcr__semestrals.next_higher', $empl_code);
                    });
            })
            ->when($request->search, function ($query) use ($request) {
                $query->where('user_employees.employee_name', 'LIKE', '%' . $request->search . '%');
            })
            ->join('user_employees', 'user_employees.empl_id', 'ipcr__semestrals.employee_code')
            ->paginate(10)
            ->through(function ($item) use ($request) {
                //office, division, immediate, next_higher, sem, year, idsemestral, period,
                // $of = "";
                $off = "";
                $imm = "";
                $next = "";
                $div = "";

                //SUFFIXES AND POSTFIXES
                $suff_imm = "";
                $post_imm = "";

                $suff_next = "";
                $post_next = "";


                $off = $item->department;

                //IMMEDIATE SUPERVISOR
                $imm_emp = $item->immediate;
                if ($imm_emp) {
                    if ($imm_emp->suffix_name) {
                        $suff_imm = ', ' . $imm_emp->suffix_name;
                    }
                    if ($imm_emp->postfix_name) {
                        $post_imm = ', ' . $imm_emp->postfix_name;
                    }
                    $imm = $imm_emp->first_name . ' ' . $imm_emp->last_name . '' . $suff_imm . '' . $post_imm;
                }

                //NEXT HIGHER SUPERVISOR
                $nx = $item->next_higher1;
                if ($nx) {
                    if ($nx->suffix_name) {
                        $suff_next = ', ' . $nx->suffix_name;
                    }
                    if ($nx->postfix_name) {
                        $post_next = ', ' . $nx->postfix_name;
                    }
                    $next = $nx->first_name . ' ' . $nx->last_name . '' . $suff_next . '' . $post_next;
                }


                $div = $item->division_name;
                $Average_Point_Core = 0;
                $Average_Point_Support = 0;
                // dd($item);
                // $pgHead = $item->pg_dept_head;

                return [
                    'id' => $item->id,
                    'status' => $item->status,
                    'year' => $item->year,
                    'sem' => $item->sem,
                    'employee_name' => $item->userEmployee ? $item->userEmployee->employee_name : '',
                    'empl_id' => $item->userEmployee ? $item->userEmployee->empl_id : '',
                    'position' => $item->userEmployee ? $item->userEmployee->position_long_title : '',
                    'office' => $item->department,
                    'division' => $div,
                    'immediate' => $imm,
                    'imm_id' => $item->immediate_id,
                    'next_higher' => $next,
                    'next_higher_id' => $item->next_higher,
                    'accomp_id' => $item->id_accomp,
                    // 'month' => $item->a_month,
                    // 'a_year' => $item->a_year,
                    'a_status' => $item->status_accomplishment,
                    'employment_type_descr' => $item->employment_type_descr,
                    'Average_Point_Core' => $Average_Point_Core,
                    'Average_Point_Support' => $Average_Point_Support,
                    'pgHead' => $item->pg_dept_head
                ];
            });
        // dd('semm');
        // ->paginate(10);




        // $my_data = $us_emp->userEmployee;
        // $is_pghead = $my_data->is_pghead;


        // $accomplished = $accomp_review;

        // if ($is_pghead == "1") {
        //     // $accomp_final = $this->ipcr_sem->select(
        //     //     'ipcr__semestrals.id AS id',
        //     //     'ipcr__semestrals.status AS status',
        //     //     'ipcr__semestrals.status_accomplishment',
        //     //     'ipcr__semestrals.year AS year',
        //     //     'ipcr__semestrals.sem AS sem',
        //     //     'user_employees.employee_name',
        //     //     'user_employees.empl_id',
        //     //     'user_employees.position_long_title',
        //     //     'user_employees.department_code',
        //     //     'user_employees.division_code',
        //     //     'ipcr__semestrals.immediate_id',
        //     //     'ipcr__semestrals.next_higher',
        //     //     'user_employees.employment_type_descr',
        //     // )
        //     //     ->where('ipcr__semestrals.status_accomplishment', '=', '2')
        //     //     ->where('user_employees.department_code', auth()->user()->department_code)
        //     //     ->join('user_employees', 'user_employees.empl_id', 'ipcr__semestrals.employee_code')
        //     //     ->get()->map(function ($item) {
        //     //         //office, division, immediate, next_higher, sem, year, idsemestral, period,
        //     //         $of = "";
        //     //         $imm = "";
        //     //         $next = "";
        //     //         $div = "";
        //     //         $of = FFUNCCOD::where('department_code', $item->department_code)->first();
        //     //         if ($of) {
        //     //             $off = $of->FFUNCTION;
        //     //         }

        //     //         $imm_emp = UserEmployees::where('empl_id', $item->immediate_id)->first();
        //     //         if ($imm_emp) {
        //     //             $imm = $imm_emp->first_name . ' ' . $imm_emp->last_name;
        //     //         }

        //     //         $nx = UserEmployees::where('empl_id', $item->next_higher)->first();
        //     //         if ($nx) {
        //     //             $next = $nx->first_name . ' ' . $nx->last_name;
        //     //         }

        //     //         $dv = Division::where('division_code', $item->division_code)->first();
        //     //         if ($dv) {
        //     //             $div = $dv->division_name1;
        //     //         }

        //     //         return [
        //     //             'id' => $item->id,
        //     //             'status' => $item->status,
        //     //             'year' => $item->year,
        //     //             'sem' => $item->sem,
        //     //             'employee_name' => $item->employee_name,
        //     //             'empl_id' => $item->empl_id,
        //     //             'position' => $item->position_long_title,
        //     //             'office' => $off,
        //     //             'division' => $div,
        //     //             'immediate' => $imm,
        //     //             'next_higher' => $next,
        //     //             'accomp_id' => $item->id_accomp,
        //     //             'month' => $item->a_month,
        //     //             'a_year' => $item->a_year,
        //     //             'a_status' => $item->status_accomplishment,
        //     //             'employment_type_descr' => $item->employment_type_descr,
        //     //         ];
        //     //     });
        //     $accomp_final = $this->ipcr_sem->select(
        //         'ipcr__semestrals.id AS id',
        //         'ipcr__semestrals.status AS status',
        //         'ipcr__semestrals.status_accomplishment',
        //         'ipcr__semestrals.year AS year',
        //         'ipcr__semestrals.sem AS sem',
        //         'user_employees.employee_name',
        //         'user_employees.empl_id',
        //         'user_employees.position_long_title',
        //         'user_employees.department_code',
        //         'user_employees.division_code',
        //         'ipcr__semestrals.immediate_id',
        //         'ipcr__semestrals.next_higher',
        //         'user_employees.employment_type_descr',
        //     )->where('ipcr__semestrals.status_accomplishment', '>', '0')
        //         ->where('user_employees.department_code', $my_data->department_code)
        //         ->join('user_employees', 'user_employees.empl_id', 'ipcr__semestrals.employee_code')
        //         ->get()->map(function ($item) {
        //             //office, division, immediate, next_higher, sem, year, idsemestral, period,
        //             $of = "";
        //             $imm = "";
        //             $next = "";
        //             $div = "";
        //             $of = FFUNCCOD::where('department_code', $item->department_code)->first();
        //             if ($of) {
        //                 $off = $of->FFUNCTION;
        //             }

        //             $imm_emp = UserEmployees::where('empl_id', $item->immediate_id)->first();
        //             if ($imm_emp) {
        //                 $imm = $imm_emp->first_name . ' ' . $imm_emp->last_name;
        //             }

        //             $nx = UserEmployees::where('empl_id', $item->next_higher)->first();
        //             if ($nx) {
        //                 $next = $nx->first_name . ' ' . $nx->last_name;
        //             }

        //             $dv = Division::where('division_code', $item->division_code)->first();
        //             if ($dv) {
        //                 $div = $dv->division_name1;
        //             }

        //             return [
        //                 'id' => $item->id,
        //                 'status' => $item->status,
        //                 'year' => $item->year,
        //                 'sem' => $item->sem,
        //                 'employee_name' => $item->employee_name,
        //                 'empl_id' => $item->empl_id,
        //                 'position' => $item->position_long_title,
        //                 'office' => $off,
        //                 'division' => $div,
        //                 'immediate' => $imm,
        //                 'next_higher' => $next,
        //                 'accomp_id' => $item->id_accomp,
        //                 'month' => $item->a_month,
        //                 'a_year' => $item->a_year,
        //                 'a_status' => $item->status_accomplishment,
        //                 'employment_type_descr' => $item->employment_type_descr,
        //             ];
        //         });
        //     // dd($accomp_final);
        //     // ->join('ipcr_monthly_accomplishments', 'ipcr_monthly_accomplishments.ipcr_semestral_id', 'ipcr__semestrals.id')

        //     // dd(auth()->user()->department_code);
        //     $accomplished = $accomplished->concat($accomp_final)->unique('id');
        // }
        // Paginate the merged collection
        // $perPage = 10; // Set the number of items per page here
        // $page = request()->get('page', 1); // Get the current page number from the request

        // $accomplishments = new LengthAwarePaginator(
        //     $accomplished->forPage($page, $perPage),
        //     $accomplished->count(),
        //     $perPage,
        //     $page,
        //     ['path' => request()->url()] // Use the current URL as the path
        // );

        // $emp = UserEmployees::where('empl_id', auth()->user()->username)
        //     ->first();
        // $dept = $us_emp->userEmployee->Office;
        // Office::where('department_code', $emp->department_code)->first();
        // dd($dept);
        $pgHead = $us_emp->userEmployee->Office->pgHead;
        $pgHead = $pgHead->first_name . ' ' . $pgHead->middle_name[0] . '. ' . $pgHead->last_name;
        // dd("accomplishment");
        return inertia(
            'Semestral_Accomplishment/Approve',
            [
                'accomplishments' => $accomp,
                // "sem_data" => $sem_data,
                // "division" => $division,
                // "emp" => $emp,
                // "dept" => $dept,
                "pghead" => $pgHead,
                "filters" => $request->only(['search']),
            ]
        );
    }
    public function myfunc()
    {
        $accomp_final
            = $this->ipcr_sem->select(
                'ipcr__semestrals.id AS id',
                'ipcr__semestrals.status AS status',
                'ipcr__semestrals.status_accomplishment',
                'ipcr__semestrals.year AS year',
                'ipcr__semestrals.sem AS sem',
                'user_employees.employee_name',
                'user_employees.empl_id',
                'user_employees.position_long_title',
                'user_employees.department_code',
                'user_employees.division_code',
                'ipcr__semestrals.immediate_id',
                'ipcr__semestrals.next_higher',
                'user_employees.employment_type_descr'
            )->where('ipcr_monthly_accomplishments.status_accomplishment', '2')
            ->where('user_employees.department_code', auth()->user()->department_code)
            ->join('user_employees', 'user_employees.empl_id', 'ipcr__semestrals.employee_code')
            ->join('ipcr_monthly_accomplishments', 'ipcr_monthly_accomplishments.ipcr_semestral_id', 'ipcr__semestrals.id')
            ->distinct('ipcr_monthly_accomplishments.id')
            ->get()->map(function ($item) {
                //office, division, immediate, next_higher, sem, year, idsemestral, period,
                $of = "";
                $imm = "";
                $next = "";
                $div = "";
                $of = FFUNCCOD::where('department_code', $item->department_code)->first();
                if ($of) {
                    $off = $of->FFUNCTION;
                }

                $imm_emp = UserEmployees::where('empl_id', $item->immediate_id)->first();
                if ($imm_emp) {
                    $imm = $imm_emp->first_name . ' ' . $imm_emp->last_name;
                }

                $nx = UserEmployees::where('empl_id', $item->next_higher)->first();
                if ($nx) {
                    $next = $nx->first_name . ' ' . $nx->last_name;
                }

                $dv = Division::where('division_code', $item->division_code)->first();
                if ($dv) {
                    $div = $dv->division_name1;
                }

                return [
                    'id' => $item->id,
                    'status' => $item->status,
                    'year' => $item->year,
                    'sem' => $item->sem,
                    'employee_name' => $item->employee_name,
                    'empl_id' => $item->empl_id,
                    'position' => $item->position_long_title,
                    'office' => $off,
                    'division' => $div,
                    'immediate' => $imm,
                    'next_higher' => $next,
                    'accomp_id' => $item->id_accomp,
                    'month' => $item->a_month,
                    'a_year' => $item->a_year,
                    'a_status' => $item->status_accomplishment,
                    'employment_type_descr' => $item->employment_type_descr,
                ];
            });
    }
    public function specific_accomplishment(Request $request)
    {
        // dd('specific_accomplishment');
        $month = $request->month;
        $sel_month = $month;
        if ($month > 6) {
            $sel_month = $month - 6;
        }
        $ipcr_semestral_id = $request->ipcr_semestral_id;
        $accomp_id = $request->accomp_id;
        $empl_code = $request->empl_id;
        // dd('specific_accomplishment: ' . $accomp_id);
        // $accomp = IPCRTargets::select(
        //     'i_p_c_r_targets.ipcr_code',
        //     'i_p_c_r_targets.month_' . $month . ' AS month',
        //     'i_p_c_r_targets.quantity_sem',
        //     'i_p_c_r_targets.ipcr_type',
        //     'individual_final_outputs.individual_output'
        // )
        //     ->where('employee_code', $request->empl_id)
        //     ->where('ipcr_semester_id', $ipcr_semestral_id)
        //     ->distinct('i_p_c_r_targets.ipcr_code')
        //     ->join('individual_final_outputs', 'individual_final_outputs.ipcr_code', 'i_p_c_r_targets.ipcr_code')
        //     ->distinct('i_p_c_r_targets.ipcr_code')
        //     ->orderBy('individual_final_outputs.ipcr_code', 'ASC')
        //     ->get();
        $prescribed_period = '';
        $time_unit = '';
        $TimeRating = '';
        $accomp = IPCRTargets::select(
            'i_p_c_r_targets.ipcr_code',
            'i_p_c_r_targets.month_' . $sel_month . ' AS monthly_target',
            'i_p_c_r_targets.quantity_sem',
            'i_p_c_r_targets.ipcr_type',
            'individual_final_outputs.quantity_type',
            'individual_final_outputs.quality_error',
            'individual_final_outputs.time_range_code',
            'individual_final_outputs.time_based',
            'time_ranges.time_unit',
            'major_final_outputs.mfo_desc',
            'individual_final_outputs.success_indicator',
            DB::raw($accomp_id . ' AS id_accomp ', $accomp_id),
            'individual_final_outputs.individual_output',
            DB::raw($month . ' AS month', $month),
            DB::raw('(SELECT SUM(ipcr_daily_accomplishments.quantity) FROM ipcr_daily_accomplishments
                WHERE ipcr_daily_accomplishments.emp_code = ' . $empl_code . ' AND MONTH(ipcr_daily_accomplishments.date) = ' . $month . '
                AND ipcr_daily_accomplishments.idIPCR = i_p_c_r_targets.ipcr_code) as total_quantity'),
            DB::raw('(SELECT AVG(ipcr_daily_accomplishments.timeliness) FROM ipcr_daily_accomplishments
                WHERE ipcr_daily_accomplishments.emp_code = ' . $empl_code . ' AND MONTH(ipcr_daily_accomplishments.date) = ' . $month . '
                AND ipcr_daily_accomplishments.idIPCR = i_p_c_r_targets.ipcr_code) as ave_time'),
            DB::raw('(SELECT AVG(ipcr_daily_accomplishments.quality) FROM ipcr_daily_accomplishments
                WHERE ipcr_daily_accomplishments.emp_code = ' . $empl_code . ' AND MONTH(ipcr_daily_accomplishments.date) = ' . $month . '
                AND ipcr_daily_accomplishments.idIPCR = i_p_c_r_targets.ipcr_code) as total_quality_avg'),
            DB::raw('(SELECT SUM(ipcr_daily_accomplishments.quality) FROM ipcr_daily_accomplishments
                WHERE ipcr_daily_accomplishments.emp_code = ' . $empl_code . ' AND MONTH(ipcr_daily_accomplishments.date) = ' . $month . '
                AND ipcr_daily_accomplishments.idIPCR = i_p_c_r_targets.ipcr_code) as total_quality'),
            DB::raw("'$TimeRating' AS TimeRating"),
            DB::raw("'$prescribed_period' AS prescribed_period"),
            DB::raw("'$time_unit' AS time_unit"),

        )
            ->where('employee_code', $request->empl_id)
            ->where('ipcr_semester_id', $ipcr_semestral_id)
            ->distinct('i_p_c_r_targets.ipcr_code')
            ->join('individual_final_outputs', 'individual_final_outputs.ipcr_code', 'i_p_c_r_targets.ipcr_code')
            ->join('time_ranges', 'time_ranges.time_code', 'individual_final_outputs.time_range_code')
            ->join('major_final_outputs', 'major_final_outputs.id', 'individual_final_outputs.idmfo')
            ->distinct('i_p_c_r_targets.ipcr_code')
            ->distinct('individual_final_outputs.time_range_code')
            ->orderBy('individual_final_outputs.ipcr_code', 'ASC')
            ->get();
        foreach ($accomp as $key => $value) {
            if ($value->time_range_code > 0 && $value->time_range_code < 47) {
                if ($value->time_based == 1) {
                    $time_range5 = TimeRange::where('time_code', $value->time_range_code)->orderBY('rating', 'DESC')->get();
                    if ($value->Final_Average_Timeliness == null) {
                        $value->TimeRating = 0;
                        $value->time_unit = $time_range5[0]->time_unit;
                        $value->prescribed_period = $time_range5[0]->prescribed_period;
                    } else if ($value->Final_Average_Timeliness <= $time_range5[0]->equivalent_time_from) {
                        $value->TimeRating = 5;
                        $value->time_unit = $time_range5[0]->time_unit;
                        $value->prescribed_period = $time_range5[0]->prescribed_period;
                    } else if (
                        $value->Final_Average_Timeliness >= $time_range5[4]->equivalent_time_from
                    ) {
                        $value->TimeRating = 1;
                        $value->time_unit = $time_range5[4]->time_unit;
                        $value->prescribed_period = $time_range5[4]->prescribed_period;
                    } else if (
                        $value->Final_Average_Timeliness >= $time_range5[3]->equivalent_time_from
                    ) {
                        $value->TimeRating = 2;
                        $value->time_unit = $time_range5[3]->time_unit;
                        $value->prescribed_period = $time_range5[3]->prescribed_period;
                    } else if (
                        $value->Final_Average_Timeliness >= $time_range5[2]->equivalent_time_from
                    ) {
                        $value->TimeRating = 3;
                        $value->time_unit = $time_range5[2]->time_unit;
                        $value->prescribed_period = $time_range5[2]->prescribed_period;
                    } else if ($value->Final_Average_Timeliness >= $time_range5[1]->equivalent_time_from) {
                        $value->TimeRating = 4;
                        $value->time_unit = $time_range5[1]->time_unit;
                        $value->prescribed_period = $time_range5[1]->prescribed_period;
                    } else {
                        $value->TimeRating = 0;
                        $value->time_unit = "";
                        $value->prescribed_period = "";
                    }
                }
            }
        }
        // dd($accomp);
        return $accomp;
    }
    public function updateStatusAccompRev(Request $request, $status, $acc_id)
    {
        // dd($acc_id);
        // if ($status == "1") {
        //     dd($status);
        // } else {
        //     dd('else: ' . $status);
        // }
        // dd('updateStatusAccompRev');
        // dd('status: ' . $status . ' acc_id: ' . $acc_id);
        // dd($request->params['employee_code']);
        //1.) Save remarks
        //2.) Update status
        //FIND the ipcr
        // if ($status == "-2") {
        //     dd("-2");
        // }
        // dd($status . ' acc_id: ' . $acc_id);
        // dd($request);
        $data = Ipcr_Semestral::find($acc_id);
        $data->status_accomplishment = $status;
        $data->save();
        $type = "info";
        $msg = "Successfully reviewed semestral IPCR!";
        //SAVE REMARKS
        // dd($data);
        if ($status == "1") {
            $retrem = new ReturnRemarks();
            $retrem->type = "review semestral accomplishment";
            $retrem->remarks = $request->params['remarks'];
            $retrem->ipcr_semestral_id = $acc_id;
            $retrem->employee_code = $request->params['employee_code'];
            $retrem->acted_by = auth()->user()->username;
            $retrem->save();
        }
        if ($status == "2") {
            $type = "message";
            $msg = "Successfully approved semestral IPCR!";
            $retrem = new ReturnRemarks();
            $retrem->type = "approve semestral accomplishment";
            $retrem->remarks = $request->params['remarks'];
            $retrem->ipcr_semestral_id = $acc_id;
            $retrem->employee_code = $request->params['employee_code'];
            $retrem->acted_by = auth()->user()->username;
            $retrem->save();

            $emp  = UserEmployees::where('empl_id', $request->params['employee_code'])
                ->first();
            $semr = new SemestralAccomplishmentRating();
            $semr->cats_number = $request->params['employee_code'];
            $semr->first_name = $emp->first_name;
            $semr->last_name = $emp->last_name;
            $semr->middle_name = $emp->middle_name;
            $semr->year = $data->year;
            $semr->sem = $data->sem;
            $semr->ipcr_sem_id = $acc_id;
            $semr->ave_core = $request->params['Average_Point_Core'];
            $semr->ave_support = $request->params['Average_Point_Support'];
            $ave_core = floatval($semr->ave_core) * 0.7;
            $ave_support = floatval($semr->ave_support) * 0.3;
            $sum = $ave_core + $ave_support;
            $semr->numerical_rating =  number_format($sum, 2);;
            $semr->adjectival_rating = $this->setAdjectivalRating($semr->numerical_rating);
            $semr->remarks = "";
            $semr->save();
        }
        if ($status == "-2") {
            // dd($request);
            $type = "message";
            $msg = "Returned semestral IPCR!";
            $retrem = new ReturnRemarks();
            $retrem->type = "return semestral accomplishment";
            $retrem->remarks = $request->params['remarks'];
            $retrem->ipcr_semestral_id = $acc_id;
            $retrem->employee_code = $request->params['employee_code'];
            $retrem->acted_by = auth()->user()->username;
            $retrem->save();
        }
        return back()->with($type, $msg);
    }
    public function setAdjectivalRating($rating)
    {
        if ($rating >= 4.51) {
            return 'Outstanding';
        } elseif ($rating >= 3.51 && $rating <= 4.5) {
            return 'Very Satisfactory';
        } elseif ($rating >= 2.51 && $rating <= 3.5) {
            return 'Satisfactory';
        } elseif ($rating >= 1.51 && $rating <= 2.5) {
            return 'Unsatisfactory';
        } elseif ($rating <= 1.5) {
            return 'Poor';
        } else {
            return 'Unknown'; // Handle other cases as needed
        }
    }
    public function updateStatusAccomp(Request $request, $status, $acc_id)
    {
        // dd($request);
        // dd($request->params["employee_code"]);
        // dd('status: ' . $status . ' sem_id:' . $acc_id);
        $validator = Validator::make($request->params, [
            'remarks' => 'nullable|string',
            'employee_code' => 'required|string', // Adjust the validation rule as per your needs
        ]);

        // Check if the validation fails
        if ($validator->fails()) {
            // Handle validation errors here
            return response()->json(['errors' => $validator->errors()], 422); // Adjust the response as needed
        }
        $data = $this->model::findOrFail($acc_id);
        $data->update([
            'status' => $status,
        ]);
        $monthName = Carbon::create()->month($data->month)->format('F');

        // dd($data->ipcr_semestral_id);
        // $ipcr_sem_list = Ipcr_Semestral::where('id', $data->ipcr_semestral_id)->first();
        // dd($ipcr_sem_list);
        $msg = "Reviewed IPCR Accomplishment for the month of " . $monthName . " year " . $data->year . "!";
        $tp = "review accomplishment";
        $th = "info";
        if ($status == "3") {
            $msg = "Final approved IPCR Accomplishment for the month of " . $monthName . " year " . $data->year . "!";
            $tp = "final approve accomplishment";
            $th = "message";
        }
        if ($status == "2") {
            $msg = "Approved IPCR Accomplishment for the month of " . $monthName . " year " . $data->year . "!";
            $tp = "approve accomplishment";
            $th = "message";
        }
        if ($status == "-2") {
            $msg = "Returned IPCR Accomplishment for the month of " . $monthName . " year " . $data->year . "!";
            $tp = "return accomplishment";
            $th = "message";
        }
        $remarks = new ReturnRemarks();
        $remarks->type = $tp;
        $remarks->remarks = $request->params["remarks"];
        $remarks->ipcr_semestral_id = $data->ipcr_semestral_id;
        $remarks->ipcr_monthly_accomplishment_id = $data->id;
        $remarks->employee_code = $request->params["employee_code"];
        $remarks->save();
        //
        return redirect('/approve/accomplishments')
            ->with($th, $msg);
    }
    public function api_kobo()
    {
        $apiToken = env('4f9297d58684fb2784df4eee1c603d3e4f8fdc4e');
        // $baseUrl = 'https://kobo.humanitarianresponse.info/api/v1/';
        $baseUrl = 'https://eu.kobotoolbox.org/api/v2/';
        $client = new Client();

        // Example: Fetch a list of surveys
        $response = $client->get($baseUrl . 'surveys', [
            'headers' => [
                'Authorization' => 'Token ' . $apiToken,
            ],
        ]);

        $data = json_decode($response->getBody());

        // Process the retrieved data as needed

        return view($data);
    }

    public function getAccomplishmentValue(Request $request, $sem_id, $emp_code)
    {
        // dd($sem_id);
        $TimeRating = null;
        $data = IndividualFinalOutput::select(
            'individual_final_outputs.ipcr_code',
            'i_p_c_r_targets.id',
            'i_p_c_r_targets.ipcr_type',
            'i_p_c_r_targets.quantity_sem',
            'i_p_c_r_targets.ipcr_semester_id',
            'i_p_c_r_targets.year',
            'individual_final_outputs.individual_output',
            'individual_final_outputs.performance_measure',
            'individual_final_outputs.success_indicator',
            'individual_final_outputs.quantity_type',
            'individual_final_outputs.quality_error',
            'individual_final_outputs.time_range_code',
            'individual_final_outputs.time_based',
            'time_ranges.prescribed_period',
            'time_ranges.time_unit',
            'divisions.division_name1 AS division',
            'division_outputs.output AS div_output',
            'major_final_outputs.mfo_desc',
            'major_final_outputs.FFUNCCOD',
            'sub_mfos.submfo_description',
            'semestral_remarks.remarks',
            'semestral_remarks.id AS remarks_id',
            DB::raw("'$TimeRating' AS TimeRating"),
        )
            ->leftjoin('time_ranges', 'time_ranges.time_code', 'individual_final_outputs.time_range_code')
            ->leftjoin('division_outputs', 'division_outputs.id', 'individual_final_outputs.id_div_output')
            ->leftjoin('divisions', 'divisions.id', 'division_outputs.division_id')
            ->leftjoin('major_final_outputs', 'major_final_outputs.id', 'division_outputs.idmfo')
            ->leftjoin('sub_mfos', 'sub_mfos.id', 'individual_final_outputs.idsubmfo')
            ->leftjoin('i_p_c_r_targets', 'i_p_c_r_targets.ipcr_code', 'individual_final_outputs.ipcr_code')
            ->leftJoin('semestral_remarks', function ($join) use ($sem_id) {
                $join->on('i_p_c_r_targets.ipcr_code', '=', 'semestral_remarks.idIPCR')
                    ->where('semestral_remarks.idSemestral', '=', $sem_id)
                    ->where('i_p_c_r_targets.ipcr_semester_id', '=', $sem_id);
            })
            ->where('i_p_c_r_targets.employee_code', $emp_code)
            ->where('i_p_c_r_targets.ipcr_semester_id', $sem_id)
            ->distinct('time_ranges.prescribed_period')
            ->distinct('time_ranges.time_unit')
            ->orderBy('individual_final_outputs.ipcr_code')
            ->get()
            ->map(function ($item) use ($sem_id) {
                $result = DB::table('ipcr_daily_accomplishments as A')
                    ->select(
                        DB::raw('MONTH(A.date) as month'),
                        DB::raw('SUM(A.quantity) as quantity'),
                        DB::raw('SUM(A.quality) as quality'),
                        DB::raw('SUM(A.timeliness) as timeliness'),
                        DB::raw('COUNT(A.quality) AS quality_count'),
                        DB::raw('ROUND(SUM(A.quality) / COUNT(A.quality)) AS average_quality'),
                        DB::raw('ROUND(SUM(A.average_timeliness) / SUM(A.quantity)) AS average_time'),
                    )
                    ->where('sem_id', $sem_id)
                    ->where('idIPCR', $item->ipcr_code)
                    ->groupBy(DB::raw('MONTH(date)'))
                    ->orderBy(DB::raw('MONTH(date)'), 'ASC')
                    ->get();
                // dd($result);
                $data = TimeRange::where('time_code', $item->time_range_code)
                    ->get();

                return [
                    "TimeRange" => $data,
                    "result" => $result,
                    "ipcr_code" => $item->ipcr_code,
                    "id" => $item->id,
                    "ipcr_type" => $item->ipcr_type,
                    "ipcr_semester_id" => $item->ipcr_semester_id,
                    "year" => $item->year,
                    "quantity_sem" => $item->quantity_sem,
                    "individual_output" => $item->individual_output,
                    "performance_measure" => $item->performance_measure,
                    "success_indicator" => $item->success_indicator,
                    "quantity_type" => $item->quantity_type,
                    "quality_error" => $item->quality_error,
                    "time_range_code" => $item->time_range_code,
                    "time_based" => $item->time_based,
                    "prescribed_period" => $item->prescribed_period,
                    "time_unit" => $item->time_unit,
                    "division_name1 AS division" => $item->division,
                    "output AS div_output" => $item->div_output,
                    "mfo_desc" => $item->mfo_desc,
                    "FFUNCCOD" => $item->FFUNCOD,
                    "submfo_description" => $item->submfo_description,
                    "remarks" => $item->remarks,
                    "remarks_id" => $item->remarks_id,
                ];
            });
        // dd(count($data));
        // dd($data[1]['ipcr_code']);
        $total_core = 0;
        $total_support = 0;
        $count_core = 0;
        $count_support = 0;
        // dd($data->pluck('ipcr_type'));
        $core_arr = [];
        $support_arr = [];
        for ($i = 0; $i < count($data); $i++) {
            // dd($data[$i]);

            // dd(count($data[$i]['result']));

            $quantity_score = 0;
            $quality_score = 0;
            $time_rating = 0;
            $time_rating = 0;
            $ave_time = 0;
            $total_time = 0;
            $result_count = intval(count($data[$i]['result']));
            // dd($data[$i]);
            // dd($data[$i]['result']);
            $sum_quantity = $this->getSumQuantity($data[$i]['result']);
            $quality_score = 0;
            if ($result_count > 0) {
                //QUANTITY
                $quant_type = $data[$i]['quantity_type'];
                $quantity = $this->GetSumQuantity($data[$i]['result']);
                $target = $data[$i]['quantity_sem'];
                $quantity_score = $this->QuantityRate($quant_type, $quantity, $target);

                //QUALITY
                //Param1: quality error
                $quality_type = $data[$i]['quality_error'];
                //Param2: qualityType (qualityerror [ok], getSumQuality, countMonth)
                $sum_quality = $this->getSumQuality($data[$i]['result']);
                $quality_point = $this->QualityTypes($quality_type, $sum_quality, $result_count, $data[$i]['ipcr_code']);
                $quality_score = $this->QualityRate($quality_type, $quality_point, $data[$i]['ipcr_code']);

                //TIMELINESS
                $total_time = $this->totalTime($data[$i]['result']);
                $ave_time = $this->AveTime($total_time, $sum_quantity);
                $time_rating = $this->timeRatings($ave_time, $data[$i]['TimeRange'], $data[$i]['time_range_code']);

                // dd($data[$i]['ipcr_code']);
                // if ($data[$i]['ipcr_code'] == 2556) {
                // QUALITY DD
                // dd("sum quality: " . $sum_quality . " quality_type: " . $quality_type . " quality point: " . $quality_point .
                //     "quality_score: " . $quality_score . ' result_count: ' . $result_count);
                // OVERALL
                // dd('ipcr_code: ' . $data[$i]['ipcr_code'] . ' quantity: ' . $quantity_score . ' quality ' . $quality_score . ' timeliness: ' . $time_rating);
                // }
                // dd($time_rating);
            }

            $ave_score = floatval($quantity_score) + floatval($quality_score) + floatval($time_rating);
            $div = 0;
            if (intval($quantity_score) > 0) {
                $div = $div + 1;
            }
            if (intval($quality_score) > 0) {
                $div = $div + 1;
            }
            if (intval($time_rating) > 0) {
                $div = $div + 1;
            }
            if (intval($div) < 1) {
                $div = 1;
            }
            $ave_score = number_format(($ave_score / intval($div)), 2);
            // dd($ave_score);
            $typee = $data[$i]['ipcr_type'];
            if ($ave_score > 0) {
                if ($typee == 'Core Function') {
                    $total_core = $total_core + $ave_score;
                    // dd($total_core);
                    $count_core = $count_core + 1;
                    $value = ["ipcr_code" => $data[$i]['ipcr_code'], "ave" => $ave_score];
                    array_push($core_arr, $value);
                    // dd($typee);
                    // dd($data[$i]['ipcr_type'] . ' ' . $total_core);
                } else {
                    $total_support = $total_support + $ave_score;
                    $count_support = $count_support + 1;
                    $value = ["ipcr_code" => $data[$i]['ipcr_code'], "ave" => $ave_score];
                    array_push($support_arr, $value);
                    // dd($data[$i]['ipcr_type'] . ' ' . $total_support);
                }
            }


            // if ($i == -2) {

            //     $text =
            //         ' index: ' . $i . ' ' . PHP_EOL .
            //         ' IPCR: ' . $data[$i]['ipcr_code'] . '       ' .  PHP_EOL .
            //         ' time_rating: ' . $time_rating . '       ' .  PHP_EOL .
            //         ' ave_time: ' . $ave_time . '       ' .  PHP_EOL .
            //         ' total_time: ' . $total_time . '       ' .  PHP_EOL .
            //         ' result_count: ' . $result_count . '       ' .  PHP_EOL .
            //         ' sum: ' . $sum_quantity . '       ' .  PHP_EOL .
            //         ' ave_score: ' . $ave_score . '       ' .  PHP_EOL .
            //         ' IPCR: ' . $data[$i]['ipcr_code'] . '       ' .  PHP_EOL .
            //         ' quantity_rating: ' . $quantity_score . '       ' .  PHP_EOL .
            //         ' quality_score: ' . $quality_score . '       ' .  PHP_EOL .
            //         ' time_rating: ' . $time_rating . '       ' .  PHP_EOL .
            //         ' ave_score: ' . $ave_score . '       ' .  PHP_EOL .
            //         ' type: ' . $data[$i]['ipcr_type'];
            //     // dd($data[$i]['TimeRange']);
            //     // dd($data[$i]['result']);
            //     // dd($text);
            // }
        }
        if ($count_core < 1) {
            $count_core = 1;
        }
        if ($count_support < 1) {
            $count_support = 1;
        }
        // dd($count_core);
        $ave_core = $total_core / $count_core;
        $ave_support = $total_support / $count_support;
        // dd($total_support . ' count_support: ' . $count_support . ' ave_support: ' . $ave_support);
        // dd($total_core . ' count_core: ' . $count_core . ' ave_core: ' . $ave_core);
        $ave_core2 = number_format($ave_core, 2);
        $ave_support2 = number_format($ave_support, 2);
        $vall = [
            "average_core" => $ave_core2,
            "average_support" => $ave_support2,
            "core_val" => $core_arr,
            "support_val" => $support_arr
        ];
        // return inertia(
        //     "average_core"->$ave_core2,
        //     "average_support"->$ave_support2,
        //     "core_val"->$core_arr,
        //     "support_val"->$support_arr
        // );
        return $vall;
        // return $data;
    }
    public function QuantityRate($id, $quantity, $target)
    {
        // dd('id: ' . $id . ' quantity: ' . $quantity . ' target: ' . $target);
        $result = null;

        if ($id == 1) {
            $total = round(($quantity / $target) * 100);
            // dd($total);
            if ($total >= 130) {
                $result = "5";
            } elseif ($total <= 129 && $total >= 115) {
                $result = "4";
            } elseif ($total <= 114 && $total >= 90) {
                $result = "3";
            } elseif ($total <= 89 && $total >= 51) {
                $result = "2";
            } elseif ($total <= 50) {
                $result = "1";
            } else {
                $result = "0";
            }
        } elseif ($id == 2) {
            if ($quantity == $target) {
                $result = 5;
            } else {
                $result = 2;
            }
        }

        return $result;
    }
    public function GetSumQuantity($items)
    {
        // Convert the array of items to a Laravel Collection
        $result = Collection::make($items)->sum(function ($o) {
            return (int)$o->quantity;
        });

        return $result;
    }
    public function QualityRate($id, $total, $ipcr_code)
    {
        $result = null;

        if ($id == 1) {
            if ($total == 0) {
                $result = "5";
            } elseif ($total >= 0.01 && $total <= 2.99) {
                $result = "4";
            } elseif ($total >= 3 && $total <= 4.99) {
                $result = "3";
            } elseif ($total >= 5 && $total <= 6.99) {
                $result = "2";
            } elseif ($total >= 7) {
                $result = "1";
            } else {
                $result = "0";
            }
        } elseif ($id == 2) {
            if ($total >= 5) {
                $result = "5";
            } elseif ($total >= 4 && $total <= 4.99) {
                $result = "4";
            } elseif ($total >= 3 && $total <= 3.99) {
                $result = "3";
            } elseif ($total >= 2 && $total <= 2.99) {
                $result = "2";
            } elseif ($total >= 1 && $total <= 1.99) {
                $result = "1";
            } else {
                // if ($ipcr_code == 65) {
                //     dd('ipcr65 tptal: ' . $total);
                // }
                $result = "0";
            }
        } elseif ($id == 3) {
            $result = "0";
        } elseif ($id == 4) {
            if ($total >= 1) {
                $result = "2";
            } else {
                $result = "5";
            }
        }

        return $result;
    }
    public function QualityTypes($quality_type, $score, $length, $ipcr_code)
    {
        $result = 0;

        if ($quality_type == 1 || $quality_type == 3 || $quality_type == 4) {
            $result = $score;
        } elseif ($quality_type == 2) {
            if ($length == 0) {

                $result = 0;
            } else {
                // if ($ipcr_code == 65) {
                //     dd($score);
                // }
                $result = round($score / $length);
            }
        }
        return $result;
    }

    public function getSumQuality($items)
    {
        // dd($items);
        $result = Collection::make($items)->sum(function ($item) {
            return (float)$item->average_quality;
        });
        // dd($result);
        return $result;
    }

    public function timeRatings($ave_time, $ranges, $time_code)
    {
        $result = null;
        $eq = null;
        // dd($ranges);
        if ($time_code == 56) {
            $result = " ";
        } else {
            foreach ($ranges as $item) {
                if ($ave_time <= $item->equivalent_time_from && $item->rating == 5) {
                    $result = 5;
                    $eq = $item->equivalent_time_from;
                    break; // Exit loop since we found a match
                } elseif ($ave_time >= $item->equivalent_time_from && $ave_time <= $item->equivalent_time_to && $item->rating == 4) {
                    $result = 4;
                    $eq = $item->equivalent_time_from;
                    break; // Exit loop since we found a match
                } elseif ($ave_time == $item->equivalent_time_from && $item->rating == 3) {
                    $result = 3;
                    $eq = $item->equivalent_time_from;
                    break; // Exit loop since we found a match
                } elseif ($ave_time >= $item->equivalent_time_from && $ave_time <= $item->equivalent_time_to && $item->rating == 2) {
                    $result = 2;
                    $eq = $item->equivalent_time_from;
                    break; // Exit loop since we found a match
                } elseif ($ave_time >= $item->equivalent_time_from && $item->rating == 1) {
                    $result = 1;
                    $eq = $item->equivalent_time_from;
                    break; // Exit loop since we found a match
                } elseif ($ave_time == 0) {
                    $result = 0;
                    break; // Exit loop since we found a match
                }
            }
        }
        return $result;
    }
    public function totalTime($items)
    {
        // dd($items);
        // $result = Collection::make($items)->sum(function ($obj) {
        //     return $obj->timeliness ? $obj->timeliness * $obj->quantity : 0;
        //     // return $obj->timeliness ? $obj->timeliness : 0;
        // });
        $result = 0;
        for ($i = 0; $i < count($items); $i++) {
            // $res = floatval($items[$i]->average_time) * floatval($items[$i]->quantity);
            $res = floatval($items[$i]->average_time) ? floatval($items[$i]->average_time) * floatval($items[$i]->quantity) : 0;
            $result = floatval($result) + $res;
        }
        return $result;
    }
    public function AveTime($time, $totalQuantity)
    {
        $result = 0;
        // dd('time: ' . $time . ' totalQuantity: ' . $totalQuantity);
        if ($time == 0 && $totalQuantity == 0) {
            $result = 0;
        } else {
            $result = floatval($time) / floatval($totalQuantity);
            $result = number_format((float)$result, 0, '.', '');
        }

        return $result;
    }

    public function getAccomplishmentValueMonthly(Request $request, $month, $year, $emp_code, $sem_id)
    {
        // $emp_code = Auth()->user()->username;
        $month = Carbon::parse($month)->month;
        // dd($month);
        // $year = $year;
        $sem = 1;
        // dd($year);
        $months = $month;
        if ($month > 6) {
            $months = $month - 6;
            $sem = 2;
        }
        $TimeRating = $request->TimeRating;
        $prescribed_period = '';
        $time_unit = '';


        // $div = auth()->user()->division_code;
        // $division = [];
        // dd($div);
        // if ($div) {
        //     $division = Division::where('division_code', $div)
        //         ->first()->division_name1;
        // }
        // $office = FFUNCCOD::where('department_code', auth()->user()->department_code)->first();
        // $dept = Office::where('department_code', auth()->user()->department_code)->first();
        // $pgHead = UserEmployees::where('empl_id', $dept->empl_id)->first();
        // $pgHead = $pgHead->first_name . ' ' . $pgHead->middle_name[0] . ' ' . $pgHead->last_name;
        // $data = Daily_Accomplishment::select(
        //     'ipcr_daily_accomplishments.idIPCR',
        //     DB::raw('SUM(ipcr_daily_accomplishments.quantity) as TotalQuantity'),
        //     DB::raw('SUM(ipcr_daily_accomplishments.average_timeliness) as TotalTimeliness'),
        //     DB::raw('ROUND(SUM(ipcr_daily_accomplishments.average_timeliness) / SUM(ipcr_daily_accomplishments.quantity)) as Final_Average_Timeliness'),
        //     'individual_final_outputs.individual_output',
        //     'individual_final_outputs.success_indicator',
        //     'individual_final_outputs.quantity_type',
        //     'individual_final_outputs.quality_error',
        //     'individual_final_outputs.time_range_code',
        //     'individual_final_outputs.time_based',
        //     'major_final_outputs.mfo_desc',
        //     'monthly_remarks.remarks',
        //     'monthly_remarks.id AS remarks_id',
        //     'division_outputs.output',
        //     'i_p_c_r_targets.ipcr_type',
        //     'i_p_c_r_targets.ipcr_semester_id',
        //     'i_p_c_r_targets.semester',
        //     "i_p_c_r_targets.month_$months as month",
        //     'ipcr__semestrals.year',
        //     DB::raw('COUNT(ipcr_daily_accomplishments.quality) as NumberofQuality'),
        //     DB::raw('SUM(CASE WHEN ipcr_daily_accomplishments.quality IS NOT NULL AND ipcr_daily_accomplishments.quality != "" THEN ipcr_daily_accomplishments.quality ELSE 0 END) AS total_quality'),
        //     DB::raw('ROUND(CASE WHEN COUNT(ipcr_daily_accomplishments.quality) > 0 THEN SUM(CASE WHEN ipcr_daily_accomplishments.quality IS NOT NULL AND ipcr_daily_accomplishments.quality != "" THEN ipcr_daily_accomplishments.quality ELSE 0 END) / COUNT(ipcr_daily_accomplishments.quality) ELSE 0 END, 0) AS quality_average'),
        //     DB::raw("'$prescribed_period' AS prescribed_period"),
        //     DB::raw("'$time_unit' AS time_unit"),
        //     DB::raw("'$TimeRating' AS TimeRating"),
        // )
        //     ->join('individual_final_outputs', 'ipcr_daily_accomplishments.idIPCR', '=', 'individual_final_outputs.ipcr_code')
        //     ->join('major_final_outputs', 'individual_final_outputs.idmfo', '=', 'major_final_outputs.id')
        //     ->join('division_outputs', 'individual_final_outputs.id_div_output', '=', 'division_outputs.id')
        //     ->join(
        //         'i_p_c_r_targets',
        //         function ($join) use ($emp_code) {
        //             $join->on('ipcr_daily_accomplishments.idIPCR', '=', 'i_p_c_r_targets.ipcr_code')
        //                 ->where('ipcr_daily_accomplishments.emp_code', '=', $emp_code)
        //                 ->where('i_p_c_r_targets.employee_code', '=', $emp_code);
        //         }
        //     )
        //     ->join('ipcr__semestrals', 'i_p_c_r_targets.ipcr_semester_id', '=', 'ipcr__semestrals.id')
        //     ->leftJoin('monthly_remarks', function ($join) use ($month) {
        //         $join->on('ipcr_daily_accomplishments.idIPCR', '=', 'monthly_remarks.idIPCR')
        //             ->where('monthly_remarks.month', '=', $month)
        //             ->whereMonth('ipcr_daily_accomplishments.date', '=', $month);
        //     })->where('ipcr__semestrals.year', $year)
        //     ->where('i_p_c_r_targets.semester', $sem)
        //     ->where('emp_code', $emp_code)
        //     ->whereMonth('date', $month)
        //     ->whereYear('date', $year)
        //     ->groupBy('ipcr_daily_accomplishments.idIPCR')
        //     ->get();


        // foreach ($data as $key => $value) {
        //     if ($value->time_range_code > 0 && $value->time_range_code < 47) {
        //         if ($value->time_based == 1) {
        //             $time_range5 = TimeRange::where('time_code', $value->time_range_code)->orderBY('rating', 'DESC')->get();
        //             if ($value->Final_Average_Timeliness == null) {
        //                 // dd($value->Final_Average_Timeliness);
        //                 $value->TimeRating = 0;
        //                 $value->time_unit = "";
        //                 $value->prescribed_period = "";
        //             } else if ($value->Final_Average_Timeliness <= $time_range5[0]->equivalent_time_from) {
        //                 $value->TimeRating = 5;
        //                 $value->time_unit = $time_range5[0]->time_unit;
        //                 $value->prescribed_period = $time_range5[0]->prescribed_period;
        //             } else if (
        //                 $value->Final_Average_Timeliness >= $time_range5[4]->equivalent_time_from
        //             ) {
        //                 $value->TimeRating = 1;
        //                 $value->time_unit = $time_range5[4]->time_unit;
        //                 $value->prescribed_period = $time_range5[4]->prescribed_period;
        //             } else if (
        //                 $value->Final_Average_Timeliness >= $time_range5[3]->equivalent_time_from
        //             ) {
        //                 $value->TimeRating = 2;
        //                 $value->time_unit = $time_range5[3]->time_unit;
        //                 $value->prescribed_period = $time_range5[3]->prescribed_period;
        //             } else if (
        //                 $value->Final_Average_Timeliness >= $time_range5[2]->equivalent_time_from
        //             ) {
        //                 $value->TimeRating = 3;
        //                 $value->time_unit = $time_range5[2]->time_unit;
        //                 $value->prescribed_period = $time_range5[2]->prescribed_period;
        //             } else if ($value->Final_Average_Timeliness >= $time_range5[1]->equivalent_time_from) {
        //                 $value->TimeRating = 4;
        //                 $value->time_unit = $time_range5[1]->time_unit;
        //                 $value->prescribed_period = $time_range5[1]->prescribed_period;
        //             } else {
        //                 $value->TimeRating = 0;
        //                 $value->time_unit = "";
        //                 $value->prescribed_period = "";
        //             }
        //         }
        //     }
        // }
        // Ipcr_Semestral::where('employee_code',$emp_code)
        $data = Daily_Accomplishment::with([
            'individualFinalOutput',
            'ipcrTarget' => function ($query) use ($emp_code, $sem, $year, $sem_id) {
                $query->where('i_p_c_r_targets.employee_code', '=', $emp_code)
                    // ->where('semester', $semt)
                    ->where('i_p_c_r_targets.ipcr_semester_id', $sem_id);
            },
            'ipcr_Semestral.immediate.Division',
            'ipcr_Semestral.next_higher1.Division',
            'monthlyAccomplishment',
            'monthlyAccomplishment.returnRemarks'
        ])
            ->where('emp_code', $emp_code)
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->orderBy('idIPCR', 'ASC')
            ->get()
            ->groupBy('idIPCR')
            ->map(fn ($item, $key) => [
                "idIPCR" => $key,
                "TotalQuantity" => $item->sum('quantity'),
                "TotalTimeliness" => $item->sum('average_timeliness'),
                "Final_Average_Timeliness" =>
                number_format($item->sum('average_timeliness') / $item->sum('quantity'), 0),
                "individual_output" => $item[0]['individualFinalOutput'] ? $item[0]['individualFinalOutput']->individual_output : '',
                "success_indicator" => $item[0]['individualFinalOutput'] ? $item[0]['individualFinalOutput']->success_indicator : '',
                "quantity_type" => $item[0]['individualFinalOutput']->quantity_type,
                "quality_error" => $item[0]['individualFinalOutput']->quality_error,
                "time_range_code" => $item[0]['individualFinalOutput']->time_range_code,
                "time_based" => $item[0]['individualFinalOutput']->time_based,
                "mfo_desc" => $item[0]['individualFinalOutput']->majorFinalOutputs->mfo_desc,
                "remarks" => $item[0]['monthlyAccomplishment']->returnRemarks ? $item[0]['monthlyAccomplishment']->returnRemarks->remarks : '',
                "remarks_id" => $item[0]['monthlyAccomplishment']->returnRemarks ? $item[0]['monthlyAccomplishment']->returnRemarks->id : '',
                "output" => $item[0]['individualFinalOutput']->divisionOutput->output,
                "ipcr_type" => $item[0]['ipcrTarget'] ? $item[0]['ipcrTarget']->ipcr_type : "",
                "ipcr_semester_id" => $item[0]['ipcrTarget'] ? $item[0]['ipcrTarget']->ipcr_semester_id : '',
                "semester" => $item[0]['ipcrTarget'] ? $item[0]['ipcrTarget']->semester : '',
                "month" => $item[0]['ipcrTarget'] ? (($item[0]['ipcrTarget']["month_" . $months] > 0) ? $item[0]['ipcrTarget']["month_" . $months] : 0) : '',
                "year" => $year,
                "NumberofQuality" => $item->count(),
                // DB::raw('FORMAT(SUM(ipcr_daily_accomplishments.quality) / COUNT(ipcr_daily_accomplishments.date), 2) as total_quality'),
                "total_quality" => number_format($item->sum('quality') / $item->count(), 2),
                // ROUND(CASE WHEN COUNT(ipcr_daily_accomplishments.quality) > 0 THEN SUM(CASE WHEN ipcr_daily_accomplishments.quality IS NOT NULL AND ipcr_daily_accomplishments.quality != "" THEN ipcr_daily_accomplishments.quality ELSE 0 END) / COUNT(ipcr_daily_accomplishments.quality) ELSE 0 END, 0)
                "quality_average" => ($item->count() > 0) ? number_format($item->sum('quality') / $item->count(), 2) : 0,
                "timeRanges" => $item[0]['individualFinalOutput']->timeRanges,
                "prescribed_period" => $this->getTimeRatingAndUnit(
                    $item[0]['individualFinalOutput']->time_range_code,
                    $item[0]['individualFinalOutput']->time_based,
                    $item[0]['individualFinalOutput']->timeRanges,
                    // number_format($item->sum('timeliness') / $item->sum('quantity'), 0),
                    number_format($item->sum('average_timeliness') / $item->sum('quantity'), 0),
                    'pr'
                ),
                // getTimeRatingAndUnit($time_range_code, $time_based, $time_range, $Final_Average_Timeliness)
                "time_unit" => $this->getTimeRatingAndUnit(
                    $item[0]['individualFinalOutput']->time_range_code,
                    $item[0]['individualFinalOutput']->time_based,
                    $item[0]['individualFinalOutput']->timeRanges,
                    number_format($item->sum('average_timeliness') / $item->sum('quantity'), 0),
                    'tu'
                ),
                "TimeRating" => $this->getTimeRatingAndUnit(
                    $item[0]['individualFinalOutput']->time_range_code,
                    $item[0]['individualFinalOutput']->time_based,
                    $item[0]['individualFinalOutput']->timeRanges,
                    number_format($item->sum('average_timeliness') / $item->sum('quantity'), 0),
                    'tr'
                ),
                "monthly_accomp" => $item[0]['monthlyAccomplishment'],
                "sem_id" => $item[0]->sem_id,
                "imm" => $item[0]['ipcr_Semestral']->immediate,
                "next" => $item[0]['ipcr_Semestral']->next_higher1,
                'sem_data' => $item[0]['ipcr_Semestral']
            ])
            // ->dd()
            ->values();
        // dd($data);
        // dd($data->pluck('TimeRating'));
        $ave_core = $this->calculateAverageCoreMonthly($data);
        $ave_support = $this->calculateAverageSupportMonthly($data);
        $val = [
            "ave_core" => $ave_core,
            "ave_support" => $ave_support
        ];
        $dt = (object)$val;
        // dd($dt);
        return $dt;
    }

    public function monthNameToNumber(string $month): ?int
    {
        $months = [
            'January' => 1,
            'February' => 2,
            'March' => 3,
            'April' => 4,
            'May' => 5,
            'June' => 6,
            'July' => 7,
            'August' => 8,
            'September' => 9,
            'October' => 10,
            'November' => 11,
            'December' => 12,
        ];

        // $month = strtolower(trim($month));

        return $months[$month] ?? null;
    }
    private function getPGDH($pgHead)
    {
        $suff = "";
        $post = "";
        $mn = "";
        if (
            $pgHead->suffix_name != ''
        ) {
            $suff = ', ' . $pgHead->suffix_name;
        }
        if (
            $pgHead->postfix_name != ''
        ) {
            // dd('fsdfdsfsdf');
            $post = ', ' . $pgHead->postfix_name;
        }
        if (
            $pgHead->middle_name != ''
        ) {
            $mn = $pgHead->middle_name[0] . '. ';
        }
        $pgHead = $pgHead->first_name . ' ' . $mn  . $pgHead->last_name . '' . $suff . '' . $post;
        return $pgHead;
    }
    private function getOffice($us)
    {
        $office = "";
        $pgHead = "";
        $esd = $us->employeeSpecialDepartment;
        $office_main = $us->userEmployee->Office;
        $pgdh_main = $us->userEmployee->Office->pgHead;
        // dd($pgdh_main);
        // dd($esd);
        if ($esd) {
            $off = $esd->Office;
            $pg_esd = $esd->PGDH;
            if ($off) {
                $office = $off;
                // dd($office);
            } else {
                $office = $office_main;
            }

            if ($pg_esd) {
                $pgHead = $pg_esd;
                // dd($pg_esd);
            } else {
                $pgHead = $pgdh_main;
            }
            // dd($office);
        } else {
            $office = $office_main;
            $pgHead = $pgdh_main;
        }

        return [
            "office" => $office,
            "pgHead" => $pgHead
        ];
    }
    private function getTimeRatingAndUnit($time_range_code, $time_based, $time_range, $Final_Average_Timeliness, $ret)
    {
        // alert($Final_Average)
        $prescribed_period = 0;
        $time_unit = '';
        $TimeRating = '';
        // if ($time_range_code == '1') {
        //     dd($time_range);
        // }
        if ($time_range_code > 0 && $time_range_code < 47) {
            if ($time_based == 1) {
                $time_range5 = $time_range;
                // TimeRange::where('time_code', $time_range_code)->orderBY('rating', 'DESC')->get();
                // dd($time_range);
                if ($Final_Average_Timeliness == null) {
                    // dd($Final_Average_Timeliness);
                    $TimeRating = 0;
                    $time_unit = "";
                    $prescribed_period = "";
                } else if ($Final_Average_Timeliness <= $time_range5[0]->equivalent_time_from) {
                    $TimeRating = 5;
                    $time_unit = $time_range5[0]->time_unit;
                    $prescribed_period = $time_range5[0]->prescribed_period;
                } else if (
                    $Final_Average_Timeliness >= $time_range5[4]->equivalent_time_from
                ) {
                    $TimeRating = 1;
                    $time_unit = $time_range5[4]->time_unit;
                    $prescribed_period = $time_range5[4]->prescribed_period;
                } else if (
                    $Final_Average_Timeliness >= $time_range5[3]->equivalent_time_from
                ) {
                    $TimeRating = 2;
                    $time_unit = $time_range5[3]->time_unit;
                    $prescribed_period = $time_range5[3]->prescribed_period;
                } else if (
                    $Final_Average_Timeliness >= $time_range5[2]->equivalent_time_from
                ) {
                    $TimeRating = 3;
                    $time_unit = $time_range5[2]->time_unit;
                    $prescribed_period = $time_range5[2]->prescribed_period;
                } else if ($Final_Average_Timeliness >= $time_range5[1]->equivalent_time_from) {
                    $TimeRating = 4;
                    $time_unit = $time_range5[1]->time_unit;
                    $prescribed_period = $time_range5[1]->prescribed_period;
                } else {
                    $TimeRating = 0;
                    $time_unit = "";
                    $prescribed_period = "";
                }
            }
        }
        // return [
        //     'TimeRating' => $TimeRating,
        //     'time_unit' => $time_unit,
        //     'prescribed_period' => $prescribed_period,
        // ];
        if ($ret == 'pr') {
            return $prescribed_period;
        } else if ($ret == 'tu') {
            return $time_unit;
        } else if ($ret == 'tr') {
            return $TimeRating;
        }


        // if ($time_range_code > 0 && $time_range_code < 47) {
        //     if ($value->time_based == 1) {
        //         $time_range5 = TimeRange::where('time_code', $value->time_range_code)->orderBY('rating', 'DESC')->get();
        //         if ($value->Final_Average_Timeliness == null) {
        //             // dd($value->Final_Average_Timeliness);
        //             $value->TimeRating = 0;
        //             $value->time_unit = "";
        //             $value->prescribed_period = "";
        //         } else if ($value->Final_Average_Timeliness <= $time_range5[0]->equivalent_time_from) {
        //             $value->TimeRating = 5;
        //             $value->time_unit = $time_range5[0]->time_unit;
        //             $value->prescribed_period = $time_range5[0]->prescribed_period;
        //         } else if (
        //             $value->Final_Average_Timeliness >= $time_range5[4]->equivalent_time_from
        //         ) {
        //             $value->TimeRating = 1;
        //             $value->time_unit = $time_range5[4]->time_unit;
        //             $value->prescribed_period = $time_range5[4]->prescribed_period;
        //         } else if (
        //             $value->Final_Average_Timeliness >= $time_range5[3]->equivalent_time_from
        //         ) {
        //             $value->TimeRating = 2;
        //             $value->time_unit = $time_range5[3]->time_unit;
        //             $value->prescribed_period = $time_range5[3]->prescribed_period;
        //         } else if (
        //             $value->Final_Average_Timeliness >= $time_range5[2]->equivalent_time_from
        //         ) {
        //             $value->TimeRating = 3;
        //             $value->time_unit = $time_range5[2]->time_unit;
        //             $value->prescribed_period = $time_range5[2]->prescribed_period;
        //         } else if ($value->Final_Average_Timeliness >= $time_range5[1]->equivalent_time_from) {
        //             $value->TimeRating = 4;
        //             $value->time_unit = $time_range5[1]->time_unit;
        //             $value->prescribed_period = $time_range5[1]->prescribed_period;
        //         } else {
        //             $value->TimeRating = 0;
        //             $value->time_unit = "";
        //             $value->prescribed_period = "";
        //         }
        //     }
        // }
    }
    private function getDivision($div, $immh, $nxth)
    {
        if ($div) {
            $div = $div->division_name1;
        } else {
            if ($immh['Division'] != null) {
                $div = $immh['Division']->division_name1;
            } else {
                if ($nxth['Division'] != null) {
                    $div = $nxth['Division']->division_name1;
                }
            };
        }
        if ($div == null) {
            $div = "";
        }
        return $div;
    }
    public function calculateAverageCoreMonthly($data)
    {
        $sum = 0;
        $num_of_data = 0;
        $average = 0;
        $count_core = 0;
        $qn_rate = 0;
        // dd(count($data));
        // dd($data);
        // $arr = [];
        foreach ($data as $item) {
            // dd($item['ipcr_type']);
            // if (!$item) {
            //     dd($item);
            // }
            // dd($item);
            if ($item['ipcr_type'] === 'Core Function') {
                // dd($item);

                $count_core = $count_core + 1;
                $val = $this->averageRatingMonthly(($item['month'] === "0" || $item['month'] === null) ?
                        $this->quantityRateMonthly($item['quantity_type'], $item['TotalQuantity'], 1) :
                        $this->quantityRateMonthly($item['quantity_type'], $item['TotalQuantity'], $item['month']),
                    $this->qualityRateMonthly($item['quality_error'], $item['quality_average'], $item['total_quality']),
                    ($item['TimeRating'] == "") ? 0 : $item['TimeRating']
                );
                // if ($item['idIPCR'] == '68') {
                //     dd('id: ' . $item['quantity_type'] . ' quantity: ' . $item['TotalQuantity'] . ' target: ' . $item['month']);
                //     // dd('68');
                // }
                // $for_arr = [
                //     "ipcr_code" => $item['idIPCR'],
                //     "quantity" => ($item['month'] === "0" || $item['month'] === null) ?
                //         $this->quantityRateMonthly($item['quantity_type'], $item['TotalQuantity'], 1) :
                //         $this->quantityRateMonthly($item['quantity_type'], $item['TotalQuantity'], $item['month']),
                //     "quality" => $this->qualityRateMonthly($item['quality_error'], $item['quality_average'], $item['total_quality']),
                //     "timeratings" => ($item['TimeRating'] == "") ? 0 : $item['TimeRating'],
                //     "score" => $val,
                // ];
                // array_push($arr, $for_arr);
                // $this->qualityRateMonthly($item['quality_error'], $item['quality_average']),

                // if ($num_of_data == 6) {
                //     // dd($item->idIPCR);
                //     $quant = ($item->month === "0" || $item->month === null) ?
                //         $this->quantityRateMonthly($item->quantity_type, $item->TotalQuantity, 1) :
                //         $this->quantityRateMonthly($item->quantity_type, $item->TotalQuantity, $item->month);
                //     $qual = $this->qualityRateMonthly($item->quality_error, $item->quality_average);
                //     $time = ($item->TimeRating == "") ? 0 : $item->TimeRating;

                //     dd("IPCR COde: " . $item->idIPCR . " quantitity: " . $quant . " quality: " . $qual . " timeliness: " . $time . " rating: " . $val);
                // }
                $qn_rate = $item['TotalQuantity'];

                $num_of_data += 1;
                $sum += (float)$val;
                // dd('time rating: ' . $item->TimeRating);
                // dd($this->qualityRateMonthly($item->quality_error, $item->quality_average));

            }
        }
        // dd(
        //     "quality rate monthly: " .
        //         $this->qualityRateMonthly($item->quality_error, $item->quality_average),
        // );
        // dd($arr);
        if ($num_of_data < 1) {
            $num_of_data = 1;
        }
        $average = $sum / $num_of_data;

        // dd($qn_rate);
        return number_format($average, 2);
        // return response()->json(['average' => number_format($average, 2)]);
    }
    public function calculateAverageSupportMonthly($data)
    {
        $sum = 0;
        $num_of_data = 0;
        $average = 0;
        $count_core = 0;
        $qn_rate = 0;
        // dd(count($data));
        // dd($data);
        $arr = [];
        foreach ($data as $item) {
            if ($item['ipcr_type'] === 'Support Function') {
                $count_core = $count_core + 1;
                $val = $this->averageRatingMonthly(($item['month'] === "0" || $item['month'] === null) ?
                        $this->quantityRateMonthly($item['quantity_type'], $item['TotalQuantity'], 1) :
                        $this->quantityRateMonthly($item['quantity_type'], $item['TotalQuantity'], $item['month']),
                    $this->qualityRateMonthly($item['quality_error'], $item['quality_average'], $item['total_quality']),
                    ($item['TimeRating'] == "") ? 0 : $item['TimeRating']
                );
                $qn_rate = $item['TotalQuantity'];

                $num_of_data += 1;
                $sum += (float)$val;
            }
        }

        if ($num_of_data < 1) {
            $num_of_data = 1;
        }
        $average = $sum / $num_of_data;

        return number_format($average, 2);
    }
    private function averageRatingMonthly($quantityRatings, $qualityRatings, $timeRatings)
    {
        $ratings = [floatval($quantityRatings), floatval($qualityRatings), floatval($timeRatings)];

        $nonZeroRatings = array_filter($ratings, function ($rating) {
            return $rating !== 0;
        });
        // dd($nonZeroRatings);
        $count = 0;
        if (floatVal($quantityRatings > 0)) {
            $count = $count + 1;
        }
        if (floatVal($qualityRatings > 0)) {
            $count = $count + 1;
        }
        if (floatVal($timeRatings > 0)) {
            $count = $count + 1;
        }
        if (count($nonZeroRatings) === 0) {
            return 0; // or any default value when all ratings are zero
        }
        // array_sum($nonZeroRatings) / count($nonZeroRatings);
        $average = array_sum($nonZeroRatings) / $count;

        // Assuming there's a method called format_number_conv
        return round($average, 2);
    }
    public function quantityRateMonthly($id, $quantity, $target)
    {
        $result = "";
        // dd($target);
        if ($id == 1) {
            if ($target == 0) {
                $result = 5;
            } else {
                $total = round(($quantity / $target) * 100);
                if ($total >= 130) {
                    $result = "5";
                } else if ($total <= 129 && $total >= 115) {
                    $result = "4";
                } else if ($total <= 114 && $total >= 90) {
                    $result = "3";
                } else if ($total <= 89 && $total >= 51) {
                    $result = "2";
                } else if ($total <= 50) {
                    $result = "1";
                }
            }
        } else if ($id == 2) {
            if ($target == 0) {
                $target = 1;
            }
            $total = round(($quantity / $target) * 100);
            if ($total == 100) {
                $result = "5";
            } else {
                $result = "2";
            }
        }

        return $result;
    }
    public function computeScore($value)
    {
        // dd($value);
        if ($value == 0) {
            $score = 0;
        } else if ($value >= 0.01 && $value <= 1) {
            $score = 1;
        } else if ($value >= 1.01 && $value <= 2) {
            $score = 2;
        } else if ($value >= 2.01 && $value <= 3) {
            $score = 3;
        } else if ($value >= 3.01 && $value <= 4) {
            $score = 4;
        } else if ($value >= 4.01 && $value <= 5) {
            $score = 5;
        } else if ($value >= 5.01 && $value <= 6) {
            $score = 6;
        } else if ($value >= 6.01 && $value <= 7) {
            $score = 7;
        } else if ($value >= 7.01 && $value <= 8) {
            $score = 8;
        } else if ($value >= 8.01 && $value <= 9) {
            $score = 9;
        } else if ($value >= 9.01 && $value <= 10) {
            $score = 10;
        } else if ($value >= 10.01 && $value <= 11) {
            $score = 11;
        } else if ($value >= 11.01 && $value <= 12) {
            $score = 12;
        } else if ($value >= 12.01 && $value <= 13) {
            $score = 13;
        } else if ($value >= 13.01 && $value <= 14) {
            $score = 14;
        } else if ($value >= 14.01 && $value <= 15) {
            $score = 15;
        }
        return $score;
    }
    public function qualityRateMonthly($id, $total, $total_quality)
    {
        $result = "";

        if ($id == 1) {
            $total = $this->computeScore($total_quality);
            if ($total == 0) {
                $result = "5";
            } else if ($total >= 0.01 && $total <= 2.99) {
                $result = "4";
            } else if ($total >= 3 && $total <= 4.99) {
                $result = "3";
            } else if ($total >= 5 && $total <= 6.99) {
                $result = "2";
            } else if ($total >= 7) {
                $result = "1";
            }
        } else if ($id == 2) {
            if ($total == 5) {
                $result = "5";
            } else if ($total >= 4 && $total <= 4.99) {
                $result = "4";
            } else if ($total >= 3 && $total <= 3.99) {
                $result = "3";
            } else if ($total >= 2 && $total <= 2.99) {
                $result = "2";
            } else if ($total >= 1 && $total <= 1.99) {
                $result = "1";
            } else {
                $result = "0";
            }
        } else if ($id == 3) {
            $result = "0";
        } else if ($id == 4) {
            if ($total >= 1) {
                $result = "2";
            } else {
                $result = "5";
            }
        }
        // dd($result);
        return $result;
    }

    //BACKUP --SEMESTRAL**************************************************************8
    public function approve_monthly_backup(Request $request)
    {
        // dd("sem");
        $empl_code = auth()->user()->username;
        $accomp_review = $this->ipcr_sem
            ->select(
                'ipcr__semestrals.id AS id',
                'ipcr__semestrals.status AS status',
                'ipcr__semestrals.status_accomplishment',
                'ipcr__semestrals.year AS year',
                'ipcr__semestrals.sem AS sem',
                'user_employees.employee_name',
                'user_employees.empl_id',
                'user_employees.position_long_title',
                'user_employees.department_code',
                'user_employees.division_code',
                'ipcr__semestrals.immediate_id',
                'ipcr__semestrals.next_higher',
                'user_employees.employment_type_descr'
            )
            ->where('ipcr__semestrals.status_accomplishment', '0')
            ->where('ipcr__semestrals.immediate_id', $empl_code)
            ->join('user_employees', 'user_employees.empl_id', 'ipcr__semestrals.employee_code')
            ->get()->map(function ($item) use ($request) {
                //office, division, immediate, next_higher, sem, year, idsemestral, period,
                $of = "";
                $off = "";
                $imm = "";
                $next = "";
                $div = "";

                //SUFFIXES AND POSTFIXES
                $suff_imm = "";
                $post_imm = "";

                $suff_next = "";
                $post_next = "";

                // dd($item->department_code);
                $esd = EmployeeSpecialDepartment::where('employee_code', $item->empl_id)->first();
                // dd($esd);
                if ($esd) {
                    // dd('naay esd');
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

                    $of = FFUNCCOD::where('department_code', $item->department_code)->first();
                    // dd($of);
                    $dept = Office::where('department_code', $item->department_code)->first();
                    $pgHead = UserEmployees::where('empl_id', $dept->empl_id)->first();
                }
                // $of = FFUNCCOD::where('department_code', $item->department_code)->first();
                if ($of) {
                    $off = $of->FFUNCTION;
                }

                $imm_emp = UserEmployees::where('empl_id', $item->immediate_id)->first();
                if ($imm_emp) {
                    if ($imm_emp->suffix_name) {
                        $suff_imm = ', ' . $imm_emp->suffix_name;
                    }
                    if ($imm_emp->postfix_name) {
                        $post_imm = ', ' . $imm_emp->postfix_name;
                    }
                    $imm = $imm_emp->first_name . ' ' . $imm_emp->last_name . '' . $suff_imm . '' . $post_imm;
                }

                $nx = UserEmployees::where('empl_id', $item->next_higher)->first();
                if ($nx) {
                    if ($nx->suffix_name) {
                        $suff_next = ', ' . $nx->suffix_name;
                    }
                    if ($nx->postfix_name) {
                        $post_next = ', ' . $nx->postfix_name;
                    }
                    $next = $nx->first_name . ' ' . $nx->last_name . '' . $suff_next . '' . $post_next;
                }

                $dv = Division::where('division_code', $item->division_code)->first();
                if ($dv) {
                    $div = $dv->division_name1;
                }
                $Average_Point_Core = 0;
                $Average_Point_Support = 0;
                $TimeRating = $request->TimeRating;
                $sem_id = $item->id;
                $emp_code = $item->empl_id;
                $data = IndividualFinalOutput::select(
                    'individual_final_outputs.ipcr_code',
                    'i_p_c_r_targets.id',
                    'i_p_c_r_targets.ipcr_type',
                    'i_p_c_r_targets.quantity_sem',
                    'i_p_c_r_targets.ipcr_semester_id',
                    'i_p_c_r_targets.year',
                    'individual_final_outputs.individual_output',
                    'individual_final_outputs.performance_measure',
                    'individual_final_outputs.success_indicator',
                    'individual_final_outputs.quantity_type',
                    'individual_final_outputs.quality_error',
                    'individual_final_outputs.time_range_code',
                    'individual_final_outputs.time_based',
                    'time_ranges.prescribed_period',
                    'time_ranges.time_unit',
                    'divisions.division_name1 AS division',
                    'division_outputs.output AS div_output',
                    'major_final_outputs.mfo_desc',
                    'major_final_outputs.FFUNCCOD',
                    'sub_mfos.submfo_description',
                    'semestral_remarks.remarks',
                    'semestral_remarks.id AS remarks_id',
                    DB::raw("'$TimeRating' AS TimeRating"),
                )
                    ->leftjoin('time_ranges', 'time_ranges.time_code', 'individual_final_outputs.time_range_code')
                    ->leftjoin('division_outputs', 'division_outputs.id', 'individual_final_outputs.id_div_output')
                    ->leftjoin('divisions', 'divisions.id', 'division_outputs.division_id')
                    ->leftjoin('major_final_outputs', 'major_final_outputs.id', 'division_outputs.idmfo')
                    ->leftjoin('sub_mfos', 'sub_mfos.id', 'individual_final_outputs.idsubmfo')
                    ->leftjoin('i_p_c_r_targets', 'i_p_c_r_targets.ipcr_code', 'individual_final_outputs.ipcr_code')
                    ->leftJoin('semestral_remarks', function ($join) use ($sem_id) {
                        $join->on('i_p_c_r_targets.ipcr_code', '=', 'semestral_remarks.idIPCR')
                            ->where('semestral_remarks.idSemestral', '=', $sem_id)
                            ->where('i_p_c_r_targets.ipcr_semester_id', '=', $sem_id);
                    })
                    ->where('i_p_c_r_targets.employee_code', $emp_code)
                    ->where('i_p_c_r_targets.ipcr_semester_id', $sem_id)
                    ->distinct('time_ranges.prescribed_period')
                    ->distinct('time_ranges.time_unit')
                    ->orderBy('individual_final_outputs.ipcr_code')
                    ->get()
                    ->map(function ($item) use ($sem_id) {
                        $result = DB::table('ipcr_daily_accomplishments as A')
                            ->select(
                                DB::raw('MONTH(A.date) as month'),
                                DB::raw('SUM(A.quantity) as quantity'),
                                DB::raw('SUM(A.quality) as quality'),
                                DB::raw('SUM(A.timeliness) as timeliness'),
                                DB::raw('COUNT(A.quality) AS quality_count'),
                                DB::raw('ROUND(SUM(A.quality) / COUNT(A.quality)) AS average_quality'),
                                DB::raw('ROUND(SUM(A.average_timeliness) / SUM(A.quantity)) AS average_time'),
                            )
                            ->where('sem_id', $sem_id)
                            ->where('idIPCR', $item->ipcr_code)
                            ->groupBy(DB::raw('MONTH(date)'))
                            ->orderBy(DB::raw('MONTH(date)'), 'ASC')
                            ->get();
                        // dd($result);
                        $data = TimeRange::where('time_code', $item->time_range_code)
                            ->get();
                        // dd($item->ipcr_code);
                        return [
                            "TimeRange" => $data,
                            "result" => $result,
                            "ipcr_code" => $item->ipcr_code,
                            "id" => $item->id,
                            "ipcr_type" => $item->ipcr_type,
                            "ipcr_semester_id" => $item->ipcr_semester_id,
                            "year" => $item->year,
                            "quantity_sem" => $item->quantity_sem,
                            "individual_output" => $item->individual_output,
                            "performance_measure" => $item->performance_measure,
                            "success_indicator" => $item->success_indicator,
                            "quantity_type" => $item->quantity_type,
                            "quality_error" => $item->quality_error,
                            "time_range_code" => $item->time_range_code,
                            "time_based" => $item->time_based,
                            "prescribed_period" => $item->prescribed_period,
                            "time_unit" => $item->time_unit,
                            "division_name1 AS division" => $item->division,
                            "output AS div_output" => $item->div_output,
                            "mfo_desc" => $item->mfo_desc,
                            "FFUNCCOD" => $item->FFUNCOD,
                            "submfo_description" => $item->submfo_description,
                            "remarks" => $item->remarks,
                            "remarks_id" => $item->remarks_id,
                        ];
                    });
                // dd($result);
                $data = TimeRange::where('time_code', $item->time_range_code)
                    ->get();
                $suff = "";
                $post = "";
                $mn = "";
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
                    'id' => $item->id,
                    'status' => $item->status,
                    'year' => $item->year,
                    'sem' => $item->sem,
                    'employee_name' => $item->employee_name,
                    'empl_id' => $item->empl_id,
                    'position' => $item->position_long_title,
                    'office' => $off,
                    'division' => $div,
                    'immediate' => $imm,
                    'next_higher' => $next,
                    'accomp_id' => $item->id_accomp,
                    'month' => $item->a_month,
                    'a_year' => $item->a_year,
                    'a_status' => $item->status_accomplishment,
                    'employment_type_descr' => $item->employment_type_descr,
                    'Average_Point_Core' => $Average_Point_Core,
                    'Average_Point_Support' => $Average_Point_Support,
                    'pgHead' => $pgHead
                ];
            });

        $accomp_approve = $this->ipcr_sem->select(
            'ipcr__semestrals.id AS id',
            'ipcr__semestrals.status AS status',
            'ipcr__semestrals.status_accomplishment',
            'ipcr__semestrals.year AS year',
            'ipcr__semestrals.sem AS sem',
            'user_employees.employee_name',
            'user_employees.empl_id',
            'user_employees.position_long_title',
            'user_employees.department_code',
            'user_employees.division_code',
            'ipcr__semestrals.immediate_id',
            'ipcr__semestrals.next_higher',
            'user_employees.employment_type_descr',
        )->where('ipcr__semestrals.status_accomplishment', '>', '0')
            ->where('ipcr__semestrals.next_higher', $empl_code)
            ->join('user_employees', 'user_employees.empl_id', 'ipcr__semestrals.employee_code')
            ->get()->map(function ($item) {
                //office, division, immediate, next_higher, sem, year, idsemestral, period,
                $of = "";
                $imm = "";
                $next = "";
                $div = "";
                //SUFFIXES AND POSTFIXES
                $suff_imm = "";
                $post_imm = "";

                $suff_next = "";
                $post_next = "";
                // dd($item->department_code);
                //EMPLOYEE SPECIAL DEPARTMENT
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
                    $of = FFUNCCOD::where('department_code', $item->department_code)->first();
                    $dept = Office::where('department_code', $item->department_code)->first();
                    $pgHead = UserEmployees::where('empl_id', $dept->empl_id)->first();
                }
                // $of = FFUNCCOD::where('department_code', $item->department_code)->first();
                // dd($of);
                if ($of) {
                    $off = $of->FFUNCTION;
                }
                // dd($of);
                $imm_emp = UserEmployees::where('empl_id', $item->immediate_id)->first();
                if ($imm_emp) {
                    if ($imm_emp->suffix_name) {
                        $suff_imm = ', ' . $imm_emp->suffix_name;
                    }
                    if ($imm_emp->postfix_name) {
                        $post_imm = ', ' . $imm_emp->postfix_name;
                    }
                    $imm = $imm_emp->first_name . ' ' . $imm_emp->last_name . '' . $suff_imm . '' . $post_imm;
                }

                $nx = UserEmployees::where('empl_id', $item->next_higher)->first();
                if ($nx) {
                    if ($nx->suffix_name) {
                        $suff_next = ', ' . $nx->suffix_name;
                    }
                    if ($nx->postfix_name) {
                        $post_next = ', ' . $nx->postfix_name;
                    }
                    $next = $nx->first_name . ' ' . $nx->last_name . '' . $suff_next . '' . $post_next;
                }


                $dv = Division::where('division_code', $item->division_code)->first();
                if ($dv) {
                    $div = $dv->division_name1;
                }
                $suff = "";
                $post = "";
                $mn = "";
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
                    'id' => $item->id,
                    'status' => $item->status,
                    'year' => $item->year,
                    'sem' => $item->sem,
                    'employee_name' => $item->employee_name,
                    'empl_id' => $item->empl_id,
                    'position' => $item->position_long_title,
                    'office' => $off,
                    'division' => $div,
                    'immediate' => $imm,
                    'next_higher' => $next,
                    'accomp_id' => $item->id_accomp,
                    'month' => $item->a_month,
                    'a_year' => $item->a_year,
                    'a_status' => $item->status_accomplishment,
                    'employment_type_descr' => $item->employment_type_descr,
                    'pgHead' => $pgHead
                ];
            });


        $my_data = UserEmployees::where('empl_id', auth()->user()->username)->first();
        $is_pghead = $my_data->is_pghead;


        $accomplished = $accomp_review->concat($accomp_approve);

        if (
            $is_pghead == "1"
        ) {
            // $accomp_final = $this->ipcr_sem->select(
            //     'ipcr__semestrals.id AS id',
            //     'ipcr__semestrals.status AS status',
            //     'ipcr__semestrals.status_accomplishment',
            //     'ipcr__semestrals.year AS year',
            //     'ipcr__semestrals.sem AS sem',
            //     'user_employees.employee_name',
            //     'user_employees.empl_id',
            //     'user_employees.position_long_title',
            //     'user_employees.department_code',
            //     'user_employees.division_code',
            //     'ipcr__semestrals.immediate_id',
            //     'ipcr__semestrals.next_higher',
            //     'user_employees.employment_type_descr',
            // )
            //     ->where('ipcr__semestrals.status_accomplishment', '=', '2')
            //     ->where('user_employees.department_code', auth()->user()->department_code)
            //     ->join('user_employees', 'user_employees.empl_id', 'ipcr__semestrals.employee_code')
            //     ->get()->map(function ($item) {
            //         //office, division, immediate, next_higher, sem, year, idsemestral, period,
            //         $of = "";
            //         $imm = "";
            //         $next = "";
            //         $div = "";
            //         $of = FFUNCCOD::where('department_code', $item->department_code)->first();
            //         if ($of) {
            //             $off = $of->FFUNCTION;
            //         }

            //         $imm_emp = UserEmployees::where('empl_id', $item->immediate_id)->first();
            //         if ($imm_emp) {
            //             $imm = $imm_emp->first_name . ' ' . $imm_emp->last_name;
            //         }

            //         $nx = UserEmployees::where('empl_id', $item->next_higher)->first();
            //         if ($nx) {
            //             $next = $nx->first_name . ' ' . $nx->last_name;
            //         }

            //         $dv = Division::where('division_code', $item->division_code)->first();
            //         if ($dv) {
            //             $div = $dv->division_name1;
            //         }

            //         return [
            //             'id' => $item->id,
            //             'status' => $item->status,
            //             'year' => $item->year,
            //             'sem' => $item->sem,
            //             'employee_name' => $item->employee_name,
            //             'empl_id' => $item->empl_id,
            //             'position' => $item->position_long_title,
            //             'office' => $off,
            //             'division' => $div,
            //             'immediate' => $imm,
            //             'next_higher' => $next,
            //             'accomp_id' => $item->id_accomp,
            //             'month' => $item->a_month,
            //             'a_year' => $item->a_year,
            //             'a_status' => $item->status_accomplishment,
            //             'employment_type_descr' => $item->employment_type_descr,
            //         ];
            //     });
            $accomp_final = $this->ipcr_sem->select(
                'ipcr__semestrals.id AS id',
                'ipcr__semestrals.status AS status',
                'ipcr__semestrals.status_accomplishment',
                'ipcr__semestrals.year AS year',
                'ipcr__semestrals.sem AS sem',
                'user_employees.employee_name',
                'user_employees.empl_id',
                'user_employees.position_long_title',
                'user_employees.department_code',
                'user_employees.division_code',
                'ipcr__semestrals.immediate_id',
                'ipcr__semestrals.next_higher',
                'user_employees.employment_type_descr',
            )->where('ipcr__semestrals.status_accomplishment', '>', '0')
                ->where('user_employees.department_code', $my_data->department_code)
                ->join('user_employees', 'user_employees.empl_id', 'ipcr__semestrals.employee_code')
                ->get()->map(function ($item) {
                    //office, division, immediate, next_higher, sem, year, idsemestral, period,
                    $of = "";
                    $imm = "";
                    $next = "";
                    $div = "";
                    $of = FFUNCCOD::where('department_code', $item->department_code)->first();
                    if ($of) {
                        $off = $of->FFUNCTION;
                    }

                    $imm_emp = UserEmployees::where('empl_id', $item->immediate_id)->first();
                    if ($imm_emp) {
                        $imm = $imm_emp->first_name . ' ' . $imm_emp->last_name;
                    }

                    $nx = UserEmployees::where('empl_id', $item->next_higher)->first();
                    if ($nx) {
                        $next = $nx->first_name . ' ' . $nx->last_name;
                    }

                    $dv = Division::where('division_code', $item->division_code)->first();
                    if ($dv) {
                        $div = $dv->division_name1;
                    }

                    return [
                        'id' => $item->id,
                        'status' => $item->status,
                        'year' => $item->year,
                        'sem' => $item->sem,
                        'employee_name' => $item->employee_name,
                        'empl_id' => $item->empl_id,
                        'position' => $item->position_long_title,
                        'office' => $off,
                        'division' => $div,
                        'immediate' => $imm,
                        'next_higher' => $next,
                        'accomp_id' => $item->id_accomp,
                        'month' => $item->a_month,
                        'a_year' => $item->a_year,
                        'a_status' => $item->status_accomplishment,
                        'employment_type_descr' => $item->employment_type_descr,
                    ];
                });
            // dd($accomp_final);
            // ->join('ipcr_monthly_accomplishments', 'ipcr_monthly_accomplishments.ipcr_semestral_id', 'ipcr__semestrals.id')

            // dd(auth()->user()->department_code);
            $accomplished = $accomplished->concat($accomp_final)->unique('id');
        }
        // Paginate the merged collection
        $perPage = 10; // Set the number of items per page here
        $page = request()->get('page', 1); // Get the current page number from the request

        $accomplishments = new LengthAwarePaginator(
            $accomplished->forPage($page, $perPage),
            $accomplished->count(),
            $perPage,
            $page,
            ['path' => request()->url()] // Use the current URL as the path
        );

        $emp = UserEmployees::where('empl_id', auth()->user()->username)
            ->first();
        $dept = Office::where('department_code', $emp->department_code)->first();
        // dd($dept);
        $pgHead = UserEmployees::where('empl_id', $dept->empl_id)->first();
        $pgHead = $pgHead->first_name . ' ' . $pgHead->middle_name[0] . '. ' . $pgHead->last_name;
        // dd("accomplishment");
        return inertia(
            'Semestral_Accomplishment/Approve',
            [
                'accomplishments' => $accomplishments,
                // "sem_data" => $sem_data,
                // "division" => $division,
                // "emp" => $emp,
                // "dept" => $dept,
                "pghead" => $pgHead,
                "filters" => $request->only(['search']),
            ]
        );
    }
}
