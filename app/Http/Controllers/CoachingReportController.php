<?php

namespace App\Http\Controllers;

use App\Models\CoachingReport;
use App\Models\Ipcr_Semestral;
use App\Models\UserEmployees;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class CoachingReportController extends Controller
{

    private $model;
    public function __construct(CoachingReport $model)
    {
        $this->model = $model;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        // dd('create');
        session(['previous_url' => url()->previous()]);
        // dd($is_div_head);
        // dd(auth()->user());
        // ********************************************************************
        //adjustments for section heads (SPCR) and hospital chief (HPCR)

        // dd($request->all());

        $year = $request->year;
        $monthName = $request->month;

        $monthMap = [
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

        $month = $monthMap[$monthName] ?? null;

        // dd($month);

        // dd($month . " " . $year);
        $emp_code = Auth()->user()->username;
        $emp_code = $request->emp_code ?? $emp_code;

        $is_div_head = employee_division_head($emp_code);

        $sem = Ipcr_Semestral::select(
            'id',
            'sem',
            'employee_code',
            'year',
            'status',
            'immediate_id',
            DB::raw("IF(sem=1,'First Semester', 'Second Semester') as sem_in_word"),
            'status_accomplishment'
        )
            ->where('employee_code', $emp_code)
            ->where('year', $year)
            ->get();

        // dd($sem);
        $coachee = UserEmployees::select('employee_name')
            ->where('empl_id', $emp_code)
            ->first();

        $coachee_name = '';

        if ($coachee && !empty($coachee->employee_name)) {
            $name = trim($coachee->employee_name);

            $parts = explode(',', $name);

            if (count($parts) === 2) {
                $lastname = ucwords(strtolower(trim($parts[0])));
                $firstname = ucwords(strtolower(trim($parts[1])));

                $coachee_name = $firstname . ' ' . $lastname;
            } else {
                $coachee_name = ucwords(strtolower($name));
            }
        }



        // dd($coachee_name);

        $immediate_head = UserEmployees::select('employee_name', 'position_long_title')
            ->where('empl_id', $sem->first()->immediate_id)
            ->first();

        // dd($immediate_head);
        $formatted_name = '';

        if ($immediate_head && !empty($immediate_head->employee_name)) {
            $name = trim($immediate_head->employee_name);

            $parts = explode(',', $name);

            if (count($parts) === 2) {
                $lastname = ucwords(strtolower(trim($parts[0])));
                $firstname = ucwords(strtolower(trim($parts[1])));

                $formatted_name = $firstname . ' ' . $lastname;
            } else {
                $formatted_name = ucwords(strtolower($name));
            }
        }

        // dd($formatted_name);
        // $data = $this->getTargetData($is_div_head, $emp_code);
        // $is_div_head == "emp" ? $this->data_ipcr($emp_code) : $this->data_dpcr($emp_code);
        // dd($data);
        // dd($this->data_dpcr($emp_code));
        // dd($data);

        return inertia('Coaching_Report/Create', [
            'emp_code' => $emp_code,
            'immediate_head' => $formatted_name,
            'immediate_position' => $immediate_head ? $immediate_head->position_long_title : '',
            'coachee_name' => $coachee_name,
            'month' => $month,
            // 'data' => $data,
            'sem' => $sem,
            'emp_type' => $is_div_head,
            'session' => session()->all(),
            'can' => [
                'can_access_validation' => Auth::user()->can('can_access_validation', User::class),
                'can_access_indicators' => Auth::user()->can('can_access_indicators', User::class)
            ],
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        // dd($request->all());

        $monthName = $request->month;
        $monthMap = [
            1 => 'January',
            2 => 'February',
            3 => 'March',
            4 => 'April',
            5 => 'May',
            6 => 'June',
            7 => 'July',
            8 => 'August',
            9 => 'September',
            10 => 'October',
            11 => 'November',
            12 => 'December',
        ];

        $newMonth = $monthMap[$monthName] ?? null;

        // dd($newMonth);
        $this->model->create([
            // 'date' => $request->date,
            'employee_name' => $request->coachee_name,
            'employee_cats_id' => $request->emp_code,
            'critical_incidence_description' => $request->critical_incident,
            'goal' => $request->goals,
            'reality' => $request->reality,
            'opportunities' => $request->opportunities,
            'way_forward' => $request->way_forward,
            'follow_up_date' => $request->followup_date,
            'follow_up_time' => $request->followup_time,
            'write_things_down' => $request->followup_notes,
            'coach_name' => $request->supervisor_name,
            'position' => $request->supervisor_position,
            'semester' => $request->sem,
            'month' => $request->month,
            'year' => $request->year,
        ]);

        return redirect('/coaching-report/monthly?year=' . $request->year . '&month=' . $newMonth . '&department_code=' . $request->department_code)
            ->with('message', 'Coaching Report Created Successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CoachingReport  $coachingReport
     * @return \Illuminate\Http\Response
     */
    public function show(CoachingReport $coachingReport)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CoachingReport  $coachingReport
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {

        // dd($id);
        $coachingReport = CoachingReport::findOrFail($id);

        $data = CoachingReport::findOrFail($id);

        return inertia('Coaching_Report/Create', [

            "editData" => $data,
            // 'sem' => $sem,
            'session' => session()->all(),
            'can' => [
                'can_access_validation' => Auth::user()->can('can_access_validation', User::class),
                'can_access_indicators' => Auth::user()->can('can_access_indicators', User::class)
            ],
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CoachingReport  $coachingReport
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CoachingReport $coachingReport)
    {

        $department_code = $request->department_code;

        $monthName = $request->month;

        //


        $data = $this->model->findOrFail($request->id);
        // dd($data);

        $monthName = $data->month;


        $monthMap = [
            1 => 'January',
            2 => 'February',
            3 => 'March',
            4 => 'April',
            5 => 'May',
            6 => 'June',
            7 => 'July',
            8 => 'August',
            9 => 'September',
            10 => 'October',
            11 => 'November',
            12 => 'December',
        ];

        $newMonth = $monthMap[$monthName] ?? null;
        // dd($newMonth);
        $data->update(
            [
                'critical_incidence_description' => $request->critical_incident,
                'goal' => $request->goals,
                'reality' => $request->reality,
                'opportunities' => $request->opportunities,
                'way_forward' => $request->way_forward,
                'follow_up_date' => $request->followup_date,
                'follow_up_time' => $request->followup_time,
                'write_things_down' => $request->followup_notes,
            ]
        );

        return redirect('/coaching-report/monthly?year=' . $data->year . '&month=' . $newMonth . '&department_code=' . $request->department_code)
            ->with('message', 'Coaching Report Created Successfully!');
    }

    public function destroy(Request $request)
    {
        // dd($request->id);

        $data = $this->model->findOrFail($request->id);
        // dd($data);
        $data->delete();
        //dd($request->raao_id);
        return back()->with('message', 'Coaching Report Deleted');
    }


    public function coachingReport(Request $request)
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

        return inertia('Coaching_Report/Index', [
            "id" => $id,
            "sem_data" => $sem_data,
            "division" => $div,
            "emp" => $emp,
            "source" => $source,
        ]);
    }

    public function monthly_report(Request $request)
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
        $data = UserEmployees::whereHas('manySemestral', function ($query) use ($office, $semt, $year) {
            $query->where('department_code', $office)
                ->where('sem', $semt)
                ->where('year', $year);
        })
            ->where('active_status', 'ACTIVE')
            ->where('salary_grade', '!=', 26)
            ->withExists(['coachingReport as has_coaching_report' => function ($query) use ($semt, $year, $monthNumber) {
                $query->where('semester', $semt)
                    ->where('year', $year)
                    ->where('month', $monthNumber)
                    ->select('id', 'employee_cats_id', 'sem', 'year', 'month');
            }])
            ->orderBy('last_name', 'ASC')
            ->get()
            ->map(function ($item, $key) {

                $middleInitial = $item->middle_name ? $item->middle_name[0] . '.' : '';

                $coaching = $item->coachingReport->first();
                return [
                    'Fullname' => $item->last_name . ", " . $item->first_name . " " . $middleInitial,
                    'Employee Code' => $item->empl_id,
                    'Has Coaching Report' => $item->has_coaching_report, // true/false
                    'Coaching Report ID' => $coaching->id ?? null,
                ];
            });

        // dd($data);
        return inertia('Coaching_Report/MonthlyReport', [
            "data" => $data,
            "month" => $month,
            "year" => $year,
            "office" => $request->department_code
        ]);
    }

    public function print_form(Request $request)
    {

        $emp_code = $request->emp_code;
        $month = $request->month;
        $year = $request->year;
        $data = CoachingReport::where('employee_cats_id', $emp_code)
            ->where('month', $month)
            ->where('year', $year)
            ->get();

        return $data;
    }
}
