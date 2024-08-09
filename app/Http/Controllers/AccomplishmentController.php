<?php

namespace App\Http\Controllers;

use App\Models\Daily_Accomplishment;
use App\Models\Division;
use App\Models\EmployeeSpecialDepartment;
use App\Models\FFUNCCOD;
use App\Models\IndividualFinalOutput;
use App\Models\Ipcr_Semestral;
use App\Models\MonthlyAccomplishment;
use App\Models\MonthlyAccomplishmentRating;
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
        // dd($request->ipcr_semestral_id);
        $ipcr_semestral_id = $request->ipcr_semestral_id;
        $emp_code = Auth()->user()->username;
        $emp = Auth()->user()->userEmployee;

        // $month = Carbon::parse($request->month)->month;
        $month = $this->monthNameToNumber($request->month);
        $year = $request->year;
        // dd($request->month);
        $div = auth()->user()->division_code;

        $mo2 = $month;
        $semt = 1;
        if ($mo2 > 6) {
            $mo2 = intval($mo2) - 6;
            $semt = 2;
        }
        // dd($ipcr_semestral_id);
        // dd($year);
        // dd($month);
        $data = Daily_Accomplishment::with([
            'individualFinalOutput',
            'ipcrTarget' => function ($query) use ($emp_code, $semt, $year, $ipcr_semestral_id) {
                $query->where('i_p_c_r_targets.employee_code', '=', $emp_code)
                    // ->where('semester', $semt)
                    ->where('i_p_c_r_targets.ipcr_semester_id', $ipcr_semestral_id);
            },
            'ipcr_Semestral.immediate.Division',
            'ipcr_Semestral.next_higher1.Division',
            'monthlyAccomplishmentMany' => function ($query) use ($month) {
                $query->where('ipcr_monthly_accomplishments.month', '=', $month);
            },
            'monthlyAccomplishmentMany.returnRemarks'
        ])
            ->where('emp_code', $emp_code)
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->where('sem_id', $ipcr_semestral_id)
            // ->where('sem_id', $ipcr_semestral_id)
            // ->select()
            ->orderBy('idIPCR', 'ASC')
            ->get()
            ->groupBy('idIPCR')
            ->map(fn ($item, $key) => [
                // DB::raw('ROUND(SUM(ipcr_daily_accomplishments.average_timeliness) / SUM(ipcr_daily_accomplishments.quantity)) as Final_Average_Timeliness'),

                // if($item[0]->idIPCR){}(dd($item[0]->idIPCR),
                // dd($item[0]['ipcrTarget']->ipcr_Semestral),
                // dd($item[0]['individualFinalOutput']->majorFinalOutputs),
                // 'total_qty' => $item->sum('quantity'),
                // 'ipcr_code' => $key,
                // 'quality_average' => number_format($item->sum('quality') / $item->count(), 2),
                // dd($item),
                // dd('year: ' . $year . ' sem:' . $semt),
                // dd($item[0]['ipcrTarget']->ipcr_type),
                // dd($item[0]['ipcrTarget']->semester),
                // "dd" => $item[0]->idIPCR == '1724' ? dd($item) : '',
                // dd($item[0]['ipcrTarget']["month_" . $mo2]),
                // "month_" . $mo2 => $item[0]['ipcrTarget']["month_" . $mo2],
                // ($key == 124) ? dd($item) : '',
                // !$item[0]['ipcrTarget'] ? dd($item[0]) : '',
                // ($item->count() > 0) ? number_format($item->sum('quality') / $item->count(), 0) : 0)
                // ($key == '6') ? dd(($item->count() > 0) ? number_format($item->sum('quality') / $item->count(), 2) : '0') : '',
                // dd($item),
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
                // dd($item[0]['monthlyAccomplishmentMany'][0]->return_remarks),
                // "remarks" => $item[0]['monthlyAccomplishmentMany'] ? ($item[0]['monthlyAccomplishment'][0] ? $item[0]['monthlyAccomplishment'][0]->returnRemarks->remarks : '') : '',
                // "remarks_id" =>  $item[0]['monthlyAccomplishmentMany'] ? ($item[0]['monthlyAccomplishment'][0] ? $item[0]['monthlyAccomplishment'][0]->returnRemarks->id : '') : '',
                // dd($item[0]['monthlyAccomplishmentMany'][0]->returnRemarks),
                // dd($item[0]['monthlyAccomplishmentMany'][0]->returnRemarks),
                "remarks" => $item[0]['monthlyAccomplishmentMany'][0]->returnRemarks ? $item[0]['monthlyAccomplishmentMany'][0]->returnRemarks->remarks : '',
                "remarks_id" => $item[0]['monthlyAccomplishmentMany'][0]->returnRemarks ? $item[0]['monthlyAccomplishmentMany'][0]->returnRemarks->id : '',
                "output" => $item[0]['individualFinalOutput']->divisionOutput->output,
                "ipcr_type" => $item[0]['ipcrTarget'] ? $item[0]['ipcrTarget']->ipcr_type : "",
                "ipcr_semester_id" => $item[0]['ipcrTarget'] ? $item[0]['ipcrTarget']->ipcr_semester_id : '',
                "semester" => $item[0]['ipcrTarget'] ? $item[0]['ipcrTarget']->semester : '',
                "month" => $item[0]['ipcrTarget'] ? (($item[0]['ipcrTarget']["month_" . $mo2] > 0) ? $item[0]['ipcrTarget']["month_" . $mo2] : 0) : '',
                "year" => $year,
                "NumberofQuality" => $item->count(),
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
                // ($item[0]['monthlyAccomplishmentMany']) ? '' : dd($item[0]['monthlyAccomplishmentMany']),
                // "monthly_accomp" => $item[0]['monthlyAccomplishmentMany'] ? $item[0]['monthlyAccomplishmentMany'][0] : '',
                // $this->getSelectedMonth($item[0]['monthlyAccomplishmentMany'], $month),  1672, 1638
                // ('1' == '1' ? dd('23232') : ''),
                // dd($item[0]['sem_id']),
                // dd('434234234234234'),    ['monthlyAccomplishmentMany']
                // ($item[0]['idIPCR'] == '1684') ? dd($item[0]) : '',
                "monthly_accomp" => $item[0]['monthlyAccomplishmentMany'][0],
                "sem_id" => $item[0]->sem_id,
                "imm" => $item[0]['ipcr_Semestral']->immediate,
                "next" => $item[0]['ipcr_Semestral']->next_higher1,
                'sem_data' => $item[0]['ipcr_Semestral']
            ])
            ->values();
        // dd($data->pluck('month'));
        // dd(count($data));
        // dd($data->pluck('idIPCR'));
        if (count($data) > 0) {
            $us = auth()->user()->load([
                'userEmployee.Division',
                'userEmployee.Office',
                'userEmployee.Office.pgHead',
                'employeeSpecialDepartment',
                'employeeSpecialDepartment.Office',
                'employeeSpecialDepartment.PGDH',
            ]);
            // dd($us);
            $office = "";

            $mo = $data[0];
            // dd($data[0]);
            $div = "";
            $div = $us->userEmployee->Division;
            $immh = $mo['imm'];
            $nxth = $mo['next'];
            $div = $this->getDivision($div, $immh, $nxth);
            $rm = '';
            if ($mo['monthly_accomp']->returnRemarks) {
                $rm = $mo['monthly_accomp']->returnRemarks->remarks;
            }
            $my_stat = $mo['monthly_accomp']->status;
            // dd($my_stat);
            $my_sem_id = $mo['sem_id'];
            $mo_data = [
                "id" => $mo['monthly_accomp']->id,
                "division" => $div,
                "employee_code" => $emp->empl_id,
                "imm" => $immh,
                "next" => $nxth,
                "sem" => $mo['sem_data']->sem,
                "status" => $my_stat,
                "year" => $year,
                "rem" => $rm
            ];

            $off_pg = $this->getOffice($us);
            $office = $off_pg['office'];
            $pgHead = $off_pg['pgHead'];
            $dept = $office;

            return inertia('Monthly_Accomplishment/Index', [
                // "data" => $data,
                "emp_code" => $emp_code,
                "month" => $request->month,
                "year" => $year,
                "data" => $data,
                "month_data" => $mo_data,
                "office" => $office,
                "dept" => $dept,
                "pgHead" => $this->getPGDH($pgHead),
                'sem_id' => $my_sem_id,
                "status" => $my_stat,
                // "sel_month"=>
            ]);
        } else {
            $per = $request->month . ', ' . $year;
            return redirect()->back()->with('error', 'Accomplishments for ' . $per . ' is empty');
        }
    }
    public function getSelectedMonth($month, $monum)
    {
        // dd('monthhh');
        // dd($month);
        // foreach ($month as $mo) {
        //     dd($mo);
        //     // if ($mo->month == $monum) {

        //     //     dd($mo->status);
        //     // }
        // }
        return 1;
    }
    // private function getMonthValue($target, $month){
    //     $month
    // }
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
    public function semestral_monthly(Request $request)
    {
        $id = auth()->user()->username;
        $emp = auth()->user()->userEmployee;
        $emp_code = $emp->empl_id;
        $sem_data = Ipcr_Semestral::with([
            'monthly_accomplishment.returnRemarks'
        ])
            ->where('employee_code', $emp_code)
            ->where('status', '2')
            ->orderBy('year', 'asc')
            ->orderBy('sem', 'asc')
            ->get();

        $source = "direct";

        $div = "";
        if ($emp->Division) {
            $div = $emp->Division->division_name1;
        }

        return inertia('IPCR/Accomplishment/Index', [
            "id" => $id,
            "sem_data" => $sem_data,
            "division" => $div,
            "emp" => $emp,
            "source" => $source,
        ]);
    }

    public function summaryRating(Request $request)
    {
        $id = auth()->user()->username;
        $emp = auth()->user()->userEmployee;
        $emp_code = $emp->empl_id;
        $sem_data = Ipcr_Semestral::with([
            'monthly_accomplishment.returnRemarks'
        ])
            ->where('employee_code', $emp_code)
            ->where('status', '2')
            ->orderBy('year', 'asc')
            ->orderBy('sem', 'asc')
            ->get();

        $source = "direct";

        $div = "";
        if ($emp->Division) {
            $div = $emp->Division->division_name1;
        }

        return inertia('SummaryOfRating/Index', [
            "id" => $id,
            "sem_data" => $sem_data,
            "division" => $div,
            "emp" => $emp,
            "source" => $source,
        ]);
    }

    public function monthly(Request $request)
    {
        // dd($request->all());

        $office = $request->department_code;
        $month = $request->month;
        $date = Carbon::createFromFormat('F', $month);
        $monthNumber = $date->month;
        $year = $request->year;
        $sem_id = $request->ipcr_semestral_id;

        // dd($monthNumber);

        $mo2 = $monthNumber;
        $semt = 1;
        if ($mo2 > 6) {
            $mo2 = intval($mo2) - 6;
            $semt = 2;
        }

        // dd(($semt . " " . $office . " " . $year));
        $data = UserEmployees::with([
            'manySemestral' => function ($query) use ($year, $semt, $office) {
                $query->where('year', $year)
                    ->where('sem', $semt)
                    ->where('department_code', $office);
            },
            'manySemestral.monthRate' => function ($query) use ($year, $monthNumber) {
                $query->where('year', $year)
                    ->where('month', $monthNumber);
            }
        ])
            ->whereHas('manySemestral', function ($query) use ($office, $semt, $year) {
                $query->where('department_code', $office)
                    ->where('sem', $semt)
                    ->where('year', $year);
            })
            // ->where('department_code', $office)
            ->where('active_status', 'ACTIVE')
            ->where('salary_grade', '!=', 26)
            ->orderBy('first_name', 'ASC')
            ->get()
            ->map(function ($item, $key) {
                $numericalRating = $item->manySemestral->map(function ($semestral) {
                    return optional($semestral->monthRate)->first()->numerical_rating ?? 0;
                })->first() ?? 0;

                // dd($item->manySemestral);

                $adjectivalRating =
                    $item->manySemestral->map(function ($semestral) {
                        return optional($semestral->monthRate)->first()->adjectival_rating ?? "";
                    })->first() ?? "";

                $middleInitial = $item->middle_name ? $item->middle_name[0] . '.' : '';

                return [
                    'Fullname' => $item->first_name . " " . $middleInitial . " " . $item->last_name,
                    'numericalRating' => $numericalRating,
                    'adjectivalRating' => $adjectivalRating,
                ];
            });

        // dd($data);
        return inertia('SummaryOfRating/MonthlyRating', [
            "data" => $data,
            "month" => $month,
            "year" => $year,
            "office" => $request->department_code
        ]);
    }

    public function monthlyPrintSummary(Request $request)
    {
        // dd($request->all());
        $office = $request->department_code;
        $month = $request->month;
        $year = $request->year;


        if (!$office || !$month || !$year) {
            return [];
        }
        $date = Carbon::createFromFormat('F', $month);
        $monthNumber = $date->month;

        // $sem_id = $request->ipcr_semestral_id;

        // dd($monthNumber);

        $mo2 = $monthNumber;
        $semt = 1;
        if ($mo2 > 6) {
            $mo2 = intval($mo2) - 6;
            $semt = 2;
        }

        // dd(($semt));
        $data = UserEmployees::with([
            'Office',
            'manySemestral' => function ($query) use ($year, $semt) {
                $query->where('year', $year)
                    ->where('sem', $semt);
            },
            'manySemestral.monthRate' => function ($query) use ($year, $monthNumber) {
                $query->where('year', $year)
                    ->where('month', $monthNumber);
            },
            'manySemestral.Office' => function ($query) use ($office) {
                $query->where('department_code', $office);
            },
            'manySemestral.Office.pgHead'
        ])
            ->whereHas('manySemestral', function ($query) use ($office, $semt, $year) {
                $query->where('department_code', $office)
                    ->where('sem', $semt)
                    ->where('year', $year);
            })
            ->where('active_status', 'ACTIVE')
            ->where('salary_grade', '!=', 26)
            ->orderBy('first_name', 'ASC')
            ->get();

        if ($data->isEmpty()) {
            return [];
        }
        // dd($data[1]);
        return $data->map(function ($item, $key) {
            // Extract numerical and adjectival ratings
            $numericalRating = $item->manySemestral->map(function ($semestral) {
                return optional($semestral->monthRate)->first()->numerical_rating ?? 0;
            })->first() ?? 0;

            $adjectivalRating = $item->manySemestral->map(function ($semestral) {
                return optional($semestral->monthRate)->first()->adjectival_rating ?? "";
            })->first() ?? "";

            // Handle possible nulls in the name fields
            $firstName = $item->first_name ?? '';
            $middleName = $item->middle_name ?? '';
            $lastName = $item->last_name ?? '';

            $Office_Name =
                $item->manySemestral->map(function ($semestral) {
                    // dd($semestral->Office->pgHead);
                    return optional($semestral->Office)->office ?? "";
                })->first() ?? "";


            $pgHeadFirst =
                $item->manySemestral->map(function ($semestral) {
                    return optional($semestral->Office->pgHead)->first_name ?? "";
                })->first() ?? "";

            // dd($pgHeadFirst);
            $pgHeadMiddle
                =
                $item->manySemestral->map(function ($semestral) {
                    return optional($semestral->Office->pgHead)->middle_name ?? "";
                })->first() ?? "";

            $pgHeadLast
                =
                $item->manySemestral->map(function ($semestral) {
                    return optional($semestral->Office->pgHead)->last_name ?? "";
                })->first() ?? "";

            $pgHeadMiddleInitial = $pgHeadMiddle ?  $pgHeadMiddle[0] . '. ' : '';

            $pgHeadFull = $pgHeadFirst . " " . $pgHeadMiddleInitial . $pgHeadLast;
            // dd($pgHeadFull);
            $middleInitial = $middleName ? $middleName[0] . '.' : '';

            // Handle case where all name parts are null or empty
            $fullName = trim($firstName . ' ' . $middleInitial . ' ' . $lastName);
            $fullName = $fullName !== '' ? $fullName : 'Unknown Name'; // Fallback to a default name if all are null or empty

            // Return the final array with fallback values
            return [
                'Fullname' => $fullName,
                'numericalRating' => $numericalRating,
                'adjectivalRating' => $adjectivalRating !== '' ? $adjectivalRating : 'No Rating', // Fallback to 'No Rating' if null or empty
                'Office' => $Office_Name,
                'pgHead' => $pgHeadFull,
            ];
        });
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
        // dd($request->id);
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
            // return redirect('/Accomplishment/?month=' . $mo . '&year=' . $year . '&ipcr_semestral_id=' . $request->id)
            return redirect()->back()
                ->with('info', 'IPCR for the month of ' . $mo . ' year ' . $year . ' successfully submitted');
        } else {
            // return redirect('/Accomplishment/?month=' . $mo . '&year=' . $year . '&ipcr_semestral_id=' . $request->id)
            //     ->with('error', 'IPCR for the month of ' . $mo . ' year ' . $year . ' submitted successfully');
            return redirect()->back()
                ->with('info', 'IPCR for the month of ' . $mo . ' year ' . $year . ' successfully submitted');
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
            // return redirect('/Accomplishment/?month=' . $mo . '&year=' . $year)
            //     ->with('info', 'Recall of IPCR for the month of ' . $mo . ' year ' . $year . ' successful');
            return redirect()->back()
                ->with('info', 'Recall of IPCR for the month of ' . $mo . ' year ' . $year . ' successful');
        } else {
            // return redirect('/Accomplishment/?month=' . $mo . '&year=' . $year)
            return redirect()->back()
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
        $month1 = $request->month;
        $months = $request->month;

        // dd($months);
        if ($months == "January") {
            $months = 1;
        } else if ($months == 2) {
            $months = "Febraury";
        } else if ($months == 3) {
            $months = "March";
        } else if ($months == 4) {
            $months = "April";
        } else if ($months == 5) {
            $months = "May";
        } else if ($months == "June") {
            $months = 6;
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
        MonthlyRemarks::create([
            'remarks' => $request->remarks,
            'remarks_id' => $request->remarks_id,
            'year' => $request->year,
            'month' => $months,
            'idIPCR' => $request->idIPCR,
            'idSemestral' => $request->idSemestral,
            'emp_code' => $request->emp_code,
        ]);

        return redirect('/Accomplishment/?month=' . $month1 . '&year=' . $year)
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
        // dd($QualityRating);
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
            'monthly_remarks.id',
            'monthly_remarks.remarks',
            DB::raw('COUNT(ipcr_daily_accomplishments.date) as NumberofQuality'),
            DB::raw('FORMAT(SUM(ipcr_daily_accomplishments.quality) / COUNT(ipcr_daily_accomplishments.date), 2) as total_quality'),
            // DB::raw('SUM(CASE WHEN ipcr_daily_accomplishments.quality IS NOT NULL AND ipcr_daily_accomplishments.quality != "" THEN ipcr_daily_accomplishments.quality ELSE 0 END) AS total_quality'),
            DB::raw('FLOOR(CASE WHEN COUNT(ipcr_daily_accomplishments.date) > 0 THEN SUM(CASE WHEN ipcr_daily_accomplishments.quality IS NOT NULL AND ipcr_daily_accomplishments.quality != "" THEN ipcr_daily_accomplishments.quality ELSE 0 END) / COUNT(ipcr_daily_accomplishments.date) ELSE 0 END) AS quality_average'),
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
            ->orderBy('ipcr_daily_accomplishments.idIPCR', 'ASC')
            ->get();
        foreach ($data as $key => $value) {


            if ($value->quantity_type == 1) {
                if ($value->month == 0) {
                    $value->Score = "5";
                } else {
                    $value->Percentage = round(($value->TotalQuantity / $value->month) * 100);
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
                }
            } else if ($value->quantity_type == 2) {
                if ($value->month == 0) {
                    $value->Score = "2";
                } else {
                    $value->Percentage = round(($value->TotalQuantity / $value->month) * 100);
                    if ($value->Percentage == 100) {
                        $value->Score = 5;
                    } else {
                        $value->Score = 2;
                    }
                }
            }





            if ($value->quantity_type == 1) {
                $value->QuantityType = "TO BE RATED";
            } else if ($value->quantity_type == 2) {
                $value->QuantityType = "ACCURACY RULE (100%=5,2 if less than 100%)";
            }

            $score = 0;
            if ($value->quality_error == 1) {
                if ($value->total_quality == 0) {
                    $score = 0;
                } else if ($value->total_quality >= 0.01 && $value->total_quality <= 1) {
                    $score = 1;
                } else if ($value->total_quality >= 1.01 && $value->total_quality <= 2) {
                    $score = 2;
                } else if ($value->total_quality >= 2.01 && $value->total_quality <= 3) {
                    $score = 3;
                } else if ($value->total_quality >= 3.01 && $value->total_quality <= 4) {
                    $score = 4;
                } else if ($value->total_quality >= 4.01 && $value->total_quality <= 5) {
                    $score = 5;
                } else if ($value->total_quality >= 5.01 && $value->total_quality <= 6) {
                    $score = 6;
                } else if ($value->total_quality >= 6.01 && $value->total_quality <= 7) {
                    $score = 7;
                } else if ($value->total_quality >= 7.01 && $value->total_quality <= 8) {
                    $score = 8;
                } else if ($value->total_quality >= 8.01 && $value->total_quality <= 9) {
                    $score = 9;
                } else if ($value->total_quality >= 9.01 && $value->total_quality <= 10) {
                    $score = 10;
                } else if ($value->total_quality >= 10.01 && $value->total_quality <= 11) {
                    $score = 11;
                } else if ($value->total_quality >= 11.01 && $value->total_quality <= 12) {
                    $score = 12;
                } else if ($value->total_quality >= 12.01 && $value->total_quality <= 13) {
                    $score = 13;
                } else if ($value->total_quality >= 13.01 && $value->total_quality <= 14) {
                    $score = 14;
                } else if ($value->total_quality >= 14.01 && $value->total_quality <= 15) {
                    $score = 15;
                }
            }

            // dd($score);

            if ($value->quality_error == 1) {
                if ($score == 0) {
                    $value->QualityRating = "5";
                } else if ($score >= .01 && $score <= 2.99) {
                    $value->QualityRating = "4";
                } else if ($score >= 3 && $score <= 4.99) {
                    $value->QualityRating = "3";
                } else if ($score >= 5 && $score <= 6.99) {
                    $value->QualityRating = "2";
                } else if ($score >= 7) {
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
            } else if ($value->quality_error == 3) {
                $value->QualityRating = "0";
            } else if ($value->quality_error == 4) {
                if ($value->quality_average >= 1) {
                    $value->QualityRating = "2";
                } else {
                    $value->QualityRating = "5";
                }
            }

            // dd($value->QualityRating);
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

    public function index_back(Request $request)
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
        // $data = Daily_Accomplishment::with([
        //     'ipcr_Semestral',
        //     'ipcr_Semestral.ipcrTarget',
        //     'individualFinalOutput',
        // ])
        //     ->where('emp_code', $emp_code)
        //     ->whereMonth('date', $month)
        //     ->whereYear('date', $year)
        //     ->get()
        //     ->groupBy('idIPCR')
        //     ->map(fn ($item, $key) => [

        //         dd($item),
        //     ]);
        // dd($data);
        $data = Daily_Accomplishment::with([
            'individualFinalOutput',
            'ipcrTarget' => function ($query) use ($emp_code, $month, $year) {
                $query->where('i_p_c_r_targets.employee_code', '=', $emp_code);
                // ->whereMonth('date', $month)
                // ->whereYear('date', $year);
            },
            'ipcr_Semestral.immediate.Division',
            'ipcr_Semestral.next_higher1.Division',
            'monthlyAccomplishment',
            'monthlyAccomplishment.returnRemarks'
        ])
            ->where('emp_code', $emp_code)
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->select()
            // ->selectRaw('ipcr_daily_accomplishments.idIPCR, SUM(quantity) as totalQuantity')
            // ->selectRaw('SUM(ipcr_daily_accomplishments.average_timeliness) as TotalTimeliness')
            // ->selectRaw('ROUND(CASE WHEN COUNT(ipcr_daily_accomplishments.quality) > 0 THEN SUM
            // (CASE WHEN ipcr_daily_accomplishments.quality IS NOT NULL AND ipcr_daily_accomplishments.quality != ""
            // THEN ipcr_daily_accomplishments.quality ELSE 0 END) / COUNT(ipcr_daily_accomplishments.quality) ELSE 0 END, 0) AS quality_average')
            // ->selectRaw('COUNT(ipcr_daily_accomplishments.quality) as NumberofQuality')
            // ->selectRaw('SUM(CASE WHEN ipcr_daily_accomplishments.quality IS NOT NULL AND ipcr_daily_accomplishments.quality != "" THEN ipcr_daily_accomplishments.quality ELSE 0 END) AS total_quality')
            // ->groupBy('ipcr_daily_accomplishments.idIPCR')
            ->get()
            ->groupBy('idIPCR')
            ->map(fn ($item, $key) => [
                dd($item),
                // dd($item[0]['ipcrTarget']->ipcr_Semestral),
                // dd($item[0]['individualFinalOutput']->majorFinalOutputs),
                // 'total_qty' => $item->sum('quantity'),
                // 'ipcr_code' => $key,
                // 'quality_average' => number_format($item->sum('quality') / $item->count(), 2),

                dd($item),
                // dd($item[0]['ipcrTarget']->ipcr_Semestral),
                "idIPCR" => $key,
                "TotalQuantity" => $item->sum('quantity'),
                "TotalTimeliness" => $item->sum('average_timeliness'),
                "Final_Average_Timeliness" =>
                number_format($item->sum('quality') / $item->count(), 2),
                "individual_output" => $item[0]['individualFinalOutput']->individual_output,
                "success_indicator" => $item[0]['individualFinalOutput']->success_indicator,
                "quantity_type" => $item[0]['individualFinalOutput']->quantity_type,
                "quality_error" => $item[0]['individualFinalOutput']->quality_error,
                "time_range_code" => $item[0]['individualFinalOutput']->time_range_code,
                "time_based" => $item[0]['individualFinalOutput']->time_based,
                "mfo_desc" => $item[0]['individualFinalOutput']->majorFinalOutputs->mfo_desc,
                "remarks" => $item[0]['monthlyAccomplishment']->returnRemarks ? $item[0]['monthlyAccomplishment']->returnRemarks->remarks : '',
                "remarks_id" => $item[0]['monthlyAccomplishment']->returnRemarks ? $item[0]['monthlyAccomplishment']->returnRemarks->id : '',
                "output" => $item[0]['individualFinalOutput']->divisionOutput->output,
                "ipcr_type" => $item[0]['ipcrTarget']->ipcr_type,
                "ipcr_semester_id" => $item[0]['ipcrTarget']->ipcr_semester_id,
                "semester" => $item[0]['ipcrTarget']->semester,
                "month" => $month,
                "year" => $year,
                "NumberofQuality" => $item->count('quality'),
                "total_quality" => number_format($item->sum('quality') / $item->count(), 2),
                "quality_average" => number_format($item->sum('quality') / $item->count(), 2),
                "timeRanges" => $item[0]['monthlyAccomplishment']->timeRanges,
                // "prescribed_period" => $this->getTimeRatingAndUnit(),
                "time_unit" => "",
                "TimeRating" => "",
                "monthly_accomp" => $item[0]['monthlyAccomplishment'],
                "imm" => $item[0]['ipcr_Semestral']->immediate,
                "next" => $item[0]['ipcr_Semestral']->next_higher1,
                'sem_data' => $item[0]['ipcr_Semestral']
            ])
            ->values();
        // ->dd();

        // dd($data);

        // ->map(function ($item) use ($emp_code, $month, $year) {
        //     $timeRanges = $item->individualFinalOutput->timeRanges;
        //     // dd($timeRanges);
        //     // $subacc = $item->individualFinalOutput->ipcrDailyAccomplishments
        //     //     ->where('emp_code', $emp_code)
        //     //     ->where('idIPCR', $item->idIPCR)
        //     //     ->where('sem_id', $item->sem_id)
        //     //     ->map(fn ($result) => [
        //     //         'quantity' => $result->sum('quantity'),
        //     //     ]);
        //     // // $subacc = $item->subAccomplishments;
        //     // // ->where('emp_code', $emp_code)
        //     // // ->where('Month(date)', $month)
        //     // // ->where('Year(date)', $year)
        //     // // // ->sortBy(function ($item) {
        //     // // //     return Carbon::parse($item->date)->month;
        //     // // // })
        //     // // // ->groupBy(function ($item) {
        //     // // //     return Carbon::parse($item->date)->month;
        //     // // // })
        //     // // ->map(fn ($result) => [
        //     // //     'month' => Carbon::parse($result[0]->date)->format('n'),
        //     // //     'quantity' => $result->sum('quantity'),
        //     // //     'quality' => $result->sum('quality'),
        //     // //     'TotalAverage' => $result->sum('average_timeliness'),
        //     // //     'timeliness' => $result->sum('timeliness'),
        //     // //     'quality_count' => $result->count(),
        //     // //     'average_quality' => number_format($result->sum('quality') / $result->count(), 0),
        //     // //     'average_time' => number_format($result->sum('average_timeliness') / $result->sum('quantity'), 0)
        //     // // ])
        //     // // ->values();
        //     // dd($subacc);
        //     // dd($item->ipcrTarget->ipcr_Semestral->next_higher1);
        //     return [
        //         "idIPCR" => $item->idIPCR,
        //         "TotalQuantity" => $item->totalQuantity,
        //         "TotalTimeliness" => $item->TotalTimeliness,
        //         "Final_Average_Timeliness" => $item->quality_average,
        //         "individual_output" => $item->individualFinalOutput->individual_output,
        //         "success_indicator" => $item->individualFinalOutput->success_indicator,
        //         "quantity_type" => $item->individualFinalOutput->quantity_type,
        //         "quality_error" => $item->individualFinalOutput->quality_error,
        //         "time_range_code" => $item->individualFinalOutput->time_range_code,
        //         "time_based" => $item->individualFinalOutput->time_based,
        //         "mfo_desc" => $item->individualFinalOutput->majorFinalOutputs->mfo_desc,
        //         "remarks" => $item->monthlyAccomplishment->returnRemarks->remarks,
        //         "remarks_id" => $item->monthlyAccomplishment->returnRemarks->id,
        //         "output" => $item->individualFinalOutput->divisionOutput->output,
        //         "ipcr_type" => $item->ipcrTarget->ipcr_type,
        //         "ipcr_semester_id" => $item->ipcrTarget->ipcr_semester_id,
        //         "semester" => $item->ipcrTarget->semester,
        //         "month" => $month,
        //         "year" => $year,
        //         "NumberofQuality" => $item->NumberofQuality,
        //         "total_quality" => $item->total_quality,
        //         "quality_average" => $item->qualityAverage,
        //         "timeRanges" => $item->individualFinalOutput->timeRanges,
        //         "prescribed_period" => "",
        //         "time_unit" => "",
        //         "TimeRating" => "",
        //         "monthly_accomp" => $item->monthlyAccomplishments,
        //         "imm" => $item->ipcrTarget->ipcr_Semestral->immediate,
        //         "next" => $item->ipcrTarget->ipcr_Semestral->next_higher1
        //     ];
        // });
        // ->timeRanges
        // dd('tafdasdasd');
        // dd($data);
        // // dd($data[0]['individualFinalOutput']['timeRanges']);
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
        return $data;
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
        // dd(auth()->user()->userEmployee->division);
        $my_sem_id = "";
        $my_stat = "";
        // $mo_data =[
        //     ""
        // ]
        // $mo_data = Ipcr_Semestral::where('employee_code', $emp_code)
        //     ->where('ipcr__semestrals.year', $year)
        //     ->where('ipcr__semestrals.sem', $sem)
        //     ->orderBy('year', 'DESC')
        //     ->orderBy('sem', 'DESC')
        //     ->get()
        //     ->map(function ($item) {
        //         $rem = ReturnRemarks::where('ipcr_semestral_id', $item->id)
        //             ->orderBy('created_at', 'DESC')
        //             ->first();
        //         $immediate = UserEmployees::where('empl_id', $item->immediate_id)
        //             ->first();
        //         $next_higher = UserEmployees::where('empl_id', $item->next_higher)
        //             ->first();
        //         $user = UserEmployees::where('empl_id', $item->employee_code)
        //             ->first();

        //         $division_code = "";
        //         if ($user->division_code == "") {
        //             $division_code = $immediate->division_code;
        //         } else {
        //             $division_code = $user->division_code;
        //         }
        //         // dd($division_code);
        //         $division = Division::where('division_code', $division_code)
        //             ->first();
        //         // $userEmployee = UserEmployees::
        //         // dd($division);
        //         $division_assigned = "";
        //         // dd($item);
        //         if ($division == "") {
        //             $division_assigned = "";
        //         } else {
        //             if ($item->division == "") {
        //                 $division_assigned = $division->division_name1;
        //             } else {
        //                 $division_assigned = $division->division_name1;
        //             }
        //         }
        //         //
        //         // dd($division_assigned);
        //         return [
        //             'id' => $item->id,
        //             'division' => $division_assigned,
        //             'employee_code' => $item->employee_code,
        //             'immediate_id' => $item->immediate_id,
        //             'next_higher' => $item->next_higher,
        //             "imm" => $immediate,
        //             "next" => $next_higher,
        //             'sem' => $item->sem,
        //             'status' => $item->status,
        //             'year' => $item->year,
        //             'rem' => $rem
        //         ];
        //     });
        // dd($mo_data);
        // dd($mo_data);['Division']
        // dd($data[0]);
        $mo = $data[0];
        // dd(auth()->user()->userEmployee->Division);
        // dd($mo['remarks']);
        // dd($mo['sem_data']);
        $div = "";
        // dd('mmomo');
        $div = auth()->user()->load('userEmployee.Division')->userEmployee->Division;
        // dd($div);
        // dd(auth()->user()->userEmployee);
        // auth()->user()->userEmployee->Division
        $immh = $mo['imm'];
        $nxth = $mo['next'];
        if ($div) {
            // dd($div->division_name1);
            $div = $div->division_name1;
        } else {
            // dd($immh);
            // dd($immh['Division']->division_name1);
            // if($immh['Division']);
        }
        // dd($mo);
        $mo_data = [
            "id" => 0,
            "division" => $div,
            "employee_code" => $emp->empl_id,
            "imm" => $immh,
            "next" => $nxth,
            "sem" => $mo['sem_data']->semester,
            "status" => $mo['sem_data']->status,
            "year" => $year,
            "rem" => $mo['remarks']
        ];
        dd($data);
        dd($mo_data);
        // if ($data) {
        //     $mo_data = [
        //         "id" => 0,
        //         "division" => "",
        //         "employee_code" => "",
        //         "imm" => "",
        //         "next" => "",
        //         "sem" => "",
        //         "status" => "",
        //         "year" => "2023",
        //         "rem" => "",
        //     ];
        // }
        $my_mo_data = $mo_data;
        // if ($mo_data->isNotEmpty()) {
        //     $my_sem_id = $mo_data[0]['id'];
        //     $my_mo_data = $mo_data[0];
        // }
        // $sel_month = MonthlyAccomplishment::where("month", $month)
        //     ->where("year", $year)
        //     ->where("ipcr_semestral_id", $my_sem_id)
        //     ->first();
        // $sel_month = MonthlyAccomplishment::where("month", $month)
        //     ->where("ipcr_semestral_id", $my_sem_id)
        //     ->first();
        // if ($sel_month) {
        //     $my_stat = $sel_month->status;
        // }

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
    // http://192.168.56.1:8000/monthly/accomplishments/object/8510/1/2024/36/3
    public function monthly_object(
        Request $request,
        $emp_code,
        $semt,
        $year,
        $ipcr_semestral_id,
        $month
    ) {
        // dd($month);
        $mo2 = $month;
        if ($month > 6) {
            $mo2 = $month - 6;
        }
        $data = Daily_Accomplishment::with([
            'individualFinalOutput',
            'ipcrTarget' => function ($query) use ($emp_code, $semt, $year, $ipcr_semestral_id) {
                $query->where('i_p_c_r_targets.employee_code', '=', $emp_code)
                    ->where('i_p_c_r_targets.ipcr_semester_id', $ipcr_semestral_id);
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
                "month" => $item[0]['ipcrTarget'] ? (($item[0]['ipcrTarget']["month_" . $mo2] > 0) ? $item[0]['ipcrTarget']["month_" . $mo2] : 0) : '',
                "year" => $year,
                "NumberofQuality" => $item->count(),
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

        return $data;
    }
}
