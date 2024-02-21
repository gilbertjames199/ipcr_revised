<?php

namespace App\Http\Controllers;

use App\Models\Daily_Accomplishment;
use App\Models\Division;
use App\Models\FFUNCCOD;
use App\Models\IndividualFinalOutput;
use App\Models\Ipcr_Semestral;
use App\Models\IPCRTargets;
use App\Models\MonthlyAccomplishment;
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
        $empl_code = auth()->user()->username;
        // dd($empl_code);


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
            ->join('ipcr_monthly_accomplishments', 'ipcr_monthly_accomplishments.ipcr_semestral_id', 'ipcr__semestrals.id')
            ->distinct('ipcr_monthly_accomplishments.id')
            ->get()->map(function ($item) use ($request) {
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
                // dd($result);
                $data = TimeRange::where('time_code', $item->time_range_code)
                    ->get();
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
                    'Average_Point_Support' => $Average_Point_Support
                ];
            });
        // dd($accomp_review->count());
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
        )->where('ipcr__semestrals.next_higher', $empl_code)
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

        $my_data = UserEmployees::where('id', auth()->user()->id)->first();
        $is_pghead = $my_data->is_pghead;


        $accomplished = $accomp_review->concat($accomp_approve);
        // dd($my_data);
        if ($is_pghead == "1") {

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
                )->where('ipcr_monthly_accomplishments.status', '2')
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
            $accomplished = $accomp_review->concat($accomp_final);
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
        // dd(auth()->user());
        $emp = UserEmployees::where('id', auth()->user()->id)
            ->first();
        $dept = Office::where('department_code', $emp->department_code)->first();
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
                "pghead" => $pgHead
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
            $th = "error";
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
}
