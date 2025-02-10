<?php

namespace App\Http\Controllers;

use App\Models\Daily_Accomplishment;
use App\Models\IndividualFinalOutput;
use App\Models\Ipcr_Semestral;
use App\Models\IpcrTarget;
use App\Models\IPCRTargets;
use App\Models\Office;
use App\Models\TimeRange;
use App\Models\UserEmployees;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
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

        $emp_code = auth()->user()->username;
        $data = Daily_Accomplishment::with([
            'individualFinalOutput.divisionOutput',
            'monthlyAccomplishment',
            'ipcr_Semestral'
        ])
            ->whereHas('ipcr_Semestral')
            ->select(
                'ipcr_daily_accomplishments.id',
                'ipcr_daily_accomplishments.date',
                'ipcr_daily_accomplishments.description',
                'ipcr_daily_accomplishments.emp_code',
                'ipcr_daily_accomplishments.individual_final_output_id',
                'ipcr_daily_accomplishments.individual_output',
                'ipcr_daily_accomplishments.sem_id',
            )

            ->when($request->date_from, function ($query, $searchItem) {
                $query->whereDate('ipcr_daily_accomplishments.date', '>=', $searchItem);
            })
            ->when($request->date_to, function ($query, $searchItem) {
                $query->whereDate('ipcr_daily_accomplishments.date', '<=', $searchItem);
            })
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
            ->orderBy('ipcr_daily_accomplishments.date', 'DESC')
            ->simplePaginate(10)
            ->withQueryString();

        // dd($data);
        return inertia('Daily_Accomplishment/Index', [
            "data" => fn() => $data,
            "emp_code" => $emp_code,
            // "ipcr_codes" => $ipcr_codes
        ]);
    }

    public function create(Request $request)
    {
        // dd('create');
        session(['previous_url' => url()->previous()]);
        $emp_code = Auth()->user()->username;
        // dd($emp_code);
        $sem = Ipcr_Semestral::select('id', 'sem', 'employee_code', 'year', 'status', DB::raw("IF(sem=1,'First Semester', 'Second Semester') as sem_in_word"), 'status_accomplishment')
            ->where('status', '2')
            ->where('employee_code', $emp_code)
            ->get();

        // dd($sem);

        $data = IpcrTarget::with([
            'individualOutput',
            'ipcr_Semestral',
            // 'individualOutput.majorFinalOutputs',
            // 'individualOutput.subMfo',
        ])
            ->where('employee_code', $emp_code)
            ->where(function ($query) {
                $query->where('is_additional_target', 0)
                    ->orWhere(function ($query) {
                        $query->where('is_additional_target', 1)
                            ->where('status', '>=', 2);
                    });
            })
            // ->orderBy('ipcr_code', 'ASC')
            ->get()
            ->map(function ($item) {




                // dd($item->individualOutput);

                return [
                    "id" => $item->id,
                    "semester" => $item->semester,
                    "individual_final_output_id" => $item->individualOutput ? $item->individualOutput->id : '',
                    "individual_output" => $item->individualOutput ? $item->individualOutput->individual_output : '',
                    "performance_measure" => $item->individualOutput ? $item->individualOutput->performance_measure : '',
                    "sem_id" => $item->ipcr_Semestral ? $item->ipcr_Semestral->id : '',
                    "sem" =>  $item->ipcr_Semestral ? $item->ipcr_Semestral->sem : '',
                    "year" => $item->ipcr_Semestral ? $item->ipcr_Semestral->year : '',
                    "status" => $item->ipcr_Semestral ? $item->ipcr_Semestral->status : '',
                ];
            });
        // dd($data);

        return inertia('Daily_Accomplishment/Create', [
            'emp_code' => $emp_code,
            'data' => $data,
            'sem' => $sem,
            'session' => session()->all(),
            'can' => [
                'can_access_validation' => Auth::user()->can('can_access_validation', User::class),
                'can_access_indicators' => Auth::user()->can('can_access_indicators', User::class)
            ],
        ]);
    }

    public function store(Request $request)
    {
        // dd($request->all());
        // dd($request);
        $request->validate([
            'date' => 'required',
            'description' => 'required',
            'individual_final_output_id' => 'required',
            'emp_code' => 'required',
            'individual_output' => 'required',
            'sem_id' => 'required',
        ]);

        // dd($request->all());
        $this->model->create([
            'date' => $request->date,
            'description' => $request->description,
            'individual_final_output_id' => $request->individual_final_output_id,
            'emp_code' => $request->emp_code,
            'individual_output' => $request->individual_output,
            'sem_id' => $request->sem_id,
        ]);
        return redirect('/Daily_Accomplishment')
            ->with('message', 'Daily Accomplishment added');
    }

    public function edit(Request $request, $id)
    {
        session(['previous_url' => url()->previous()]);

        $data = $this->model->where('id', $id)->first([
            'id',
            'emp_code',
            'date',
            'individual_output',
            'individual_final_output_id',
            'description',
            'sem_id',
        ]);

        // dd($data);
        $sem = Ipcr_Semestral::select('id', 'sem', 'employee_code', 'year', 'status', DB::raw("IF(sem=1,'First Semester', 'Second Semester') as sem_in_word"))
            ->where('status', '2')
            ->get();
        $emp_code = Auth()->user()->username;
        $IPCR = IndividualFinalOutput::select(
            'ipcr_targets.id',
            'individual_final_outputs.individual_output',
            'individual_final_outputs.id as individual_final_output_id',
            'ipcr__semestrals.id as sem_id',
            'ipcr__semestrals.sem',
            'ipcr__semestrals.year',
            'ipcr__semestrals.status',
        )
            ->join('ipcr_targets', 'ipcr_targets.individual_final_output_id', 'individual_final_outputs.id')
            ->Leftjoin('ipcr__semestrals', 'ipcr__semestrals.id', 'ipcr_targets.ipcr_semestral_id')
            ->distinct('individual_final_outputs.id')
            ->where('ipcr_targets.employee_code', $emp_code)
            ->orderBy('individual_final_outputs.id')
            ->get();

        // dd($IPCR);

        return inertia('Daily_Accomplishment/Create', [
            "data" => $IPCR,
            "editData" => $data,
            'sem' => $sem,
            'session' => session()->all(),
            'can' => [
                'can_access_validation' => Auth::user()->can('can_access_validation', User::class),
                'can_access_indicators' => Auth::user()->can('can_access_indicators', User::class)
            ],
        ]);
    }

    public function update(Request $request)
    {
        // dd($request->all());
        // dd(session()->all());
        $prev_url = session('previous_url');
        $data = $this->model->findOrFail($request->id);
        // dd($data);
        // $emp_code = $data->emp_code;
        $data->update([
            'date' => $request->date,
            'individual_final_output_id' => $request->individual_final_output_id,
            'individual_output' => $request->individual_output,
            'description' => $request->description,
            "sem_id" => $request->sem_id,
        ]);

        return redirect($prev_url)
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
            'individual_final_outputs.performance_measure',
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
        $emp_code = $targets->employee_code;
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
            "data" => fn() => $data,
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
    }

    public function sync_daily(Request $request)
    {
        $date_from = $request->date_from;
        $date_to = $request->date_to;

        $apiUrl = 'http://192.168.80.81/sync-accomplishment?from=' . $date_from . '&to=' . $date_to;



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
            $rated_by_ipcr = 124;
            $data = json_decode($response->getBody(), true);

            // dd($data);

            $length = count($data);
            $mapped_data = [];
            $mapped_data2 = [];
            for ($i = 0; $i < $length; $i++) {
                $reviewed_at = $data[$i]['due_date'];
                // dd($reviewed_at);
                if ($data[$i]['description'] && $data[$i]['due_date'] &&  $data[$i]['ipcr_code'] && $data[$i]['started_at']  && $data[$i]['completed_at'] && $data[$i]['cats'] && $data[$i]['cats_reviewer']) {
                    if ($data[$i]['rated_by_ipcr_code'] == null) {
                        $data[$i]['rated_by_ipcr_code'] = $rated_by_ipcr;
                    }
                    if ($data[$i]['reviewed_at'] == null) {
                        $data[$i]['reviewed_at'] = $reviewed_at;
                    }
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
                $quality = 5;
            } else {
                $quality = 4;
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
                $quality = 5;
            } else {
                $quality = 4;
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
