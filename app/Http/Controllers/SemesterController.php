<?php

namespace App\Http\Controllers;

use App\Models\Daily_Accomplishment;
use App\Models\Division;
use App\Models\EmployeeSpecialDepartment;
use App\Models\FFUNCCOD;
use App\Models\IndividualFinalOutput;
use App\Models\Ipcr_Semestral;
use App\Models\IpcrScore;
use App\Models\IPCRTargets;
use App\Models\MonthlyAccomplishment;
use App\Models\Office;
use App\Models\ReturnRemarks;
use App\Models\SemestralRemarks;
use App\Models\summary_rating_remarks;
use App\Models\TimeRange;
use App\Models\UserEmployees;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDO;
use Throwable;

class SemesterController extends Controller
{
    private $model;
    public function __construct(Daily_Accomplishment $model)
    {
        $this->model = $model;
    }

    public function semestral(Request $request, $sem_id)
    {
        $emp = auth()->user()->userEmployee;
        $emp_code = $emp->empl_id;
        $division = "";
        $pgHead = NULL;
        $office = NULL;
        // dd('office');
        $data = IPCRTargets::with([
            'individualOutput',
            'individualOutput.timeRanges',
            'individualOutput.divisionOutput.division',
            'individualOutput.divisionOutput.majorFinalOutput',
            'individualOutput.subMfo',
            'semestralRemarks' => function ($query) use ($sem_id) {
                $query->where('idSemestral', $sem_id);
            },
            'individualOutput.ipcrDailyAccomplishments' => function ($query) use ($sem_id) {
                $query->where('sem_id', $sem_id);
            },
            'ipcr_Semestral',
            'ipcr_Semestral.latestReturnRemark' => function ($query) use ($sem_id) {
                $query->where('type', 'review semestral accomplishment');
                $query->where('ipcr_semestral_id', $sem_id);
            },
            'ipcr_Semestral.latestReturnRemarkNextHigher' => function ($query) use ($sem_id) {
                $query->where('type', 'approve semestral accomplishment');
                $query->where('ipcr_semestral_id', $sem_id);
            },

            // 'ipcr_Semestral.next_higher1', pgHead
        ])
            ->where('employee_code', '=', $emp_code)
            ->where('ipcr_semester_id', $sem_id)
            ->get()
            ->map(function ($item, $key) use ($sem_id) {
                // if ($item->individualOutput) {
                $result = $item->individualOutput->ipcrDailyAccomplishments
                    ->where('sem_id', $sem_id)
                    ->where('idIPCR', $item->ipcr_code)
                    ->sortBy(function ($item) {
                        return Carbon::parse($item->date)->month;
                    })
                    ->groupBy(function ($item) {
                        return Carbon::parse($item->date)->month;
                    })
                    ->map(fn($result) => [
                        'month' => Carbon::parse($result[0]->date)->format('n'),
                        'quantity' => $result->sum('quantity'),
                        'quality' => $result->sum('quality'),
                        'TotalAverage' => $result->sum('average_timeliness'),
                        'timeliness' => $result->sum('timeliness'),
                        'quality_count' => $result->count(),
                        'average_quality' => $result->count() > 0 ? number_format($result->sum('quality') / $result->count(), 2) : 0,
                        'average_time' => $result->sum('quantity') > 0 ? number_format($result->sum('average_timeliness') / $result->sum('quantity'), 0) : 0,

                        // 'average_quality' => number_format($result->sum('quality') / $result->count(), 2),
                        // 'average_time' => number_format($result->sum('average_timeliness') / $result->sum('quantity'), 0),
                        // 'score' => $this->score(number_format($result->sum('quality') / $result->count(), 2))

                    ])
                    ->values();





                // dd($item);
                $prescribed_period = "";
                if ($item->individualOutput->time_range_code > 0 && $item->individualOutput->time_range_code < 47) {
                    $prescribed_period = $item->individualOutput->timeRanges[0]->prescribed_period;
                }
                return [
                    "result" => $result,
                    "ipcr_code" => $item->ipcr_code,
                    "id" => $item->id,
                    "ipcr_type" => $item->ipcr_type,
                    "ipcr_semester_id" => $item->ipcr_semester_id,
                    "year" => $item->year,
                    "quantity_sem" => $item->quantity_sem,
                    "performance_measure" => $item->performance_measure,
                    "success_indicator" => $item->individualOutput->success_indicator,
                    "quantity_type" => $item->individualOutput->quantity_type,
                    "quality_error" => $item->individualOutput->quality_error,
                    "time_range_code" => $item->individualOutput->time_range_code,
                    "time_based" => $item->individualOutput->time_based,
                    "prescribed_period" => $prescribed_period,
                    "time_unit" => $item->individualOutput->time_unit,
                    "division" => $item->division,
                    // "output AS div_output" => $item->div_output,
                    "mfo_desc" => $item->individualOutput->divisionOutput->majorFinalOutput->mfo_desc,
                    "FFUNCCOD" => $item->FFUNCOD,
                    "submfo_description" => $item->submfo_description,
                    "remarks" => $item->semestralRemarks ? $item->semestralRemarks->remarks : '',
                    "remarks_id" => $item->semestralRemarks ? $item->semestralRemarks->id : '',
                    'indi_output' => $item->individualOutput,
                    "sem" => $item->ipcr_Semestral,
                    "imm_ob" => $item->ipcr_Semestral->immediate,
                    "nxt_ob" => $item->ipcr_Semestral->next_higher1,
                    "Remarks" => $item->ipcr_Semestral->latestReturnRemark,
                    "RemarksNextHigher" => $item->ipcr_Semestral->latestReturnRemarkNextHigher,
                    "division" => $item->ipcr_Semestral->division_name,
                    "office" => $item->ipcr_Semestral->department,
                    "pghead" => $item->ipcr_Semestral->pg_dept_head,
                    "division" => $item->ipcr_Semestral->division_name ? $item->ipcr_Semestral->division_name : "",
                ];
            });

        if (count($data) > 0) {
            // dd($data);
            $pgHead = $data[0]['pghead'];
            $office = $data[0]['office'];
            $division = $data[0]['division'];
            // dd($pgHead);
            // dd("division " . $office);
        }
        $sem = $data[0]['sem'];

        // $division = $emp->Division ? $emp->Division : false; # Assign division from employee division object

        // $division = $division ? $division :  $sem->immediate->Division; # Assign division from immediate output division object if employee division object is null

        // $division = $division->division_name1 ?? ''; # Set division name from division variable
        // dd($division);

        $RemarksHigher = "";
        // dd($sem->latestReturnRemarkNextHigher == null);
        if ($sem->latestReturnRemarkNextHigher == null) {
            $RemarksHigher = "";
        } else {
            $RemarksHigher = $sem->latestReturnRemarkNextHigher ? $sem->latestReturnRemarkNextHigher->remarks : '';
        }
        // dd($RemarksHigher);
        // dd($emp);
        $sem_data = [
            'id' => $sem_id,
            'employee_code' => $emp_code,
            'immediate_id' => $sem->immediate_id,
            'next_higher' => $sem->next_higher,
            'division' => $division,
            "imm" => $data[0]['imm_ob'],
            "next" => $data[0]['nxt_ob'],
            'sem' => $sem->sem,
            'status' => $sem->status,
            'status_accomplishment' => $sem->status_accomplishment,
            'remarks' => $sem->latestReturnRemark ? $sem->latestReturnRemark->remarks : '',
            'remarkshigher' => $RemarksHigher,
            'year' => $sem->year,
            'rem' => $sem->remarks,
        ];
        // dd($sem_data);
        // dd($emp);
        return inertia('Semestral_Accomplishment/Index', [
            "id" => $emp->empl_id,
            "data" => $data,
            "sem_data" => $sem_data,
            "sem_id" => $sem_id,
            "division" => $division,
            "sem" => $sem,
            // "division" => fn () => $emp->latestSemestral->Immediate,
            "emp" => $emp,
            "dept_con" => $office,
            "pghead_con" => $pgHead,
            "division_con" => $division ? $division : ''
        ]);
    }

    public function SemesterRating(Request $request)
    {
        // dd($request->all());
        $office = $request->department_code;
        $year = $request->year;
        $sem = $request->sem;

        $data = UserEmployees::with([
            'manySemestral' => function ($query) use ($year, $sem, $office) {
                $query->where('year', $year)
                    ->where('sem', $sem)
                    ->where('department_code', $office);
            },
            'manySemestral.semRate' => function ($query) use ($year, $sem) {
                $query->where('year', $year)
                    ->where('sem', $sem);
            },
            'semestralRatingRemarks' => function ($query) use ($year, $sem) {
                $query->where('year', $year)
                    ->where('semester', $sem);
            }
        ])
            ->whereHas('manySemestral', function ($query) use ($office, $sem, $year) {
                $query->where('department_code', $office)
                    ->where('sem', $sem)
                    ->where('year', $year);
            })
            ->where('active_status', 'ACTIVE')
            ->where('salary_grade', '!=', 26)
            ->orderBy('last_name', 'ASC')
            ->get()
            // dd($data[1]);
            ->map(function ($item, $key) {


                $numericalRating = $item->manySemestral->map(function ($semestral) {
                    return optional($semestral->semRate)->first()->numerical_rating ?? 0;
                })->first() ?? 0;

                $adjectivalRating =
                    $item->manySemestral->map(function ($semestral) {
                        return optional($semestral->semRate)->first()->adjectival_rating ?? "";
                    })->first() ?? "";

                $semesterRemarks = $item->semestralRatingRemarks->map(function ($semestral) use ($item) {
                    if ($item->empl_id == $semestral->employee_code) {
                        return optional($semestral)->remarks ?? "";
                    }
                })->first() ?? "";
                // dd($item->semestralRatingRemarks);

                // if ($item->empl_id == 2089) {
                //
                // }
                $semesterRemarksId = $item->semestralRatingRemarks->map(function ($semestral) {
                    return optional($semestral)->id ?? "";
                })->first() ?? "";

                $middleInitial = $item->middle_name ? $item->middle_name[0] . '.' : '';
                return [
                    'emp_code' => $item->empl_id,
                    'Fullname' => $item->last_name . ", " . $item->first_name . " " . $middleInitial,
                    'numericalRating' => $numericalRating,
                    'adjectivalRating' => $adjectivalRating,
                    'remarks' => $semesterRemarks,
                    'remarks_id' => $semesterRemarksId,
                ];
            });
        // dd($data[0]);
        return inertia('SummaryOfRating/SemestralRating', [
            "data" => $data,
            "year" => $year,
            "office" => $request->department_code,
            "sem" => $request->sem,
        ]);
    }

    public function semester_store(Request $request)
    {
        // dd($request->all());
        $year = $request->year;
        $deparment_code = $request->office;
        $sem = $request->sem;

        // dd($request->all());
        summary_rating_remarks::create([
            'id' => $request->id,
            'remarks' => $request->remarks,
            'employee_code' => $request->emp_code,
            'year' => $request->year,
            'semester' => $request->semester,
        ]);

        return redirect()->back()
            ->with('message', 'Remarks added');
    }

    public function semester_update(Request $request)
    {
        // dd($request->all());
        $data = summary_rating_remarks::findOrFail($request->remarks_id);
        // dd($data);

        $data->update([
            'remarks' => $request->remarks,
        ]);

        return redirect()->back()->with('info', 'Remark Updated');
    }
    public function semester_destroy(Request $request)
    {
        $data = summary_rating_remarks::findOrFail($request->id);
        // dd($data);

        $data->delete();
        return redirect()->back()->with('info', 'Remark deleted');
    }

    public function SemestralPrintSummary(Request $request)
    {

        $office = $request->department_code;
        $year = $request->year;
        $sem = $request->sem;
        // dd($request->all());
        if (!$office || !$year || !$sem) {
            return [];
        }

        $semester = $this->semester($sem);

        // dd($semester);
        $data = UserEmployees::with([
            'Office',
            'manySemestral' => function ($query) use ($year, $sem, $office) {
                $query->where('year', $year)
                    ->where('sem', $sem)
                    ->where('department_code', $office);
            },
            'manySemestral.semRate' => function ($query) use ($year, $sem) {
                $query->where('year', $year)
                    ->where('sem', $sem);
            },
            'manySemestral.Office.pgHead'
        ])
            ->whereHas('manySemestral', function ($query) use ($office, $sem, $year) {
                $query->where('department_code', $office)
                    ->where('sem', $sem)
                    ->where('year', $year);
            })
            ->where('active_status', 'ACTIVE')
            ->where('salary_grade', '!=', 26)
            ->orderBy('last_name', 'ASC')
            ->get();

        if ($data->isEmpty()) {
            return [];
        }

        return $data->map(function ($item) use ($sem) {
            // Extract numerical and adjectival ratings
            $numericalRating = $item->manySemestral->map(function ($semestral) {
                return optional($semestral->semRate)->first()->numerical_rating ?? 0;
            })->first() ?? 0;

            $adjectivalRating = $item->manySemestral->map(function ($semestral) {
                return optional($semestral->semRate)->first()->adjectival_rating ?? "";
            })->first() ?? "";

            $semester = $this->semester($sem);
            // Handle possible nulls in the name fields
            $firstName = $item->first_name ?? '';
            $middleName = $item->middle_name ?? '';
            $lastName = $item->last_name ?? '';

            $Office_Name = $item->manySemestral->map(function ($semestral) {
                return optional($semestral->Office)->office ?? "";
            })->first() ?? "";

            $pgHeadFirst = $item->manySemestral->map(function ($semestral) {
                return optional($semestral->Office->pgHead)->first_name ?? "";
            })->first() ?? "";

            $pgHeadMiddle = $item->manySemestral->map(function ($semestral) {
                return optional($semestral->Office->pgHead)->middle_name ?? "";
            })->first() ?? "";

            $pgHeadLast = $item->manySemestral->map(function ($semestral) {
                return optional($semestral->Office->pgHead)->last_name ?? "";
            })->first() ?? "";

            $pgHeadMiddleInitial = $pgHeadMiddle ? $pgHeadMiddle[0] . '. ' : '';
            $pgHeadFull = $pgHeadFirst . " " . $pgHeadMiddleInitial . $pgHeadLast;

            $middleInitial = $middleName ? $middleName[0] . '.' : '';

            // Handle case where all name parts are null or empty
            $fullName = trim($lastName . ", " . $firstName . ' ' . $middleInitial);
            $fullName = $fullName !== '' ? $fullName : 'Unknown Name'; // Fallback to a default name if all are null or empty

            // Return the final array with fallback values
            return [
                'Fullname' => $fullName,
                'numericalRating' => $numericalRating,
                'adjectivalRating' => $adjectivalRating !== '' ? $adjectivalRating : 'No Rating', // Fallback to 'No Rating' if null or empty
                'Office' => $Office_Name,
                'pgHead' => $pgHeadFull,
                'Semester' => $semester,
            ];
        });
    }

    public function SemestralAllPrintSummary(Request $request)
    {

        $emp_code = $request->emp_code;
        $year = $request->year;
        $sem = $request->sem;
        $employmentType = $request->employment_type;
        // dd($request->all());
        // Validate inputs
        if (!$year || !$sem) {
            return [];
        }
        // dd($emp_code);

        // Fetch all offices that match the conditions
        $division_code = NULL;
        $offices = Office::select(
            'id',
            'department_code',
            'short_name',
            DB::raw('NULL AS division_code'),
            DB::raw('NULL AS division_name'),
            'office',
            'empl_id'
        )
            ->where(function ($query) {
                $query->where('office', 'LIKE', '%Office%')
                    ->orWhere('office', 'LIKE', '%Hospital%');
            })
            ->where('office', '<>', 'NO OFFICE')
            ->orderBy('office', 'ASC')
            ->get();
        // dd($offices);
        // Separate the DDOPH entries
        $ddophOffices = $offices->filter(function ($office) {
            return strpos(
                $office->office,
                'DAVAO DE ORO PROVINCIAL HOSPITAL (DDOPH)'
            ) === 0;
        });


        // Filter out PAO entries from the main list
        $otherOffices = $offices->filter(function ($office) {
            return strpos(
                $office->office,
                'PROVINCIAL ADMINISTRATOR\'S OFFICE'
            ) !== 0;
        });
        $otherOffices = $offices->filter(function ($office) {
            return strpos(
                $office->office,
                'DAVAO DE ORO PROVINCIAL HOSPITAL (DDOPH)'
            ) !== 0;
        });
        // DIVISIONS of the Provincial Administrator's Office
        $div = Office::select(
            'offices.id',
            'offices.department_code',
            'offices.short_name',
            'divisions.division_code',
            'divisions.division_name1 AS division_name',
            'offices.office',
            'offices.empl_id'
        )
            ->leftJoin('divisions', 'offices.department_code', '=', 'divisions.department_code')
            ->where('offices.department_code', '=', '02')
            ->orderBy('divisions.division_name1', 'ASC')
            ->get();
        // dd($div);
        // $div = Division::where('department_code', '02')->get()->map(
        //     function ($item) {
        //         return [
        //             //             'id'=>2,
        //             //             "short_name" => "DDOPH - LAAK",
        //             // "division_code" => null,
        //             // "office" => "DAVAO DE ORO PROVINCIAL HOSPITAL (DDOPH) - LAAK"
        //             // "empl_id" => "9499"
        //             "id" => 2,
        //             "department_code" => "02",
        //             "short_name" => "PAO",
        //             "division_code" => $item->division_code,
        //             "office" => "PAO - " . $item->division_name1,
        //             "empl_id" => "10058",
        //         ];
        //     }
        // );
        // $div = collect($div);
        // dd($div);
        // Insert DDOPH entries after "PROVINCIAL ECONOMIC ENTERPRISE & MGT OFFICE"
        $finalOffices = collect();
        // dd($otherOffices);
        foreach ($otherOffices as $office) {
            $finalOffices->push($office);
            // After "PROVINCIAL ECONOMIC ENTERPRISE & MGT OFFICE", append DDOPH entries
            if ($office->office === 'PROVINCIAL ECONOMIC ENTERPRISE & MGT OFFICE') {
                foreach ($ddophOffices as $ddoph) {
                    $finalOffices->push($ddoph);
                }
            }
            if ($office->office === 'PROVINCIAL ACCOUNTANT\'S OFFICE') {
                foreach ($div as $div1) {
                    $finalOffices->push($div1);
                }
            }
        }
        // foreach ($otherOffices as $office) {
        //     $div->push($office);
        //     if ($office->office === 'PROVINCIAL ACCOUNTANT\'S OFFICE') {
        //         foreach ($ddophOffices as $ddoph) {
        //             $finalOffices->push($div);
        //         }
        //     }
        // }
        // dd($finalOffices->pluck('office'));
        // dd($finalOffices->pluck('division_name'));
        // dd($finalOffices->pluck('department_code'));
        // Prepare the data for each office
        // dd($finalOffices);
        $result = $finalOffices->map(function ($finalOffices) use ($year, $sem, $employmentType, $emp_code) {
            // dd($finalOffices);
            $username = UserEmployees::where('empl_id', $emp_code)
                ->first();

            $user_first_name = $username->first_name;
            $user_middle_initial = $username->middle_name[0];
            $user_last_name = $username->last_name;
            $userFullname = $user_first_name . " " . $user_middle_initial . ". " . $user_last_name;
            $userPosition = $username->position_long_title;
            $employeesData = [];
            $semester = $this->semester($sem);
            $employment_type = $this->employment_type($employmentType);
            $office_shortname = $finalOffices->short_name;
            if ($finalOffices->department_code !== '02') {
                $employeesQuery = UserEmployees::with([
                    'Office',
                    'manySemestral' => function ($query) use ($year, $sem, $finalOffices, $employmentType) {
                        $query->where('year', $year)
                            ->where('sem', $sem)
                            ->where('department_code', $finalOffices->department_code)
                            ->where('employment_type', $this->employment_type($employmentType));
                    },
                    'manySemestral.semRate' => function ($query) use ($year, $sem) {
                        $query->where('year', $year)
                            ->where('sem', $sem);
                    },
                    'manySemestral.Office.pgHead',
                    'semestralRatingRemarks' => function ($query) use ($year, $sem) {
                        $query->where('year', $year)
                            ->where('semester', $sem);
                    }
                ])
                    ->whereHas('manySemestral', function ($query) use ($finalOffices, $sem, $year, $employmentType) {
                        $query->where('department_code', $finalOffices->department_code)
                            ->where('sem', $sem)
                            ->where('year', $year)
                            ->where('employment_type', $this->employment_type($employmentType));
                    })
                    ->where('active_status', 'ACTIVE')
                    ->where('salary_grade', '!=', 26);


                // Order the results by last name
                $employees = $employeesQuery->orderBy('last_name', 'ASC')->get();

                // Map employees data
                $employeesData = $employees->map(function ($item) use ($sem) {
                    $numericalRating = $item->manySemestral->map(function ($semestral) {
                        return optional($semestral->semRate)->first()->numerical_rating ?? 0;
                    })->first() ?? 0;

                    $adjectivalRating = $item->manySemestral->map(function ($semestral) {
                        return optional($semestral->semRate)->first()->adjectival_rating ?? "";
                    })->first() ?? "";

                    $semesterRemarks = $item->semestralRatingRemarks->map(function ($semestral) use ($item) {
                        if ($item->empl_id == $semestral->employee_code) {
                            return optional($semestral)->remarks ?? "";
                        }
                    })->first() ?? "";

                    $semesterRemarksId = $item->semestralRatingRemarks->map(function ($semestral) {
                        return optional($semestral)->id ?? "";
                    })->first() ?? "";
                    // dd($semesterRemarks);
                    $firstName = $item->first_name ?? '';
                    $middleName = $item->middle_name ?? '';
                    $lastName = $item->last_name ?? '';

                    $Office_Name = $item->manySemestral->map(function ($semestral) {
                        return optional($semestral->Office)->office ?? "";
                    })->first() ?? "";



                    $middleInitial = $middleName ? $middleName[0] . '.' : '';
                    $fullName = trim($lastName . ", " . $firstName . ' ' . $middleInitial);
                    $fullName = $fullName !== '' ? $fullName : 'Unknown Name';

                    return [
                        'Fullname' => $fullName,
                        'numericalRating' => $numericalRating,
                        'adjectivalRating' => $adjectivalRating !== '' ? $adjectivalRating : 'No Rating',
                        'Office' => $Office_Name,
                        'remarks' => $semesterRemarks,
                        'remarks_id' => $semesterRemarksId,
                    ];
                });
            } else {
                $employeesQuery = UserEmployees::with([
                    'Office',
                    'manySemestral' => function ($query) use ($year, $sem, $finalOffices) {
                        $query->where('year', $year)
                            ->where('sem', $sem)
                            ->where('department_code', $finalOffices->department_code)
                            ->where('division', $finalOffices->division_code);
                    },
                    'manySemestral.semRate' => function ($query) use ($year, $sem) {
                        $query->where('year', $year)
                            ->where('sem', $sem);
                    },
                    'manySemestral.Office.pgHead',
                    'semestralRatingRemarks' => function ($query) use ($year, $sem) {
                        $query->where('year', $year)
                            ->where('semester', $sem);
                    }
                ])
                    ->whereHas('manySemestral', function ($query) use ($finalOffices, $sem, $year) {
                        $query->where('department_code', $finalOffices->department_code)
                            ->where('division', $finalOffices->division_code)
                            ->where('sem', $sem)
                            ->where('year', $year);
                    })
                    ->where('active_status', 'ACTIVE')
                    ->where('salary_grade', '!=', 26)
                    ->where('employment_type', $employmentType);




                // Order the results by last name
                $employees = $employeesQuery->orderBy('last_name', 'ASC')->get();

                // Map employees data
                $employeesData = $employees->map(function ($item) use ($sem) {
                    $numericalRating = $item->manySemestral->map(function ($semestral) {
                        return optional($semestral->semRate)->first()->numerical_rating ?? 0;
                    })->first() ?? 0;

                    $adjectivalRating = $item->manySemestral->map(function ($semestral) {
                        return optional($semestral->semRate)->first()->adjectival_rating ?? "";
                    })->first() ?? "";

                    $semesterRemarks = $item->semestralRatingRemarks->map(function ($semestral) use ($item) {
                        if ($item->empl_id == $semestral->employee_code) {
                            return optional($semestral)->remarks ?? "";
                        }
                    })->first() ?? "";

                    $semesterRemarksId = $item->semestralRatingRemarks->map(function ($semestral) {
                        return optional($semestral)->id ?? "";
                    })->first() ?? "";
                    // dd($semesterRemarks);
                    $firstName = $item->first_name ?? '';
                    $middleName = $item->middle_name ?? '';
                    $lastName = $item->last_name ?? '';

                    $Office_Name = $item->manySemestral->map(function ($semestral) {
                        return optional($semestral->Office)->office ?? "";
                    })->first() ?? "";



                    $middleInitial = $middleName ? $middleName[0] . '.' : '';
                    $fullName = trim($lastName . ", " . $firstName . ' ' . $middleInitial);
                    $fullName = $fullName !== '' ? $fullName : 'Unknown Name';

                    return [
                        'Fullname' => $fullName,
                        'numericalRating' => $numericalRating,
                        'adjectivalRating' => $adjectivalRating !== '' ? $adjectivalRating : 'No Rating',
                        'Office' => $Office_Name,
                        'remarks' => $semesterRemarks,
                        'remarks_id' => $semesterRemarksId,
                    ];
                });

                $office_shortname = $finalOffices->short_name . ' - ' . $finalOffices->division_name;
            }

            // dd($finalOffices)
            return [
                'id' => $finalOffices->id,
                'department_code' => $finalOffices->department_code,
                'office' => $finalOffices->office,
                'short_name' => $office_shortname,
                'Semester' => $semester,
                'Name' => $userFullname,
                'Position' => $userPosition,
                'Employment_type' => $employment_type,
                'Employees' => $employeesData
            ];
        });

        // $filteredData = collect($result)->filter(function ($item) {
        //     return is_array($item['Employees']) && !empty($item['Employees']);
        // })->values()->all();
        //****************** */
        $filteredData = collect($result)->filter(function ($item) {
            // Ensure Employees is an array and has at least one entry
            // dd($item);
            // return isset($item['Employees']) && is_array($item['Employees']) && count($item['Employees']) > 0;
            return $item['Employees'] instanceof \Illuminate\Support\Collection && $item['Employees']->isNotEmpty();
        })->values()->all();
        return $filteredData;
        // ??********************

        // $filteredResult = array_filter($result, function ($entry) {
        //     return !empty($entry->Employees);
        // });
        // return $result;
    }

    public function employment_type($type)
    {
        $employment = "";
        if ($type == "RE") {
            $employment = "Regular";
        } else if ($type == "CE") {
            $employment = "Casual";
        } else if ($type == "JO") {
            $employment = "Job Order";
        }

        return $employment;
    }

    public function semester($sem)
    {

        $semestral = "";
        if ($sem == 1) {
            $semestral = "JANUARY TO JUNE";
        } else if ($sem == 2) {
            $semestral = "JULY TO DECEMBER";
        }

        return $semestral;
    }

    public function averageRate($Quantity, $Quality, $Timeliness)
    {
        $sum = 0;
        $count = 0;

        if ($Quantity != 0) {
            $sum += $Quantity;
            $count++;
        }

        if ($Quality != 0) {
            $sum += $Quality;
            $count++;
        }

        if ($Timeliness != 0) {
            $sum += $Timeliness;
            $count++;
        }

        if ($count == 0) {
            return number_format(0, 2); // Return 0.00 if all parameters are zero
        }

        $average = $sum / $count;
        return number_format($average, 2);
    }

    public function score($score, $quality_type)
    {
        if ($quality_type == 1) {
            if ($score == 0) {
                return '0';
            } else if ($score >= 0.01 && $score <= 1) {
                return '1';
            } else if ($score >= 1.01 && $score <= 2) {
                return '2';
            } else if ($score >= 2.01 && $score <= 3) {
                return '3';
            } else if ($score >= 3.01 && $score <= 4) {
                return '4';
            } else if ($score >= 4.01 && $score <= 5) {
                return '5';
            } else if ($score >= 6.01 && $score <= 6) {
                return '6';
            } else if ($score >= 6.01 && $score <= 7) {
                return '7';
            } else if ($score >= 7.01 && $score <= 8) {
                return '8';
            } else if ($score >= 8.01 && $score <= 9) {
                return '9';
            } else if ($score >= 9.01 && $score <= 10) {
                return '10';
            } else if ($score >= 10.01 && $score <= 11) {
                return '11';
            } else if ($score >= 11.01 && $score <= 12) {
                return '12';
            } else if ($score >= 12.01 && $score <= 13) {
                return '13';
            } else if ($score >= 13.01 && $score <= 14) {
                return '14';
            } else if ($score >= 14.01 && $score <= 15) {
                return '15';
            }
        } else if ($quality_type == 2) {
            return floor($score);
        }
    }

    public function feedbackError($score, $qualityRating, $error_feedback)
    {
        if ($error_feedback == "") {
            if ($qualityRating == 5) {
                return "Outstanding Feedback";
            } else if ($qualityRating == 4) {
                return "Very Satisfactory Feedback";
            } else if ($qualityRating == 3) {
                return "Satisfactory Feedback";
            } else if ($qualityRating == 2) {
                return "Unsatisfactory Feedback";
            } else if ($qualityRating == 1) {
                return "Poor Feedback";
            }
        } else {
            if ($score == 0) {
                return "No " .  $error_feedback;
            } else {
                if ($score >= 0) {
                }
                return (string)$score . " " . $error_feedback;
            }
        }
    }
    public function qualityRating($quality, $qualityType, $lenght)
    {
        if ($qualityType == 1) {
            if ($quality == 0) {
                return '5';
            } else if ($quality >= 1 && $quality <= 2) {
                return '4';
            } else if ($quality >= 3 && $quality <= 4) {
                return '3';
            } else if ($quality >= 5 && $quality <= 6) {
                return '2';
            } else if ($quality >= 7) {
                return '1';
            }
        } else if ($qualityType == 2) {
            $length = $lenght; // your length value here;
            if ($length == 0) {
                $total = 0; // or handle the zero case as appropriate
            } else {
                $total = round($quality / $length);
            }
            if ($total == 5) {
                return "5";
            } else if ($total >= 4 && $total <= 4.99) {
                return "4";
            } else if ($total >= 3 && $total <= 3.99) {
                return "3";
            } else if ($total >= 2 && $total <= 2.99) {
                return "2";
            } else if ($total >= 1 && $total <= 1.99) {
                return "1";
            } else {
                return "0";
            }
        } else if ($qualityType == 3) {
            return "0";
        } else if ($qualityType == 4) {
            if ($quality >= 1) {
                return "2";
            } else {
                return "5";
            }
        }
    }

    public function timelinessRating() {}

    public function quantityRating($quantityType, $quantityScore, $targetQuantity)
    {
        if ($quantityType == 1) {
            if ($targetQuantity != 0) {
                $total = ROUND(($quantityScore / $targetQuantity) * 100);
            } else {
                // Handle the case where $targetQuantity is zero
                $total = 0; // or some other appropriate value or action
            }
            if ($total >= 130) {
                return "5";
            } else if ($total <= 129 && $total >= 115) {
                return  "4";
            } else if ($total <= 114 && $total >= 90) {
                return "3";
            } else if ($total <= 89 && $total >= 51) {
                return "2";
            } else if ($total >= 1 && $total <= 50) {
                return "1";
            } else {
                return "0";
            }
        } else if ($quantityType == 2) {
            $total = FLOOR(($quantityScore / $targetQuantity) * 100);
            if ($total == 100) {
                return "5";
            } else {
                return "2";
            }
        }
    }

    public function semestralReview(Request $request)
    {
        // dd($request->id_shown);
        // $id = auth()->user()->username;
        // dd($id);
        // dd($sem_id);
        $sem_id = $request->sem_id;
        $emp = auth()->user()->userEmployee;
        // dd($emp->latestSemestral->lastestSemestralImmediate);
        // dd($sem_id);
        $emp_code = $request->empl_id;
        $esd = EmployeeSpecialDepartment::where('employee_code', $emp_code)->first();
        $division = "";
        $TimeRating = $request->TimeRating;
        $prescribed_period = '';
        $time_unit = '';

        if ($esd) {
            if ($esd->department_code) {
                // $office = FFUNCCOD::where('department_code', $esd->department_code)->first();
                $emp->office = Office::where('department_code', $esd->department_code)->first();
            }
            if ($esd->pgdh_cats) {
                $pgHead = UserEmployees::where('empl_id', $esd->pgdh_cats)->first();
                // dd('esd');
            } else {
                $pgHead = UserEmployees::where('empl_id', $emp->Office->empl_id)->first();
            }
        } else {
            $pgHead = $emp->Office->pgHead;
        }


        $suff = "";
        $post = "";
        $mn = "";
        if ($pgHead->suffix_name != '') {
            $suff = ', ' . $pgHead->suffix_name;
        }
        if (
            $pgHead->postfix_name != ''
        ) {
            $post = ', ' . $pgHead->postfix_name;
        }
        if ($pgHead->middle_name != '') {
            $mn = $pgHead->middle_name[0] . '. ';
        }
        $pgHead = $pgHead->first_name . ' ' . $mn  . $pgHead->last_name . '' . $suff . '' . $post;
        $data = IPCRTargets::with([
            'individualOutput.timeRanges',
            'individualOutput.divisionOutput.division',
            'individualOutput.divisionOutput.majorFinalOutput',
            'individualOutput.subMfo',
            'semestralRemarks' => function ($query) use ($sem_id) {
                $query->where('idSemestral', $sem_id);
            },
            'individualOutput.ipcrDailyAccomplishments' => function ($query) use ($sem_id) {
                $query->where('sem_id', $sem_id);
            },
            'ipcr_Semestral',
            'ipcr_Semestral.userEmployee',
            'ipcr_Semestral.latestReturnRemarkNextHigher' => function ($query) use ($sem_id) {
                $query->where('type', 'approve semestral accomplishment');
                $query->where('ipcr_semestral_id', $sem_id);
            },
        ])
            ->where('employee_code', '=', $emp_code)
            ->where('ipcr_semester_id', $sem_id)
            ->get()
            ->map(function ($item, $key) use ($sem_id) {
                $result = $item->individualOutput->ipcrDailyAccomplishments
                    ->where('sem_id', $sem_id)
                    ->where('idIPCR', $item->ipcr_code)
                    ->sortBy(function ($item) {
                        return Carbon::parse($item->date)->month;
                    })
                    ->groupBy(function ($item) {
                        return Carbon::parse($item->date)->month;
                    })
                    ->map(fn($result) => [
                        // ($result->sum('quantity') > 0) ? $result->sum('quantity') : dd($result->sum('quantity')),
                        'month' => Carbon::parse($result[0]->date)->format('n'),
                        'quantity' => $result->sum('quantity'),
                        'quality' => $result->sum('quality'),
                        'TotalAverage' => $result->sum('average_timeliness'),
                        'timeliness' => $result->sum('timeliness'),
                        'quality_count' => $result->count(),
                        'average_quality' => number_format($result->sum('quality') / (($result->count() > 0) ? $result->count() : 1), 2),
                        'average_time' => number_format($result->sum('average_timeliness') / (($result->sum('quantity') > 0) ? $result->sum('quantity') : 1), 0),
                        // 'score' => $this->score(number_format($result->sum('quality') / $result->count(), 2))
                    ])
                    ->values();
                return [
                    "result" => $result,
                    "ipcr_code" => $item->ipcr_code,
                    "id" => $item->id,
                    "ipcr_type" => $item->ipcr_type,
                    "ipcr_semester_id" => $item->ipcr_semester_id,
                    "year" => $item->year,
                    "quantity_sem" => $item->quantity_sem,
                    "performance_measure" => $item->performance_measure,
                    "success_indicator" => $item->individualOutput->success_indicator,
                    "quantity_type" => $item->individualOutput->quantity_type,
                    "quality_error" => $item->individualOutput->quality_error,
                    "time_range_code" => $item->individualOutput->time_range_code,
                    "time_based" => $item->individualOutput->time_based,
                    "prescribed_period" => $item->individualOutput->prescribed_period,
                    "time_unit" => $item->individualOutput->time_unit,
                    "division_name1 AS division" => $item->division,
                    "output AS div_output" => $item->div_output,
                    "mfo_desc" => $item->individualOutput->divisionOutput->majorFinalOutput->mfo_desc,
                    "FFUNCCOD" => $item->FFUNCOD,
                    "submfo_description" => $item->submfo_description,
                    "remarks" => $item->semestralRemarks ? $item->semestralRemarks->remarks : '',
                    "remarks_id" => $item->semestralRemarks ? $item->semestralRemarks->id : '',
                    'indi_output' => $item->individualOutput,
                    "sem" => $item->ipcr_Semestral,
                    "userEmployee" => $item->ipcr_Semestral->UserEmployee,
                    "Remarks" => $item->ipcr_Semestral->latestReturnRemark
                ];
            });
        // dd($data);
        $sem = $data[0]['sem'];

        $sem_data = [
            'id' => $sem_id,
            'employee_code' => $emp_code,
            'division' => '',
            "employee" => $data[0]['userEmployee'],
            'sem' => $sem->sem,
            'status' => $sem->status,
            'status_accomplishment' => $sem->status_accomplishment,
            'year' => $sem->year,
            'rem' => 'remmm',
        ];

        return [
            'data' => $data,
            'sem' => $sem,
            'sem_data' => $sem_data,
        ];
    }

    public function store(Request $request)
    {
        $sem_id = $request->idSemestral;

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

        // dd($request->emp_code);
        $date_now = Carbon::now();
        $dn = $date_now->format('m-d-Y');
        $remarks = ReturnRemarks::select(
            'return_remarks.remarks',
            'return_remarks.created_at',
            'return_remarks.ipcr_semestral_id',
            'ipcr__semestrals.status_accomplishment',
        )
            ->leftjoin('ipcr__semestrals', 'ipcr__semestrals.id', 'return_remarks.ipcr_semestral_id')
            ->where('return_remarks.type', 'review semestral accomplishment')
            ->where('return_remarks.ipcr_semestral_id', $request->idsemestral)
            ->where('return_remarks.employee_code', $request->emp_code)
            ->orderBy('return_remarks.created_at', 'DESC')
            ->first();

        $remarkshigher = ReturnRemarks::select(
            'return_remarks.remarks',
            'return_remarks.created_at',
            'return_remarks.ipcr_semestral_id',
            'ipcr__semestrals.status_accomplishment',
        )
            ->leftjoin('ipcr__semestrals', 'ipcr__semestrals.id', 'return_remarks.ipcr_semestral_id')
            ->where('return_remarks.type', 'approve semestral accomplishment')
            ->where('return_remarks.ipcr_semestral_id', $request->idsemestral)
            ->where('return_remarks.employee_code', $request->emp_code)
            ->orderBy('return_remarks.created_at', 'DESC')
            ->first();
        // dd($remarks);
        // dd($remarkshigher->status_accomplishment);

        $review_remarks = "";
        $remarks_status = 0;
        if (isset($remarks)) {
            $review_remarks = $remarks->remarks;
            $remarks_status = $remarks->status_accomplishment;
        };

        $review_remarks1 = "";
        $remarks_status1 = 0;
        if (isset($remarkshigher)) {
            $review_remarks1 = $remarkshigher->remarks;
            $remarks_status1 = $remarkshigher->status_accomplishment;
        };

        $TotalRatings = ($request->Average_Point_Core * .70) + ($request->Average_Point_Support * .30);
        $totalRating = number_format(round($TotalRatings, 2), 2);

        // dd($remarks_status == 0 ? $remarks_status1 : $remarks_status);
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
                "Total_Average_Score" => $totalRating,
                "Semestral_Remarks" => $review_remarks,
                "Semestral_RemarksHigher" => $review_remarks1,
                "Semestral_status" => $remarks_status == 0 ? $remarks_status1 : $remarks_status
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
                "Total_Average_Score" => $totalRating,
                "Semestral_Remarks" => $review_remarks,
                "Semestral_RemarksHigher" => $review_remarks1,
                "Semestral_status" => $remarks_status == 0 ? $remarks_status1 : $remarks_status
            ]
        ];
        // dd($arr);
        return $arr;
    }

    public function semester_print_score(Request $request)
    {
        $sem_id = $request->idsemestral;

        $data = IPCRTargets::with([
            'individualOutput',
            'individualOutput.timeRanges',
            'individualOutput.divisionOutput.division',
            'individualOutput.divisionOutput.majorFinalOutput',
            'individualOutput.subMfo',
            'semestralRemarks' => function ($query) use ($sem_id) {
                $query->where('idSemestral', $sem_id);
            },
            'individualOutput.ipcrDailyAccomplishments' => function ($query) use ($sem_id) {
                $query->where('sem_id', $sem_id);
            },
            'ipcr_Semestral',
            'ipcr_Semestral.latestReturnRemarkNextHigher' => function ($query) use ($sem_id) {
                $query->where('type', 'approve semestral accomplishment');
                $query->where('ipcr_semestral_id', $sem_id);
            },
        ])

            ->where('ipcr_semester_id', $sem_id)
            ->where('ipcr_type', $request->type)
            ->get()

            ->map(function ($item, $key) use ($sem_id) {
                // dd($item);
                $result = $item->individualOutput->ipcrDailyAccomplishments
                    ->where('sem_id', $sem_id)
                    ->where('idIPCR', $item->ipcr_code)
                    ->sortBy(function ($item) {
                        return Carbon::parse($item->date)->month;
                    })
                    ->groupBy(function ($item) {
                        return Carbon::parse($item->date)->month;
                    })
                    ->map(fn($result, $key) => [
                        'month' => Carbon::parse($result[0]->date)->format('n'),
                        'quantity' => $result->sum('quantity'),
                        'quality' => $result->sum('quality'),
                        'TotalAverage' => $result->sum('average_timeliness'),
                        'timeliness' => $result->sum('timeliness'),
                        // $result->sum('quantity') ? "quantity" : dd($result->sum('average_timeliness')),
                        'timeliness_total' => $result->sum('quantity') > 0 ? $result->sum('quantity') * ($result->sum('average_timeliness') / $result->sum('quantity')) : 0,
                        // 'timeliness_total' => $result->sum('quantity') * number_format($result->sum('average_timeliness') / $result->sum('quantity'), 0),
                        'quality_count' => $result->count(),
                        'average_quality' => $result->count() > 0 ? number_format($result->sum('quality') / $result->count(), 2) : 0,
                        'average_quality_number' => $result->sum('quality') / ($result->count() > 0 ? $result->count() : 1),
                        'average_time' => $result->sum('quantity') > 0 ? number_format($result->sum('average_timeliness') / $result->sum('quantity'), 0) : 0,
                        'average_time_number' => $result->sum('quantity') > 0 ? $result->sum('average_timeliness') / $result->sum('quantity') : 0,
                        // 'average_quality' => number_format($result->sum('quality') / $result->count(), 2),
                        // 'average_time' => number_format($result->sum('average_timeliness') / $result->sum('quantity'), 0),
                    ])
                    ->values();

                // dd($item);
                $sumQuantity = $result->sum('quantity');
                if ($sumQuantity == 0) {
                    $averageTimeliness = 0; // or handle the zero case as appropriate
                } else {
                    $averageTimeliness = (int) round($result->sum('timeliness_total') / $sumQuantity, 0);
                }




                // $averageTimeliness = (int) round($result->sum('timeliness_total') / $result->sum('quantity'), 0);

                try {
                    $timeRate = ($item->individualOutput->timeRanges->filter(function ($row) use ($averageTimeliness) {
                        return $this->getTimeRate($row, $averageTimeliness);
                    })->first());
                } catch (\Throwable $th) {
                    $timeRate = $item->individualOutput->timeRanges;
                    $timeRate->filter(function ($row) use ($averageTimeliness) {
                        return $row->equivalent_time_from <= $averageTimeliness && $row->equivalent_time_to >= $averageTimeliness;
                    });
                }
                // dump($this->score($result->sum('average_quality'), $item->individualOutput->quality_error));

                // dd(ROUND(($result->sum('quantity') / $item->quantity_sem) * 100), 0);
                $qualityRate = $result->count() == 0 ? "0" : $this->qualityRating($this->score($result->sum('average_quality_number'), $item->individualOutput->quality_error), $item->individualOutput->quality_error, $result->count());
                $quantityRate = $result->count() == 0 ? "0" : $this->quantityRating($item->individualOutput->quantity_type, $result->sum('quantity'), $item->quantity_sem);

                // dd($timeRate == null);
                if ($timeRate != null) {
                    $averageRating = $this->averageRate($quantityRate, $qualityRate, $averageTimeliness == 0 ? "0" : $timeRate->rating);
                    $timelinessRating = $averageTimeliness == 0 ? "0" : $timeRate->rating;
                } else {
                    $averageRating = $this->averageRate($quantityRate, $qualityRate, 0);
                    $timelinessRating = "";
                }
                //$total = FLOOR(($quantityScore / $targetQuantity) * 100);
                // dd($qualityRate);
                // dd($result);

                return [
                    "result" => $result,
                    "result_count" => $result->count(),
                    "TotalQuantity" => $result->sum('quantity'),
                    "TotalQuality" => $result->sum('average_quality_number'),
                    'score' => $this->score($result->sum('average_quality_number'), $item->individualOutput->quality_error),
                    "TotalTimeliness" =>
                    $item->individualOutput->time_range_code == 56 ? "" : $result->sum('timeliness_total'),
                    "averageTimeliness" => $item->individualOutput->time_range_code == 56 ? "" : $averageTimeliness,
                    "ipcr_code" => $item->ipcr_code,
                    "id" => $item->id,
                    "ipcr_type" => $item->ipcr_type,
                    'qualityRating' => $result->count() == 0 ? "0" : $qualityRate,
                    'quantityRating' => $result->count() == 0 ? "0" : $quantityRate,
                    'timelinessRating' => $timelinessRating,
                    'averageRating' => $averageRating,
                    'error_feedback' => $this->feedbackError($this->score($result->sum('average_quality_number'), $item->individualOutput->quality_error), $this->qualityRating($this->score($result->sum('average_quality_number'), $item->individualOutput->quality_error), $item->individualOutput->quality_error, $result->count()), $item->individualOutput->error_feedback),
                    "ipcr_semester_id" => $item->ipcr_semester_id,
                    "quantity_sem" => $item->quantity_sem,
                    "individual_output" => $item->individualOutput->individual_output,
                    "performance_measure" => $item->individualOutput->performance_measure,
                    "success_indicator" => $item->individualOutput->success_indicator,
                    "quantity_type" => $item->individualOutput->quantity_type,
                    "quality_error" => $item->individualOutput->quality_error,
                    "time_range_code" => $item->individualOutput->time_range_code,
                    "time_based" => $item->individualOutput->time_based,
                    "division_output" => $item->individualOutput->divisionOutput->output,
                    "mfo_desc" => $item->individualOutput->divisionOutput->majorFinalOutput->mfo_desc,
                    "submfo_description" => $item->submfo_description,
                    "remarks" => $item->semestralRemarks ? $item->semestralRemarks->remarks : '',
                    "remarks_id" => $item->semestralRemarks ? $item->semestralRemarks->id : '',
                    'activity' => $item->individualOutput->activity,
                    'verb' => $item->individualOutput->verb,
                    'within' => $item->individualOutput->within,
                    'unit_of_time' => $item->individualOutput->unit_of_time,
                    'concatenate' => $item->individualOutput->concatenate,
                    'indi_output' => $item->individualOutput,
                ];
            });

        // dd($data);
        return $data;
        // $emp_code = $request->emp_code;

    }

    protected function getTimeRate($data, $averageTimeliness)
    {
        $operator = $data->operator;
        if ($averageTimeliness) {
        }
        if ($operator !== 'between') {

            return $operator == '>=' ? $averageTimeliness >= $data->equivalent_time_to : $averageTimeliness <= $data->equivalent_time_from;
        } else {
            return $data->rating == 3 ? $data->equivalent_time_from == $averageTimeliness : $data->equivalent_time_from <= $averageTimeliness && $data->equivalent_time_to >= $averageTimeliness;
        }
    }

    public function semester_second_print(Request $request)
    {

        $date_now = Carbon::now();
        $dn = $date_now->format('m-d-Y');
        $remarks = ReturnRemarks::select(
            'return_remarks.remarks',
            'return_remarks.created_at',
            'return_remarks.ipcr_semestral_id',
            'ipcr__semestrals.status_accomplishment',
        )
            ->leftjoin('ipcr__semestrals', 'ipcr__semestrals.id', 'return_remarks.ipcr_semestral_id')
            ->where('return_remarks.type', 'review semestral accomplishment')
            ->where('return_remarks.ipcr_semestral_id', $request->idsemestral)
            ->where('return_remarks.employee_code', $request->emp_code)
            ->orderBy('return_remarks.created_at', 'DESC')
            ->first();

        $review_remarks = "";
        $remarks_status = 0;
        if (isset($remarks)) {
            $review_remarks = $remarks->remarks;
            $remarks_status = $remarks->status_accomplishment;
        };

        // dd($review_remarks);
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
                "Semestral_Remarks" => $review_remarks,
                "Semestral_status" => $remarks_status
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
                "Semestral_Remarks" => $review_remarks,
                "Semestral_status" => $remarks_status
            ]
        ];
        return $arr;
    }

    public function semester_print_second(Request $request)
    {
        // dd($request->idsemestral);
        $emp_code = $request->emp_code;
        $sem_id = $request->idsemestral;
        $Total = 0;

        //         $table_result = "SELECT MONTH
        // 	( A.date ) AS MONTH,
        // 	SUM( A.quantity ) AS quantity,
        // 	SUM( A.quality ) AS quality,
        // 	SUM( A.timeliness ) AS timeliness,
        // 	COUNT( A.quality ) AS quality_count,
        // 	ROUND( SUM( A.quality ) / COUNT( A.quality ) ) AS average_quality,
        // 	ROUND( SUM( A.average_timeliness ) / SUM( A.quantity ) ) AS average_timeliness,
        // 	ROUND( MNO.total_timeXX ) AS total_timeliness,
        // 	(
        // 	 SELECT
        // 	SUM( X.quantity ),
        //     idIPCR
        // FROM
        // 	ipcr_daily_accomplishments X
        // WHERE
        // 	X.sem_id = A.sem_id
        // 	AND X.idIPCR = A.idIPCR
        // 	) AS sum_all_quantity,
        // 	(
        // SELECT
        // 	COUNT( MNX.monthX )
        // FROM
        // 	(
        // SELECT MONTH
        // 	( A.date ) AS monthX
        // FROM
        // 	ipcr_daily_accomplishments A
        // WHERE
        // 	A.sem_id = 32
        // 	AND A.idIPCR = 23
        // GROUP BY
        // 	MONTH ( A.date )
        // 	) AS MNX
        // 	) AS month_count,
        // 	ROUND( MN.average_qualityXX ) AS sum_all_quality
        // FROM
        // 	`ipcr_daily_accomplishments` AS `A`
        // 	INNER JOIN (
        // SELECT
        // 	SUM( MNX.average_qualityX ) AS average_qualityXX,
        // 	MNX.sem_idX,
        // 	MNX.idIPCRX
        // FROM
        // 	(
        // SELECT
        // 	 ( SUM( X.quality ) / COUNT( X.quality ) ) AS average_qualityX,
        // 	X.idIPCR AS idIPCRX,
        // 	X.sem_id AS sem_idX,
        // 	MONTH ( X.date ) AS xmont
        // FROM
        // 	ipcr_daily_accomplishments X
        // GROUP BY
        // 	X.idIPCR,
        // 	X.sem_id,
        // 	MONTH ( X.date )
        // 	) MNX
        // GROUP BY
        // 	MNX.sem_idX,
        // 	MNX.idIPCRX
        // 	) MN ON `MN`.`idIPCRX` = `A`.`idIPCR`
        // 	AND `MN`.`sem_idX` = `A`.`sem_id`
        // 	INNER JOIN (
        // SELECT
        // 	SUM( MNX.total_timeX ) AS total_timeXX,
        // 	MNX.sem_idX,
        // 	MNX.idIPCRX
        // FROM
        // 	(
        // SELECT
        // 	 ( SUM( X.quantity ) * SUM( X.timeliness ) ) AS total_timeX,
        // 	X.idIPCR AS idIPCRX,
        // 	X.sem_id AS sem_idX,
        // 	MONTH ( X.date ) AS xmont
        // FROM
        // 	ipcr_daily_accomplishments X
        // GROUP BY
        // 	X.idIPCR,
        // 	X.sem_id,
        // 	MONTH ( X.date )
        // 	) MNX
        // GROUP BY
        // 	MNX.sem_idX,
        // 	MNX.idIPCRX
        // 	) MNO ON `MNO`.`idIPCRX` = `A`.`idIPCR`
        // 	AND `MNO`.`sem_idX` = `A`.`sem_id`
        // WHERE
        // 	`sem_id` = $sem_id
        // GROUP BY
        // 	MONTH ( date )
        // ORDER BY
        // 	MONTH ( date ) ASC ";

        $data = IndividualFinalOutput::select(
            'individual_final_outputs.ipcr_code',
            'i_p_c_r_targets.id',
            'i_p_c_r_targets.ipcr_type',
            'i_p_c_r_targets.quantity_sem',
            'i_p_c_r_targets.ipcr_semester_id',
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
            // ->leftJoinSub($table_result, 'tr', 'individual_final_outputs.ipcr_code', 'tr.idIPCR')

            ->where('i_p_c_r_targets.employee_code', $emp_code)
            ->where('i_p_c_r_targets.ipcr_semester_id', $sem_id)
            ->where('i_p_c_r_targets.ipcr_type', $request->type)
            ->distinct('time_ranges.prescribed_period')
            ->distinct('time_ranges.time_unit')
            ->orderBy('individual_final_outputs.ipcr_code')
            // ->dd()
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
                    // ->dd()
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
                $quantity_month1 = "";
                $quantity_month2 = "";
                $quantity_month3 = "";
                $quantity_month4 = "";
                $quantity_month5 = "";
                $quantity_month6 = "";
                $quality_month1 = "";
                $quality_month2 = "";
                $quality_month3 = "";
                $quality_month4 = "";
                $quality_month5 = "";
                $quality_month6 = "";
                $timeliness_month1 = "";
                $timeliness_month2 = "";
                $timeliness_month3 = "";
                $timeliness_month4 = "";
                $timeliness_month5 = "";
                $timeliness_month6 = "";


                // if ($result[$x]->month == 1 || $result[$x]->month == 7) {
                //     $quantity_month1 = $result[$x]->quantity;
                // } else if ($result[$x]->month == 2 || $result[$x]->month == 8) {
                //     $quantity_month2 = $result[$x]->quantity;
                // } else if ($result[$x]->month == 3 || $result[$x]->month == 9) {
                //     $quantity_month3 = $result[$x]->quantity;
                // } else if ($result[$x]->month == 4 || $result[$x]->month == 10) {
                //     $quantity_month4 = $result[$x]->quantity;
                // } elseif ($result[$x]->month == 5 || $result[$x]->month == 11) {
                //     $quantity_month5 = $result[$x]->quantity;
                // } else if ($result[$x]->month == 6 || $result[$x]->month == 12) {
                //     $quantity_month6 = $result[$x]->quantity;
                // }

                // if ($result[$x]->month == 1 || $result[$x]->month == 7) {
                //     $quality_month1 = $result[$x]->average_quality;
                // } else if ($result[$x]->month == 2 || $result[$x]->month == 8) {
                //     $quality_month2 = $result[$x]->average_quality;
                // } else if ($result[$x]->month == 3 || $result[$x]->month == 9) {
                //     $quality_month3 = $result[$x]->average_quality;
                // } else if ($result[$x]->month == 4 || $result[$x]->month == 10) {
                //     $quality_month4 = $result[$x]->average_quality;
                // } else if ($result[$x]->month == 5 || $result[$x]->month == 11) {
                //     $quality_month5 = $result[$x]->average_quality;
                // } else if ($result[$x]->month == 6 || $result[$x]->month == 12) {
                //     $quality_month6 = $result[$x]->average_quality;
                // }


                // if ($result[$x]->month == 1 || $result[$x]->month == 7) {
                //     $timeliness_month1 = $result[$x]->average_timeliness;
                // } else if ($result[$x]->month == 2 || $result[$x]->month == 8) {
                //     $timeliness_month2 = $result[$x]->average_timeliness;
                // } else if ($result[$x]->month == 3 || $result[$x]->month == 9) {
                //     $timeliness_month3 = $result[$x]->average_timeliness;
                // } else if ($result[$x]->month == 4 || $result[$x]->month == 10) {
                //     $timeliness_month4 = $result[$x]->average_timeliness;
                // } else if ($result[$x]->month == 5 || $result[$x]->month == 11) {
                //     $timeliness_month5 = $result[$x]->average_timeliness;
                // } else if ($result[$x]->month == 6 || $result[$x]->month == 12) {
                //     $timeliness_month6 = $result[$x]->average_timeliness;
                // }

                for ($x = 0; $x < count($result); $x++) {
                    $sum_all_quantity = $result[$x]->sum_all_quantity;
                    $sum_all_quality = $result[$x]->average_quality;
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


                // dd($averageRating);



                return [
                    "TimeRange" => $data,
                    "result" => $result,
                    "ipcr_code" => $item->ipcr_code,
                    "id" => $item->id,
                    "ipcr_type" => $item->ipcr_type,
                    "quantity_sem" => $item->quantity_sem,
                    "success_indicator" => $item->success_indicator,
                    "quantity_type" => $item->quantity_type,
                    "quality_error" => $item->quality_error,
                    "time_range_code" => $item->time_range_code,
                    "time_based" => $item->time_based,
                    "prescribed_period" => $item->prescribed_period,
                    "time_unit" => $item->time_unit,
                    "mfo_desc" => $item->mfo_desc,
                    "FFUNCCOD" => $item->FFUNCOD,
                    "submfo_description" => $item->submfo_description,
                    "sum_all_quantity" => $sum_all_quantity,
                    "sum_all_quality" => $sum_all_quality,
                    "TotalTimeliness" => $ave_time,
                    "ave_time" => $ave_times,
                    "QuantityRating" => $QuantityRating,
                    "QualityRating" => $QualityRating,
                    "TimelinessRating" => $TimelinessRating,
                    "remarks" => $item->remarks,
                    "remarks_id" => $item->remarks_id,
                    "quantity_month1" => $quantity_month1,
                    "quantity_month2" => $quantity_month2,
                    "quantity_month3" => $quantity_month3,
                    "quantity_month4" => $quantity_month4,
                    "quantity_month5" => $quantity_month5,
                    "quantity_month6" => $quantity_month6,
                    "quality_month1" => $quality_month1,
                    "quality_month2" => $quality_month2,
                    "quality_month3" => $quality_month3,
                    "quality_month4" => $quality_month4,
                    "quality_month5" => $quality_month5,
                    "quality_month6" => $quality_month6,
                    "timeliness_month1" => $timeliness_month1,
                    "timeliness_month2" => $timeliness_month2,
                    "timeliness_month3" => $timeliness_month3,
                    "timeliness_month4" => $timeliness_month4,
                    "timeliness_month5" => $timeliness_month5,
                    "timeliness_month6" => $timeliness_month6,
                ];
            });
        // dd($data);
        return $data;
    }

    public function api_ipcr(Request $request)
    {
        // dd($request->emp_code);
        $emp_code = $request->emp_code;
        // dd($request->all());
        $status = 2;
        $current_date = date('Y-m-d');

        $current_month = date('n'); // Get the current month (01-12)
        $current_year = date('Y');

        $currentSem = 0;
        // $months = $current_month;
        $months = 6;
        if ($current_month > 6) {
            $months = $current_month - 6;
        }

        // dd($months);
        if ($current_month < 7) {
            $currentSem  = 1;
        } else {
            $currentSem = 2;
        }

        $semester = Ipcr_Semestral::select(
            'id'
        )
            ->where('employee_code', $emp_code)
            ->where('year', 2024)
            ->where('sem', 2)
            ->first();



        $data = IPCRTargets::select(
            'i_p_c_r_targets.id',
            'i_p_c_r_targets.ipcr_code',
            DB::raw('IFNULL(i_p_c_r_targets.month_' . $months . ', 0) as quantity_sem'),
            'individual_final_outputs.individual_output',
            DB::raw('CONCAT(individual_final_outputs.performance_measure, " (", IFNULL(i_p_c_r_targets.month_' . $months . ', 0), ")") AS performance_measure'),
            'ipcr__semestrals.status',
        )
            ->leftJoin('individual_final_outputs', 'i_p_c_r_targets.ipcr_code', '=', 'individual_final_outputs.ipcr_code')
            ->leftJoin('ipcr__semestrals', 'i_p_c_r_targets.employee_code', '=', 'ipcr__semestrals.employee_code')
            ->where('i_p_c_r_targets.employee_code', $emp_code)
            ->where('i_p_c_r_targets.semester', 2)
            ->where('i_p_c_r_targets.year', 2024)
            ->where('ipcr__semestrals.status', $status)
            ->where('i_p_c_r_targets.ipcr_semester_id', $semester->id)
            ->groupBy('individual_final_outputs.ipcr_code')
            ->orderBy('individual_final_outputs.ipcr_code')
            ->get();
        return $data;
    }

    public function getTimeRanges(Request $request) {}

    public function submitAccomplishment(Request $request, $id)
    {
        // dd("dddddd: " . $id);
        Ipcr_Semestral::where('id', $id)
            ->update([
                'status_accomplishment' => '0'
            ]);

        $rem = new ReturnRemarks();
        $rem->type = "Submit semestral accomplishment";
        $rem->ipcr_semestral_id = $id;
        $rem->employee_code = auth()->user()->username;
        $rem->save();
        // return redirect('semester-accomplishment/semestral/accomplishment/' . $id)
        //     ->with('message', 'Successfully submitted semestral accomplishment!');
        return back()->with('message', 'Successfully submitted semestral accomplishment!');
    }
    public function recallAccomplishment(Request $request, $id)
    {
        // dd("id: " . $id);
        Ipcr_Semestral::where('id', $id)
            ->update([
                'status_accomplishment' => '-1'
            ]);
        $rem = new ReturnRemarks();
        $rem->type = "Recall semestral accomplishment";
        $rem->ipcr_semestral_id = $id;
        $rem->employee_code = auth()->user()->username;
        $rem->save();
        // return redirect('semester-accomplishment/semestral/accomplishment/' . $id)
        //     ->with('message', 'Successfully submitted semestral accomplishment!');
        return back()->with('message', 'Recall successful!');
    }

    public function semestral_backup(Request $request, $sem_id)
    {
        // dd($request->id_shown);
        // $id = auth()->user()->username;
        // dd($id);
        $emp = auth()->user()->userEmployee;
        // dd($emp);

        $emp_code = $emp->empl_id;
        $esd = EmployeeSpecialDepartment::where('employee_code', $emp_code)->first();
        $division = "";
        $TimeRating = $request->TimeRating;
        $prescribed_period = '';
        $time_unit = '';
        // dd($emp);
        // if ($emp->division_code) {
        //     //dd($emp->division_code);
        //     $division = Division::where('division_code', $emp->division_code)
        //         ->first()->division_name1;
        // }
        // $office = FFUNCCOD::where('department_code', $emp->department_code)->first();
        // $emp->office = Office::where('department_code', $emp->department_code)->first();
        if ($esd) {
            if ($esd->department_code) {
                // $office = FFUNCCOD::where('department_code', $esd->department_code)->first();
                $emp->office = Office::where('department_code', $esd->department_code)->first();
            }
            // else {
            //     // $office = FFUNCCOD::where('department_code', $emp->department_code)->first();
            //     $emp->office = Office::where('department_code', $emp->department_code)->first();
            // }

            if ($esd->pgdh_cats) {

                $pgHead = UserEmployees::where('empl_id', $esd->pgdh_cats)->first();
                // dd('esd');
            } else {
                $pgHead = UserEmployees::where('empl_id', $emp->Office->empl_id)->first();
            }
        } else {
            $pgHead = UserEmployees::where('empl_id', $emp->office->empl_id)->first();
        }


        // dd($pgHead);
        $suff = "";
        $post = "";
        $mn = "";
        if ($pgHead->suffix_name != '') {
            $suff = ', ' . $pgHead->suffix_name;
        }
        if (
            $pgHead->postfix_name != ''
        ) {
            // dd('fsdfdsfsdf');
            $post = ', ' . $pgHead->postfix_name;
        }
        if ($pgHead->middle_name != '') {
            $mn = $pgHead->middle_name[0] . '. ';
        }
        $pgHead = $pgHead->first_name . ' ' . $mn  . $pgHead->last_name . '' . $suff . '' . $post;
        // $pgHead = $pgHead->first_name . ' ' . $pgHead->middle_name[0] . '. ' . $pgHead->last_name . '' . $suff . '' . $post;
        // dd($emp_code);
        $data = IPCRTargets::with([
            'individualOutput.timeRanges',
            'individualOutput.divisionOutput.division',
            'individualOutput.divisionOutput.majorFinalOutput',
            'individualOutput.subMfo',
            'semestralRemarks',
            'individualOutput.ipcrDailyAccomplishments' => function ($query) use ($sem_id) {
                $query->where('sem_id', $sem_id);
            },
            // 'ipcrTarget' => function($query) use($emp_code, $sem_id) {
            //     $query->where('employee_code', '=', $emp_code)->where('ipcr_semester_id', $sem_id);
            // }
        ])
            // ->select(
            //     'individual_final_outputs.ipcr_code',
            //     // 'i_p_c_r_targets.id',
            //     // 'i_p_c_r_targets.ipcr_type',
            //     // 'i_p_c_r_targets.quantity_sem',
            //     // 'i_p_c_r_targets.ipcr_semester_id',
            //     // 'i_p_c_r_targets.year',
            //     'individual_final_outputs.individual_output',
            //     'individual_final_outputs.performance_measure',
            //     'individual_final_outputs.success_indicator',
            //     'individual_final_outputs.quantity_type',
            //     'individual_final_outputs.quality_error',
            //     'individual_final_outputs.time_range_code',
            //     'individual_final_outputs.time_based',
            //     // 'time_ranges.prescribed_period',
            //     // 'time_ranges.time_unit',
            //     // 'divisions.division_name1 AS division',
            //     // 'division_outputs.output AS div_output',
            //     // 'major_final_outputs.mfo_desc',
            //     // 'major_final_outputs.FFUNCCOD',
            //     // 'sub_mfos.submfo_description',
            //     'semestral_remarks.remarks',
            //     'semestral_remarks.id AS remarks_id',
            //     DB::raw("'$TimeRating' AS TimeRating"),
            // )
            // ->leftjoin('time_ranges', 'time_ranges.time_code', 'individual_final_outputs.time_range_code')
            // ->leftjoin('division_outputs', 'division_outputs.id', 'individual_final_outputs.id_div_output')
            // ->leftjoin('divisions', 'divisions.id', 'division_outputs.division_id')
            // ->leftjoin('major_final_outputs', 'major_final_outputs.id', 'division_outputs.idmfo')
            // ->leftjoin('sub_mfos', 'sub_mfos.id', 'individual_final_outputs.idsubmfo')
            // ->leftjoin('i_p_c_r_targets', 'i_p_c_r_targets.ipcr_code', 'individual_final_outputs.ipcr_code')
            // ->leftJoin('semestral_remarks', function ($join) use ($sem_id) {
            //     $join->on('i_p_c_r_targets.ipcr_code', '=', 'semestral_remarks.idIPCR')
            //         ->where('semestral_remarks.idSemestral', '=', $sem_id)
            //         ->where('i_p_c_r_targets.ipcr_semester_id', '=', $sem_id);
            // })
            // ->where('i_p_c_r_targets.employee_code', $emp_code)
            // ->where('i_p_c_r_targets.ipcr_semester_id', $sem_id)

            // ->whereHas('semestralRemarks', function($query) use($sem_id){
            //     $query->where('idSemestral', '=', $sem_id)
            //             ->where('ipcr_semester_id', '=', $sem_id);
            // })
            // ->whereHas('individualOutput.ipcrDailyAccomplishments',function($query) use($sem_id) {
            //     $query->where('sem_id', $sem_id);
            // })

            // ->whereHas('ipcrTarget',function($query) use($emp_code, $sem_id) {
            //     $query->where('employee_code', '=', $emp_code)
            //         ->where('ipcr_semester_id', $sem_id);
            // })
            ->where('employee_code', '=', $emp_code)
            ->where('ipcr_semester_id', $sem_id)
            // ->withSum(['individualOutput.ipcrDailyAccomplishments as quantity'], 'quantity')
            // ->withSum(['individualOutput.ipcrDailyAccomplishments as quality'], 'quality')
            // ->withSum(['individualOutput.ipcrDailyAccomplishments as TotalAverage'], 'average_timeliness')
            // ->withSum(['individualOutput.ipcrDailyAccomplishments as timeliness'], 'timeliness')
            // ->withCount(['ipcrDailyAccomplishments as quality_count'], 'quality')
            // ->distinct('time_ranges.prescribed_period')
            // ->distinct('time_ranges.time_unit')
            // ->orderBy('individualOutput.individual_final_outputs.ipcr_code')
            // ->dd()
            ->get()
            // ->dd()
            ->map(function ($item, $key) use ($sem_id) {
                // dd($item->ipcrTarget->employee_code);
                // $result = DB::table('ipcr_daily_accomplishments as A')
                //     ->select(
                //         DB::raw('MONTH(A.date) as month'),
                //         DB::raw('SUM(A.quantity) as quantity'),
                //         DB::raw('SUM(A.quality) as quality'),
                //         DB::raw('SUM(A.average_timeliness) as TotalAverage'),
                //         DB::raw('SUM(A.timeliness) as timeliness'),
                //         DB::raw('COUNT(A.quality) AS quality_count'),
                //         DB::raw('ROUND(SUM(A.quality) / COUNT(A.quality)) AS average_quality'),
                //         DB::raw('ROUND(SUM(A.average_timeliness) / SUM(A.quantity)) AS average_time'),
                //     )
                //     ->where('sem_id', $sem_id)
                //     ->where('idIPCR', $item->ipcr_code)
                //     ->groupBy(DB::raw('MONTH(date)'))
                //     ->orderBy(DB::raw('MONTH(date)'), 'ASC')
                //     ->get();
                // dd($result);

                $result = $item->individualOutput->ipcrDailyAccomplishments
                    // ->select(
                    //     DB::raw('MONTH(A.date) as month'),
                    //     DB::raw('SUM(A.quantity) as quantity'),
                    //     DB::raw('SUM(A.quality) as quality'),
                    //     DB::raw('SUM(A.average_timeliness) as TotalAverage'),
                    //     DB::raw('SUM(A.timeliness) as timeliness'),
                    //     DB::raw('COUNT(A.quality) AS quality_count'),
                    //     DB::raw('ROUND(SUM(A.quality) / COUNT(A.quality)) AS average_quality'),
                    //     DB::raw('ROUND(SUM(A.average_timeliness) / SUM(A.quantity)) AS average_time'),
                    // )
                    ->where('sem_id', $sem_id)
                    ->where('idIPCR', $item->ipcr_code)
                    // ->take(10)
                    ->sortBy(function ($item) {
                        // dump(Carbon::parse($item->date)->month);
                        return Carbon::parse($item->date)->month;
                    })
                    ->groupBy(function ($item) {
                        // dump($item->date);
                        // dump(Carbon::parse($item->date)->month);
                        return Carbon::parse($item->date)->month;
                    })
                    ->map(fn($result) => [
                        'quantity' => $result->sum('quantity'),
                        'quality' => $result->sum('quality'),
                        'TotalAverage' => $result->sum('average_timeliness'),
                        'timeliness' => $result->sum('timeliness'),
                        'quality_count' => $result->count(),
                        'average_quality' => $result->count() > 0 ? number_format($result->sum('quality') / $result->count(), 2) : 0,
                        'average_time' => $result->sum('quantity') > 0 ? number_format($result->sum('average_timeliness') / $result->sum('quantity'), 0) : 0,
                        // 'average_quality' => number_format($result->sum('quality') / $result->count(), 2),
                        // 'average_time' => number_format($result->sum('average_timeliness') / $result->sum('quantity'), 0)
                    ])
                    ->values()
                    // ->dd()
                    // ->get()
                ;




                return [
                    "result" => $result,
                    "ipcr_code" => $item->ipcr_code,
                    "id" => $item->id,
                    "ipcr_type" => $item->ipcr_type,
                    "ipcr_semester_id" => $item->ipcr_semester_id,
                    "year" => $item->year,
                    "quantity_sem" => $item->quantity_sem,
                    // "individual_output" => $item->individual_output,
                    "performance_measure" => $item->performance_measure,
                    "success_indicator" => $item->individualOutput->success_indicator,
                    "quantity_type" => $item->individualOutput->quantity_type,
                    "quality_error" => $item->individualOutput->quality_error,
                    "time_range_code" => $item->individualOutput->time_range_code,
                    "time_based" => $item->individualOutput->time_based,
                    "prescribed_period" => $item->individualOutput->prescribed_period,
                    "time_unit" => $item->individualOutput->time_unit,
                    "division_name1 AS division" => $item->division,
                    "output AS div_output" => $item->div_output,
                    "mfo_desc" => $item->individualOutput->divisionOutput->majorFinalOutput->mfo_desc,
                    "FFUNCCOD" => $item->FFUNCOD,
                    "submfo_description" => $item->submfo_description,
                    "remarks" => $item->remarks,
                    "remarks_id" => $item->remarks_id,
                    'indi_output' => $item->individualOutput
                ];
            })
            // ->dd()
        ;

        // , 'next_higher'
        $sem = Ipcr_Semestral::select(
            'sem',
            'employee_code',
            'immediate_id',
            'next_higher AS next_higher_id',
            'employee_name',
            'position',
            'salary_grade',
            'division',
            'year',
            'status',
            'status_accomplishment'
        )
            ->where('employee_code', $emp_code)
            ->with('immediate')
            ->where('id', $sem_id)
            ->where('status', '2')
            ->orderBy('year', 'asc')
            ->orderBy('sem', 'asc')
            ->first();
        // dd($emp_code);
        // dd($sem->status_accomplishment);
        if ($sem) {
            $rem = ReturnRemarks::where('ipcr_semestral_id', $sem->id)
                ->orderBy('created_at', 'DESC')
                ->first();
            $immediate = $sem->immediate;
            $next_higher = $sem->next_higher;

            // $next_higher = UserEmployees::where('empl_id', $sem->next_higher)
            //     ->first();
            // dd($sem);
            $user = $emp;
            // $user = UserEmployees::where('empl_id', $sem->employee_code)
            //     ->first();

            $division_code = "";
            if ($user->division_code == "") {
                $division_code = $immediate->division_code;
            } else {
                $division_code = $user->division_code;
            }
            $division = Division::where('division_code', $division_code)
                ->first();
            // dd($division_code);
            $division_assigned = "";
            if ($division == "") {
                $division_assigned = "";
            } else {
                if ($sem->division == "") {
                    $division_assigned = $division->division_name1;
                } else {
                    $division_assigned = $division->division_name1;
                }
            }

            // dd($division_assigned);
            // dd($division->division_name1);
            $sem_data = [
                'id' => $sem->id,
                'employee_code' => $sem->employee_code,
                'immediate_id' => $sem->immediate_id,
                'next_higher' => $sem->next_higher,
                'division' => $division_assigned,
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
        // dd($emp->office);
        //return inertia('IPCR/Semestral/Index');

        return inertia('Semestral_Accomplishment/Index', [
            "id" => $emp->empl_id,
            "data" => $data,
            "sem_data" => $sem_data,
            "sem_id" => $sem_id,
            "division" => $division,
            "emp" => $emp,
            "dept" => $emp->office,
            "pghead" => $pgHead
        ]);
    }

    public function semestral_back2(Request $request, $sem_id)
    {
        // dd($request->id_shown);
        // $id = auth()->user()->username;
        // dd($id);
        $emp = auth()->user()->userEmployee;
        // dd($emp);

        $emp_code = $emp->empl_id;
        $esd = EmployeeSpecialDepartment::where('employee_code', $emp_code)->first();
        $division = "";
        $TimeRating = $request->TimeRating;
        $prescribed_period = '';
        $time_unit = '';
        // dd($emp);
        // if ($emp->division_code) {
        //     //dd($emp->division_code);
        //     $division = Division::where('division_code', $emp->division_code)
        //         ->first()->division_name1;
        // }
        // $office = FFUNCCOD::where('department_code', $emp->department_code)->first();
        // $emp->office = Office::where('department_code', $emp->department_code)->first();
        if ($esd) {
            if ($esd->department_code) {
                // $office = FFUNCCOD::where('department_code', $esd->department_code)->first();
                $emp->office = Office::where('department_code', $esd->department_code)->first();
            }
            // else {
            //     // $office = FFUNCCOD::where('department_code', $emp->department_code)->first();
            //     $emp->office = Office::where('department_code', $emp->department_code)->first();
            // }

            if ($esd->pgdh_cats) {

                $pgHead = UserEmployees::where('empl_id', $esd->pgdh_cats)->first();
                // dd('esd');
            } else {
                $pgHead = UserEmployees::where('empl_id', $emp->Office->empl_id)->first();
            }
        } else {
            $pgHead = UserEmployees::where('empl_id', $emp->office->empl_id)->first();
        }


        // dd($pgHead);
        $suff = "";
        $post = "";
        $mn = "";
        if ($pgHead->suffix_name != '') {
            $suff = ', ' . $pgHead->suffix_name;
        }
        if (
            $pgHead->postfix_name != ''
        ) {
            // dd('fsdfdsfsdf');
            $post = ', ' . $pgHead->postfix_name;
        }
        if ($pgHead->middle_name != '') {
            $mn = $pgHead->middle_name[0] . '. ';
        }
        $pgHead = $pgHead->first_name . ' ' . $mn  . $pgHead->last_name . '' . $suff . '' . $post;
        // $pgHead = $pgHead->first_name . ' ' . $pgHead->middle_name[0] . '. ' . $pgHead->last_name . '' . $suff . '' . $post;
        // dd($emp_code);
        $data = IPCRTargets::with([
            'individualOutput.timeRanges',
            'individualOutput.divisionOutput.division',
            'individualOutput.divisionOutput.majorFinalOutput',
            'individualOutput.subMfo',
            'semestralRemarks',
            'individualOutput.ipcrDailyAccomplishments' => function ($query) use ($sem_id) {
                $query->where('sem_id', $sem_id);
            },
            // 'ipcrTarget' => function($query) use($emp_code, $sem_id) {
            //     $query->where('employee_code', '=', $emp_code)->where('ipcr_semester_id', $sem_id);
            // }
        ])
            // ->select(
            //     'individual_final_outputs.ipcr_code',
            //     // 'i_p_c_r_targets.id',
            //     // 'i_p_c_r_targets.ipcr_type',
            //     // 'i_p_c_r_targets.quantity_sem',
            //     // 'i_p_c_r_targets.ipcr_semester_id',
            //     // 'i_p_c_r_targets.year',
            //     'individual_final_outputs.individual_output',
            //     'individual_final_outputs.performance_measure',
            //     'individual_final_outputs.success_indicator',
            //     'individual_final_outputs.quantity_type',
            //     'individual_final_outputs.quality_error',
            //     'individual_final_outputs.time_range_code',
            //     'individual_final_outputs.time_based',
            //     // 'time_ranges.prescribed_period',
            //     // 'time_ranges.time_unit',
            //     // 'divisions.division_name1 AS division',
            //     // 'division_outputs.output AS div_output',
            //     // 'major_final_outputs.mfo_desc',
            //     // 'major_final_outputs.FFUNCCOD',
            //     // 'sub_mfos.submfo_description',
            //     'semestral_remarks.remarks',
            //     'semestral_remarks.id AS remarks_id',
            //     DB::raw("'$TimeRating' AS TimeRating"),
            // )
            // ->leftjoin('time_ranges', 'time_ranges.time_code', 'individual_final_outputs.time_range_code')
            // ->leftjoin('division_outputs', 'division_outputs.id', 'individual_final_outputs.id_div_output')
            // ->leftjoin('divisions', 'divisions.id', 'division_outputs.division_id')
            // ->leftjoin('major_final_outputs', 'major_final_outputs.id', 'division_outputs.idmfo')
            // ->leftjoin('sub_mfos', 'sub_mfos.id', 'individual_final_outputs.idsubmfo')
            // ->leftjoin('i_p_c_r_targets', 'i_p_c_r_targets.ipcr_code', 'individual_final_outputs.ipcr_code')
            // ->leftJoin('semestral_remarks', function ($join) use ($sem_id) {
            //     $join->on('i_p_c_r_targets.ipcr_code', '=', 'semestral_remarks.idIPCR')
            //         ->where('semestral_remarks.idSemestral', '=', $sem_id)
            //         ->where('i_p_c_r_targets.ipcr_semester_id', '=', $sem_id);
            // })
            // ->where('i_p_c_r_targets.employee_code', $emp_code)
            // ->where('i_p_c_r_targets.ipcr_semester_id', $sem_id)

            // ->whereHas('semestralRemarks', function($query) use($sem_id){
            //     $query->where('idSemestral', '=', $sem_id)
            //             ->where('ipcr_semester_id', '=', $sem_id);
            // })
            // ->whereHas('individualOutput.ipcrDailyAccomplishments',function($query) use($sem_id) {
            //     $query->where('sem_id', $sem_id);
            // })

            // ->whereHas('ipcrTarget',function($query) use($emp_code, $sem_id) {
            //     $query->where('employee_code', '=', $emp_code)
            //         ->where('ipcr_semester_id', $sem_id);
            // })
            ->where('employee_code', '=', $emp_code)
            ->where('ipcr_semester_id', $sem_id)
            // ->withSum(['individualOutput.ipcrDailyAccomplishments as quantity'], 'quantity')
            // ->withSum(['individualOutput.ipcrDailyAccomplishments as quality'], 'quality')
            // ->withSum(['individualOutput.ipcrDailyAccomplishments as TotalAverage'], 'average_timeliness')
            // ->withSum(['individualOutput.ipcrDailyAccomplishments as timeliness'], 'timeliness')
            // ->withCount(['ipcrDailyAccomplishments as quality_count'], 'quality')
            // ->distinct('time_ranges.prescribed_period')
            // ->distinct('time_ranges.time_unit')
            // ->orderBy('individualOutput.individual_final_outputs.ipcr_code')
            // ->dd()
            ->get()
            // ->dd()
            ->map(function ($item, $key) use ($sem_id) {
                // dd($item->ipcrTarget->employee_code);
                // $result = DB::table('ipcr_daily_accomplishments as A')
                //     ->select(
                //         DB::raw('MONTH(A.date) as month'),
                //         DB::raw('SUM(A.quantity) as quantity'),
                //         DB::raw('SUM(A.quality) as quality'),
                //         DB::raw('SUM(A.average_timeliness) as TotalAverage'),
                //         DB::raw('SUM(A.timeliness) as timeliness'),
                //         DB::raw('COUNT(A.quality) AS quality_count'),
                //         DB::raw('ROUND(SUM(A.quality) / COUNT(A.quality)) AS average_quality'),
                //         DB::raw('ROUND(SUM(A.average_timeliness) / SUM(A.quantity)) AS average_time'),
                //     )
                //     ->where('sem_id', $sem_id)
                //     ->where('idIPCR', $item->ipcr_code)
                //     ->groupBy(DB::raw('MONTH(date)'))
                //     ->orderBy(DB::raw('MONTH(date)'), 'ASC')
                //     ->get();
                // dd($result);

                $result = $item->individualOutput->ipcrDailyAccomplishments
                    // ->select(
                    //     DB::raw('MONTH(A.date) as month'),
                    //     DB::raw('SUM(A.quantity) as quantity'),
                    //     DB::raw('SUM(A.quality) as quality'),
                    //     DB::raw('SUM(A.average_timeliness) as TotalAverage'),
                    //     DB::raw('SUM(A.timeliness) as timeliness'),
                    //     DB::raw('COUNT(A.quality) AS quality_count'),
                    //     DB::raw('ROUND(SUM(A.quality) / COUNT(A.quality)) AS average_quality'),
                    //     DB::raw('ROUND(SUM(A.average_timeliness) / SUM(A.quantity)) AS average_time'),
                    // )
                    ->where('sem_id', $sem_id)
                    ->where('idIPCR', $item->ipcr_code)
                    // ->take(10)
                    ->sortBy(function ($item) {
                        // dump(Carbon::parse($item->date)->month);
                        return Carbon::parse($item->date)->month;
                    })
                    ->groupBy(function ($item) {
                        // dump($item->date);
                        // dump(Carbon::parse($item->date)->month);
                        return Carbon::parse($item->date)->month;
                    })
                    ->map(fn($result) => [
                        'quantity' => $result->sum('quantity'),
                        'quality' => $result->sum('quality'),
                        'TotalAverage' => $result->sum('average_timeliness'),
                        'timeliness' => $result->sum('timeliness'),
                        'quality_count' => $result->count(),
                        'average_quality' => number_format($result->sum('quality') / $result->count(), 0),
                        'average_time' => number_format($result->sum('average_timeliness') / $result->sum('quantity'), 0)
                    ])
                    ->values()
                    // ->dd()
                    // ->get()
                ;




                return [
                    "result" => $result,
                    "ipcr_code" => $item->ipcr_code,
                    "id" => $item->id,
                    "ipcr_type" => $item->ipcr_type,
                    "ipcr_semester_id" => $item->ipcr_semester_id,
                    "year" => $item->year,
                    "quantity_sem" => $item->quantity_sem,
                    // "individual_output" => $item->individual_output,
                    "performance_measure" => $item->performance_measure,
                    "success_indicator" => $item->individualOutput->success_indicator,
                    "quantity_type" => $item->individualOutput->quantity_type,
                    "quality_error" => $item->individualOutput->quality_error,
                    "time_range_code" => $item->individualOutput->time_range_code,
                    "time_based" => $item->individualOutput->time_based,
                    "prescribed_period" => $item->individualOutput->prescribed_period,
                    "time_unit" => $item->individualOutput->time_unit,
                    "division_name1 AS division" => $item->division,
                    "output AS div_output" => $item->div_output,
                    "mfo_desc" => $item->individualOutput->divisionOutput->majorFinalOutput->mfo_desc,
                    "FFUNCCOD" => $item->FFUNCOD,
                    "submfo_description" => $item->submfo_description,
                    "remarks" => $item->remarks,
                    "remarks_id" => $item->remarks_id,
                    'indi_output' => $item->individualOutput
                ];
            })
            // ->dd()
        ;
        // dd('sem 33');
        dd($sem_id);
        // , 'next_higher'
        $sem = Ipcr_Semestral::select(
            'sem',
            'employee_code',
            'immediate_id',
            'next_higher AS next_higher_id',
            'employee_name',
            'position',
            'salary_grade',
            'division',
            'year',
            'status',
            'status_accomplishment'
        )
            ->where('employee_code', $emp_code)
            ->with('immediate')
            ->where('id', $sem_id)
            ->where('status', '2')
            ->orderBy('year', 'asc')
            ->orderBy('sem', 'asc')
            ->first();
        // dd($emp_code);
        // dd($sem->status_accomplishment);
        if ($sem) {
            $rem = ReturnRemarks::where('ipcr_semestral_id', $sem->id)
                ->orderBy('created_at', 'DESC')
                ->first();
            $immediate = $sem->immediate;
            $next_higher = $sem->next_higher;

            // $next_higher = UserEmployees::where('empl_id', $sem->next_higher)
            //     ->first();
            // dd($sem);
            $user = $emp;
            // $user = UserEmployees::where('empl_id', $sem->employee_code)
            //     ->first();

            $division_code = "";
            if ($user->division_code == "") {
                $division_code = $immediate->division_code;
            } else {
                $division_code = $user->division_code;
            }
            $division = Division::where('division_code', $division_code)
                ->first();
            // dd($division_code);
            $division_assigned = "";
            if ($division == "") {
                $division_assigned = "";
            } else {
                if ($sem->division == "") {
                    $division_assigned = $division->division_name1;
                } else {
                    $division_assigned = $division->division_name1;
                }
            }

            // dd($division_assigned);
            // dd($division->division_name1);
            $sem_data = [
                'id' => $sem->id,
                'employee_code' => $sem->employee_code,
                'immediate_id' => $sem->immediate_id,
                'next_higher' => $sem->next_higher,
                'division' => $division_assigned,
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
        $sem_data = [
            'id' => '',
            'employee_code' => '',
            'immediate_id' => '',
            'next_higher' => '',
            'division' => '',
            "imm" => '',
            "next" => '',
            'sem' => '',
            'status' => '',
            'status_accomplishment' => '',
            'year' => '',
            'rem' => '',
        ];
        // dd($sem_data);
        // dd($emp->office);
        //return inertia('IPCR/Semestral/Index');

        return inertia('Semestral_Accomplishment/Index', [
            "id" => $emp->empl_id,
            "data" => $data,
            "sem_data" => $sem_data,
            "sem_id" => $sem_id,
            "division" => $division,
            "emp" => $emp,
            "dept" => $emp->office,
            "pghead" => $pgHead
        ]);
    }
    public function semestralbackup123(Request $request, $sem_id)
    {
        // dd($request->id_shown);
        // $id = auth()->user()->username;
        // dd($id);
        $emp = auth()->user()->userEmployee;
        // dd($emp);

        $emp_code = $emp->empl_id;
        $esd = EmployeeSpecialDepartment::where('employee_code', $emp_code)->first();
        $division = "";
        $TimeRating = $request->TimeRating;
        $prescribed_period = '';
        $time_unit = '';

        if ($esd) {
            if ($esd->department_code) {
                // $office = FFUNCCOD::where('department_code', $esd->department_code)->first();
                $emp->office = Office::where('department_code', $esd->department_code)->first();
            }


            if ($esd->pgdh_cats) {

                $pgHead = UserEmployees::where('empl_id', $esd->pgdh_cats)->first();
                // dd('esd');
            } else {
                $pgHead = UserEmployees::where('empl_id', $emp->Office->empl_id)->first();
            }
        } else {
            $pgHead = UserEmployees::where('empl_id', $emp->office->empl_id)->first();
        }


        $suff = "";
        $post = "";
        $mn = "";
        if ($pgHead->suffix_name != '') {
            $suff = ', ' . $pgHead->suffix_name;
        }
        if (
            $pgHead->postfix_name != ''
        ) {
            $post = ', ' . $pgHead->postfix_name;
        }
        if ($pgHead->middle_name != '') {
            $mn = $pgHead->middle_name[0] . '. ';
        }
        $pgHead = $pgHead->first_name . ' ' . $mn  . $pgHead->last_name . '' . $suff . '' . $post;
        $data = IPCRTargets::with([
            'individualOutput.timeRanges',
            'individualOutput.divisionOutput.division',
            'individualOutput.divisionOutput.majorFinalOutput',
            'individualOutput.subMfo',
            'semestralRemarks' => function ($query) use ($sem_id) {
                $query->where('idSemestral', $sem_id);
            },
            'individualOutput.ipcrDailyAccomplishments' => function ($query) use ($sem_id) {
                $query->where('sem_id', $sem_id);
            },
            'ipcr_Semestral',
            'ipcr_Semestral.immediate',
            'ipcr_Semestral.next_higher1',
        ])
            ->where('employee_code', '=', $emp_code)
            ->where('ipcr_semester_id', $sem_id)
            ->get()
            ->map(function ($item, $key) use ($sem_id) {
                $result = $item->individualOutput->ipcrDailyAccomplishments
                    ->where('sem_id', $sem_id)
                    ->where('idIPCR', $item->ipcr_code)
                    ->sortBy(function ($item) {
                        return Carbon::parse($item->date)->month;
                    })
                    ->groupBy(function ($item) {
                        return Carbon::parse($item->date)->month;
                    })
                    ->map(fn($result) => [
                        'month' => Carbon::parse($result[0]->date)->format('n'),
                        'quantity' => $result->sum('quantity'),
                        'quality' => $result->sum('quality'),
                        'TotalAverage' => $result->sum('average_timeliness'),
                        'timeliness' => $result->sum('timeliness'),
                        'quality_count' => $result->count(),
                        'average_quality' => number_format($result->sum('quality') / $result->count(), 0),
                        'average_time' => number_format($result->sum('average_timeliness') / $result->sum('quantity'), 0)
                    ])
                    ->values();

                // dd($item->ipcr_Semestral->next_higher1);

                // $sem = ;
                // dd($sem);
                return [
                    "result" => $result,
                    "ipcr_code" => $item->ipcr_code,
                    "id" => $item->id,
                    "ipcr_type" => $item->ipcr_type,
                    "ipcr_semester_id" => $item->ipcr_semester_id,
                    "year" => $item->year,
                    "quantity_sem" => $item->quantity_sem,
                    "performance_measure" => $item->performance_measure,
                    "success_indicator" => $item->individualOutput->success_indicator,
                    "quantity_type" => $item->individualOutput->quantity_type,
                    "quality_error" => $item->individualOutput->quality_error,
                    "time_range_code" => $item->individualOutput->time_range_code,
                    "time_based" => $item->individualOutput->time_based,
                    "prescribed_period" => $item->individualOutput->prescribed_period,
                    "time_unit" => $item->individualOutput->time_unit,
                    "division_name1 AS division" => $item->division,
                    "output AS div_output" => $item->div_output,
                    "mfo_desc" => $item->individualOutput->divisionOutput->majorFinalOutput->mfo_desc,
                    "FFUNCCOD" => $item->FFUNCOD,
                    "submfo_description" => $item->submfo_description,
                    "remarks" => $item->semestralRemarks ? $item->semestralRemarks->remarks : '',
                    "remarks_id" => $item->semestralRemarks ? $item->semestralRemarks->id : '',
                    'indi_output' => $item->individualOutput,
                    "sem" => $item->ipcr_Semestral,
                    "imm_ob" => $item->ipcr_Semestral->immediate,
                    "nxt_ob" => $item->ipcr_Semestral->next_higher1,
                ];
            });
        // dd($data[0]['sem']);

        // $sem = Ipcr_Semestral::select(
        //     'sem',
        //     'employee_code',
        //     'immediate_id',
        //     'next_higher',
        //     'employee_name',
        //     'position',
        //     'salary_grade',
        //     'division',
        //     'year',
        //     'status',
        //     'status_accomplishment'
        // )
        //     ->where('employee_code', $emp_code)
        //     ->with(['immediate', 'next_higher1', 'latestReturnRemark'])
        //     ->where('id', $sem_id)
        //     ->where('status', '2')
        //     ->orderBy('year', 'asc')
        //     ->orderBy('sem', 'asc')
        //     ->first();
        $sem = $data[0]['sem'];
        // dd($sem);
        $sem_data = [
            'id' => $sem_id,
            'employee_code' => $emp_code,
            'immediate_id' => $sem->immediate_id,
            'next_higher' => $sem->next_higher,
            'division' => '',
            "imm" => $data[0]['imm_ob'],
            "next" => $data[0]['nxt_ob'],
            'sem' => $sem->sem,
            'status' => $sem->status,
            'status_accomplishment' => $sem->status_accomplishment,
            'year' => $sem->year,
            'rem' => 'remmm',
        ];
        // if ($sem) {
        //     $rem = ReturnRemarks::where('ipcr_semestral_id', $sem_id)
        //         ->orderBy('created_at', 'DESC')
        //         ->first();

        // $immediate = $sem->immediate;
        // $next_higher = $sem->next_higher1;

        // $division_code = "";
        // if ($emp->division_code == "") {
        //     $division_code = $immediate->division_code;
        // } else {
        //     $division_code = $emp->division_code;
        // }
        // $division = Division::where('division_code', $division_code)
        //     ->first();
        // // dd($division_code);
        // $division_assigned = "";
        // if ($division == "") {
        //     $division_assigned = "";
        // } else {
        //     if ($sem->division == "") {
        //         $division_assigned = $division->division_name1;
        //     } else {
        //         $division_assigned = $division->division_name1;
        //     }
        // }

        // $user = $emp;
        // $user = UserEmployees::where('empl_id', $sem->employee_code)
        //     ->first();
        // $sem_data = [
        //     'id' => $sem_id,
        //     'employee_code' => $emp_code,
        //     'immediate_id' => $sem->immediate_id,
        //     'next_higher' => $sem->next_higher,
        //     'division' => $division_assigned,
        //     "imm" => $immediate,
        //     "next" => $next_higher,
        //     'sem' => $sem->sem,
        //     'status' => $sem->status,
        //     'status_accomplishment' => $sem->status_accomplishment,
        //     'year' => $sem->year,
        //     'rem' => $rem,
        // ];
        // dd($sem_data);
        // }



        return inertia('Semestral_Accomplishment/Index', [
            "id" => $emp->empl_id,
            "data" => $data,
            "sem_data" => $sem_data,
            "sem_id" => $sem_id,
            "division" => $division,
            "emp" => $emp,
            "dept" => $emp->office,
            "pghead" => $pgHead
        ]);
    }
}
