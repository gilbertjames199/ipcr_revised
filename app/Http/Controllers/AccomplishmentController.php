<?php

namespace App\Http\Controllers;

use App\Models\Daily_Accomplishment;
use App\Models\Division;
use App\Models\EmployeeSpecialDepartment;
use App\Models\FFUNCCOD;
use App\Models\IndividualFinalOutput;
use App\Models\Ipcr_Semestral;
use App\Models\MonthlyAccomplishment;
use App\Models\MonthlyRemarks;
use App\Models\Office;
use App\Models\ReturnRemarks;
use App\Models\TimeRange;
use App\Models\UserEmployees;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDO;

class AccomplishmentController extends Controller
{
    private $model;
    public function __construct(Daily_Accomplishment $model)
    {
        $this->model = $model;
    }

    public function index(Request $request)
    {
        // dd("Function");
        $emp_code = Auth()->user()->username;
        $emp = UserEmployees::where('empl_id', $emp_code)
            ->first();
        $month = Carbon::parse($request->month)->month;
        $year = $request->year;
        $sem = 1;

        $months = $month;
        if ($month > 6) {
            $months = $month - 6;
            $sem = 2;
        }
        $TimeRating = $request->TimeRating;
        $prescribed_period = '';
        $time_unit = '';
        $div = auth()->user()->division_code;
        $division = [];
        // dd($div);
        if ($div) {
            $division = Division::where('division_code', $div)
                ->first()->division_name1;
        }
        $esd = EmployeeSpecialDepartment::where('employee_code', $emp_code)->first();
        $office = FFUNCCOD::where('department_code', auth()->user()->department_code)->first();
        if ($esd) {
            if ($esd->department_code) {
                $office = FFUNCCOD::where('department_code', $esd->department_code)->first();
                $dept = Office::where('department_code', $esd->department_code)->first();
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


        // $dept = Office::where('department_code', auth()->user()->department_code)->first();
        // $pgHead = UserEmployees::where('empl_id', $dept->empl_id)->first();
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
        $data = Daily_Accomplishment::select(
            'ipcr_daily_accomplishments.idIPCR',
            DB::raw('SUM(ipcr_daily_accomplishments.quantity) as TotalQuantity'),
            DB::raw('SUM(ipcr_daily_accomplishments.average_timeliness) as TotalTimeliness'),
            DB::raw('ROUND(SUM(ipcr_daily_accomplishments.average_timeliness) / SUM(ipcr_daily_accomplishments.quantity)) as Final_Average_Timeliness'),
            'individual_final_outputs.individual_output',
            'individual_final_outputs.success_indicator',
            'individual_final_outputs.quantity_type',
            'individual_final_outputs.quality_error',
            'individual_final_outputs.time_range_code',
            'individual_final_outputs.time_based',
            'major_final_outputs.mfo_desc',
            'monthly_remarks.remarks',
            'monthly_remarks.id AS remarks_id',
            'division_outputs.output',
            'i_p_c_r_targets.ipcr_type',
            'i_p_c_r_targets.ipcr_semester_id',
            'i_p_c_r_targets.semester',
            "i_p_c_r_targets.month_$months as month",
            'ipcr__semestrals.year',
            DB::raw('COUNT(ipcr_daily_accomplishments.quality) as NumberofQuality'),
            DB::raw('SUM(CASE WHEN ipcr_daily_accomplishments.quality IS NOT NULL AND ipcr_daily_accomplishments.quality != "" THEN ipcr_daily_accomplishments.quality ELSE 0 END) AS total_quality'),
            DB::raw('ROUND(CASE WHEN COUNT(ipcr_daily_accomplishments.quality) > 0 THEN SUM(CASE WHEN ipcr_daily_accomplishments.quality IS NOT NULL AND ipcr_daily_accomplishments.quality != "" THEN ipcr_daily_accomplishments.quality ELSE 0 END) / COUNT(ipcr_daily_accomplishments.quality) ELSE 0 END, 0) AS quality_average'),
            DB::raw("'$prescribed_period' AS prescribed_period"),
            DB::raw("'$time_unit' AS time_unit"),
            DB::raw("'$TimeRating' AS TimeRating"),
        )
            ->join('individual_final_outputs', 'ipcr_daily_accomplishments.idIPCR', '=', 'individual_final_outputs.ipcr_code')
            ->join('major_final_outputs', 'individual_final_outputs.idmfo', '=', 'major_final_outputs.id')
            ->join('division_outputs', 'individual_final_outputs.id_div_output', '=', 'division_outputs.id')
            ->join(
                'i_p_c_r_targets',
                function ($join) use ($emp_code) {
                    $join->on('ipcr_daily_accomplishments.idIPCR', '=', 'i_p_c_r_targets.ipcr_code')
                        ->where('ipcr_daily_accomplishments.emp_code', '=', $emp_code)
                        ->where('i_p_c_r_targets.employee_code', '=', $emp_code);
                }
            )
            ->join('ipcr__semestrals', 'i_p_c_r_targets.ipcr_semester_id', '=', 'ipcr__semestrals.id')
            ->leftJoin('monthly_remarks', function ($join) use ($month) {
                $join->on('ipcr_daily_accomplishments.idIPCR', '=', 'monthly_remarks.idIPCR')
                    ->where('monthly_remarks.month', '=', $month)
                    ->whereMonth('ipcr_daily_accomplishments.date', '=', $month);
            })
            ->where('ipcr__semestrals.year', $year)
            ->where('i_p_c_r_targets.semester', $sem)
            ->where('emp_code', $emp_code)
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->groupBy('ipcr_daily_accomplishments.idIPCR')
            ->get();

        foreach ($data as $key => $value) {
            if ($value->time_range_code > 0 && $value->time_range_code < 47) {
                if ($value->time_based == 1) {
                    $time_range5 = TimeRange::where('time_code', $value->time_range_code)->orderBY('rating', 'DESC')->get();
                    if ($value->Final_Average_Timeliness == null) {
                        // dd($value->Final_Average_Timeliness);
                        $value->TimeRating = 0;
                        $value->time_unit = "";
                        $value->prescribed_period = "";
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
        $my_sem_id = "";
        $my_stat = "";
        $mo_data = Ipcr_Semestral::where('employee_code', $emp_code)
            ->where('ipcr__semestrals.year', $year)
            ->where('ipcr__semestrals.sem', $sem)
            ->orderBy('year', 'DESC')
            ->orderBy('sem', 'DESC')
            ->get()
            ->map(function ($item) {
                $rem = ReturnRemarks::where('ipcr_semestral_id', $item->id)
                    ->orderBy('created_at', 'DESC')
                    ->first();
                $immediate = UserEmployees::where('empl_id', $item->immediate_id)
                    ->first();
                $next_higher = UserEmployees::where('empl_id', $item->next_higher)
                    ->first();
                $user = UserEmployees::where('empl_id', $item->employee_code)
                    ->first();

                $division_code = "";
                if ($immediate->division_code == "") {
                    $division_code = $user->division_code;
                } else {
                    $division_code = $immediate->division_code;
                }
                // dd($division_code);
                $division = Division::where('division_code', $division_code)
                    ->first();



                // $userEmployee = UserEmployees::
                // dd($division);


                $division_assigned = "";
                // dd($item);
                if ($division == "") {
                    $division_assigned = "";
                } else {
                    if ($item->division == "") {
                        $division_assigned = $division->division_name1;
                    } else {
                        $division_assigned = $item->division;
                    }
                }

                //



                // dd($division_assigned);
                return [
                    'id' => $item->id,
                    'division' => $division_assigned,
                    'employee_code' => $item->employee_code,
                    'immediate_id' => $item->immediate_id,
                    'next_higher' => $item->next_higher,
                    "imm" => $immediate,
                    "next" => $next_higher,
                    'sem' => $item->sem,
                    'status' => $item->status,
                    'year' => $item->year,
                    'rem' => $rem
                ];
            });
        // dd($mo_data);

        $my_mo_data = [];
        if ($mo_data->isNotEmpty()) {
            $my_sem_id = $mo_data[0]['id'];
            $my_mo_data = $mo_data[0];
        }
        $sel_month = MonthlyAccomplishment::where("month", $month)
            ->where("year", $year)
            ->where("ipcr_semestral_id", $my_sem_id)
            ->first();
        $sel_month = MonthlyAccomplishment::where("month", $month)
            ->where("ipcr_semestral_id", $my_sem_id)
            ->first();
        if ($sel_month) {
            $my_stat = $sel_month->status;
        }

        // dd($data);
        // dd($sel_month);
        return inertia('Monthly_Accomplishment/Index', [
            // "data" => $data,
            "emp_code" => $emp_code,
            "month" => $request->month,
            "year" => $year,
            "data" => $data,
            "month_data" => $my_mo_data,
            "office" => $office,
            "dept" => $dept,
            "pgHead" => $pgHead,
            'sem_id' => $my_sem_id,
            "status" => $my_stat,
            // "sel_month"=>
        ]);
    }

    public function semestral_monthly(Request $request)
    {
        // dd($request->id_shown);

        $id = auth()->user()->username;
        // dd($id);
        $emp = UserEmployees::where('empl_id', $id)
            ->first();
        // dd($emp);
        $emp_code = $emp->empl_id;
        $division = "";
        if ($emp->division_code) {
            //dd($emp->division_code);
            $division = Division::where('division_code', $emp->division_code)
                ->first()->division_name1;
        }
        // dd($emp_code);
        $data = IndividualFinalOutput::select(
            'individual_final_outputs.ipcr_code',
            'i_p_c_r_targets.id',
            'individual_final_outputs.individual_output',
            'individual_final_outputs.performance_measure',
            'divisions.division_name1 AS division',
            'division_outputs.output AS div_output',
            'major_final_outputs.mfo_desc',
            'major_final_outputs.FFUNCCOD',
            'sub_mfos.submfo_description'

        )
            ->leftjoin('division_outputs', 'division_outputs.id', 'individual_final_outputs.id_div_output')
            ->leftjoin('divisions', 'divisions.id', 'division_outputs.division_id')
            ->leftjoin('major_final_outputs', 'major_final_outputs.id', 'division_outputs.idmfo')
            ->leftjoin('sub_mfos', 'sub_mfos.id', 'individual_final_outputs.idsubmfo')
            ->join('i_p_c_r_targets', 'i_p_c_r_targets.ipcr_code', 'individual_final_outputs.ipcr_code')
            ->where('i_p_c_r_targets.employee_code', $emp_code)
            ->orderBy('individual_final_outputs.ipcr_code')
            ->get();

        // dd($data);
        $sem_data = Ipcr_Semestral::where('employee_code', $emp_code)
            ->where('status', '2')
            ->orderBy('year', 'asc')
            ->orderBy('sem', 'asc')
            ->get()
            ->map(function ($item) use ($request) {
                $monthly_accomplishment = MonthlyAccomplishment::where('ipcr_semestral_id', $item->id)
                    ->get()
                    ->map(function ($item) {
                        $remarks = ReturnRemarks::where('ipcr_monthly_accomplishment_id', $item->id)
                            ->orderBy('id', 'DESC')
                            ->first();
                        return [
                            'id' => $item->id,
                            'month' => $item->month,
                            'year' => $item->year,
                            'ipcr_semestral_id' => $item->ipcr_semestral_id,
                            'status' => $item->status,
                            'rem' => $remarks,

                        ];
                    });
                return [
                    'id' => $item->id,
                    'sem' => $item->sem,
                    'employee_code' => $item->employee_code,
                    'immediate_id' => $item->immediate_id,
                    'next_higher' => $item->next_higher,
                    'year' => $item->year,
                    'status' => $item->status,
                    'status_accomplishment' => $item->status_accomplishment,
                    'monthly_accomplishment' => $monthly_accomplishment,
                ];
            });
        $source = "direct";

        // dd($data);
        // dd($sem_data);
        //dd($source);
        //return inertia('IPCR/Semestral/Index');
        return inertia('IPCR/Accomplishment/Index', [
            "id" => $id,
            "data" => $data,
            "sem_data" => $sem_data,
            "division" => $division,
            "emp" => $emp,
            "source" => $source,
            // "id_shown" => $id_shown
        ]);
    }

    public function submit_monthly(Request $request, $id)
    {
        // dd($request->id_shown);
        $data = MonthlyAccomplishment::findOrFail($request->id);
        //dd($request->plan_period);

        $data->update([
            'status' => '0',
        ]);
        // dd($data);
        return redirect('/monthly-accomplishment')
            ->with('message', 'Successfully submitted')
            ->with('id_shown', $request->id_shown);
    }
    public function get_this_monthly(Request $request)
    {
        $mo = $request->month;
        $year = $request->year;
        // dd($year);
        // dd($request->id);
        $mo_num = Carbon::parse($request->month)->month;
        // dd($mo . ' ' . $mo_num);
        $data = MonthlyAccomplishment::where('ipcr_semestral_id', $request->id)
            ->where('year', $year)
            ->where('month', $mo_num)
            ->first();
        // dd($data);
        if ($data) {
            $data->update([
                'status' => '0',
            ]);
            $rem = new ReturnRemarks();
            $rem->type = "Submit Monthly Accomplishment";
            $rem->ipcr_semestral_id = $data->ipcr_semestral_id;
            $rem->ipcr_monthly_accomplishment_id = $data->id;
            $rem->employee_code = auth()->user()->username;
            $rem->save();
            return redirect('/Accomplishment/?month=' . $mo . '&year=' . $year)
                ->with('info', 'IPCR for the month of ' . $mo . ' year ' . $year . ' successfully submitted');
        } else {
            return redirect('/Accomplishment/?month=' . $mo . '&year=' . $year)
                ->with('error', 'IPCR for the month of ' . $mo . ' year ' . $year . ' submitted successfully');
        }


        // dd($data);

    }
    public function recall_this_monthly(Request $request)
    {
        $mo = $request->month;
        $year = $request->year;
        // dd($year);
        // dd($request->id);
        $mo_num = Carbon::parse($request->month)->month;
        // dd($mo . ' ' . $mo_num);
        $data = MonthlyAccomplishment::where('ipcr_semestral_id', $request->id)
            ->where('year', $year)
            ->where('month', $mo_num)
            ->first();
        // dd($data);
        if ($data) {
            $data->update([
                'status' => '-1',
            ]);
            $rem = new ReturnRemarks();
            $rem->type = "Recall Monthly Accomplishment";
            $rem->ipcr_semestral_id = $data->ipcr_semestral_id;
            $rem->ipcr_monthly_accomplishment_id = $data->id;
            $rem->employee_code = auth()->user()->username;
            $rem->save();
            return redirect('/Accomplishment/?month=' . $mo . '&year=' . $year)
                ->with('info', 'Recall of IPCR for the month of ' . $mo . ' year ' . $year . ' successful');
        } else {
            return redirect('/Accomplishment/?month=' . $mo . '&year=' . $year)
                ->with('error', 'Recall unsuccessful');
        }
    }
    public function generate_monthly_accomplishment(Request $request)
    {
        // dd("generate_monthly_accomplishment");
        //generate_monthly_accomplishment
        $ipcr_semestral = Ipcr_Semestral::get()
            ->map(function ($item) {
                $id = $item->id;
                $sem = $item->sem;
                $year = $item->year;
                // Define the months based on the semester value
                $months = ($sem == 1) ? ['1', '2', '3', '4', '5', '6'] : ['7', '8', '9', '10', '11', '12'];

                // Create Ipcr_monthly records for each month
                foreach ($months as $month) {
                    $existingRecord = MonthlyAccomplishment::where('ipcr_semestral_id', $id)
                        ->where('month', $month)
                        ->first();
                    if (!$existingRecord) {
                        MonthlyAccomplishment::create([
                            'month' => $month,
                            'year' => $year,
                            'ipcr_semestral_id' => $id, // Reference to the parent semestral record
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
            });

        return redirect()->back()->with('message', 'Successfully generated monthly IPCR!');
    }


    public function MonthlyPrintTypes(Request $request)
    {
        $date_now = Carbon::now();
        $dn = $date_now->format('m-d-Y');
        $arr = [
            [
                "emp_code" => $request->emp_code,
                "employee_name" => $request->employee_name,
                "emp_status" => $request->emp_status,
                "position" => $request->position,
                "office" => $request->office,
                "division" => $request->division,
                "immediate" => $request->immediate,
                "next_higher" => $request->next_higher,
                "sem" => $request->sem,
                "year" => $request->year,
                "idsemestral" => $request->idsemestral,
                "date" => $dn,
                "period" => $request->period,
                "type" => "Core Function",
                "pghead" => $request->pghead,

            ],
            [
                "emp_code" => $request->emp_code,
                "employee_name" => $request->employee_name,
                "emp_status" => $request->emp_status,
                "position" => $request->position,
                "office" => $request->office,
                "division" => $request->division,
                "immediate" => $request->immediate,
                "next_higher" => $request->next_higher,
                "sem" => $request->sem,
                "year" => $request->year,
                "idsemestral" => $request->idsemestral,
                "date" => $dn,
                "period" => $request->period,
                "type" => "Support Function",
                "pghead" => $request->pghead,
            ]
        ];
        return $arr;
    }

    public function MonthlyPrint(Request $request)
    {
        $emp_code = $request->emp_code;
        $month = Carbon::parse($request->month)->month;
        $Score = $request->Score;
        $Percentage = $request->Percentage;
        $QualityType = $request->QualityType;
        $QuantityType = $request->QuantityType;
        $QualityRating = $request->QualityRating;
        $TimeRating = $request->TimeRating;
        $year = $request->year;
        // dd($year);
        $sem = 1;
        $months = $month;
        if ($month > 6) {
            $months = $month - 6;
            $sem = 2;
        }
        $TimeRange5 = '';
        $prescribed_period = '';
        $time_unit = '';
        $Prescribed_period = '';
        $data = Daily_Accomplishment::select(
            'ipcr_daily_accomplishments.idIPCR',
            DB::raw('SUM(ipcr_daily_accomplishments.quantity) as TotalQuantity'),
            DB::raw('SUM(ipcr_daily_accomplishments.average_timeliness) as TotalTimeliness'),
            DB::raw('ROUND(SUM(ipcr_daily_accomplishments.average_timeliness) / SUM(ipcr_daily_accomplishments.quantity)) as Final_Average_Timeliness'),
            'individual_final_outputs.individual_output',
            'individual_final_outputs.success_indicator',
            'individual_final_outputs.quantity_type',
            'individual_final_outputs.quality_error',
            'individual_final_outputs.time_range_code',
            'individual_final_outputs.activity',
            'individual_final_outputs.verb',
            'individual_final_outputs.error_feedback',
            'individual_final_outputs.within',
            'individual_final_outputs.unit_of_time',
            'individual_final_outputs.concatenate',
            'individual_final_outputs.time_based',
            'monthly_remarks.remarks',
            'monthly_remarks.id AS remarks_id',
            'major_final_outputs.mfo_desc',
            'division_outputs.output',
            'i_p_c_r_targets.ipcr_type',
            'i_p_c_r_targets.ipcr_semester_id',
            'i_p_c_r_targets.semester',
            "i_p_c_r_targets.month_$months as month",
            'ipcr__semestrals.year',

            DB::raw('COUNT(ipcr_daily_accomplishments.quality) as NumberofQuality'),
            DB::raw('SUM(CASE WHEN ipcr_daily_accomplishments.quality IS NOT NULL AND ipcr_daily_accomplishments.quality != "" THEN ipcr_daily_accomplishments.quality ELSE 0 END) AS total_quality'),
            DB::raw('ROUND(CASE WHEN COUNT(ipcr_daily_accomplishments.quality) > 0 THEN SUM(CASE WHEN ipcr_daily_accomplishments.quality IS NOT NULL AND ipcr_daily_accomplishments.quality != "" THEN ipcr_daily_accomplishments.quality ELSE 0 END) / COUNT(ipcr_daily_accomplishments.quality) ELSE 0 END, 0) AS quality_average'),
            DB::raw("'$Score' AS Score"),
            DB::raw("'$QualityType' AS QualityType"),
            DB::raw("'$QuantityType' AS QuantityType"),
            DB::raw("'$QualityRating' AS QualityRating"),
            DB::raw("'$TimeRating' AS TimeRating"),
            DB::raw("'$prescribed_period' AS prescribed_period"),
            DB::raw("'$time_unit' AS time_unit"),
            // DB::raw("'$TimeRange5' AS TimeRange5"),
        )
            ->where('emp_code', $emp_code)
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->join('individual_final_outputs', 'ipcr_daily_accomplishments.idIPCR', '=', 'individual_final_outputs.ipcr_code')
            ->join('major_final_outputs', 'individual_final_outputs.idmfo', '=', 'major_final_outputs.id')
            ->join('division_outputs', 'individual_final_outputs.id_div_output', '=', 'division_outputs.id')
            ->join(
                'i_p_c_r_targets',
                function ($join) use ($emp_code) {
                    $join->on('ipcr_daily_accomplishments.idIPCR', '=', 'i_p_c_r_targets.ipcr_code')
                        ->where('ipcr_daily_accomplishments.emp_code', '=', $emp_code)
                        ->where('i_p_c_r_targets.employee_code', '=', $emp_code);
                }
            )
            ->join('ipcr__semestrals', 'i_p_c_r_targets.ipcr_semester_id', '=', 'ipcr__semestrals.id')
            ->leftJoin('monthly_remarks', function ($join) use ($month) {
                $join->on('ipcr_daily_accomplishments.idIPCR', '=', 'monthly_remarks.idIPCR')
                    ->where('monthly_remarks.month', '=', $month)
                    ->whereMonth('ipcr_daily_accomplishments.date', '=', $month);
            })
            ->where('ipcr__semestrals.year', $year)
            ->where('i_p_c_r_targets.semester', $sem)
            ->where('i_p_c_r_targets.ipcr_type', $request->type)
            ->groupBy('ipcr_daily_accomplishments.idIPCR')
            ->get();


        foreach ($data as $key => $value) {
            if ($value->month == 0) {
                $value->month = 1;
            }
            $value->Percentage = round(($value->TotalQuantity / $value->month) * 100);


            if ($value->quantity_type == 1) {
                if ($value->Percentage >= 130) {
                    $value->Score = "5";
                } else if ($value->Percentage <= 129 && $value->Percentage >= 115) {
                    $value->Score = "4";
                } else if ($value->Percentage <= 114 && $value->Percentage >= 90) {
                    $value->Score = "3";
                } else if ($value->Percentage <= 89 && $value->Percentage >= 51) {
                    $value->Score = "2";
                } else if ($value->Percentage <= 50) {
                    $value->Score = "1";
                } else {
                    $value->Score = 0.00;
                }
            } else if ($value->quantity_type == 2) {
                if ($value->Percentage = 100) {
                    $value->Score = 5;
                } else {
                    $value->Score = 2;
                }
            }

            if ($value->quantity_type == 1) {
                $value->QuantityType = "TO BE RATED";
            } else {
                $value->QuantityType = "ACCURACY RULE (100%=5,2 if less than 100%)";
            }

            if ($value->quality_error == 1) {
                if ($value->quality_average == 0) {
                    $value->QualityRating = "5";
                } else if ($value->quality_average >= .01 && $value->quality_average <= 2.99) {
                    $value->QualityRating = "4";
                } else if ($value->quality_average >= 3 && $value->quality_average <= 4.99) {
                    $value->QualityRating = "3";
                } else if ($value->quality_average >= 5 && $value->quality_average <= 6.99) {
                    $value->QualityRating = "2";
                } else if ($value->quality_average >= 7) {
                    $value->QualityRating = "1";
                }
            } else if ($value->quality_error == 2) {
                if ($value->quality_average == 5) {
                    $value->QualityRating = "5";
                } else if ($value->quality_average >= 4 && $value->quality_average <= 4.99) {
                    $value->QualityRating = "4";
                } else if ($value->quality_average >= 3 && $value->quality_average <= 3.99) {
                    $value->QualityRating = "3";
                } else if ($value->quality_average >= 2 && $value->quality_average <= 2.99) {
                    $value->QualityRating = "2";
                } else if ($value->quality_average >= 1 && $value->quality_average <= 1.99) {
                    $value->QualityRating = "1";
                } else {
                    $value->QualityRating = "0";
                }
            } else if ($value->quality_error == 4) {
                if ($value->quality_average >= 1) {
                    $value->QualityRating = "2";
                } else {
                    $value->QualityRating = "5";
                }
            }

            if ($value->quality_error == 1) {
                $value->QualityType = 'NO. OF ERROR';
            } else if ($value->quality_error == 2) {
                $value->QualityType = "AVE. FEEDBACK";
            } else if ($value->quality_error == 3) {
                $value->QualityType = "NOT TO BE RATED";
            } else if ($value->quality_error == 4) {
                $value->QualityType = "ACCURACY RULE";
            }



            if ($value->time_range_code > 0 && $value->time_range_code < 47) {
                if ($value->time_based == 1) {
                    $time_range5 = TimeRange::where('time_code', $value->time_range_code)->orderBY('rating', 'DESC')->get();
                    if (!$value->Final_Average_Timeliness) {
                        $value->TimeRating = 0;
                        $value->time_unit = "";
                        $value->prescribed_period = "";
                        $value->Prescribed_period = "Prescribed Period is " . $value->prescribed_period . " " . $value->time_unit;
                    } else if (
                        $value->Final_Average_Timeliness <= $time_range5[0]->equivalent_time_from
                    ) {
                        $value->TimeRating = 5;
                        $value->time_unit = $time_range5[0]->time_unit;
                        $value->prescribed_period = $time_range5[0]->prescribed_period;
                        $value->Prescribed_period = "Prescribed Period is " . $value->prescribed_period . " " . $value->time_unit;
                    } else if (
                        $value->Final_Average_Timeliness >= $time_range5[4]->equivalent_time_from
                    ) {
                        $value->TimeRating = 1;
                        $value->time_unit = $time_range5[4]->time_unit;
                        $value->prescribed_period = $time_range5[4]->prescribed_period;
                        $value->Prescribed_period = "Prescribed Period is " . $value->prescribed_period . " " . $value->time_unit;
                    } else if (
                        $value->Final_Average_Timeliness >= $time_range5[3]->equivalent_time_from
                    ) {
                        $value->TimeRating = 2;
                        $value->time_unit = $time_range5[3]->time_unit;
                        $value->prescribed_period = $time_range5[3]->prescribed_period;
                        $value->Prescribed_period = "Prescribed Period is " . $value->prescribed_period . " " . $value->time_unit;
                    } else if (
                        $value->Final_Average_Timeliness >= $time_range5[2]->equivalent_time_from
                    ) {
                        $value->TimeRating = 3;
                        $value->time_unit = $time_range5[2]->time_unit;
                        $value->prescribed_period = $time_range5[2]->prescribed_period;
                        $value->Prescribed_period = "Prescribed Period is " . $value->prescribed_period . " " . $value->time_unit;
                    } else if ($value->Final_Average_Timeliness >= $time_range5[1]->equivalent_time_from) {
                        $value->TimeRating = 4;
                        $value->time_unit = $time_range5[1]->time_unit;
                        $value->prescribed_period = $time_range5[1]->prescribed_period;
                        $value->Prescribed_period = "Prescribed Period is " . $value->prescribed_period . " " . $value->time_unit;
                    } else {
                        $value->TimeRating = 0;
                        $value->time_unit = "";
                        $value->prescribed_period = "";
                    }
                }
            } else {
                $value->TotalTimeliness = "";
                $value->Final_Average_Timeliness = "";
                $value->TimeRating = 0;
                $value->Prescribed_period = "Not to be Rated";
            }
        }
        return $data;
    }


    public function store(Request $request)
    {
        $year = $request->year;
        $months = $request->month;
        if ($months == 1) {
            $months = "January";
        } else if ($months == 2) {
            $months = "Febraury";
        } else if ($months == 3) {
            $months = "March";
        } else if ($months == 4) {
            $months = "April";
        } else if ($months == 5) {
            $months = "May";
        } else if ($months == 6) {
            $months = "June";
        } else if ($months == 7) {
            $months = "July";
        } else if ($months == 8) {
            $months = "August";
        } else if ($months == 9) {
            $months = "September";
        } else if ($months == 10) {
            $months = "October";
        } else if ($months == 11) {
            $months = "November";
        } else if ($months == 12) {
            $months = "December";
        }
        // dd($month);
        // dd($request->all());
        // dd($request);
        MonthlyRemarks::create($request->all());

        return redirect('/Accomplishment/?month=' . $months . '&year=' . $year)
            ->with('message', 'Remarks added');
    }
    public function update(Request $request)
    {

        $year = $request->year;
        $months = $request->month;
        if ($months == 1) {
            $months = "January";
        } else if ($months == 2) {
            $months = "Febraury";
        } else if ($months == 3) {
            $months = "March";
        } else if ($months == 4) {
            $months = "April";
        } else if ($months == 5) {
            $months = "May";
        } else if ($months == 6) {
            $months = "June";
        } else if ($months == 7) {
            $months = "July";
        } else if ($months == 8) {
            $months = "August";
        } else if ($months == 9) {
            $months = "September";
        } else if ($months == 10) {
            $months = "October";
        } else if ($months == 11) {
            $months = "November";
        } else if ($months == 12) {
            $months = "December";
        }
        $data = MonthlyRemarks::findOrFail($request->id);
        $data->update([
            'remarks' => $request->remarks,
        ]);

        return redirect('/Accomplishment/?month=' . $months . '&year=' . $year)
            ->with('info', 'Remarks updated');
    }
    public function destroy(Request $request)
    {

        $data = MonthlyRemarks::findOrFail($request->id);
        $year = $data->year;

        $months = $data->month;
        if ($months == 1) {
            $months = "January";
        } else if ($months == 2) {
            $months = "Febraury";
        } else if ($months == 3) {
            $months = "March";
        } else if ($months == 4) {
            $months = "April";
        } else if ($months == 5) {
            $months = "May";
        } else if ($months == 6) {
            $months = "June";
        } else if ($months == 7) {
            $months = "July";
        } else if ($months == 8) {
            $months = "August";
        } else if ($months == 9) {
            $months = "September";
        } else if ($months == 10) {
            $months = "October";
        } else if ($months == 11) {
            $months = "November";
        } else if ($months == 12) {
            $months = "December";
        }

        $data->delete();

        return redirect('/Accomplishment/?month=' . $months . '&year=' . $year)
            ->with('info', 'Remarks deleted');
        //dd($request->raao_id);
        // return redirect('/Daily_Accomplishment')->with('warning', 'Accomplishment Deleted');
    }
    public function MonthlyPrintMain(Request $request)
    {
        $Point_Core = 0;
        $Point_Support = 0;
        if ($request->Average_Point_Core == null) {
            $Point_Core = 0;
        } else {
            $Point_Core = floatval($request->Average_Point_Core);
        }

        if ($request->Average_Point_Support == null) {
            $Point_Support = 0;
        } else {
            $Point_Support = floatval($request->Average_Point_Support);
        }

        $months = 0;
        if ($request->period == "January") {
            $months = 1;
        } else if ($request->period == "February") {
            $months = 2;
        } else if ($request->period == "March") {
            $months = 3;
        } else if ($request->period == "April") {
            $months = 4;
        } else if ($request->period == "May") {
            $months = 5;
        } else if ($request->period == "June") {
            $months = 6;
        } else if ($request->period == "July") {
            $months = 7;
        } else if ($request->period == "August") {
            $months = 8;
        } else if ($request->period == "September") {
            $months = 9;
        } else if ($request->period == "October") {
            $months = 10;
        } else if ($request->period == "November") {
            $months = 11;
        } else if ($request->period == "December") {
            $months = 12;
        }


        $month_sem = 0;
        $monthly = MonthlyAccomplishment::select(
            'ipcr_monthly_accomplishments.id',
            'ipcr_monthly_accomplishments.month',
        )
            ->where('ipcr_monthly_accomplishments.ipcr_semestral_id', $request->idsemestral)
            ->where('ipcr_monthly_accomplishments.month', $months)
            ->first();
        // dd($monthly);
        if (isset($monthly)) {
            $month_sem = $monthly->id;
        };
        // dd($request->emp_code);
        $remarks = ReturnRemarks::select(
            'return_remarks.remarks',
            'return_remarks.ipcr_monthly_accomplishment_id',
            'return_remarks.created_at',
            'ipcr_monthly_accomplishments.status',
        )
            ->leftjoin('ipcr_monthly_accomplishments', 'ipcr_monthly_accomplishments.ipcr_semestral_id', 'return_remarks.ipcr_semestral_id')
            ->where('return_remarks.type', 'review accomplishment')
            ->where('return_remarks.employee_code', $request->emp_code)
            ->where('return_remarks.ipcr_monthly_accomplishment_id', $month_sem)
            ->orderBy('return_remarks.created_at', 'DESC')
            ->first();
        // dd($remarks);

        $monthly_review = "";
        $monthly_status = 0;
        if (isset($remarks)) {
            $monthly_review = $remarks->remarks;
            $monthly_status = $remarks->status;
        };
        // dd($remarks);
        $date_now = Carbon::now();
        $dn = $date_now->format('m-d-Y');
        $arr = [
            [
                "emp_code" => $request->emp_code,
                "employee_name" => $request->employee_name,
                "emp_status" => $request->emp_status,
                "position" => $request->position,
                "office" => $request->office,
                "division" => $request->division,
                "immediate" => $request->immediate,
                "next_higher" => $request->next_higher,
                "sem" => $request->sem,
                "year" => $request->year,
                "idsemestral" => $request->idsemestral,
                "date" => $dn,
                "period" => $request->period,
                "type" => "Core Function",
                "pghead" => $request->pghead,
                "MonthlyStatus" => $request->MonthlyStatus,
                "Average_Point" => $Point_Core,
                "Multiply" => 70,
                "Average_Score_Function" => round($Point_Core * .70, 2),
                "Total_Average_Score" => round(($Point_Core * .70) + ($Point_Support * .30), 2),
                "Monthly_Remarks" => $monthly_review,
                "Monthly_Status" => $monthly_status,
            ],
            [
                "emp_code" => $request->emp_code,
                "employee_name" => $request->employee_name,
                "emp_status" => $request->emp_status,
                "position" => $request->position,
                "office" => $request->office,
                "division" => $request->division,
                "immediate" => $request->immediate,
                "next_higher" => $request->next_higher,
                "sem" => $request->sem,
                "year" => $request->year,
                "idsemestral" => $request->idsemestral,
                "date" => $dn,
                "period" => $request->period,
                "type" => "Support Function",
                "pghead" => $request->pghead,
                "MonthlyStatus" => $request->MonthlyStatus,
                "Average_Point" => $Point_Support,
                "Multiply" => 30,
                "Average_Score_Function" => round($Point_Support * .30, 2),
                "Total_Average_Score" => round(($Point_Core * .70) + ($Point_Support * .30), 2),
                "Monthly_Remarks" => $monthly_review,
                "Monthly_Status" => $monthly_status,
            ]
        ];
        // dd($arr);
        return $arr;
    }

    public function MonthlyPrintMainTypes(Request $request)
    {
        $emp_code = $request->emp_code;
        $month = Carbon::parse($request->month)->month;
        $Score = $request->Score;
        $Percentage = $request->Percentage;
        $QualityType = $request->QualityType;
        $QuantityType = $request->QuantityType;
        $QualityRating = $request->QualityRating;
        $TimeRating = $request->TimeRating;
        $percentage = $request->Percentage;
        $year = $request->year;
        // dd($year);
        $sem = 1;
        $months = $month;
        if ($month > 6) {
            $months = $month - 6;
            $sem = 2;
        }
        $TimeRange5 = '';
        $prescribed_period = '';
        $time_unit = '';
        $data = Daily_Accomplishment::select(
            'ipcr_daily_accomplishments.idIPCR',
            DB::raw('SUM(ipcr_daily_accomplishments.quantity) as TotalQuantity'),
            DB::raw('SUM(ipcr_daily_accomplishments.average_timeliness) as TotalTimeliness'),
            DB::raw('ROUND(SUM(ipcr_daily_accomplishments.average_timeliness) / SUM(ipcr_daily_accomplishments.quantity)) as Final_Average_Timeliness'),
            'individual_final_outputs.individual_output',
            'individual_final_outputs.success_indicator',
            'individual_final_outputs.quantity_type',
            'individual_final_outputs.quality_error',
            'individual_final_outputs.time_range_code',
            'individual_final_outputs.time_based',
            'individual_final_outputs.activity',
            'individual_final_outputs.verb',
            'individual_final_outputs.error_feedback',
            'individual_final_outputs.within',
            'individual_final_outputs.unit_of_time',
            'individual_final_outputs.concatenate',
            'individual_final_outputs.performance_measure',
            'monthly_remarks.remarks',
            'monthly_remarks.id AS remarks_id',
            'major_final_outputs.mfo_desc',
            'division_outputs.output as division_output',
            'i_p_c_r_targets.ipcr_type',
            'i_p_c_r_targets.ipcr_semester_id',
            'i_p_c_r_targets.semester',
            "i_p_c_r_targets.month_$months as month",
            'ipcr__semestrals.year',

            DB::raw('COUNT(ipcr_daily_accomplishments.quality) as NumberofQuality'),
            DB::raw('SUM(CASE WHEN ipcr_daily_accomplishments.quality IS NOT NULL AND ipcr_daily_accomplishments.quality != "" THEN ipcr_daily_accomplishments.quality ELSE 0 END) AS total_quality'),
            DB::raw('ROUND(CASE WHEN COUNT(ipcr_daily_accomplishments.quality) > 0 THEN SUM(CASE WHEN ipcr_daily_accomplishments.quality IS NOT NULL AND ipcr_daily_accomplishments.quality != "" THEN ipcr_daily_accomplishments.quality ELSE 0 END) / COUNT(ipcr_daily_accomplishments.quality) ELSE 0 END, 0) AS quality_average'),
            DB::raw("'$Score' AS Score"),
            DB::raw("'$QualityType' AS QualityType"),
            DB::raw("'$QuantityType' AS QuantityType"),
            DB::raw("'$QualityRating' AS QualityRating"),
            DB::raw("'$TimeRating' AS TimeRating"),
            DB::raw("'$prescribed_period' AS prescribed_period"),
            DB::raw("'$time_unit' AS time_unit"),
            // DB::raw("'$TimeRange5' AS TimeRange5"),
        )
            ->where('emp_code', $emp_code)
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->join('individual_final_outputs', 'ipcr_daily_accomplishments.idIPCR', '=', 'individual_final_outputs.ipcr_code')
            ->join('major_final_outputs', 'individual_final_outputs.idmfo', '=', 'major_final_outputs.id')
            ->join('division_outputs', 'individual_final_outputs.id_div_output', '=', 'division_outputs.id')
            ->join(
                'i_p_c_r_targets',
                function ($join) use ($emp_code) {
                    $join->on('ipcr_daily_accomplishments.idIPCR', '=', 'i_p_c_r_targets.ipcr_code')
                        ->where('ipcr_daily_accomplishments.emp_code', '=', $emp_code)
                        ->where('i_p_c_r_targets.employee_code', '=', $emp_code);
                }
            )
            ->join('ipcr__semestrals', 'i_p_c_r_targets.ipcr_semester_id', '=', 'ipcr__semestrals.id')
            ->leftJoin('monthly_remarks', function ($join) use ($month) {
                $join->on('ipcr_daily_accomplishments.idIPCR', '=', 'monthly_remarks.idIPCR')
                    ->where('monthly_remarks.month', '=', $month)
                    ->whereMonth('ipcr_daily_accomplishments.date', '=', $month);
            })
            ->where('ipcr__semestrals.year', $year)
            ->where('i_p_c_r_targets.semester', $sem)
            ->where('i_p_c_r_targets.ipcr_type', $request->type)
            ->groupBy('ipcr_daily_accomplishments.idIPCR')
            ->get();
        foreach ($data as $key => $value) {
            if ($value->month == 0) {
                $value->month = 1;
            }
            $value->Percentage = round(($value->TotalQuantity / $value->month) * 100);




            if ($value->quantity_type == 1) {
                if ($value->Percentage >= 130) {
                    $value->Score = "5";
                } else if ($value->Percentage <= 129 && $value->Percentage >= 115) {
                    $value->Score = "4";
                } else if ($value->Percentage <= 114 && $value->Percentage >= 90) {
                    $value->Score = "3";
                } else if ($value->Percentage <= 89 && $value->Percentage >= 51) {
                    $value->Score = "2";
                } else if ($value->Percentage <= 50) {
                    $value->Score = "1";
                } else {
                    $value->Score = 0.00;
                }
            } else if ($value->quantity_type == 2) {
                if ($value->Percentage = 100) {
                    $value->Score = 5;
                } else {
                    $value->Score = 2;
                }
            }

            if ($value->quantity_type == 1) {
                $value->QuantityType = "TO BE RATED";
            } else if ($value->quantity_type == 2) {
                $value->QuantityType = "ACCURACY RULE (100%=5,2 if less than 100%)";
            }

            if ($value->quality_error == 1) {
                if ($value->quality_average == 0) {
                    $value->QualityRating = "5";
                } else if ($value->quality_average >= .01 && $value->quality_average <= 2.99) {
                    $value->QualityRating = "4";
                } else if ($value->quality_average >= 3 && $value->quality_average <= 4.99) {
                    $value->QualityRating = "3";
                } else if ($value->quality_average >= 5 && $value->quality_average <= 6.99) {
                    $value->QualityRating = "2";
                } else if ($value->quality_average >= 7) {
                    $value->QualityRating = "1";
                }
            } else if ($value->quality_error == 2) {
                if ($value->quality_average == 5) {
                    $value->QualityRating = "5";
                } else if ($value->quality_average >= 4 && $value->quality_average <= 4.99) {
                    $value->QualityRating = "4";
                } else if ($value->quality_average >= 3 && $value->quality_average <= 3.99) {
                    $value->QualityRating = "3";
                } else if ($value->quality_average >= 2 && $value->quality_average <= 2.99) {
                    $value->QualityRating = "2";
                } else if ($value->quality_average >= 1 && $value->quality_average <= 1.99) {
                    $value->QualityRating = "1";
                } else {
                    $value->QualityRating = "0";
                }
            } else if ($value->quality_error == 4) {
                if ($value->quality_average >= 1) {
                    $value->QualityRating = "2";
                } else {
                    $value->QualityRating = "5";
                }
            }

            if ($value->quality_error == 1) {
                if ($value->quality_average == 0) {
                    $value->error_feedback = "No " . $value->error_feedback;
                } else {
                    $value->error_feedback = $value->quality_average . " " . $value->error_feedback;
                }
            } else if ($value->quality_error == 2) {
                if ($value->QualityRating == "5") {
                    $value->error_feedback = "Outstanding Feedback";
                } else if ($value->QualityRating == "4") {
                    $value->error_feedback = "Very Satisfactory Feedback";
                } else if ($value->QualityRating == "3") {
                    $value->error_feedback = "Satisfactory Feedback";
                } else if ($value->QualityRating == "2") {
                    $value->error_feedback = "Unsatisfactory Feedback";
                } else if ($value->QualityRating == "1") {
                    $value->error_feedback = "Poor Feedback";
                }
            }

            if ($value->quality_error == 1) {
                $value->QualityType = 'NO. OF ERROR';
            } else if ($value->quality_error == 2) {
                $value->QualityType = "AVE. FEEDBACK";
            } else if ($value->quality_error == 3) {
                $value->QualityType = "NOT TO BE RATED";
            } else if ($value->quality_error == 4) {
                $value->QualityType = "ACCURACY RULE";
            }

            if ($value->time_range_code > 0 && $value->time_range_code < 47) {
                if ($value->time_based == 1) {
                    $time_range5 = TimeRange::where('time_code', $value->time_range_code)->orderBY('rating', 'DESC')->get();
                    if ($value->Final_Average_Timeliness == null) {
                        $value->TimeRating = 0;
                        $value->time_unit = "";
                        $value->prescribed_period = "";
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
            } else {
                $value->TimeRating = 0;
            }
        }
        return $data;
    }
}
