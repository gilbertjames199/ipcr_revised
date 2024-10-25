<?php

namespace App\Http\Controllers;

use App\Models\Division;
use App\Models\EmployeeSpecialDepartment;
use App\Models\FFUNCCOD;
use App\Models\Ipcr_Semestral;
use App\Models\IPCRTargets;
use App\Models\MonthlyAccomplishment;
use App\Models\MonthlyAccomplishmentRating;
use App\Models\Office;
use App\Models\ProbationaryTemporaryEmployees;
use App\Models\ReturnRemarks;
use App\Models\TimeRange;
use App\Models\UserEmployees;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class MonthlyAccomplishmentController extends Controller
{
    protected $model, $ipcr_sem;
    public function __construct(MonthlyAccomplishment $model, Ipcr_Semestral $ipcr_sem)
    {
        $this->model = $model;
        $this->ipcr_sem = $ipcr_sem;
    }
    public function approve_monthly(Request $request)
    {
        $empl_code = auth()->user()->username;

        $my_data = UserEmployees::where('empl_id', auth()->user()->username)->first();
        // dd(auth()->user());
        $is_pghead = $my_data->is_pghead;


        // $accomplished = $accomp_review->concat($accomp_approve);

        $accomplishments = MonthlyAccomplishment::with([
            'ipcrSemestral',
            'ipcrSemestral.userEmployee',
            'ipcrSemestral.immediate',
            'ipcrSemestral.next_higher1'
        ])
            ->whereHas('ipcrSemestral', function ($query) use ($empl_code) {

                $query->where(function ($query) use ($empl_code) {
                    $query->where('ipcr__semestrals.immediate_id', $empl_code)
                        ->where('ipcr_monthly_accomplishments.status', '=', '0');
                })
                    ->orWhere(function ($query) use ($empl_code) {
                        $query->where('ipcr__semestrals.next_higher', $empl_code)
                            ->where('ipcr_monthly_accomplishments.status', '>', '0')
                            ->where('ipcr_monthly_accomplishments.status', '<', '2');
                    });
            })
            // ->when($request->request)

            ->when($request->search,  function ($query, $searchItem) use ($request) {
                $query->whereHas('ipcrSemestral.userEmployee', function ($query) use ($request) {
                    $query->where('user_employees.employee_name', 'LIKE', '%' . $request->search . '%');
                });
            })
            ->paginate(10)
            ->through(function ($item) {
                $suff_imm = "";
                $post_imm = "";

                $suff_next = "";
                $post_next = "";
                $imm_emp = $item->ipcrSemestral->immediate;
                if ($imm_emp) {
                    if ($imm_emp->suffix_name) {
                        $suff_imm = ', ' . $imm_emp->suffix_name;
                    }
                    if ($imm_emp->postfix_name) {
                        $post_imm = ', ' . $imm_emp->postfix_name;
                    }
                    $imm = $imm_emp->first_name . ' ' . $imm_emp->last_name . '' . $suff_imm . '' . $post_imm;
                }


                $nx = $item->ipcrSemestral->next_higher1;
                if ($nx) {
                    if ($nx->suffix_name) {
                        $suff_next = ', ' . $nx->suffix_name;
                    }
                    if ($nx->postfix_name) {
                        $post_next = ', ' . $nx->postfix_name;
                    }
                    $next = $nx->first_name . ' ' . $nx->last_name . '' . $suff_next . '' . $post_next;
                }
                return [
                    //SEMESTRAL
                    'id' => $item->ipcrSemestral->id,
                    'status' => $item->ipcrSemestral->status,
                    'year' => $item->ipcrSemestral->year,
                    'sem' => $item->ipcrSemestral->sem,
                    'employee_name' => $item->ipcrSemestral->userEmployee->employee_name,
                    'empl_id' => $item->ipcrSemestral->userEmployee->empl_id,
                    'position' => $item->ipcrSemestral->userEmployee->position_long_title,
                    'office' => $item->ipcrSemestral->department,
                    'division' => $item->ipcrSemestral->division_name ? $item->ipcrSemestral->division_name : '',
                    'immediate' => $imm,
                    'next_higher' => $next,
                    //MONTHLY
                    'accomp_id' => $item->id,
                    'month' => $item->month,
                    'a_year' => $item->year,
                    'a_status' => $item->status,
                    'employment_type_descr' => $item->ipcrSemestral->employment_type,
                    'pgHead' => $item->ipcrSemestral->pg_dept_head
                ];
            });

        $emp = UserEmployees::where('empl_id', auth()->user()->username)
            ->first();

        $emp = auth()->user()->load([
            'userEmployee',
            'userEmployee.Office',
            'userEmployee.Office.pgHead'
        ]);
        // dd($emp);
        // $dept = "";
        $pgHead = "";
        if ($emp->userEmployee) {
            if ($emp->userEmployee->Office) {
                // $dept = $emp->userEmployee->Office->office;
                if ($emp->userEmployee->Office->pgHead) {
                    $pgHead = $emp->userEmployee->Office->pgHead;
                    $pgHead = $pgHead->first_name . ' ' . $pgHead->middle_name[0] . '. ' . $pgHead->last_name;
                }
            }
        }

        // dd('app monthly');
        return inertia(
            'IPCR/Review_Accomplishments/Index',
            [
                'accomplishments' => $accomplishments,
                "pghead" => $pgHead,
                "filters" => $request->only(['search']),
            ]
        );
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
    public function updateStatusAccomp(Request $request, $status, $acc_id)
    {
        // dd($request->params["core_support"]["ave_core"]);
        $emp = UserEmployees::where('empl_id', $request->params["employee_code"])->first();
        // dd($emp);
        // dd($request->params["employee_code"]);
        // dd($request);
        // $morat->ave_support
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
        $remarks->acted_by = auth()->user()->username;
        $remarks->save();

        // dd($status);
        ///Saving Monthly Rqatings
        if ($status == "2") {
            $ipsem = Ipcr_Semestral::where('id', $data->ipcr_semestral_id)->first();
            $core = $request->params["core_support"]["ave_core"];
            $support = $request->params["core_support"]["ave_support"];
            $num_rating = round((floatval($core) * .7) + (floatval($support) * .3), 2);
            $adj_rating = $this->getAdj($num_rating);
            // dd($num_rating . ' ' . $adj_rating);
            $morat = new MonthlyAccomplishmentRating();
            $morat->cats_number = $request->params["employee_code"];
            $morat->first_name = $emp->first_name;
            $morat->last_name = $emp->last_name;
            $morat->middle_name = $emp->middle_name;
            $morat->month = $data->month;
            $morat->numerical_rating = $num_rating;
            $morat->adjectival_rating = $adj_rating;
            $morat->year = $data->year;
            $morat->sem = $ipsem->sem;
            $morat->ipcr_sem_id = $data->ipcr_semestral_id;
            $morat->ave_core = $core;
            $morat->ave_support = $support;
            $morat->remarks = $request->params["remarks"];
            $morat->save();
        }

        return redirect('/approve/accomplishments')
            ->with($th, $msg);
    }
    public function updateStatusAccompReturn(Request $request, $status, $acc_id)
    {
        // dd($request->params["core_support"]["ave_core"]);
        $emp = UserEmployees::where('empl_id', $request->params["employee_code"])->first();
        // dd($emp);
        // dd($request->params["employee_code"]);

        // $morat->ave_support
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
        // $data = $this->model::findOrFail($acc_id);

        // $data->update([
        //     'status' => $status,
        // ]);
        $data = MonthlyAccomplishment::findOrFail($acc_id);
        $data->update([
            'status' => $status
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
        $by = auth()->user()->username;
        $remarks = new ReturnRemarks();
        $remarks->type = $tp;
        // ' (returned from acted by ' . $by . ')'
        $remarks->remarks = $request->params["remarks"];
        $remarks->ipcr_semestral_id = $data->ipcr_semestral_id;
        $remarks->ipcr_monthly_accomplishment_id = $data->id;
        $remarks->employee_code = $request->params["employee_code"];
        $remarks->acted_by = auth()->user()->username;
        $remarks->save();

        // dd($status);
        ///Saving Monthly Rqatings


        return redirect('/acted/particulars/accomp/lishments/monthly')
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
    public function getAdj($num)
    {
        $no = floatval($num);
        // $adj = "";
        if ($no >= 4.51) {
            return "Outstanding";
        } else if ($no >= 3.51) {
            return "Very Satisfactory";
        } else if ($no >= 2.51) {
            return "Satisfactory";
        } else if ($no >= 1.51) {
            return "Unsatisfactory";
        } else {
            return "Poor";
        }
        // return $adj;
    }

    //FOR REFERENCES ONLY
    public function approve_monthly_backup(Request $request)
    {
        $empl_code = auth()->user()->username;
        // dd($empl_code);
        $accomp_review = $this->ipcr_sem
            ->select(
                'ipcr__semestrals.id AS id',
                'ipcr__semestrals.status AS status',
                'ipcr__semestrals.year AS year',
                'ipcr__semestrals.sem AS sem',
                'ipcr__semestrals.department AS department',
                'ipcr__semestrals.pg_dept_head',
                'ipcr__semestrals.division_name',
                'user_employees.employee_name',
                'user_employees.empl_id',
                'user_employees.position_long_title',
                'user_employees.department_code',
                'user_employees.employment_type_descr',
                'user_employees.division_code',
                'ipcr__semestrals.immediate_id',
                'ipcr__semestrals.next_higher',
                'ipcr_monthly_accomplishments.id AS id_accomp',
                'ipcr_monthly_accomplishments.month AS a_month',
                'ipcr_monthly_accomplishments.year AS a_year',
                'ipcr_monthly_accomplishments.status AS a_status'
            )
            ->with(
                'userEmployee',
                'userEmployee.immediate',
                'userEmployee.next_higher'
            )
            ->where('ipcr_monthly_accomplishments.status', '0')
            ->where('ipcr__semestrals.immediate_id', $empl_code)
            ->join('user_employees', 'user_employees.empl_id', 'ipcr__semestrals.employee_code')
            ->join('ipcr_monthly_accomplishments', 'ipcr_monthly_accomplishments.ipcr_semestral_id', 'ipcr__semestrals.id')
            ->distinct('ipcr_monthly_accomplishments.id')
            ->get()->map(function ($item) {
                //office, division, immediate, next_higher, sem, year, idsemestral, period,
                // $of = "";
                $imm = "";
                $next = "";
                // $div = "";
                //SUFFIXES AND POSTFIXES
                $suff_imm = "";
                $post_imm = "";

                $suff_next = "";
                $post_next = "";

                //EMPLOYEE SPECIAL DEPARTMENTS
                // $esd = EmployeeSpecialDepartment::where('employee_code', $item->empl_id)->first();
                // if ($esd) {
                //     if ($esd->department_code) {
                //         // $office = FFUNCCOD::where('department_code', $esd->department_code)->first();
                //         $of = Office::where('department_code', $esd->department_code)->first();
                //     } else {
                //         // $office = FFUNCCOD::where('department_code', $item->department_code)->first();
                //         $of = Office::where('department_code', $item->department_code)->first();
                //     }

                //     if ($esd->pgdh_cats) {

                //         $pgHead = UserEmployees::where('empl_id', $esd->pgdh_cats)->first();
                //     } else {

                //         $pgHead = UserEmployees::where('empl_id', $of->empl_id)->first();
                //     }
                // } else {
                //     $of = FFUNCCOD::where('department_code', $item->department_code)->first();
                //     $dept = Office::where('department_code', $item->department_code)->first();
                //     $pgHead = UserEmployees::where('empl_id', $dept->empl_id)->first();
                // }
                // // $of = FFUNCCOD::where('department_code', $item->department_code)->first();
                // if ($of) {
                //     $off = $of->FFUNCTION;
                // }

                // dd($off);
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


                // $dv = Division::where('division_code', $item->division_code)->first();
                // if ($dv) {
                //     $div = $dv->division_name1;
                // }
                // $suff = "";
                // $post = "";
                // $mn = "";
                // if (
                //     $pgHead->suffix_name != ''
                // ) {
                //     $suff = ', ' . $pgHead->suffix_name;
                // }
                // if (
                //     $pgHead->postfix_name != ''
                // ) {
                //     $post = ', ' . $pgHead->postfix_name;
                // }
                // if (
                //     $pgHead->middle_name != ''
                // ) {
                //     $mn = $pgHead->middle_name[0] . '. ';
                // }
                // $pgHead = $pgHead->first_name . ' ' . $mn  . $pgHead->last_name . '' . $suff . '' . $post;
                return [
                    'id' => $item->id,
                    'status' => $item->status,
                    'year' => $item->year,
                    'sem' => $item->sem,
                    'employee_name' => $item->UserEmployee->employee_name,
                    'empl_id' => $item->empl_id,
                    'position' => $item->position_long_title,
                    'office' => $item->department,
                    'division' => $item->division_name,
                    'immediate' => $imm,
                    'next_higher' => $next,
                    'accomp_id' => $item->id_accomp,
                    'month' => $item->a_month,
                    'a_year' => $item->a_year,
                    'a_status' => $item->a_status,
                    'employment_type_descr' => $item->employment_type_descr,
                    'pgHead' => $item->pg_dept_head
                ];
            });
        // dd($accomp_review);
        // $accomp_approve = $this->ipcr_sem
        //     ->select(
        //         'ipcr__semestrals.id AS id',
        //         'ipcr__semestrals.status AS status',
        //         'ipcr__semestrals.year AS year',
        //         'ipcr__semestrals.sem AS sem',
        //         'ipcr__semestrals.department AS department',
        //         'ipcr__semestrals.pg_dept_head',
        //         'ipcr__semestrals.division_name',
        //         'user_employees.employee_name',
        //         'user_employees.empl_id',
        //         'user_employees.position_long_title',
        //         'user_employees.department_code',
        //         'user_employees.employment_type_descr',
        //         'user_employees.division_code',
        //         'ipcr__semestrals.immediate_id',
        //         'ipcr__semestrals.next_higher',
        //         'ipcr_monthly_accomplishments.id AS id_accomp',
        //         'ipcr_monthly_accomplishments.month AS a_month',
        //         'ipcr_monthly_accomplishments.year AS a_year',
        //         'ipcr_monthly_accomplishments.status AS a_status'
        //     )
        //     ->where('ipcr_monthly_accomplishments.status', '>', '0')
        //     ->where('ipcr__semestrals.next_higher', $empl_code)
        //     ->join('user_employees', 'user_employees.empl_id', 'ipcr__semestrals.employee_code')
        //     ->join('ipcr_monthly_accomplishments', 'ipcr_monthly_accomplishments.ipcr_semestral_id', 'ipcr__semestrals.id')
        //     ->distinct('ipcr_monthly_accomplishments.id')
        //     ->get()->map(function ($item) {
        //         // $of = "";
        //         $imm = "";
        //         $next = "";
        //         // $div = "";

        //         //SUFFIXES AND POSTFIXES
        //         $suff_imm = "";
        //         $post_imm = "";

        //         $suff_next = "";
        //         $post_next = "";

        //         //EMPLOYEE SPECIAL DEPARTMENTS
        //         // $esd = EmployeeSpecialDepartment::where('employee_code', $item->empl_id)->first();
        //         // if ($esd) {
        //         //     if ($esd->department_code) {
        //         //         // $office = FFUNCCOD::where('department_code', $esd->department_code)->first();
        //         //         $of = Office::where('department_code', $esd->department_code)->first();
        //         //     } else {
        //         //         // $office = FFUNCCOD::where('department_code', $item->department_code)->first();
        //         //         $of = Office::where('department_code', $item->department_code)->first();
        //         //     }

        //         //     if ($esd->pgdh_cats) {

        //         //         $pgHead = UserEmployees::where('empl_id', $esd->pgdh_cats)->first();
        //         //     } else {

        //         //         $pgHead = UserEmployees::where('empl_id', $of->empl_id)->first();
        //         //     }
        //         // } else {
        //         //     $of = FFUNCCOD::where('department_code', $item->department_code)->first();
        //         //     $dept = Office::where('department_code', $item->department_code)->first();
        //         //     $pgHead = UserEmployees::where('empl_id', $dept->empl_id)->first();
        //         // }
        //         // // $of = FFUNCCOD::where('department_code', $item->department_code)->first();
        //         // // dd($of);
        //         // if ($of) {
        //         //     $off = $of->office;
        //         // }



        //         // dd($off);
        //         $imm_emp = UserEmployees::where('empl_id', $item->immediate_id)->first();
        //         if ($imm_emp) {
        //             if ($imm_emp->suffix_name) {
        //                 $suff_imm = ', ' . $imm_emp->suffix_name;
        //             }
        //             if ($imm_emp->postfix_name) {
        //                 $post_imm = ', ' . $imm_emp->postfix_name;
        //             }
        //             $imm = $imm_emp->first_name . ' ' . $imm_emp->last_name . '' . $suff_imm . '' . $post_imm;
        //         }


        //         $nx = UserEmployees::where('empl_id', $item->next_higher)->first();
        //         if ($nx) {
        //             if ($nx->suffix_name) {
        //                 $suff_next = ', ' . $nx->suffix_name;
        //             }
        //             if ($nx->postfix_name) {
        //                 $post_next = ', ' . $nx->postfix_name;
        //             }
        //             $next = $nx->first_name . ' ' . $nx->last_name . '' . $suff_next . '' . $post_next;
        //         }


        //         // $dv = Division::where('division_code', $item->division_code)->first();
        //         // if ($dv) {
        //         //     $div = $dv->division_name1;
        //         // }


        //         return [
        //             'id' => $item->id,
        //             'status' => $item->status,
        //             'year' => $item->year,
        //             'sem' => $item->sem,
        //             'employee_name' => $item->employee_name,
        //             'empl_id' => $item->empl_id,
        //             'position' => $item->position_long_title,
        //             'office' => $item->department,
        //             'division' => $item->division_name,
        //             'immediate' => $imm,
        //             'next_higher' => $next,
        //             'accomp_id' => $item->id_accomp,
        //             'month' => $item->a_month,
        //             'a_year' => $item->a_year,
        //             'a_status' => $item->a_status,
        //             'employment_type_descr' => $item->employment_type_descr,
        //             'pgHead' => $item->pg_dept_head
        //         ];
        //     });
        // dd($accomp_approve);
        $my_data = UserEmployees::where('empl_id', auth()->user()->username)->first();
        // dd(auth()->user());
        $is_pghead = $my_data->is_pghead;


        // $accomplished = $accomp_review->concat($accomp_approve);

        // dd($accomplishments);
        // if ($is_pghead == "1") {
        //     $accomp_final = $this->ipcr_sem
        //         ->select(
        //             'ipcr__semestrals.id AS id',
        //             'ipcr__semestrals.status AS status',
        //             'ipcr__semestrals.year AS year',
        //             'ipcr__semestrals.sem AS sem',
        //             'user_employees.employee_name',
        //             'user_employees.empl_id',
        //             'user_employees.position_long_title',
        //             'user_employees.department_code',
        //             'user_employees.employment_type_descr',
        //             'user_employees.division_code',
        //             'ipcr__semestrals.immediate_id',
        //             'ipcr__semestrals.next_higher',
        //             'ipcr_monthly_accomplishments.id AS id_accomp',
        //             'ipcr_monthly_accomplishments.month AS a_month',
        //             'ipcr_monthly_accomplishments.year AS a_year',
        //             'ipcr_monthly_accomplishments.status AS a_status'
        //         )
        //         ->where('ipcr_monthly_accomplishments.status', '2')
        //         ->where('user_employees.department_code', auth()->user()->department_code)
        //         ->join('user_employees', 'user_employees.empl_id', 'ipcr__semestrals.employee_code')
        //         ->join('ipcr_monthly_accomplishments', 'ipcr_monthly_accomplishments.ipcr_semestral_id', 'ipcr__semestrals.id')
        //         ->distinct('ipcr_monthly_accomplishments.id')
        //         ->get()->map(function ($item) {
        //             $of = "";
        //             $imm = "";
        //             $next = "";
        //             $div = "";
        //             $of = FFUNCCOD::where('department_code', $item->department_code)->first();
        //             if ($of) {
        //                 $off = $of->FFUNCTION;
        //             }

        //             //SUFFIXES AND POSTFIXES
        //             $suff_imm = "";
        //             $post_imm = "";

        //             $suff_next = "";
        //             $post_next = "";
        //             // dd($off);
        //             $imm_emp = UserEmployees::where('empl_id', $item->immediate_id)->first();
        //             if ($imm_emp) {
        //                 if ($imm_emp->suffix_name) {
        //                     $suff_imm = ', ' . $imm_emp->suffix_name;
        //                 }
        //                 if ($imm_emp->postfix_name) {
        //                     $post_imm = ', ' . $imm_emp->postfix_name;
        //                 }
        //                 $imm = $imm_emp->first_name . ' ' . $imm_emp->last_name . '' . $suff_imm . '' . $post_imm;
        //             }


        //             $nx = UserEmployees::where('empl_id', $item->next_higher)->first();
        //             if ($nx) {
        //                 if ($nx->suffix_name) {
        //                     $suff_next = ', ' . $nx->suffix_name;
        //                 }
        //                 if ($nx->postfix_name) {
        //                     $post_next = ', ' . $nx->postfix_name;
        //                 }
        //                 $next = $nx->first_name . ' ' . $nx->last_name . '' . $suff_next . '' . $post_next;
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
        //                 'a_status' => $item->a_status,
        //                 'employment_type_descr' => $item->employment_type_descr
        //             ];
        //         });
        //     $accomplished = $accomplished->concat($accomp_final);
        //     // dd($accomplished);
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
        // dd($accomplishments);
        $emp = UserEmployees::where('empl_id', auth()->user()->username)
            ->first();
        $dept = Office::where('department_code', $emp->department_code)->first();
        $pgHead = UserEmployees::where('empl_id', $dept->empl_id)->first();
        $pgHead = $pgHead->first_name . ' ' . $pgHead->middle_name[0] . '. ' . $pgHead->last_name;

        return inertia(
            'IPCR/Review_Accomplishments/Index',
            [
                'accomplishments' => $accomplishments,
                "pghead" => $pgHead
            ]
        );
    }
}
