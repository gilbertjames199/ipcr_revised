<?php

namespace App\Http\Controllers;

use App\Helpers\PaginationHelper;
use App\Models\Division;
use App\Models\FFUNCCOD;
use App\Models\IndividualFinalOutput;
use App\Models\Ipcr_Semestral;
use App\Models\IPCRTargets;
use App\Models\MonthlyAccomplishment;
use App\Models\Office;
use App\Models\ReturnRemarks;
use App\Models\UserEmployees;
use Illuminate\Http\Request;

class IpcrSemestralController extends Controller
{
    protected $ipcr_sem;
    public function __construct(Ipcr_Semestral $ipcr_sem)
    {
        $this->ipcr_sem = $ipcr_sem;
    }
    public function index(Request $request, $id, $source)
    {
        // dd("gdfgdfgdfg");
        $emp = UserEmployees::where('id', $id)
            ->first();
        // dd($emp->department_code);
        $emp_code = $emp->empl_id;
        $division = "";
        if ($emp->division_code) {
            $division = Division::where('division_code', $emp->division_code)
                ->first()->division_name1;
        }
        $office = FFUNCCOD::where('department_code', $emp->department_code)->first();
        $dept = Office::where('department_code', $emp->department_code)->first();
        $pgHead = UserEmployees::where('empl_id', $dept->empl_id)->first();
        $pgHead = $pgHead->first_name . ' ' . $pgHead->middle_name[0] . ' ' . $pgHead->last_name;
        // dd($pgHead);
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
            ->paginate(10)
            ->withQueryString();
        // with('immediate')
        // ->with('next_higher')
        // ->
        $sem_data = Ipcr_Semestral::where('employee_code', $emp_code)
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
        $showPerPage = 10;
        $sem_data = PaginationHelper::paginate($sem_data, $showPerPage);
        // dd($sem_data);
        //dd($sem_data);
        //dd($source);
        //return inertia('IPCR/Semestral/Index');
        return inertia('IPCR/Semestral/Index', [
            "id" => $id,
            "data" => $data,
            "sem_data" => $sem_data,
            "division" => $division,
            "emp" => $emp,
            "source" => $source,
            "office" => $office,
            "pgHead" => $pgHead,
        ]);
    }
    public function create(Request $request, $id, $source)
    {
        // dd($id);
        // dd(auth()->user());
        $emp = UserEmployees::where('id', $id)
            ->first();
        // dd($emp);
        $sg = $emp->salary_grade;
        $dept_code = $emp->department_code;
        $supervisors = UserEmployees::where('department_code', $dept_code)
            ->where('salary_grade', '>', $sg)
            ->get();
        // dd($supervisors);
        return inertia('IPCR/Semestral/Create', [
            'supervisors' => $supervisors,
            'id' => $id,
            'emp' => $emp,
            'dept_code' => $dept_code,
            'source' => $source
        ]);
    }
    public function store(Request $request)
    {
        //dd($request->source);
        $id = UserEmployees::where('empl_id', $request->employee_code)
            ->first()->id;
        //For Automatic approved ra ni
        // $request['status'] = 2;

        $attributes = $request->validate([
            'sem' => 'required',
            'employee_code' => 'required',
            'immediate_id' => 'required',
            'next_higher' => 'required',
            'year' => 'required',
            'status' => 'required'
        ]);
        $ipcr_targg = Ipcr_Semestral::where('employee_code', $request->employee_code)
            ->where('year', $request->year)
            ->where('sem', $request->sem)
            ->get();
        if (count($ipcr_targg) < 1) {
            // $this->ipcr_sem->create($attributes);
            $ipcrsem = new Ipcr_Semestral;
            $ipcrsem->sem = $request->sem;
            $ipcrsem->employee_code = $request->employee_code;
            $ipcrsem->immediate_id = $request->immediate_id;
            $ipcrsem->next_higher = $request->next_higher;
            $ipcrsem->year = $request->year;
            $ipcrsem->status = $request->status;
            $ipcrsem->save();
            //CREATE MONTHLY ACCOMPLISHMENT
            $ipcr_m_id = $ipcrsem->id;
            $sem = $request->sem;
            $year = $request->year;
            // Define the months based on the semester value
            $months = ($sem == 1) ? ['1', '2', '3', '4', '5', '6'] : ['7', '8', '9', '10', '11', '12'];

            // Create Ipcr_monthly records for each month
            foreach ($months as $month) {
                $existingRecord = MonthlyAccomplishment::where('ipcr_semestral_id', $ipcr_m_id)
                    ->where('month', $month)
                    ->first();
                if (!$existingRecord) {
                    MonthlyAccomplishment::create([
                        'month' => $month,
                        'year' => $year,
                        'ipcr_semestral_id' => $ipcr_m_id, // Reference to the parent semestral record
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
            return redirect('/ipcrsemestral/' . $id . '/' . $request->source)
                ->with('message', 'Semestral target added');
        } else {
            return redirect('/ipcrsemestral/' . $id . '/' . $request->source)
                ->with('error', 'Error adding semestral target');
        }
    }
    public function edit(Request $request, $semid, $source)
    {
        $data = Ipcr_Semestral::where('id', $semid)
            ->first();
        // dd($data->);
        $id = $data->employee_code;
        $emp = UserEmployees::where('empl_id', $id)
            ->first();
        $dept_code = $emp->department_code;
        $supervisors = UserEmployees::where('department_code', $dept_code)
            ->get();

        // dd($supervisors);
        return inertia('IPCR/Semestral/Create', [
            'supervisors' => $supervisors,
            'id' => $id,
            'emp' => $emp,
            'dept_code' => $dept_code,
            'source' => $source,
            'editData' => $data
        ]);
    }
    public function update(Request $request, $id)
    {
        // dd($request);
        $data = $this->ipcr_sem->findOrFail($id);
        $user = UserEmployees::where('empl_id', $request->employee_code)
            ->first();
        $user_id = $user->id;
        $data->update([
            'sem' => $request->sem,
            'employee_code' => $request->employee_code,
            'immediate_id' => $request->immediate_id,
            'next_higher' => $request->next_higher,
            'ipcr_semester_id' => $request->ipcr_semester_id,
            'status' => $request->status,
            'year' => $request->year,
        ]);

        // $data = $this->ipcr_sem->findOrFail($request->id);
        // dd($data);

        return redirect('/ipcrsemestral/' . $user_id . '/' . $request->source)
            ->with('info', 'IPCR updated');
    }
    public function destroy(Request $request, $id, $source)
    {
        // dd('delete : '.$id);
        $emp_code = auth()->user()->username;
        $emp = UserEmployees::where('empl_id', $emp_code)
            ->first()->id;

        $data = $this->ipcr_sem->findOrFail($id);
        $data->delete();

        $ipcr_monthly_accomp = MonthlyAccomplishment::where('ipcr_semestral_id', $id)->delete();
        return redirect('/ipcrsemestral/' . $emp . '/' . $source)
            ->with('deleted', 'Employee IPCR Deleted!');
    }
    public function submission(Request $request, $id, $source)
    {
        // dd('id: '.$id.' source: '.$source);
        $data = $this->ipcr_sem->findOrFail($id);
        // dd($data);
        $user = UserEmployees::where('empl_id', $data->employee_code)
            ->first();
        $user_id = $user->id;
        $data->update([
            'status' => '0',
        ]);

        // $data = $this->ipcr_sem->findOrFail($request->id);
        // dd($data);

        return redirect('/ipcrsemestral/' . $user_id . '/' . $request->source)
            ->with('message', 'IPCR submitted');
    }
}
