<?php

namespace App\Http\Controllers;

use App\Models\Daily_Accomplishment;
use App\Models\IndividualFinalOutput;
use App\Models\Ipcr_Semestral;
use App\Models\IPCRTargets;
use App\Models\Office;
use App\Models\TimeRange;
use App\Models\UserEmployees;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Laravel\Ui\Presets\React;

class DailyAccomplishmentController extends Controller
{
    private $model;
    public function __construct(Daily_Accomplishment $model)
    {
        $this->model = $model;
    }

    public function index(Request $request)
    {
        // dd($request);
        $emp_code = auth()->user()->username;
        $ipcr_codes = Daily_Accomplishment::leftJoin('individual_final_outputs', 'ipcr_daily_accomplishments.idIPCR', '=', 'individual_final_outputs.ipcr_code')
            ->leftJoin('major_final_outputs', 'individual_final_outputs.idmfo', '=', 'major_final_outputs.id')
            ->leftJoin('division_outputs', 'individual_final_outputs.id_div_output', '=', 'division_outputs.id')
            ->select(
                'ipcr_daily_accomplishments.id',
                'ipcr_daily_accomplishments.date',
                'ipcr_daily_accomplishments.description',
                'ipcr_daily_accomplishments.quantity',
                'ipcr_daily_accomplishments.idIPCR',
                'ipcr_daily_accomplishments.emp_code',
                'ipcr_daily_accomplishments.remarks',
                'ipcr_daily_accomplishments.link',
                'ipcr_daily_accomplishments.individual_output',
                'individual_final_outputs.ipcr_code',
                'individual_final_outputs.idmfo',
                'individual_final_outputs.idsubmfo',
                'individual_final_outputs.id_div_output',
                'major_final_outputs.mfo_desc',
                'division_outputs.output'
            )
            ->where('ipcr_daily_accomplishments.emp_code', $emp_code)
            ->orderBy('ipcr_daily_accomplishments.date', 'DESC')
            ->get();
        // dd($ipcr_codes);
        $data = Daily_Accomplishment::leftJoin('individual_final_outputs', 'ipcr_daily_accomplishments.idIPCR', '=', 'individual_final_outputs.ipcr_code')
            ->leftJoin('major_final_outputs', 'individual_final_outputs.idmfo', '=', 'major_final_outputs.id')
            ->leftJoin('division_outputs', 'individual_final_outputs.id_div_output', '=', 'division_outputs.id')
            ->select(
                'ipcr_daily_accomplishments.id',
                'ipcr_daily_accomplishments.date',
                'ipcr_daily_accomplishments.description',
                'ipcr_daily_accomplishments.quantity',
                'ipcr_daily_accomplishments.idIPCR',
                'ipcr_daily_accomplishments.emp_code',
                'ipcr_daily_accomplishments.remarks',
                'ipcr_daily_accomplishments.link',
                'ipcr_daily_accomplishments.individual_output',
                'individual_final_outputs.ipcr_code',
                'individual_final_outputs.idmfo',
                'individual_final_outputs.idsubmfo',
                'individual_final_outputs.id_div_output',
                'major_final_outputs.mfo_desc',
                'division_outputs.output'
            )
            ->when($request->date, function ($query, $searchItem) {
                $query->where('date', $searchItem);
            })
            ->when($request->month, function ($query, $searchItem) {
                $query->whereRaw('MONTH(date) = ?', $searchItem);
            })
            ->when($request->year, function ($query, $searchItem) {
                $query->whereRaw('YEAR(date) = ?', $searchItem);
            })
            ->when($request->ipcr_code, function ($query, $searchItem) {
                $query->where('idIPCR', $searchItem);
            })
            ->where('ipcr_daily_accomplishments.emp_code', $emp_code)
            ->groupBy('idIPCR')
            ->orderBy('ipcr_daily_accomplishments.date', 'DESC')
            ->paginate(10)
            ->withQueryString();
        // dd($data);
        $data->getCollection()->transform(function ($item) {
            $item->date = Carbon::parse($item->date)->format('M. d, Y');
            return $item;
        });

        // dd($data);
        return inertia('Daily_Accomplishment/Index', [
            "data" => fn () => $data,
            "emp_code" => $emp_code,
            "ipcr_codes" => $ipcr_codes
        ]);
    }

    public function create(Request $request)
    {
        // dd('create');
        $emp_code = Auth()->user()->username;
        // dd($emp_code);
        $sem = Ipcr_Semestral::select('id', 'sem', 'employee_code', 'year', 'status', DB::raw("IF(sem=1,'First Semester', 'Second Semester') as sem_in_word"))
            ->where('status', '2')
            ->where('employee_code', $emp_code)
            ->get();
        // dd($sem);
        $data = IndividualFinalOutput::select(
            'individual_final_outputs.ipcr_code',
            'i_p_c_r_targets.id',
            'individual_final_outputs.success_indicator',
            'i_p_c_r_targets.semester',
            'individual_final_outputs.individual_output',
            'individual_final_outputs.performance_measure',
            'divisions.division_name1 AS division',
            'division_outputs.output AS div_output',
            'major_final_outputs.mfo_desc',
            'major_final_outputs.FFUNCCOD',
            'sub_mfos.submfo_description',
            'ipcr__semestrals.id as sem_id',
            'ipcr__semestrals.sem',
            'ipcr__semestrals.year',
            'ipcr__semestrals.status'
        )
            ->leftjoin('division_outputs', 'division_outputs.id', 'individual_final_outputs.id_div_output')
            ->leftjoin('divisions', 'divisions.id', 'division_outputs.division_id')
            ->leftjoin('major_final_outputs', 'major_final_outputs.id', 'division_outputs.idmfo')
            ->leftjoin('sub_mfos', 'sub_mfos.id', 'individual_final_outputs.idsubmfo')
            ->join('i_p_c_r_targets', 'i_p_c_r_targets.ipcr_code', 'individual_final_outputs.ipcr_code')
            ->Leftjoin('ipcr__semestrals', 'ipcr__semestrals.id', 'i_p_c_r_targets.ipcr_semester_id')
            ->distinct('individual_final_outputs.ipcr_code')
            ->where('i_p_c_r_targets.employee_code', $emp_code)
            ->orderBy('individual_final_outputs.ipcr_code')
            ->get();

        // dd($data);
        return inertia('Daily_Accomplishment/Create', [
            'emp_code' => $emp_code,
            'data' => $data,
            'sem' => $sem,
            'can' => [
                'can_access_validation' => Auth::user()->can('can_access_validation', User::class),
                'can_access_indicators' => Auth::user()->can('can_access_indicators', User::class)
            ],
        ]);
    }

    public function store(Request $request)
    {
        // dd($request);
        $request->validate([
            'date' => 'required',
            'description' => 'required',
            'idIPCR' => 'required',
            'emp_code' => 'required',
            'quantity' => 'required',
            'individual_output' => 'required',
            'sem_id' => 'required',
        ]);

        // dd($request->all());
        $this->model->create($request->all());
        return redirect('/Daily_Accomplishment')
            ->with('message', 'Daily Accomplishment added');
    }

    public function edit(Request $request, $id)
    {
        $data = $this->model->where('id', $id)->first([
            'id',
            'emp_code',
            'date',
            'idIPCR',
            'individual_output',
            'description',
            'quantity',
            'remarks',
            'link',
            'sem_id',
            'quality',
            'timeliness',
            'average_timeliness'
        ]);
        $sem = Ipcr_Semestral::select('id', 'sem', 'employee_code', 'year', 'status', DB::raw("IF(sem=1,'First Semester', 'Second Semester') as sem_in_word"))
            ->where('status', '2')
            ->get();
        $emp_code = Auth()->user()->username;
        $IPCR = IndividualFinalOutput::select(
            'individual_final_outputs.ipcr_code',
            'i_p_c_r_targets.id',
            'individual_final_outputs.individual_output',
            'individual_final_outputs.performance_measure',
            'individual_final_outputs.success_indicator',
            'divisions.division_name1 AS division',
            'division_outputs.output AS div_output',
            'major_final_outputs.mfo_desc',
            'major_final_outputs.FFUNCCOD',
            'sub_mfos.submfo_description',
            'ipcr__semestrals.id as sem_id',
            'ipcr__semestrals.sem',
            'ipcr__semestrals.year',
            'ipcr__semestrals.status'
        )
            ->leftjoin('division_outputs', 'division_outputs.id', 'individual_final_outputs.id_div_output')
            ->leftjoin('divisions', 'divisions.id', 'division_outputs.division_id')
            ->leftjoin('major_final_outputs', 'major_final_outputs.id', 'division_outputs.idmfo')
            ->leftjoin('sub_mfos', 'sub_mfos.id', 'individual_final_outputs.idsubmfo')
            ->join('i_p_c_r_targets', 'i_p_c_r_targets.ipcr_code', 'individual_final_outputs.ipcr_code')
            ->Leftjoin('ipcr__semestrals', 'ipcr__semestrals.id', 'i_p_c_r_targets.ipcr_semester_id')
            ->where('i_p_c_r_targets.employee_code', $emp_code)
            ->orderBy('individual_final_outputs.ipcr_code')
            ->get();
        // dd($data);
        return inertia('Daily_Accomplishment/Create', [
            "data" => $IPCR,
            "editData" => $data,
            'sem' => $sem,
            'can' => [
                'can_access_validation' => Auth::user()->can('can_access_validation', User::class),
                'can_access_indicators' => Auth::user()->can('can_access_indicators', User::class)
            ],
        ]);
    }

    public function update(Request $request)
    {
        // dd($request);
        $data = $this->model->findOrFail($request->id);
        //dd($request->plan_period);

        $data->update([
            'date' => $request->date,
            'idIPCR' => $request->idIPCR,
            'individual_output' => $request->individual_output,
            'description' => $request->description,
            'quantity' => $request->quantity,
            'remarks' => $request->remarks,
            'link' => $request->link,
            'quality' => $request->quality,
            'timeliness' => $request->timeliness,
            'average_timeliness' => $request->average_timeliness,
        ]);
        // dd($data);
        return redirect('/Daily_Accomplishment')
            ->with('info', 'Accomplishment updated');
    }

    public function destroy(Request $request)
    {
        $data = $this->model->findOrFail($request->id);
        $data->delete();
        //dd($request->raao_id);
        return redirect('/Daily_Accomplishment')->with('warning', 'Accomplishment Deleted');
    }

    public function UserEmployee(Request $request)
    {
        $username = $request->username;
        // $offices = UserEmployees::leftJoin('fms.offices','offices.department_code','user_employees.department_code')
        // ->where('user_employees.empl_id', $username)
        // ->get();

        // dd($offices);
        $date_from = $request->date_from;
        $date_to = $request->date_to;

        $accomplishment = Daily_Accomplishment::select(
            'ipcr_daily_accomplishments.id',
            'ipcr_daily_accomplishments.date',
            'ipcr_daily_accomplishments.description',
            'ipcr_daily_accomplishments.quantity',
            'ipcr_daily_accomplishments.idIPCR',
            'ipcr_daily_accomplishments.emp_code',
            'ipcr_daily_accomplishments.remarks',
            'ipcr_daily_accomplishments.link',
            'ipcr_daily_accomplishments.individual_output',
            'individual_final_outputs.ipcr_code',
            'individual_final_outputs.idmfo',
            'individual_final_outputs.idsubmfo',
            'individual_final_outputs.id_div_output',
            'major_final_outputs.mfo_desc',
            'division_outputs.output',
            'user_employees.employee_name',
            'offices.office as department_name'
        )
            ->leftJoin('individual_final_outputs', 'ipcr_daily_accomplishments.idIPCR', '=', 'individual_final_outputs.ipcr_code')
            ->leftJoin('major_final_outputs', 'individual_final_outputs.idmfo', '=', 'major_final_outputs.id')
            ->leftJoin('division_outputs', 'individual_final_outputs.id_div_output', '=', 'division_outputs.id')
            ->leftJoin('user_employees', 'ipcr_daily_accomplishments.emp_code', '=', 'user_employees.empl_id')
            ->leftJoin('fms.offices', 'offices.department_code', 'user_employees.department_code')
            ->selectRaw("'$date_from' as date_from, '$date_to' as date_to")
            ->where('ipcr_daily_accomplishments.emp_code', $username)
            ->whereBetween('ipcr_daily_accomplishments.date', [$date_from, $date_to])
            ->distinct('ipcr_daily_accomplishments.id')
            ->orderBy('ipcr_daily_accomplishments.date', 'DESC')
            ->get();

        // dd($accomplishment);
        // $username = $request -> username;

        // $accomplishment = Daily_Accomplishment::where('emp_code', $username)
        // ->whereBetween('date',[$request->date_from, $request->date_to])
        // ->get();
        return $accomplishment;
    }


    public function ipcr_code()
    {
        $data = IPCRTargets::get();
        return $data;
    }

    public function index_target(Request $request, $id)
    {
        $targets = IPCRTargets::where('id', $id)->first();
        // $semestral = Ipcr_Semestral::where('id', $targets->ipcr_semester_id)->first();
        // $month1 = 1;
        // $month2 = 6;
        // if ($semestral->sem == '2') {
        //     $month1 = 7;
        //     $month2 = 12;
        //     // dd($semestral->sem);
        // }
        $emp_code = $targets->employee_code;
        // dd($targets);
        // dd('targets: ' . $targets->year);
        // dd('semestral: ' . $semestral->year);
        $data = Daily_Accomplishment::leftJoin('individual_final_outputs', 'ipcr_daily_accomplishments.idIPCR', '=', 'individual_final_outputs.ipcr_code')
            ->leftJoin('major_final_outputs', 'individual_final_outputs.idmfo', '=', 'major_final_outputs.id')
            ->leftJoin('division_outputs', 'individual_final_outputs.id_div_output', '=', 'division_outputs.id')
            ->select(
                'ipcr_daily_accomplishments.id',
                'ipcr_daily_accomplishments.date',
                'ipcr_daily_accomplishments.description',
                'ipcr_daily_accomplishments.quantity',
                'ipcr_daily_accomplishments.idIPCR',
                'ipcr_daily_accomplishments.emp_code',
                'ipcr_daily_accomplishments.remarks',
                'ipcr_daily_accomplishments.link',
                'ipcr_daily_accomplishments.individual_output',
                'individual_final_outputs.ipcr_code',
                'individual_final_outputs.idmfo',
                'individual_final_outputs.idsubmfo',
                'individual_final_outputs.id_div_output',
                'major_final_outputs.mfo_desc',
                'division_outputs.output'
            )->with('IPCRCode', 'IPCR')
            ->where('ipcr_daily_accomplishments.sem_id', $targets->ipcr_semester_id)
            ->where('ipcr_daily_accomplishments.emp_code', $emp_code)
            ->where('ipcr_daily_accomplishments.idIPCR', $targets->ipcr_code)
            ->orderBy('ipcr_daily_accomplishments.date', 'DESC')
            ->get();

        // dd($data);
        return inertia('Daily_Accomplishment/Index', [
            "data" => fn () => $data,
            "emp_code" => $emp_code
        ]);
    }
    public function store_api(Request $request)
    {
        $emp_code = $request->emp_code;
        $current_month = date('m'); // Get the current month (01-12)
        $current_year = date('Y');
        $currentSem = 0;


        if ($current_month < 7) {
            $currentSem  = 1;
        } else {
            $currentSem = 2;
        }

        $data = Ipcr_Semestral::select(
            'ipcr__semestrals.id',
        )
            ->where('ipcr__semestrals.sem', $currentSem)
            ->where('ipcr__semestrals.employee_code', $emp_code)
            ->where('ipcr__semestrals.year', $current_year)
            ->get();

        return $data;
        // dd($current_month);
        // // dd($request);
        // $request->validate([
        //     'date' => 'required',
        //     'description' => 'required',
        //     'idIPCR' => 'required',
        //     'emp_code' => 'required',
        //     'quantity' => 'required',
        //     'individual_output' => 'required',
        //     'sem_id' => 'required',
        // ]);

        // dd($request->all());
        // $this->model->create($request->all());
        // return redirect('/Daily_Accomplishment')
        //     ->with('message', 'Daily Accomplishment added');
    }

    public function sync_daily(Request $request)
    {
        $date_from = $request->date_from;
        $date_to = $request->date_to;

        $apiUrl = 'http://192.168.5.81/sync-accomplishment?from=' . $date_from . '&to=' . $date_to;


        $data = [];
        try {
            // Initialize GuzzleHTTP client
            $client = new Client();

            // Make an HTTP POST request to the API URL
            $response = $client->get($apiUrl, [
                // If the API requires any specific data in the request body, you can add it here
                'form_params' => [
                    'key' => 'value',
                    // Add more parameters as needed
                ],
                // If the API requires headers or authentication, you can add them here
                'headers' => [
                    'Authorization' => 'Bearer YOUR_API_TOKEN', // Replace with your API token or credentials
                    // Add more headers if needed
                ],
            ]);

            $data = json_decode($response->getBody(), true);
            $length = count($data);
            $mapped_data = [];
            $mapped_data2 = [];
            for ($i = 0; $i < $length; $i++) {
                if ($data[$i]['description'] && $data[$i]['due_date'] && $data[$i]['ipcr_code'] && $data[$i]['started_at'] && $data[$i]['reviewed_at'] && $data[$i]['completed_at'] && $data[$i]['rated_by_ipcr_code'] && $data[$i]['cats'] && $data[$i]['cats_reviewer']) {
                    $val = $this->SyncReviewee($data[$i]);
                    array_push($mapped_data, $val);
                    $val1 = $this->SyncReviewer($data[$i]);
                    array_push($mapped_data2, $val1);
                }
            }
            $chunk_data = array_chunk($mapped_data, 1000);
            foreach ($chunk_data as $key => $value) {
                foreach ($value as $datas) {
                    Daily_Accomplishment::updateOrCreate(
                        [
                            'idPM' => $datas['idPM'],
                            'emp_code' => $datas['emp_code'],
                        ],
                        $datas
                    );
                }
            }
            $chunk_data2 = array_chunk($mapped_data2, 1000);
            foreach ($chunk_data2 as $key => $value) {
                foreach ($value as $datas) {
                    Daily_Accomplishment::updateOrCreate(
                        [
                            'idPM' => $datas['idPM'],
                            'emp_code' => $datas['emp_code']
                        ],
                        $datas
                    );
                }
            }
        } catch (\Exception $e) {
            //throw $th;
            return Inertia::render('ErrorView', [
                'message' => 'Failed to retrieve data from the API.',
            ]);
        }

        return redirect('Daily_Accomplishment/')
            ->with('message', 'PM synced successfully!');
    }

    public function SyncReviewee($datum)
    {
        $date_daily = $datum['reviewed_at'];
        $due_date = $datum['due_date'];
        $ipcr_code = $datum['ipcr_code'];
        $emp_code = $datum['cats'];
        $description = $datum['description'];
        $carbonDate = Carbon::parse($date_daily)->startOfDay();
        $carbonDue = Carbon::parse($due_date)->startOfDay();
        $year = $carbonDate->format("Y"); // Four-digit year
        $month = $carbonDate->format("n");
        $dateOnly = $carbonDate->format("Y-m-d");

        if ($description == null) {
            $description = "";
        }

        $currentSem = 0;
        if ($month < 7) {
            $currentSem  = 1;
        } else {
            $currentSem = 2;
        }
        $data = Ipcr_Semestral::select(
            'ipcr__semestrals.id',
        )
            ->where('ipcr__semestrals.sem', $currentSem)
            ->where('ipcr__semestrals.employee_code', $emp_code)
            ->where('ipcr__semestrals.year', $year)
            ->first();

        $output = IndividualFinalOutput::select(
            'individual_final_outputs.individual_output',
            'individual_final_outputs.quality_error',
            'individual_final_outputs.unit_of_time',
            'individual_final_outputs.time_range_code',
        )
            ->where('individual_final_outputs.ipcr_code', $ipcr_code)
            ->first();

        $time_range_code = $output->time_range_code;
        $time_range = TimeRange::select(
            'time_ranges.time_code',
            'time_ranges.equivalent_time_to',
        )
            ->where('time_ranges.time_code', $time_range_code)
            ->where('time_ranges.rating', 4)
            ->first();

        $quality = 0;
        //quality = 1 error
        //quality = 2 ave. feedback
        if ($output->quality_error == 1) {
            $quality = 5;
        } else if ($output->quality_error == 2) {
            if ($carbonDate->lessThanOrEqualTo($carbonDue)) {
                $quality = 4;
            } else {
                $quality = 3;
            }
        }


        $quantity = 1;
        $timeliness = $time_range->equivalent_time_to;
        $average_timeliness = $quantity * $timeliness;

        $syncing = [
            'date' => $dateOnly,
            'description' => $description,
            'quantity' => 1,
            'timeliness' => $time_range->equivalent_time_to,
            'average_timeliness' => $average_timeliness,
            'quality' => $quality,
            'idIPCR' => $datum['ipcr_code'],
            'emp_code' => $datum['cats'],
            'sem_id' => $data->id,
            'individual_output' => $output->individual_output,
            'idPM' => $datum['id'],
        ];

        return $syncing;
    }

    public function SyncReviewer($datum)
    {
        $date_daily = $datum['completed_at'];
        $date_review = $datum['reviewed_at'];
        $ipcr_code = $datum['rated_by_ipcr_code'];
        $emp_code = $datum['cats_reviewer'];
        $description = $datum['description'];
        $carbonDate = Carbon::parse($date_daily)->startOfDay();
        $carbonReview = Carbon::parse($date_review)->startOfDay();
        $year = $carbonDate->format("Y"); // Four-digit year
        $month = $carbonDate->format("n");
        $dateOnly = $carbonDate->format("Y-m-d");
        if ($description == null) {
            $description = "";
        }
        $currentSem = 0;
        if ($month < 7) {
            $currentSem  = 1;
        } else {
            $currentSem = 2;
        }
        $data = Ipcr_Semestral::select(
            'ipcr__semestrals.id',
        )
            ->where('ipcr__semestrals.sem', $currentSem)
            ->where('ipcr__semestrals.employee_code', $emp_code)
            ->where('ipcr__semestrals.year', $year)
            ->first();

        $output = IndividualFinalOutput::select(
            'individual_final_outputs.individual_output',
            'individual_final_outputs.quality_error',
            'individual_final_outputs.unit_of_time',
            'individual_final_outputs.time_range_code',
        )
            ->where('individual_final_outputs.ipcr_code', $ipcr_code)
            ->first();
        $time_range_code = $output->time_range_code;
        $time_range = TimeRange::select(
            'time_ranges.time_code',
            'time_ranges.equivalent_time_to',
        )
            ->where('time_ranges.time_code', $time_range_code)
            ->where('time_ranges.rating', 4)
            ->first();
        $quality = 0;

        $daysdiff = $carbonReview->diffInDays($carbonDate);
        //quality = 1 error
        //quality = 2 ave. feedback
        if ($output->quality_error == 1) {
            $quality = 5;
        } else if ($output->quality_error == 2) {
            if ($daysdiff <= 3) {
                $quality = 4;
            } else {
                $quality = 3;
            }
        }

        $quantity = 1;
        $timeliness = $time_range->equivalent_time_to;
        $average_timeliness = $quantity * $timeliness;
        $syncing = [
            'date' => $dateOnly,
            'description' => "Reviewed - " . $description,
            'quantity' => 1,
            'timeliness' => $time_range->equivalent_time_to,
            'average_timeliness' => $average_timeliness,
            'quality' => $quality,
            'idIPCR' => $ipcr_code,
            'emp_code' => $datum['cats_reviewer'],
            'sem_id' => $data->id,
            'individual_output' => $output->individual_output,
            'idPM' => $datum['id'],
        ];
        return $syncing;
    }
}
