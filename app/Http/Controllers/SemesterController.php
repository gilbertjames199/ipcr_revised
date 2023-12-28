<?php

namespace App\Http\Controllers;

use App\Models\Daily_Accomplishment;
use App\Models\Division;
use App\Models\IndividualFinalOutput;
use App\Models\Ipcr_Semestral;
use App\Models\MonthlyAccomplishment;
use App\Models\ReturnRemarks;
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
        // dd($emp_code);
        $data = IndividualFinalOutput::select(
            'individual_final_outputs.ipcr_code',
            'i_p_c_r_targets.id',
            'i_p_c_r_targets.ipcr_type',
            'i_p_c_r_targets.quantity_sem',
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
            DB::raw("'$TimeRating' AS TimeRating"),
        )
            ->leftjoin('time_ranges', 'time_ranges.time_code', 'individual_final_outputs.time_range_code')
            ->leftjoin('division_outputs', 'division_outputs.id', 'individual_final_outputs.id_div_output')
            ->leftjoin('divisions', 'divisions.id', 'division_outputs.division_id')
            ->leftjoin('major_final_outputs', 'major_final_outputs.id', 'division_outputs.idmfo')
            ->leftjoin('sub_mfos', 'sub_mfos.id', 'individual_final_outputs.idsubmfo')
            ->leftjoin('i_p_c_r_targets', 'i_p_c_r_targets.ipcr_code', 'individual_final_outputs.ipcr_code')
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
                        DB::raw('(SELECT SUM(X.quantity) FROM ipcr_daily_accomplishments X
                        WHERE X.sem_id = A.sem_id
                        AND X.idIPCR = A.idIPCR) AS sum_all_quantity'),
                        DB::raw('(SELECT SUM(X.quality) FROM ipcr_daily_accomplishments X
                        WHERE X.sem_id = A.sem_id
                        AND X.idIPCR = A.idIPCR) AS sum_all_quality'),
                        DB::raw('(SELECT COUNT(MNX.monthX) FROM (SELECT
                        MONTH(A.date)  AS monthX
                        FROM ipcr_daily_accomplishments A
                        WHERE A.sem_id = 3
                        AND   A.idIPCR = 1367
                        GROUP BY MONTH(A.date)
                        ) AS MNX) AS month_count')
                    )
                    ->where('sem_id', $sem_id)
                    ->where('idIPCR', $item->ipcr_code)
                    ->groupBy(DB::raw('MONTH(date)'))
                    ->orderBy(DB::raw('MONTH(date)'), 'ASC')
                    ->get();

                $data = TimeRange::where('time_code', $item->time_range_code)
                    ->get();

                return [
                    "TimeRange" => $data,
                    "result" => $result,
                    "ipcr_code" => $item->ipcr_code,
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
                ];
            });
        // foreach ($data as $key => $value) {
        //     dd($value);
        //     if ($value['time_range_code'] > 0 && $value['time_range_code'] < 47) {
        //         if ($value['time_based'] == 1) {
        //             $time_range5 = TimeRange::where('time_code', $value['time_range_code'])->orderBY('rating', 'DESC')->get();
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
        $sem_data = Ipcr_Semestral::where('employee_code', $emp_code)
            ->where('id', $sem_id)
            ->where('status', '2')
            ->orderBy('year', 'asc')
            ->orderBy('sem', 'asc')
            ->first();

        // dd($sem_data);
        //dd($source);
        //return inertia('IPCR/Semestral/Index');
        return inertia('Semestral_Accomplishment/Index', [
            "id" => $id,
            "data" => $data,
            "sem_data" => $sem_data,
            "division" => $division,
            "emp" => $emp,
            // "id_shown" => $id_shown
        ]);
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
    }

    public function getTimeRanges(Request $request)
    {
        // dd($request->Ave_Time);

    }
}
