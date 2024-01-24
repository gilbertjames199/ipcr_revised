<?php

namespace App\Http\Controllers;

use App\Models\Daily_Accomplishment;
use App\Models\IndividualFinalOutput;
use App\Models\Ipcr_Semestral;
use App\Models\IPCRTargets;
use App\Models\Office;
use App\Models\UserEmployees;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
            ->where('ipcr_daily_accomplishments.emp_code', $emp_code)
            ->orderBy('ipcr_daily_accomplishments.date', 'DESC')
            ->paginate(10)
            ->withQueryString();

        // dd($data);
        return inertia('Daily_Accomplishment/Index', [
            "data" => fn () => $data,
            "emp_code" => $emp_code
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
}
