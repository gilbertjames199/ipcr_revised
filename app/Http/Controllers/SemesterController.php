<?php

namespace App\Http\Controllers;

use App\Models\Daily_Accomplishment;
use App\Models\Division;
use App\Models\FFUNCCOD;
use App\Models\IndividualFinalOutput;
use App\Models\Ipcr_Semestral;
use App\Models\IpcrScore;
use App\Models\IPCRTargets;
use App\Models\MonthlyAccomplishment;
use App\Models\Office;
use App\Models\ReturnRemarks;
use App\Models\SemestralRemarks;
use App\Models\TimeRange;
use App\Models\UserEmployees;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SemesterController extends Controller
{
    private $model;
    public function __construct(Daily_Accomplishment $model)
    {
        $this->model = $model;
    }

    public function semestral(Request $request, $sem_id)
    {
        // dd($request->id_shown);
        $id = auth()->user()->username;
        // dd($id);
        $emp = UserEmployees::where('empl_id', $id)
            ->first();
        // dd($emp);
        $emp_code = $emp->empl_id;
        $division = "";
        $TimeRating = $request->TimeRating;
        $prescribed_period = '';
        $time_unit = '';
        if ($emp->division_code) {
            //dd($emp->division_code);
            $division = Division::where('division_code', $emp->division_code)
                ->first()->division_name1;
        }
        $office = FFUNCCOD::where('department_code', $emp->department_code)->first();
        $dept = Office::where('department_code', $emp->department_code)->first();
        $pgHead = UserEmployees::where('empl_id', $dept->empl_id)->first();
        $suff = "";
        $post = "";
        if (isset($pgHead->suffix_name) && $pgHead->suffix != "") {
            $suff = ', ' . $pgHead->suffix_name;
        }
        if (isset($pgHead->postfix_name) && $pgHead->suffix != "") {
            $post = ', ' . $pgHead->postfix_name;
        }
        $pgHead = $pgHead->first_name . ' ' . $pgHead->middle_name[0] . '. ' . $pgHead->last_name . '' . $suff . '' . $post;
        // dd($emp_code);
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
                        DB::raw('SUM(A.average_timeliness) as TotalAverage'),
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


        $sem = Ipcr_Semestral::where('employee_code', $emp_code)
            ->where('id', $sem_id)
            ->where('status', '2')
            ->orderBy('year', 'asc')
            ->orderBy('sem', 'asc')
            ->first();
        // dd($sem);
        // dd($sem->status_accomplishment);
        if ($sem) {
            $rem = ReturnRemarks::where('ipcr_semestral_id', $sem->id)
                ->orderBy('created_at', 'DESC')
                ->first();
            $immediate = UserEmployees::where('empl_id', $sem->immediate_id)
                ->first();
            $next_higher = UserEmployees::where('empl_id', $sem->next_higher)
                ->first();

            $sem_data = [
                'id' => $sem->id,
                'employee_code' => $sem->employee_code,
                'immediate_id' => $sem->immediate_id,
                'next_higher' => $sem->next_higher,
                "imm" => $immediate,
                "next" => $next_higher,
                'sem' => $sem->sem,
                'status' => $sem->status,
                'status_accomplishment' => $sem->status_accomplishment,
                'year' => $sem->year,
                'rem' => $rem
            ];

            // Now you can use $mapped_data as needed
        }

        // dd($sem_data);
        //return inertia('IPCR/Semestral/Index');
        $dept = Office::where('department_code', auth()->user()->department_code)->first();
        return inertia('Semestral_Accomplishment/Index', [
            "id" => $id,
            "data" => $data,
            "sem_data" => $sem_data,
            "sem_id" => $sem_id,
            "division" => $division,
            "emp" => $emp,
            "dept" => $dept,
            "pghead" => $pgHead
        ]);
    }

    public function store(Request $request)
    {
        $sem_id = $request->idSemestral;
        // dd($month);
        // dd($request->all());
        // dd($request);
        SemestralRemarks::create($request->all());

        return redirect('semester-accomplishment/semestral/accomplishment/' . $sem_id)
            ->with('message', 'Remarks added');
    }

    public function update(Request $request)
    {

        $sem_id = $request->idSemestral;

        $data = SemestralRemarks::findOrFail($request->id);

        $data->update([
            'remarks' => $request->remarks,
        ]);
        return redirect('semester-accomplishment/semestral/accomplishment/' . $sem_id)
            ->with('info', 'Remarks updated');
    }

    public function destroy(Request $request)
    {
        $data = SemestralRemarks::findOrFail($request->id);
        $sem_id = $data->idSemestral;
        $data->delete();

        return redirect('semester-accomplishment/semestral/accomplishment/' . $sem_id)
            ->with('info', 'Remarks deleted');
        //dd($request->raao_id);
        // return redirect('/Daily_Accomplishment')->with('warning', 'Accomplishment Deleted');
    }

    public function semester_print(Request $request)
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
                "Average_Point" => $request->Average_Point_Core,
                "Multiply" => 70,
                "Average_Score_Function" => $request->Average_Point_Core * .70,
                "Total_Average_Score" => ($request->Average_Point_Core * .70) + ($request->Average_Point_Support * .30)
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
                "Average_Point" => $request->Average_Point_Support,
                "Multiply" => 30,
                "Average_Score_Function" => $request->Average_Point_Support * .30,
                "Total_Average_Score" => ($request->Average_Point_Core * .70) + ($request->Average_Point_Support * .30)
            ]
        ];
        return $arr;
    }

    public function semester_print_score(Request $request)
    {
        // dd($request->idsemestral);
        $emp_code = $request->emp_code;
        $sem_id = $request->idsemestral;
        $Total = 0;
        $data = IndividualFinalOutput::select(
            'individual_final_outputs.ipcr_code',
            'individual_final_outputs.activity',
            'individual_final_outputs.verb',
            'individual_final_outputs.error_feedback',
            'individual_final_outputs.within',
            'individual_final_outputs.unit_of_time',
            'individual_final_outputs.concatenate',
            'i_p_c_r_targets.id',
            'i_p_c_r_targets.ipcr_type',
            'i_p_c_r_targets.quantity_sem',
            'i_p_c_r_targets.ipcr_semester_id',
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
            DB::raw("'$Total' AS TotalQuantity")
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
            ->where('i_p_c_r_targets.ipcr_type', $request->type)
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
                        DB::raw('ROUND(SUM(A.average_timeliness) / SUM(A.quantity)) AS average_timeliness'),
                        DB::raw('ROUND(MNO.total_timeXX) as total_timeliness'),
                        DB::raw('(
                            SELECT SUM(X.quantity)
                            FROM ipcr_daily_accomplishments X
                            WHERE X.sem_id = A.sem_id
                            AND X.idIPCR = A.idIPCR
                        ) as sum_all_quantity'),
                        DB::raw('(
                            SELECT COUNT(MNX.monthX)
                            FROM (
                                SELECT MONTH(A.date) AS monthX
                                FROM ipcr_daily_accomplishments A
                                WHERE A.sem_id = 32
                                AND A.idIPCR = 23
                                GROUP BY MONTH(A.date)
                            ) AS MNX
                        ) AS month_count'),
                        DB::raw('ROUND(MN.average_qualityXX) AS sum_all_quality')
                    )
                    ->join(DB::raw('(SELECT SUM(MNX.average_qualityX) AS average_qualityXX, MNX.sem_idX, MNX.idIPCRX FROM (SELECT
                        (SUM(X.quality)/COUNT(X.quality)) AS average_qualityX,
                        X.idIPCR AS idIPCRX,
                        X.sem_id AS sem_idX,
                        MONTH(X.date) AS xmont
                    FROM ipcr_daily_accomplishments X
                    GROUP BY X.idIPCR, X.sem_id, MONTH(X.date)) MNX
                    GROUP BY MNX.sem_idX, MNX.idIPCRX) MN'), function ($join) {
                        $join->on('MN.idIPCRX', '=', 'A.idIPCR')->on('MN.sem_idX', '=', 'A.sem_id');
                    })
                    ->join(DB::raw('(SELECT SUM(MNX.total_timeX) AS total_timeXX, MNX.sem_idX, MNX.idIPCRX FROM (SELECT
                        (SUM(X.quantity) * SUM(X.timeliness)) AS total_timeX,
                        X.idIPCR AS idIPCRX,
                        X.sem_id AS sem_idX,
                        MONTH(X.date) AS xmont
                    FROM ipcr_daily_accomplishments X
                    GROUP BY X.idIPCR, X.sem_id, MONTH(X.date)) MNX
                    GROUP BY MNX.sem_idX, MNX.idIPCRX) MNO'), function ($join) {
                        $join->on('MNO.idIPCRX', '=', 'A.idIPCR')->on('MNO.sem_idX', '=', 'A.sem_id');
                    })
                    ->where('sem_id', $sem_id)
                    ->where('idIPCR', $item->ipcr_code)
                    ->groupBy(DB::raw('MONTH(date)'))
                    ->orderBy(DB::raw('MONTH(date)'), 'ASC')
                    ->get();


                // dd(count($result));
                $sum_all_quantity = 0;
                $sum_all_quality = 0;
                $ave_time = 0;
                $QuantityRating = 0;
                $QualityRating = 0;
                $TimelinessRating = 0;
                $QualityNotZero = 0;
                $total_sum = 0;
                for ($x = 0; $x < count($result); $x++) {
                    $sum_all_quantity = $result[$x]->sum_all_quantity;
                    $sum_all_quality = $result[$x]->sum_all_quality;
                    $ave_time = $ave_time + $result[$x]->average_timeliness * $result[$x]->quantity;
                    if ($result[$x]->quality != 0) {
                        $QualityNotZero = $QualityNotZero + 1;
                    }
                }

                $quantity = $item->quantity_sem;
                if ($quantity == 0) {
                    $quantity = 1;
                }
                if (count($result) == 0) {
                    $QuantityRating = 0;
                } else {
                    if ($item->quantity_type == 1) {
                        if ($sum_all_quantity == 0) {
                            $QuantityRating = 1;
                        } else {
                            $percetage = ROUND(($sum_all_quantity / $quantity) * 100);
                            if ($percetage >= 130) {
                                $QuantityRating = 5;
                            } else if ($percetage <= 129 && $percetage >= 115) {
                                $QuantityRating = 4;
                            } else if ($percetage <= 114 && $percetage >= 90) {
                                $QuantityRating = 3;
                            } else if ($percetage <= 89 && $percetage >= 51) {
                                $QuantityRating = 2;
                            } else if ($percetage <= 50) {
                                $QuantityRating = 1;
                            }
                        }
                    } else if ($item->quantity_type == 2) {
                        if ($sum_all_quantity == $quantity) {
                            $QuantityRating = 5;
                        } else {
                            $QuantityRating = 2;
                        }
                    }
                }

                if ($total_sum == 0) {
                    $total_sum = 1;
                }


                $count = count($result);
                if ($count == 0) {
                    $count = 1;
                }
                if (count($result) == 0) {
                    $QualityRating = 0;
                } else {
                    if ($item->quality_error == 1) {
                        if ($sum_all_quality == 0) {
                            $QualityRating = 5;
                        } else if ($sum_all_quality >= .01 && $sum_all_quality <= 2.99) {
                            $QualityRating = 4;
                        } else if ($sum_all_quality >= 3 && $sum_all_quality <= 4.99) {
                            $QualityRating = 3;
                        } else if ($sum_all_quality >= 5 && $sum_all_quality <= 6.99) {
                            $QualityRating = 2;
                        } else if ($sum_all_quality >= 7) {
                            $QualityRating = 1;
                        }
                    } else if ($item->quality_error == 2) {
                        if ($sum_all_quality == 0) {
                            $sum_all_quality = 1;
                        }
                        $total_sum = ROUND($sum_all_quality / $count);
                        if ($total_sum == 5) {
                            $QualityRating = 5;
                        } else if ($total_sum >= 4 && $total_sum <= 4.99) {
                            $QualityRating = 4;
                        } else if ($total_sum >= 3 && $total_sum <= 3.99) {
                            $QualityRating = 3;
                        } else if ($total_sum >= 2 && $total_sum <= 2.99) {
                            $QualityRating = 2;
                        } else if ($total_sum >= 1 && $total_sum <= 1.99) {
                            $QualityRating = 1;
                        }
                    } else if ($item->quality_error == 3) {
                        $QualityRating = 0;
                    } else if ($item->quality_error == 4) {
                        $total_sum = ROUND($sum_all_quality / $count);
                        if ($total_sum >= 1) {
                            $QualityRating = 2;
                        } else {
                            $QualityRating = 5;
                        }
                    }
                }
                $ave_feedback = "";
                if ($item->error_feedback == " ") {
                    if ($QualityRating == 5) {
                        $ave_feedback = "Outstanding Feedback";
                    } else if ($QualityRating == 4) {
                        $ave_feedback = "Very Satisfactory Feedback";
                    } else if ($QualityRating == 3) {
                        $ave_feedback = "Satisfactory Feedback";
                    } else if ($QualityRating == 2) {
                        $ave_feedback = "Unsatisfactory Feedback";
                    } else if ($QualityRating == 1) {
                        $ave_feedback = "Poor Feedback";
                    }
                } else {
                    if ($sum_all_quality == 0) {
                        $ave_feedback = "No " . $item->error_feedback;
                    } else {
                        $ave_feedback = (string)$sum_all_quality . " " . $item->error_feedback;
                    }
                }

                $data = TimeRange::where('time_code', $item->time_range_code)
                    ->get();
                if ($ave_time == 0) {
                    $ave_times = 0;
                } else {
                    $ave_times = ROUND($ave_time / $sum_all_quantity);
                }


                $TimeRange = $item->time_range_code;

                if ($TimeRange == 56) {
                    $TimelinessRating = null;
                } else {
                    foreach ($data as $key => $value) { {
                            if ($ave_times <= $value->equivalent_time_from && $value->rating == 5) {
                                $TimelinessRating = 5;
                            } else if ($ave_times >= $value->equivalent_time_from && $ave_times <= $value->equivalent_time_to && $value->rating == 4) {
                                $TimelinessRating = 4;
                            } else if ($ave_times == $value->equivalent_time_from && $value->rating == 3) {
                                $TimelinessRating = 3;
                            } else if ($ave_times >= $value->equivalent_time_from && $ave_times <= $value->equivalent_time_to && $value->rating == 2) {
                                $TimelinessRating = 2;
                            } else if ($ave_times >= $value->equivalent_time_from && $value->rating == 1) {
                                $TimelinessRating = 1;
                            } else if ($ave_times == 0) {
                                $TimelinessRating = 0;
                            }
                        }
                    }
                }

                if ($TimelinessRating == null) {
                    $Time = 0;
                    $ratings = [$QuantityRating, $QualityRating, $Time];

                    $floatRating = array_map('floatval', $ratings);

                    $nonZero = array_filter($floatRating, function ($floatRating) {
                        return $floatRating != 0;
                    });


                    if (empty($nonZero)) {
                        $averageRating = 0;
                    } else {
                        $averageRating = array_sum($nonZero) / count($nonZero);
                        $averageRating = number_format($averageRating, 2);
                    }
                } else {
                    $ratings = [$QuantityRating, $QualityRating, $TimelinessRating];

                    $floatRating = array_map('floatval', $ratings);

                    $nonZero = array_filter($floatRating, function ($floatRating) {
                        return $floatRating != 0;
                    });


                    if (empty($nonZero)) {
                        $averageRating = 0;
                    } else {
                        $averageRating = array_sum($nonZero) / count($nonZero);
                        $averageRating = number_format($averageRating, 2);
                    }
                }


                // dd($averageRating);



                return [
                    "TimeRange" => $data,
                    "result" => $result,
                    "ipcr_code" => $item->ipcr_code,
                    "activity" => $item->activity,
                    "verb" => $item->verb,
                    "error_feedback" => $ave_feedback,
                    "within" => $item->within,
                    "unit_of_time" => $item->unit_of_time,
                    "concatenate" => $item->concatenate,
                    "id" => $item->id,
                    "ipcr_type" => $item->ipcr_type,
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
                    "sum_all_quantity" => $sum_all_quantity,
                    // "sum_all_quality" => $sum_all_quality,
                    "TotalTimeliness" => $ave_time,
                    "ave_time" => $ave_times,
                    "AverageRate" => $averageRating,
                    "QuantityRating" => $QuantityRating,
                    "QualityRating" => $QualityRating,
                    "TimelinessRating" => $TimelinessRating,
                    "remarks" => $item->remarks,
                    "remarks_id" => $item->remarks_id,
                ];
            });
        // dd($data);
        return $data;
    }

    public function api_ipcr(Request $request)
    {
        $emp_code = $request->emp_code;
        $status = 2;
        $current_date = date('Y-m-d');

        $current_month = date('n'); // Get the current month (01-12)
        $current_year = date('Y');

        $currentSem = 0;
        $months = $current_month;
        if ($current_month > 6) {
            $months = $current_month - 6;
        }

        // dd($months);
        if ($current_month < 7) {
            $currentSem  = 1;
        } else {
            $currentSem = 2;
        }

        $data = IPCRTargets::select(
            'i_p_c_r_targets.id',
            'i_p_c_r_targets.ipcr_code',
            "i_p_c_r_targets.month_$months as quantity_sem",
            'individual_final_outputs.individual_output',
            DB::raw('CONCAT(individual_final_outputs.performance_measure, " (", i_p_c_r_targets.month_' . $months . ', ")") AS performance_measure'),
            'ipcr__semestrals.status',
        )
            ->leftJoin('individual_final_outputs', 'i_p_c_r_targets.ipcr_code', '=', 'individual_final_outputs.ipcr_code')
            ->leftJoin('ipcr__semestrals', 'i_p_c_r_targets.employee_code', '=', 'ipcr__semestrals.employee_code')
            ->where('i_p_c_r_targets.employee_code', $emp_code)
            ->where('i_p_c_r_targets.semester', $currentSem)
            ->where('i_p_c_r_targets.year', $current_year)
            ->where('ipcr__semestrals.status', $status)
            ->groupBy('individual_final_outputs.ipcr_code')
            ->orderBy('individual_final_outputs.ipcr_code')
            ->get();
        return $data;
    }

    public function getTimeRanges(Request $request)
    {
    }

    public function submitAccomplishment(Request $request, $id)
    {
        // dd("dddddd: " . $id);
        Ipcr_Semestral::where('id', $id)
            ->update([
                'status_accomplishment' => '0'
            ]);
        // return redirect('semester-accomplishment/semestral/accomplishment/' . $id)
        //     ->with('message', 'Successfully submitted semestral accomplishment!');
        return back()->with('message', 'Successfully submitted semestral accomplishment!');
    }
    public function recallAccomplishment(Request $request, $id)
    {
        Ipcr_Semestral::where('id', $id)
            ->update([
                'status_accomplishment' => '-1'
            ]);
        // return redirect('semester-accomplishment/semestral/accomplishment/' . $id)
        //     ->with('message', 'Successfully submitted semestral accomplishment!');
        return back()->with('message', 'Recall successful!');
    }
}
