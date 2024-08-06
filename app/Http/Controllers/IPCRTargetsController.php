<?php

namespace App\Http\Controllers;

use App\Models\Division;
use App\Models\EmployeeSpecialDepartment;
use App\Models\IndividualFinalOutput;
use App\Models\Ipcr_Semestral;
use App\Models\IpcrProbTempoTarget;
use App\Models\IpcrScore;
use App\Models\IPCRTargets;
use App\Models\ReturnRemarks;
use App\Models\UserEmployeeCredential;
use App\Models\UserEmployees;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PHPUnit\Framework\Constraint\Count;

class IPCRTargetsController extends Controller
{
    protected $ipcr_target;
    public function __construct(IPCRTargets $ipcr_target)
    {
        $this->ipcr_target = $ipcr_target;
    }
    public function index(Request $request, $id)
    {
        // dd("dsdsdsfdsf");
        $sem = Ipcr_Semestral::where('id', $id)
            ->first();
        // dd($sem);
        $emp_code = $sem->employee_code;
        $auth_code = auth()->user()->username;
        // dd($auth_code);
        if ($emp_code != $auth_code) {
            return redirect('/forbidden')->with('error', 'You are not allowed to edit this IPCR');
        }
        // dd($sem->next_higher);
        $emp = UserEmployees::where('empl_id', $emp_code)
            ->first();
        $next_high = UserEmployees::where('empl_id', $sem->next_higher)
            ->first();
        // dd($emp->division_code);
        $division = "";
        if ($emp->division_code) {
            $division = Division::where('division_code', $emp->division_code)
                ->first()->division_name1;
        } else {
            if ($next_high->division_code) {
                $division
                    = Division::where('division_code', $next_high->division_code)
                    ->first()->division_name1;
            }
        }

        // $data = IPCRTargets::with([
        //     'individualOutput',
        //     'individualOutput.divisionOutput',
        //     'individualOutput.divisionOutput.division',
        //     'individualOutput.majorFinalOutputs',
        //     'individualOutput.subMfo'
        // ])
        //     ->get()
        //     ->map(function ($item) {
        //         // dd($item);
        //         // dd($item->individualOutput[0]->divisionOutput[0]);
        //         // if (!$item->individualOutput) {
        //         //     dd($item);
        //         // }
        //         $div_output = "";
        //         $mfo_desc = "";
        //         $submfo_description = "";
        //         $performance_measure = "";
        //         if (count($item->individualOutput) > 0) {
        //             // dd($item->individualOutput[0]);
        //             if ($item->individualOutput[0]) {
        //                 $performance_measure = $item->individualOutput[0]->performance_measure;
        //                 if ($item->individualOutput[0]->divisionOutput) {
        //                     $div_output = $item->individualOutput[0]->divisionOutput;
        //                 }
        //                 if ($item->individualOutput[0]->majorFinalOutputs) {
        //                     $mfo_desc = $item->individualOutput[0]->majorFinalOutputs;
        //                 }
        //                 if ($item->individualOutput[0]->subMfo) {
        //                     $submfo_description = $item->individualOutput[0]->subMfo;
        //                 }
        //             }
        //         }
        //         return [
        //             'ipcr_code' => $item->ipcr_code,
        //             'id' => $item->id,
        //             'ipcr_type' => $item->ipcr_type,
        //             'remarks' => $item->remarks,
        //             // 'individual_output' => $item->individualOutput[0]->individual_output,
        //             'performance_measure' => $performance_measure,
        //             // 'division' => $item->individualOutput[0]->divisionOutput->division ? ($item->individualOutput[0]->divisionOutput[0] ? $item->individualOutput[0]->divisionOutput[0]->division[0]->division_name1 : '') : '',
        //             'is_additional_target' => $item->is_additional_target,
        //             'div_output' => $div_output,
        //             'mfo_desc' => $mfo_desc,
        //             // 'FFUNCCOD' => $item->individualOutput->majorFinalOutputs ? $item->individualOutput->majorFinalOutputs->FFUNCCOD : '',
        //             'submfo_description' => $submfo_description,
        //             // 'department_code' => $item->individualOutput->majorFinalOutputs ? $item->individualOutput->majorFinalOutputs->department_code : '',
        //             'ipcr_semester_id' => $item->ipcr_semester_id
        //         ];
        //     });
        // dd($data);
        // dd("division");
        $data = IPCRTargets::select(
            'individual_final_outputs.ipcr_code',
            'i_p_c_r_targets.id',
            'i_p_c_r_targets.ipcr_type',
            'i_p_c_r_targets.remarks',
            'individual_final_outputs.individual_output',
            'individual_final_outputs.performance_measure',
            'i_p_c_r_targets.is_additional_target',
            'divisions.division_name1 AS division',
            'division_outputs.output AS div_output',
            'major_final_outputs.mfo_desc',
            'major_final_outputs.FFUNCCOD',
            'sub_mfos.submfo_description',
            'major_final_outputs.department_code',
            'i_p_c_r_targets.ipcr_semester_id',
        )
            ->leftjoin('individual_final_outputs', 'individual_final_outputs.ipcr_code', 'i_p_c_r_targets.ipcr_code')
            ->leftjoin('division_outputs', 'division_outputs.id', 'individual_final_outputs.id_div_output')
            ->leftjoin('divisions', 'divisions.id', 'division_outputs.division_id')
            ->leftjoin('major_final_outputs', 'major_final_outputs.id', 'division_outputs.idmfo')
            ->leftjoin('sub_mfos', 'sub_mfos.id', 'individual_final_outputs.idsubmfo')
            ->when($request->search, function ($query, $searchValue) {
                // dd($searchValue);
                return $query->where(function ($query) use ($searchValue) {
                    $query->where('individual_final_outputs.individual_output', 'LIKE', '%' . $searchValue . '%')
                        ->orWhere('individual_final_outputs.performance_measure', 'LIKE', '%' . $searchValue . '%')
                        ->orWhere('individual_final_outputs.ipcr_code', 'LIKE', '%' . $searchValue . '%');
                });
            })
            ->where('i_p_c_r_targets.employee_code', $emp_code)
            ->where('i_p_c_r_targets.ipcr_semester_id', $id)
            ->orderBy('ipcr_type')
            ->orderBy('individual_final_outputs.ipcr_code')
            ->get();

        // dd($data);
        // dd($id);
        // $data = IPCRTargets::where('i_p_c_r_targets.ipcr_semester_id', $id)
        //     ->get();
        // dd($data->pluck('ipcr_code'));
        return inertia('IPCR/Targets/Index', [

            "sem" => $sem,
            "id" => $id,
            "data" => $data,
            "division" => $division,
            "emp" => $emp
        ]);
    }
    public function create(Request $request, $id)
    {
        //major_final_outputs.department_code = '04' OR
        // WHERE (major_final_outputs.department_code = '' OR major_final_outputs.department_code = '0' OR major_final_outputs.department_code = '-')
        $sem = Ipcr_Semestral::where('id', $id)
            ->first();
        $emp_code = $sem->employee_code;
        $emp = UserEmployees::where('empl_id', $emp_code)
            ->first();
        // dd($emp);
        $dept_code = $emp->department_code;
        $desig_dept = $emp->designate_department_code;
        // dd($emp);
        $existingTargets = IPCRTargets::where('ipcr_semester_id', $id)
            ->pluck('ipcr_code')
            ->toArray();
        $special_dept = EmployeeSpecialDepartment::where('employee_code', Auth::user()->username)->first();
        // dd($special_dept->pluck('employee_code'));
        // where('employee_code', Auth::user()->username)->first();
        // dd(Auth::user()->username);
        // dd($special_dept);



        $ipcrs = IndividualFinalOutput::select(
            'individual_final_outputs.ipcr_code',
            'individual_final_outputs.id',
            'individual_final_outputs.individual_output',
            'individual_final_outputs.performance_measure',
            'divisions.division_name1 AS division',
            'division_outputs.output AS div_output',
            'major_final_outputs.mfo_desc',
            'major_final_outputs.FFUNCCOD',
            'sub_mfos.submfo_description',
            'major_final_outputs.department_code'
        )
            ->leftjoin('major_final_outputs', 'major_final_outputs.id', 'individual_final_outputs.idmfo')
            ->leftjoin('division_outputs', 'division_outputs.id', 'individual_final_outputs.id_div_output')
            ->leftjoin('divisions', 'divisions.id', 'division_outputs.division_id')
            ->leftjoin('sub_mfos', 'sub_mfos.id', 'individual_final_outputs.idsubmfo')
            ->whereNested(function ($query) use ($dept_code, $desig_dept) {
                $query->where('major_final_outputs.department_code', '=', $dept_code)
                    ->orWhere('major_final_outputs.department_code', '=', '')
                    ->orWhere('major_final_outputs.department_code', '=', $desig_dept)
                    ->orWhere('major_final_outputs.department_code', '=', '0')
                    ->orWhere('major_final_outputs.department_code', '=', '-')
                    ->orWhere('individual_final_outputs.ipcr_code', '<', '126')
                    ->when($dept_code >= 20 && $dept_code <= 24, function ($query) {
                        $query->orWhere('major_final_outputs.department_code', '=', '20');
                    });
            })
            ->whereNotIn('individual_final_outputs.ipcr_code', $existingTargets)
            ->orderBy('individual_final_outputs.ipcr_code', 'ASC')
            ->get();
        // dd($dept_code);
        // dd($dept_code);
        // dd($ipcrs->pluck('department_code'));
        // ->orderBy('major_final_outputs.department_code', 'DESC')
        // if (Count($special_dept) > 0) {
        if ($special_dept) {
            // $spdp = $special_dept->department_code;
            // $desig = $special_dept->pluck('designate_department_code');
            // $spdp = $spdp->unique()->concat($desig);
            // dd($special_dept);
            // dd($spdp);
            //if($spdp==27 || $spdp == ""){}

            $sp = IndividualFinalOutput::select(
                'individual_final_outputs.ipcr_code',
                'individual_final_outputs.id',
                'individual_final_outputs.individual_output',
                'individual_final_outputs.performance_measure',
                'divisions.division_name1 AS division',
                'division_outputs.output AS div_output',
                'major_final_outputs.mfo_desc',
                'major_final_outputs.FFUNCCOD',
                'sub_mfos.submfo_description',
                'major_final_outputs.department_code'
            )
                ->leftjoin('major_final_outputs', 'major_final_outputs.id', 'individual_final_outputs.idmfo')
                ->leftjoin(
                    'division_outputs',
                    'division_outputs.id',
                    'individual_final_outputs.id_div_output'
                )
                ->leftjoin('divisions', 'divisions.id', 'division_outputs.division_id')
                ->leftjoin('sub_mfos', 'sub_mfos.id', 'individual_final_outputs.idsubmfo')
                ->orderBy('individual_final_outputs.ipcr_code', 'ASC')
                ->get();


            $ipcrs = $ipcrs->concat($sp);
        }
        return inertia('IPCR/Targets/Create', [
            "id" => $id,
            "filters" => $request->only(['search']),
            "emp" => $emp,
            "ipcrs" => $ipcrs,
            "sem" => $sem
        ]);
    }
    public function store(Request $request, $id)
    {

        //dd($request->is_additional_target);
        $attributes = $request->validate([
            'employee_code' => 'required',
            'ipcr_code' => 'required',
            'semester' => 'required',
            'ipcr_type' => 'required',
            'ipcr_semester_id' => 'required',
            'quantity_sem' => 'required|numeric',
            // 'month_1' => 'required|numeric',
            // 'month_2' => 'required|numeric',
            // 'month_3' => 'required|numeric',
            // 'month_4' => 'required|numeric',
            // 'month_5' => 'required|numeric',
            // 'month_6' => 'required|numeric',
            'year' => 'required|numeric',
        ]);
        // $request['status'] = 2;
        // dd($request->status);
        $ipcr_targg = IPCRTargets::where('employee_code', $request->employee_code)
            ->where('ipcr_code', $request->ipcr_code)
            ->where('ipcr_semester_id', $request->ipcr_semester_id)
            ->get();
        $msg = '';
        $tp = '';
        // dd(count($ipcr_targg));
        if (count($ipcr_targg) < 1) {
            $this->ipcr_target->create($request->all());
            $tp = 'message';
            $msg = 'Employee Targets added!';
        } else {
            $tp = 'error';
            $msg = 'Unable to save!';
        }
        return redirect('/ipcrtargets/' . $id)
            ->with($tp, $msg);
    }
    public function edit(Request $request, $id)
    {
        $data = IPCRTargets::where('id', $id)->first();
        // dd($id);
        $emp_code = $data->employee_code;

        $emp = UserEmployees::where('empl_id', $emp_code)
            ->first();
        $e_id = $emp->id;
        $dept_code = auth()->user()->department_code;
        // dd(auth()->user());
        $ipcrs = IndividualFinalOutput::select(
            'individual_final_outputs.ipcr_code',
            'individual_final_outputs.id',
            'individual_final_outputs.individual_output',
            'individual_final_outputs.performance_measure',
            'divisions.division_name1 AS division',
            'division_outputs.output AS div_output',
            'major_final_outputs.mfo_desc',
            'major_final_outputs.FFUNCCOD',
            'sub_mfos.submfo_description',
            'major_final_outputs.department_code'
        )
            ->leftjoin('division_outputs', 'division_outputs.id', 'individual_final_outputs.id_div_output')
            ->leftjoin('divisions', 'divisions.id', 'division_outputs.division_id')
            ->leftjoin('major_final_outputs', 'major_final_outputs.id', 'division_outputs.idmfo')
            ->leftjoin('sub_mfos', 'sub_mfos.id', 'individual_final_outputs.idsubmfo')
            ->whereNested(function ($query) use ($dept_code) {
                $query->where('major_final_outputs.department_code', '=', $dept_code)
                    ->orWhere('major_final_outputs.department_code', '=', '')
                    ->orWhere('major_final_outputs.department_code', '=', '0')
                    ->orWhere('major_final_outputs.department_code', '=', '-')
                    ->orWhere('individual_final_outputs.ipcr_code', '<', '126');
            })
            // ->where('ipcr_code', '1512')
            ->orderBy('individual_final_outputs.ipcr_code', 'DESC')
            ->get();
        // dd($ipcrs);
        // dd($dept_code);
        // ->orderBy('major_final_outputs.department_code', 'DESC')
        $data = IPCRTargets::where('id', $id)->first();
        $special_dept = EmployeeSpecialDepartment::where('employee_code', Auth::user()->username)->first();
        if ($special_dept) {
            $spdp = $special_dept->department_code;
            // $desig = $special_dept->pluck('designate_department_code');
            // $spdp = $spdp->unique()->concat($desig);
            // dd($special_dept);
            // dd($spdp);
            //if($spdp==27 || $spdp == ""){}
            $sp = IndividualFinalOutput::select(
                'individual_final_outputs.ipcr_code',
                'individual_final_outputs.id',
                'individual_final_outputs.individual_output',
                'individual_final_outputs.performance_measure',
                'divisions.division_name1 AS division',
                'division_outputs.output AS div_output',
                'major_final_outputs.mfo_desc',
                'major_final_outputs.FFUNCCOD',
                'sub_mfos.submfo_description',
                'major_final_outputs.department_code'
            )
                ->leftjoin('major_final_outputs', 'major_final_outputs.id', 'individual_final_outputs.idmfo')
                ->leftjoin(
                    'division_outputs',
                    'division_outputs.id',
                    'individual_final_outputs.id_div_output'
                )
                ->leftjoin('divisions', 'divisions.id', 'division_outputs.division_id')
                ->leftjoin('sub_mfos', 'sub_mfos.id', 'individual_final_outputs.idsubmfo')
                ->orderBy('individual_final_outputs.ipcr_code', 'ASC')
                ->get();


            $ipcrs = $ipcrs->concat($sp);
        }
        return inertia('IPCR/Targets/Create', [
            "id" => $e_id,
            "emp" => $emp,
            "ipcrs" => $ipcrs,
            "editData" => $data
        ]);
    }
    public function update(Request $request, $id)
    {
        // dd($id . ' update');
        // dd($request);
        $data = $this->ipcr_target->findOrFail($request->id);
        // dd($data);
        // ->whereNot('id',$request->id)
        $ipcr_targg = IPCRTargets::where('employee_code', $request->employee_code)
            ->where('ipcr_code', $request->ipcr_code)
            ->where('ipcr_semester_id', $request->ipcr_semester_id)
            ->get();
        // dd($ipcr_targg);
        $data->update([
            'employee_code' => $request->employee_code,
            'ipcr_code' => $request->ipcr_code,
            'semester' => $request->semester,
            'ipcr_type' => $request->ipcr_type,
            'quantity_sem' => $request->quantity_sem,
            'ipcr_semester_id' => $request->ipcr_semester_id,
            'month_1' => $request->month_1,
            'month_2' => $request->month_2,
            'month_3' => $request->month_3,
            'month_4' => $request->month_4,
            'month_5' => $request->month_5,
            'month_6' => $request->month_6,
            "remarks" => $request->remarks,
            'year' => $request->year,
        ]);

        $data = $this->ipcr_target->findOrFail($request->id);
        // dd($data);

        return redirect('/ipcrtargets/' . $request->ipcr_semester_id)
            ->with('info', 'IPCR Target updated');
    }
    public function destroy($id, $empl_id)
    {
        //dd($id.' empid: '.$empl_id);
        $data = $this->ipcr_target->findOrFail($id);
        $data->delete();
        return redirect('/ipcrtargets/' . $empl_id)
            ->with('deleted', 'Employee Target Deleted!');
    }
    public function review_ipcr(Request $request)
    {
        //dd($request->empl_code);
        $targets = IPCRTargets::select(
            'i_p_c_r_targets.ipcr_code',
            'i_p_c_r_targets.month_1',
            'i_p_c_r_targets.month_2',
            'i_p_c_r_targets.month_3',
            'i_p_c_r_targets.month_4',
            'i_p_c_r_targets.month_5',
            'i_p_c_r_targets.month_6',
            'i_p_c_r_targets.quantity_sem',
            'i_p_c_r_targets.ipcr_type',
            'individual_final_outputs.individual_output',
            'individual_final_outputs.performance_measure'
        )
            ->where('employee_code', $request->empl_id)
            ->where('ipcr_semester_id', $request->sem_id)
            ->distinct('i_p_c_r_targets.ipcr_code')
            ->join('individual_final_outputs', 'individual_final_outputs.ipcr_code', 'i_p_c_r_targets.ipcr_code')
            ->distinct('i_p_c_r_targets.ipcr_code')
            ->orderBy('individual_final_outputs.ipcr_code', 'ASC')
            ->get();
        return $targets;
    }
    //REVIEW TARGETS SET BY PROBATIONARY/TEMPORARY EMPLOYEES
    public function review_ipcr2(Request $request)
    {

        $targets = IpcrProbTempoTarget::select(
            'ipcr_prob_tempo_targets.ipcr_code',
            'ipcr_prob_tempo_targets.quantity',
            'ipcr_prob_tempo_targets.ipcr_type',
            'individual_final_outputs.individual_output',
            'individual_final_outputs.performance_measure'
        )
            ->where('probationary_temporary_employees.employee_code', $request->empl_id)
            ->where('probationary_temporary_employees.id', $request->sem_id)
            ->distinct('ipcr_prob_tempo_targets.ipcr_code')
            ->join('individual_final_outputs', 'individual_final_outputs.ipcr_code', 'ipcr_prob_tempo_targets.ipcr_code')
            ->join('probationary_temporary_employees', 'probationary_temporary_employees.id', 'ipcr_prob_tempo_targets.probationary_temporary_employees_id')
            ->distinct('ipcr_prob_tempo_targets.ipcr_code')
            ->orderBy('individual_final_outputs.ipcr_code', 'ASC')
            ->get();
        return $targets;
    }
    public function additional_create(Request $request, $id)
    {
        $sem = Ipcr_Semestral::where('id', $id)
            ->first();
        $emp_code = $sem->employee_code;
        $emp = UserEmployees::where('empl_id', $emp_code)
            ->first();
        $dept_code = auth()->user()->department_code;
        $existingTargets = IPCRTargets::where('ipcr_semester_id', $id)
            ->pluck('ipcr_code')
            ->toArray();
        // dd($dept_code);
        $ipcrs =
            IndividualFinalOutput::select(
                'individual_final_outputs.ipcr_code',
                'individual_final_outputs.id',
                'individual_final_outputs.individual_output',
                'individual_final_outputs.performance_measure',
                'divisions.division_name1 AS division',
                'division_outputs.output AS div_output',
                'major_final_outputs.mfo_desc',
                'major_final_outputs.FFUNCCOD',
                'sub_mfos.submfo_description',
                'major_final_outputs.department_code'
            )
            ->leftjoin('major_final_outputs', 'major_final_outputs.id', 'individual_final_outputs.idmfo')
            ->leftjoin('division_outputs', 'division_outputs.id', 'individual_final_outputs.id_div_output')
            ->leftjoin('divisions', 'divisions.id', 'division_outputs.division_id')
            ->leftjoin('sub_mfos', 'sub_mfos.id', 'individual_final_outputs.idsubmfo')
            ->whereNested(function ($query) use ($dept_code) {
                $query->where('major_final_outputs.department_code', '=', $dept_code)
                    ->orWhere('major_final_outputs.department_code', '=', '')
                    ->orWhere('major_final_outputs.department_code', '=', '0')
                    ->orWhere('major_final_outputs.department_code', '=', '-')
                    ->orWhere('individual_final_outputs.ipcr_code', '<', '126');
            })
            ->whereNotIn('individual_final_outputs.ipcr_code', $existingTargets)
            ->orderBy('individual_final_outputs.ipcr_code', 'ASC')
            ->get();

        // dd($dept_code);
        // dd($ipcrs->pluck('ipcr_code'));
        // dd($ipcrs->pluck('individual_output'));
        // ->orderBy('major_final_outputs.department_code', 'DESC')
        return inertia('IPCR/Targets/Create', [
            "id" => $id,
            "emp" => $emp,
            "ipcrs" => $ipcrs,
            "sem" => $sem,
            "additional" => '1'
        ]);
    }
    public function additional_store(Request $request, $id)
    {
        // dd($request);
        $attributes = $request->validate([
            'employee_code' => 'required',
            'ipcr_code' => 'required',
            'semester' => 'required',
            'ipcr_type' => 'required',
            'ipcr_semester_id' => 'required',
            'quantity_sem' => 'required|numeric',
            // 'remarks' => 'required',
            'year' => 'required|numeric',
            'month_1' => 'required',
            'month_2' => 'required',
            'month_3' => 'required',
            'month_4' => 'required',
            'month_5' => 'required',
            'month_6' => 'required'
        ]);
        // dd($attributes);
        $ipcr_targg = IPCRTargets::where('employee_code', $request->employee_code)
            ->where('ipcr_code', $request->ipcr_code)
            ->where('ipcr_semester_id', $request->ipcr_semester_id)
            ->get();
        $msg = '';
        $tp = '';
        // dd(count($ipcr_targg));
        if (count($ipcr_targg) < 1) {
            $my_targ = new IPCRTargets();
            $my_targ->employee_code = $request->employee_code;
            $my_targ->ipcr_code = $request->ipcr_code;
            $my_targ->semester = $request->semester;
            $my_targ->ipcr_type = $request->ipcr_type;
            $my_targ->is_additional_target = '1';
            $my_targ->ipcr_semester_id = $request->ipcr_semester_id;
            $my_targ->quantity_sem = $request->quantity_sem;
            $my_targ->remarks = $request->remarks;
            $my_targ->year = $request->year;
            $my_targ->month_1 = $request->month_1;
            $my_targ->month_2 = $request->month_2;
            $my_targ->month_3 = $request->month_3;
            $my_targ->month_4 = $request->month_4;
            $my_targ->month_5 = $request->month_5;
            $my_targ->month_6 = $request->month_6;
            $my_targ->save();
            // $this->ipcr_target->create($request->all());
            $tp = 'message';
            $msg = 'Employee Targets added!';
        } else {
            $tp = 'error';
            $msg = 'Unable to save!';
        }
        return redirect('/ipcrtargets/' . $id)
            ->with($tp, $msg);
    }
    // Route::post('/ipcrtargets/recall/{id_target}/additional/ipcr/targets/{ipcr_id}', [IPCRTargetsController::class, 'additional_recall']);

    public function additional_recall(Request $request, $id_target, $source)
    {
        // dd($id_target . ' ' . $ipcr_id);
        $typ = "info";
        $msg = "IPCR Semestral recall successful!";
        $target = IPCRTargets::findOrFail($id_target);
        if ($target) {
            $target->status = '-1';
            $target->save();
        } else {
            $typ = "error";
            $msg = "Recall unsuccessful. Contact PICTO to resolve this issue";
        }

        return back()
            ->with($typ, $msg);
    }
    // ,
    //     $idsemestral,
    //     $employee_name,
    //     $emp_status,
    //     $office,
    //     $division,
    //     $immediate,
    //     $next_higher,
    //     $sem,
    //     $year
    public function target_types(Request $request)
    {
        $date_now = Carbon::now();
        $dn = $date_now->format('m-d-Y');
        $arr = [
            [
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
    public function get_ipcr_targets(Request $request)
    {

        $data = IPCRTargets::select(
            'ipcr__semestrals.id AS sem_id',
            'i_p_c_r_targets.id AS id',
            'major_final_outputs.mfo_desc',
            'sub_mfos.submfo_description',
            'division_outputs.output',
            'i_p_c_r_targets.quantity_sem',
            'individual_final_outputs.ipcr_code',
            'individual_final_outputs.individual_output',
            'individual_final_outputs.performance_measure',
            'individual_final_outputs.quantity_type',
            'individual_final_outputs.success_indicator'
        )
            ->join('ipcr__semestrals', 'ipcr__semestrals.id', 'i_p_c_r_targets.ipcr_semester_id')
            ->join('individual_final_outputs', 'individual_final_outputs.ipcr_code', 'i_p_c_r_targets.ipcr_code')
            ->join('major_final_outputs', 'major_final_outputs.id', 'individual_final_outputs.idmfo')
            ->join('sub_mfos', 'sub_mfos.id', 'individual_final_outputs.idsubmfo')
            ->join('division_outputs', 'division_outputs.id', 'individual_final_outputs.id_div_output')
            ->where('ipcr__semestrals.id', $request->ipcr_sem_id)
            ->where('i_p_c_r_targets.ipcr_type', $request->type)
            ->orderBy('individual_final_outputs.ipcr_code', 'ASC')
            ->distinct('ipcr_code')
            ->get();
        return $data;
    }
    public function ipcrtargets_review(Request $request, $id, $source, $id_sem)
    {
        // dd("id: " . $id . " source: " . $source . " sem: " . $id_sem);
        IPCRTargets::find($id)->update(['status' => '0']);
        return back()->with('message', 'Successfully submitted additional target!');
        // return redirect()
    }
    public function ipcrtargets_update_status(Request $request, $id_target, $target_status)
    {
        // dd('id_target: ' . $id_target . ' target_status: ' . $target_status);
        $new_stat = '1';
        $msg = "";
        if ($target_status == "0") {
            $new_stat = '1';
            $msg = 'info';
            $act = 'reviewed';
        } elseif ($target_status == "1") {
            $new_stat = '2';
            $msg = 'message';
            $act = 'approved';
        } else {
            $new_stat = "-2";
            $msg = 'deleted';
            $act = 'returned';
        }
        IPCRTargets::find($id_target)->update(['status' => $new_stat]);
        return back()->with($msg, 'Successfully ' . $act . ' additional IPCR target!');
        // dd($new_stat);
    }
    public function destroy_additional_taget(Request $request, $id, $source, $id_sem)
    {
        // dd($id);
        $id = $request->id;
        $data = $this->ipcr_target->findOrFail($id);
        $ep = $data->employee_code;
        $user = UserEmployees::where('empl_id', $ep)->first();
        // dd($user->id);
        $data->delete();
        return redirect('/ipcrsemestral/' . $user->id . '/' . $source)
            ->with('deleted', 'Employee Target Deleted!');
    }
    // /ipcrtargetsreview/recall/my/target/" + id_target + '/' + this.source+ '/' + ipcr_id);
    public function recall(Request $request, $source, $id_sem)
    {
        // dd('recall target');
        $typ = "info";
        $msg = "IPCR Semestral recall successful!";
        $data = Ipcr_Semestral::findOrFail($id_sem);
        $ep = $data->employee_code;
        $user = UserEmployees::where('empl_id', $ep)->first();
        if ($data) {
            $data->status = '-1';
            $data->save();
            $rem = new ReturnRemarks();
            $rem->type = "Recall IPCR semestral target";
            $rem->ipcr_semestral_id = $id_sem;
            $rem->employee_code = auth()->user()->username;
            $rem->save();
        } else {
            $typ = "error";
            $msg = "Recall unsuccessful. Contact PICTO to resolve this issue";
        }

        return redirect('/ipcrsemestral/' . $user->id . '/' . $source)
            ->with($typ, $msg);
    }
    public function updateTargetColumns()
    {
        // $ipcr_targets = Ipcr_Semestral::with(['userEmployee', 'userEmployee.Office', 'userEmployee.employeeSpecialDepartment'])
        //     ->paginate(10);
        // dd('4444');
        $ipcr_targets =
            Ipcr_Semestral::with([
                'userEmployee', 'userEmployee.Office',
                'userEmployee.Office.pgHead',
                'userEmployee.employeeSpecialDepartment',
                'userEmployee.employeeSpecialDepartment.Office',
                'userEmployee.employeeSpecialDepartment.PGDH',
                'immediate.Division',
                'next_higher1.Division'
            ])
            // ->whereHas('userEmployees.employeeSpecialDepartment')
            // ->where('department_code', NULL)
            ->chunk(1000, function ($ipcrTargets) {
                foreach ($ipcrTargets as $target) {
                    // pg_dept_head
                    // division_name
                    // department
                    // department_code
                    // division

                    // Declare variables
                    $dept_name = NULL;
                    $dept_code = NULL;
                    $div_code = NULL;
                    $div_name = NULL;
                    $emp_type = NULL;


                    $pgdh = NULL;
                    $pgdh_post = NULL;
                    $pgdh_suff = NULL;
                    $mid = NULL;

                    //Check if the target corresponds to an actual employee record

                    if ($target->userEmployee) {
                        // dd($target->userEmployee);
                        //EMPLOYMENT TYPE
                        $emp_type = $target->userEmployee->employment_type_descr;
                        // dd($target->userEmployee);
                        //Office
                        if ($target->userEmployee->Office) {
                            $dept_name = $target->userEmployee->Office->office;
                            $dept_code = $target->userEmployee->Office->department_code;

                            //PGDH
                            if ($target->userEmployee->Office) {
                                if ($target->userEmployee->Office->pgHead) {
                                    //MIDDLE INITIAL
                                    if ($target->userEmployee->Office->pgHead->middle_name) {
                                        $mid = $target->userEmployee->Office->pgHead->middle_name[0] . '.';
                                    }
                                    //SUFFIX
                                    if ($target->userEmployee->Office->pgHead->suffix_name) {
                                        $pgdh_suff = ', ' . $target->userEmployee->Office->pgHead->suffix_name;
                                    }
                                    //POSTFIX
                                    if ($target->userEmployee->Office->pgHead->postfix_name) {
                                        $pgdh_post = ', ' . $target->userEmployee->Office->pgHead->postfix_name;
                                    }
                                    $pgdh = $target->userEmployee->Office->pgHead->first_name . ' ' . $mid . ' ' .
                                        $target->userEmployee->Office->pgHead->last_name . $pgdh_suff . $pgdh_post;
                                }
                            }
                        }

                        //Division
                        if ($target->userEmployee->Division) {
                            $div_code = $target->userEmployee->Division->division_code;
                            $div_name = $target->userEmployee->Division->division_name1;
                        }
                        //EMPLOYEE SPECIAL DEPARTMENTS
                        if ($target->userEmployee->employeeSpecialDepartment) {
                            //DEPARTMENT
                            if ($target->userEmployee->employeeSpecialDepartment->Office) {
                                $dept_code = $target->userEmployee->employeeSpecialDepartment->Office->department_code;
                                $dept_name = $target->userEmployee->employeeSpecialDepartment->Office->office;
                            }
                            //PG DEPARTMENTHEAD
                            if ($target->userEmployee->employeeSpecialDepartment->PGDH) {
                                // dd('naay pgdh');

                                // dd($target->userEmployee->employeeSpecialDepartment->PGDH);
                                //MIDDLE INITIAL
                                if ($target->userEmployee->employeeSpecialDepartment->PGDH->middle_name) {

                                    $mid = $target->userEmployee->employeeSpecialDepartment->PGDH->middle_name[0] . '.';
                                }
                                //SUFFIX
                                if ($target->userEmployee->employeeSpecialDepartment->PGDH->suffix_name) {
                                    $pgdh_suff = ', ' . $target->userEmployee->employeeSpecialDepartment->PGDH->suffix_name;
                                }
                                //POSTFIX
                                if ($target->userEmployee->employeeSpecialDepartment->PGDH->postfix_name) {
                                    $pgdh_post = ', ' . $target->userEmployee->employeeSpecialDepartment->PGDH->postfix_name;
                                }
                                $pgdh = $target->userEmployee->employeeSpecialDepartment->PGDH->first_name . ' ' . $mid . ' ' .
                                    $target->userEmployee->employeeSpecialDepartment->PGDH->last_name .  $pgdh_suff .  $pgdh_post;
                            }
                        }
                    }

                    // if (!$dept_code || $dept_code == "") {
                    //     dd($target);
                    // }

                    // dd($target);
                    if (!$div_name) {
                        if ($target->immediate) {
                            if ($target->immediate->Division) {
                                $div_name = $target->immediate->Division->division_name1;
                            } else {
                                if ($target->next_higher1) {
                                    if ($target->next_higher1->Division) {
                                        $div_name = $target->next_higher1->Division->division_name1;
                                    }
                                }
                            }
                        }
                    }

                    $target->update([
                        'department' => $dept_name,
                        'department_code' => $dept_code,
                        'division' => $div_code,
                        'division_name' => $div_name,
                        'pg_dept_head' => $pgdh,
                        'employment_type' => $emp_type
                        // Add other columns to be updated here
                    ]);
                }
            });
        // dd($ipcr_targets);
    }
    public function countNullTargets()
    {
        $ipcr_targets = Ipcr_Semestral::with(['userEmployees', 'userEmployees.Office'])
            ->where('department_code', NULL)
            ->count();
        dd($ipcr_targets);
    }
}
