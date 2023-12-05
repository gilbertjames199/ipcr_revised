<?php

namespace App\Http\Controllers;

use App\Models\Daily_Accomplishment;
use App\Models\Division;
use App\Models\FFUNCCOD;
use App\Models\IndividualFinalOutput;
use App\Models\Ipcr_Semestral;
use App\Models\MonthlyAccomplishment;
use App\Models\Office;
use App\Models\ReturnRemarks;
use App\Models\TimeRange;
use App\Models\UserEmployees;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AccomplishmentController extends Controller
{
    private $model;
    public function __construct(Daily_Accomplishment $model)
    {
        $this->model = $model;
    }

    public function index(Request $request)
    {

        $emp_code = Auth()->user()->username;
        $month = Carbon::parse($request->month)->month;
        $year = $request->year;
        $sem = 1;
        $months = $month;
        if ($month > 6) {
            $months = $month - 6;
            $sem = 2;
        }
        $div = auth()->user()->division_code;
        $division = [];
        // dd($div);
        if ($div) {
            $division = Division::where('division_code', $div)
                ->first()->division_name1;
        }
        $office = FFUNCCOD::where('department_code', auth()->user()->department_code)->first();
        $dept = Office::where('department_code', auth()->user()->department_code)->first();
        $pgHead = UserEmployees::where('empl_id', $dept->empl_id)->first();
        $pgHead = $pgHead->first_name . ' ' . $pgHead->middle_name[0] . ' ' . $pgHead->last_name;
        $data = Daily_Accomplishment::select(
            'ipcr_daily_accomplishments.idIPCR',
            DB::raw('SUM(ipcr_daily_accomplishments.quantity) as TotalQuantity'),
            'individual_final_outputs.individual_output',
            'individual_final_outputs.success_indicator',
            'individual_final_outputs.quantity_type',
            'individual_final_outputs.quality_error',
            'major_final_outputs.mfo_desc',
            'division_outputs.output',
            'i_p_c_r_targets.ipcr_type',
            'i_p_c_r_targets.ipcr_semester_id',
            'i_p_c_r_targets.semester',
            "i_p_c_r_targets.month_$months as month",
            'ipcr__semestrals.year',
            DB::raw('COUNT(ipcr_daily_accomplishments.quality) as NumberofQuality'),
            DB::raw('SUM(CASE WHEN ipcr_daily_accomplishments.quality IS NOT NULL AND ipcr_daily_accomplishments.quality != "" THEN ipcr_daily_accomplishments.quality ELSE 0 END) AS total_quality'),
            DB::raw('ROUND(CASE WHEN COUNT(ipcr_daily_accomplishments.quality) > 0 THEN SUM(CASE WHEN ipcr_daily_accomplishments.quality IS NOT NULL AND ipcr_daily_accomplishments.quality != "" THEN ipcr_daily_accomplishments.quality ELSE 0 END) / COUNT(ipcr_daily_accomplishments.quality) ELSE 0 END, 0) AS quality_average')
        )
            ->where('emp_code', $emp_code)
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->join('individual_final_outputs', 'ipcr_daily_accomplishments.idIPCR', '=', 'individual_final_outputs.ipcr_code')
            ->join('major_final_outputs', 'individual_final_outputs.idmfo', '=', 'major_final_outputs.id')
            ->join('division_outputs', 'individual_final_outputs.id_div_output', '=', 'division_outputs.id')
            ->join('i_p_c_r_targets', 'ipcr_daily_accomplishments.idIPCR', '=', 'i_p_c_r_targets.ipcr_code')
            ->join('ipcr__semestrals', 'i_p_c_r_targets.ipcr_semester_id', '=', 'ipcr__semestrals.id')
            ->where('ipcr__semestrals.year', $year)
            ->where('i_p_c_r_targets.semester', $sem)
            ->groupBy('ipcr_daily_accomplishments.idIPCR')
            ->paginate(10)
            ->withQueryString();

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
                return [
                    'id' => $item->id,
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


        // dd($mo_data[0]);
        return inertia('Monthly_Accomplishment/Index', [
            // "data" => $data,
            "emp_code" => $emp_code,
            "month" => $request->month,
            "data" => $data,
            "month_data" => $mo_data[0],
            "office" => $office,
            "dept" => $dept,
            "pgHead" => $pgHead,
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
                            'rem' => $remarks
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
                    'monthly_accomplishment' => $monthly_accomplishment,
                ];
            });
        $source = "direct";
        //dd($sem_data);
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
                "type" => "Core Function"
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
                "type" => "Support Function"
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
            'division_outputs.output',
            'i_p_c_r_targets.ipcr_type',
            'i_p_c_r_targets.ipcr_semester_id',
            'i_p_c_r_targets.semester',
            "i_p_c_r_targets.month_$months as month",
            'ipcr__semestrals.year',
            DB::raw("ROUND((SUM(ipcr_daily_accomplishments.quantity) / i_p_c_r_targets.month_$months) * 100) as Percentage"),
            DB::raw('COUNT(ipcr_daily_accomplishments.quality) as NumberofQuality'),
            DB::raw('SUM(CASE WHEN ipcr_daily_accomplishments.quality IS NOT NULL AND ipcr_daily_accomplishments.quality != "" THEN ipcr_daily_accomplishments.quality ELSE 0 END) AS total_quality'),
            DB::raw('ROUND(CASE WHEN COUNT(ipcr_daily_accomplishments.quality) > 0 THEN SUM(CASE WHEN ipcr_daily_accomplishments.quality IS NOT NULL AND ipcr_daily_accomplishments.quality != "" THEN ipcr_daily_accomplishments.quality ELSE 0 END) / COUNT(ipcr_daily_accomplishments.quality) ELSE 0 END, 0) AS quality_average'),
            DB::raw('ROUND(AVG(CASE WHEN ipcr_daily_accomplishments.timeliness IS NOT NULL AND ipcr_daily_accomplishments.timeliness != "" THEN ipcr_daily_accomplishments.timeliness ELSE 0 END), 0) AS average_timeliness'),
            DB::raw('SUM(CASE WHEN ipcr_daily_accomplishments.timeliness IS NOT NULL AND ipcr_daily_accomplishments.timeliness != "" THEN ipcr_daily_accomplishments.timeliness ELSE 0 END) AS timeliness_total'),
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
            ->join('i_p_c_r_targets', 'ipcr_daily_accomplishments.idIPCR', '=', 'i_p_c_r_targets.ipcr_code')
            ->join('ipcr__semestrals', 'i_p_c_r_targets.ipcr_semester_id', '=', 'ipcr__semestrals.id')
            ->where('ipcr__semestrals.year', $year)
            ->where('i_p_c_r_targets.semester', $sem)
            ->where('i_p_c_r_targets.ipcr_type', $request->type)
            ->groupBy('ipcr_daily_accomplishments.idIPCR')
            ->get();

        foreach ($data as $key => $value) {
            if ($value->quantity_type = 1) {
                if ($value->Percentage >= 130) {
                    $value->Score = "5.00";
                } else if ($value->Percentage <= 129 && $value->Percentage >= 115) {
                    $value->Score = "4.00";
                } else if ($value->Percentage <= 114 && $value->Percentage >= 90) {
                    $value->Score = "3.00";
                } else if ($value->Percentage <= 89 && $value->Percentage >= 51) {
                    $value->Score = "2.00";
                } else if ($value->Percentage <= 50) {
                    $value->Score = "1.00";
                } else {
                    $value->Score = 0.00;
                }
            } else if ($value->quantity_type = 2) {
                if ($value->Percentage = 100) {
                    $value->Score = 5.00;
                } else {
                    $value->Score = 2.00;
                }
            }

            if ($value->quantity_type = 1) {
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
                    $time_range5 = TimeRange::where('time_code', $value->time_range_code)->get();
                    // $value->TimeRange5 = $time_range5;
                    // dd($time_range5[1]);
                    //5
                    if ($value->average_timeliness <= $time_range5[0]->equivalent_time_from) {
                        $value->TimeRating = 5;
                        $value->time_unit = $time_range5[0]->time_unit;
                        $value->prescribed_period = $time_range5[0]->prescribed_period;
                    } else if (
                        $value->average_timeliness >= $time_range5[4]->equivalent_time_from
                    ) {
                        $value->TimeRating = 1;
                        $value->time_unit = $time_range5[4]->time_unit;
                        $value->prescribed_period = $time_range5[4]->prescribed_period;
                    } else if (
                        $value->average_timeliness >= $time_range5[3]->equivalent_time_from
                    ) {
                        $value->TimeRating = 2;
                        $value->time_unit = $time_range5[3]->time_unit;
                        $value->prescribed_period = $time_range5[3]->prescribed_period;
                    } else if (
                        $value->average_timeliness >= $time_range5[2]->equivalent_time_from
                    ) {
                        $value->TimeRating = 3;
                        $value->time_unit = $time_range5[2]->time_unit;
                        $value->prescribed_period = $time_range5[2]->prescribed_period;
                    } else if ($value->average_timeliness >= $time_range5[1]->equivalent_time_from) {
                        $value->TimeRating = 4;
                        $value->time_unit = $time_range5[1]->time_unit;
                        $value->prescribed_period = $time_range5[1]->prescribed_period;
                    }
                }
            }
        }
        return $data;
    }
    public function MonthlyPrintMain(Request $request)
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
            'individual_final_outputs.performance_measure',
            'major_final_outputs.mfo_desc',
            'division_outputs.output as division_output',
            'i_p_c_r_targets.ipcr_type',
            'i_p_c_r_targets.ipcr_semester_id',
            'i_p_c_r_targets.semester',
            "i_p_c_r_targets.month_$months as month",
            'ipcr__semestrals.year',
            DB::raw("ROUND((SUM(ipcr_daily_accomplishments.quantity) / i_p_c_r_targets.month_$months) * 100) as Percentage"),
            DB::raw('COUNT(ipcr_daily_accomplishments.quality) as NumberofQuality'),
            DB::raw('SUM(CASE WHEN ipcr_daily_accomplishments.quality IS NOT NULL AND ipcr_daily_accomplishments.quality != "" THEN ipcr_daily_accomplishments.quality ELSE 0 END) AS total_quality'),
            DB::raw('ROUND(CASE WHEN COUNT(ipcr_daily_accomplishments.quality) > 0 THEN SUM(CASE WHEN ipcr_daily_accomplishments.quality IS NOT NULL AND ipcr_daily_accomplishments.quality != "" THEN ipcr_daily_accomplishments.quality ELSE 0 END) / COUNT(ipcr_daily_accomplishments.quality) ELSE 0 END, 0) AS quality_average'),
            DB::raw('ROUND(AVG(CASE WHEN ipcr_daily_accomplishments.timeliness IS NOT NULL AND ipcr_daily_accomplishments.timeliness != "" THEN ipcr_daily_accomplishments.timeliness ELSE 0 END), 0) AS average_timeliness'),
            DB::raw('SUM(CASE WHEN ipcr_daily_accomplishments.timeliness IS NOT NULL AND ipcr_daily_accomplishments.timeliness != "" THEN ipcr_daily_accomplishments.timeliness ELSE 0 END) AS timeliness_total'),
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
            ->join('i_p_c_r_targets', 'ipcr_daily_accomplishments.idIPCR', '=', 'i_p_c_r_targets.ipcr_code')
            ->join('ipcr__semestrals', 'i_p_c_r_targets.ipcr_semester_id', '=', 'ipcr__semestrals.id')
            ->where('ipcr__semestrals.year', $year)
            ->where('i_p_c_r_targets.semester', $sem)
            ->where('i_p_c_r_targets.ipcr_type', $request->type)
            ->groupBy('ipcr_daily_accomplishments.idIPCR')
            ->get();

        foreach ($data as $key => $value) {
            if ($value->quantity_type = 1) {
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
            } else if ($value->quantity_type = 2) {
                if ($value->Percentage = 100) {
                    $value->Score = 5;
                } else {
                    $value->Score = 2;
                }
            }

            if ($value->quantity_type = 1) {
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
                    $time_range5 = TimeRange::where('time_code', $value->time_range_code)->get();
                    // $value->TimeRange5 = $time_range5;
                    // dd($time_range5[1]);
                    //5
                    if ($value->average_timeliness <= $time_range5[0]->equivalent_time_from) {
                        $value->TimeRating = 5;
                        $value->time_unit = $time_range5[0]->time_unit;
                        $value->prescribed_period = $time_range5[0]->prescribed_period;
                    } else if (
                        $value->average_timeliness >= $time_range5[4]->equivalent_time_from
                    ) {
                        $value->TimeRating = 1;
                        $value->time_unit = $time_range5[4]->time_unit;
                        $value->prescribed_period = $time_range5[4]->prescribed_period;
                    } else if (
                        $value->average_timeliness >= $time_range5[3]->equivalent_time_from
                    ) {
                        $value->TimeRating = 2;
                        $value->time_unit = $time_range5[3]->time_unit;
                        $value->prescribed_period = $time_range5[3]->prescribed_period;
                    } else if (
                        $value->average_timeliness >= $time_range5[2]->equivalent_time_from
                    ) {
                        $value->TimeRating = 3;
                        $value->time_unit = $time_range5[2]->time_unit;
                        $value->prescribed_period = $time_range5[2]->prescribed_period;
                    } else if ($value->average_timeliness >= $time_range5[1]->equivalent_time_from) {
                        $value->TimeRating = 4;
                        $value->time_unit = $time_range5[1]->time_unit;
                        $value->prescribed_period = $time_range5[1]->prescribed_period;
                    }
                }
            }
        }
        return $data;
    }
}
