<?php

namespace App\Http\Controllers;

use App\Models\Division;
use App\Models\DivisionOutput;
use App\Models\EmployeeSpecialDepartment;
use App\Models\IndividualFinalOutput;
use App\Models\Ipcr_Semestral;
use App\Models\IpcrProbTempoTarget;
use App\Models\IpcrScore;
use App\Models\IPCRTargets;
use App\Models\ReturnRemarks;
use App\Models\UserEmployeeCredential;
use App\Models\UserEmployees;
use App\Models\IpcrTarget;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class IpcrTargetController extends Controller
{
    protected $model;
    public function __construct(IpcrTarget $model)
    {
        $this->model = $model;
    }
    public function index(Request $request, $slug)
    {
        $sem = Ipcr_Semestral::where('slug', $slug)
            ->first();
        // dd($sem);
        $id = $sem->id;
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


        $data = IpcrTarget::select(
            'individual_final_outputs.id AS individual_final_output_id',
            'ipcr_targets.id',
            'ipcr_targets.ipcr_type',
            'ipcr_targets.remarks',
            'individual_final_outputs.individual_output',
            'individual_final_outputs.performance_measure',
            'ipcr_targets.is_additional_target',
            'divisions.division_name1 AS division',
            'division_outputs.output AS div_output',
            'major_final_outputs.mfo_desc',
            'major_final_outputs.FFUNCCOD',
            'ipcr_targets.slug',
            // 'sub_mfos.submfo_description',
            'major_final_outputs.department_code',
            'ipcr_targets.ipcr_semestral_id',
        )
            ->leftjoin('individual_final_outputs', 'individual_final_outputs.id', 'ipcr_targets.individual_final_output_id')
            ->leftjoin('division_outputs', 'division_outputs.id', 'individual_final_outputs.idDPCR')
            ->leftjoin('divisions', 'divisions.id', 'division_outputs.division_id')
            ->leftjoin('major_final_outputs', 'major_final_outputs.id', 'division_outputs.idmfo')
            // ->leftjoin('sub_mfos', 'sub_mfos.id', 'individual_final_outputs.idsubmfo')
            ->when($request->search, function ($query, $searchValue) {
                // dd($searchValue);
                return $query->where(function ($query) use ($searchValue) {
                    $query->where('individual_final_outputs.individual_output', 'LIKE', '%' . $searchValue . '%')
                        ->orWhere('individual_final_outputs.performance_measure', 'LIKE', '%' . $searchValue . '%')
                        ->orWhere('individual_final_outputs.ipcr_code', 'LIKE', '%' . $searchValue . '%');
                });
            })
            ->where('ipcr_targets.employee_code', $emp_code)
            ->where('ipcr_targets.ipcr_semestral_id', $id)
            ->orderBy('ipcr_type')
            ->orderBy('individual_final_outputs.id')
            ->get();
        // $data = Individual
        // $data
        // dd($data);
        // dd($id);
        // $data = IPCRTargets::where('i_p_c_r_targets.ipcr_semester_id', $id)
        //     ->get();
        // dd($data->pluck('ipcr_code'));
        return inertia('Targets/Index', [
            "slug" => $slug,
            "sem" => $sem,
            "id" => $id,
            "data" => $data,
            "division" => $division,
            "emp" => $emp
        ]);
    }
    public function create(Request $request, $slug)
    {
        // dd("create");
        // dd($slug);
        $sem = Ipcr_Semestral::where('slug', $slug)
            ->first();
        // dd($sem);
        if (!$sem) {
            return redirect('/forbidden')->with('error', 'You are not allowed to edit this IPCR');
        }
        $id = $sem->id;
        $emp_code = $sem->employee_code;
        $emp = UserEmployees::where('empl_id', $emp_code)
            ->first();
        // dd($emp);
        $dept_code = $emp->department_code;
        $desig_dept = $emp->designate_department_code;
        // dd($emp);
        $existingTargets = IpcrTarget::where('ipcr_semestral_id', $id)
            ->pluck('individual_final_output_id')
            ->toArray();
        $special_dept = EmployeeSpecialDepartment::where('employee_code', Auth::user()->username)->first();
        $dpcrs = DivisionOutput::select(
            'division_outputs.id',
            'division_outputs.output',
        )
            ->join('divisions', 'divisions.id', 'division_outputs.division_id')
            ->where('divisions.department_code', $emp->dept_code)
            ->get();
        $ipcrs = IndividualFinalOutput::select(
            'individual_final_outputs.id AS individual_final_output_id',
            'individual_final_outputs.id',
            'individual_final_outputs.individual_output',
            'individual_final_outputs.performance_measure',
            'divisions.division_name1 AS division',
            'division_outputs.output AS div_output',
            'major_final_outputs.mfo_desc',
            'major_final_outputs.FFUNCCOD',
            'individual_final_outputs.prescribed_period',
            'major_final_outputs.department_code'
        )
            ->leftjoin('division_outputs', 'division_outputs.id', 'individual_final_outputs.idDPCR')
            ->leftjoin('divisions', 'divisions.id', 'division_outputs.division_id')
            ->leftjoin('major_final_outputs', 'major_final_outputs.id', 'division_outputs.idmfo')
            ->whereNested(function ($query) use ($dept_code, $desig_dept) {
                $query->where('individual_final_outputs.department_code', '=', $dept_code)
                    // ->orWhere('major_final_outputs.department_code', '=', '')
                    // ->orWhere('major_final_outputs.department_code', '=', $desig_dept)
                    // ->orWhere('major_final_outputs.department_code', '=', '0')
                    // ->orWhere('major_final_outputs.department_code', '=', '-')
                    ->orWhere('individual_final_outputs.type', '<', 'Common')
                    ->when($dept_code >= 20 && $dept_code <= 24, function ($query) {
                        $query->orWhere('individual_final_outputs.department_code', '=', '20');
                    });
            })
            ->whereNotIn('individual_final_outputs.id', $existingTargets)
            ->orderBy('individual_final_outputs.id', 'ASC')
            ->get();

        if ($special_dept) {

            $sp = IndividualFinalOutput::select(
                'individual_final_outputs.id AS individual_final_output_id',
                'individual_final_outputs.id',
                'individual_final_outputs.individual_output',
                'individual_final_outputs.performance_measure',
                'divisions.division_name1 AS division',
                'division_outputs.output AS div_output',
                'major_final_outputs.mfo_desc',
                'major_final_outputs.FFUNCCOD',
                'individual_final_outputs.prescribed_period',
                // 'sub_mfos.submfo_description',
                'major_final_outputs.department_code'
            )
                //
                ->leftjoin('division_outputs', 'division_outputs.id', 'individual_final_outputs.idDPCR')
                ->leftjoin('divisions', 'divisions.id', 'division_outputs.division_id')
                ->leftjoin('major_final_outputs', 'major_final_outputs.id', 'division_outputs.idmfo')
                // ->leftjoin('sub_mfos', 'sub_mfos.id', 'individual_final_outputs.idsubmfo')
                ->orderBy('individual_final_outputs.id', 'ASC')
                ->get();
            $sp_dpcrs = DivisionOutput::select(
                'division_outputs.id',
                'division_outputs.output',
            )
                ->get();
            $dpcrs = $dpcrs->concat($sp_dpcrs);
            $ipcrs = $ipcrs->concat($sp);
        }

        return inertia('Targets/Create', [
            "id" => $id,
            "filters" => $request->only(['search']),
            "emp" => $emp,
            "ipcrs" => $ipcrs,
            "dpcrs" => $dpcrs,
            "sem" => $sem,
            "slug" => $slug
        ]);
    }
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'ipcr_semestral_id' => 'required',
            'employee_code' => 'required',
            'individual_final_output_id' => 'required',
            'ipcr_type' => 'required',
            // 'remarks' => 'required',
        ]);

        $random = Str::random(7 * 2);
        $append = substr(preg_replace('/[^a-z1-3]/', '', $random), 0, 7);
        $slugBase = Str::slug($request->ifo_desc . '-' . $append . '-' . $request->sem . '-' . $request->year);
        $slug = $slugBase;
        while (DB::table('ipcr_targets')->where('slug', $slug)->exists()) {
            $random = Str::random(10 * 2);
            $append = substr(preg_replace('/[^a-z1-3]/', '', $random), 0, 10);
            // if ($count > 1) {
            $slug = $slugBase . '-' . $append;
            // }
            // $count++;
        }
        // dd('opopop');
        $slug = $slugBase;
        $data = new IpcrTarget();
        $data->ipcr_semestral_id = $request->ipcr_semestral_id;
        $data->individual_final_output_id = $request->individual_final_output_id;
        $data->ipcr_type = $request->ipcr_type;
        $data->employee_code = $request->employee_code;
        $data->is_additional_target = $request->is_additional_target;
        $data->semester = $request->semester;
        $data->year = $request->year;
        $data->status = $request->status;
        $data->remarks = $request->remarks;
        $data->slug = $slug;
        $data->save();
        // dd($data);
        // $data->store();
        // $data['created_by'] = Auth::user()->username;
        // $data['updated_by'] = Auth::user()->username;
        // $this->model->create($data);
        if (intval($request->is_additional_target) > 0) {
            return redirect('/ipcrsemestral/' . auth()->user()->id . '/direct')
                ->with('success', 'IPCR Target created successfully');
        }
        return redirect('/ipcrtargets/r/' . $request->slug_sem)
            ->with('success', 'IPCR Target created successfully');
    }

    public function edit(Request $request, $slug, $slug_sem)
    {
        // dd("slug: " . $slug . " slug_sem:" . $slug_sem);
        $data = IpcrTarget::where('slug', $slug)
            ->first();
        $sem = Ipcr_Semestral::where('slug', $slug_sem)
            ->first();
        // dd($sem);
        // dd($data);
        if (!$sem || !$data) {
            return redirect('/forbidden')->with('error', 'You are not allowed to edit this IPCR');
        }
        $id = $sem->id;
        $emp_code = $sem->employee_code;
        $emp = UserEmployees::where('empl_id', $emp_code)
            ->first();
        // dd($emp);
        $dept_code = $emp->department_code;
        $desig_dept = $emp->designate_department_code;
        // dd($emp);
        $existingTargets = IpcrTarget::where('ipcr_semestral_id', $id)
            ->where('individual_final_output_id', '<>', $data->individual_final_output_id)
            ->pluck('individual_final_output_id')
            ->toArray();
        // dd($data->individual_final_output_id);
        $special_dept = EmployeeSpecialDepartment::where('employee_code', Auth::user()->username)->first();
        $dpcrs = DivisionOutput::select(
            'division_outputs.id',
            'division_outputs.output',
        )
            ->join('divisions', 'divisions.id', 'division_outputs.division_id')
            ->where('divisions.department_code', $emp->dept_code)
            ->get();
        $ipcrs = IndividualFinalOutput::select(
            'individual_final_outputs.id AS individual_final_output_id',
            'individual_final_outputs.id',
            'individual_final_outputs.individual_output',
            'individual_final_outputs.performance_measure',
            'divisions.division_name1 AS division',
            'division_outputs.output AS div_output',
            'major_final_outputs.mfo_desc',
            'major_final_outputs.FFUNCCOD',
            'individual_final_outputs.prescribed_period',
            'major_final_outputs.department_code'
        )
            ->leftjoin('division_outputs', 'division_outputs.id', 'individual_final_outputs.idDPCR')
            ->leftjoin('divisions', 'divisions.id', 'division_outputs.division_id')
            ->leftjoin('major_final_outputs', 'major_final_outputs.id', 'division_outputs.idmfo')
            ->whereNested(function ($query) use ($dept_code, $desig_dept) {
                $query->where('individual_final_outputs.department_code', '=', $dept_code)
                    // ->orWhere('major_final_outputs.department_code', '=', '')
                    // ->orWhere('major_final_outputs.department_code', '=', $desig_dept)
                    // ->orWhere('major_final_outputs.department_code', '=', '0')
                    // ->orWhere('major_final_outputs.department_code', '=', '-')
                    ->orWhere('individual_final_outputs.type', '<', 'Common')
                    ->when($dept_code >= 20 && $dept_code <= 24, function ($query) {
                        $query->orWhere('individual_final_outputs.department_code', '=', '20');
                    });
            })
            ->whereNotIn('individual_final_outputs.id', $existingTargets)
            ->orderBy('individual_final_outputs.id', 'ASC')
            ->get();

        if ($special_dept) {

            $sp = IndividualFinalOutput::select(
                'individual_final_outputs.id AS individual_final_output_id',
                'individual_final_outputs.id',
                'individual_final_outputs.individual_output',
                'individual_final_outputs.performance_measure',
                'divisions.division_name1 AS division',
                'division_outputs.output AS div_output',
                'major_final_outputs.mfo_desc',
                'major_final_outputs.FFUNCCOD',
                'individual_final_outputs.prescribed_period',
                // 'sub_mfos.submfo_description',
                'major_final_outputs.department_code'
            )
                //
                ->leftjoin('division_outputs', 'division_outputs.id', 'individual_final_outputs.idDPCR')
                ->leftjoin('divisions', 'divisions.id', 'division_outputs.division_id')
                ->leftjoin('major_final_outputs', 'major_final_outputs.id', 'division_outputs.idmfo')
                // ->leftjoin('sub_mfos', 'sub_mfos.id', 'individual_final_outputs.idsubmfo')
                ->orderBy('individual_final_outputs.id', 'ASC')
                ->get();
            $sp_dpcrs = DivisionOutput::select(
                'division_outputs.id',
                'division_outputs.output',
            )
                ->get();
            $dpcrs = $dpcrs->concat($sp_dpcrs);
            $ipcrs = $ipcrs->concat($sp);
        }
        // dd($ipcrs);
        return inertia('Targets/Create', [
            "id" => $id,
            "filters" => $request->only(['search']),
            "emp" => $emp,
            "ipcrs" => $ipcrs,
            "dpcrs" => $dpcrs,
            "sem" => $sem,
            "slug" => $slug_sem,
            "editData" => $data
        ]);
    }
    public function update(Request $request, $id)
    {
        // dd("update");
        // dd($request->id);
        $request->validate([
            'ipcr_semestral_id' => 'required',
            'employee_code' => 'required',
            'individual_final_output_id' => 'required',
            'ipcr_type' => 'required',
            // 'remarks' => 'required',
        ]);
        $random = Str::random(7 * 2);
        $append = substr(preg_replace('/[^a-z1-3]/', '', $random), 0, 7);
        $slugBase = Str::slug($request->ifo_desc . '-' . $append . '-' . $request->sem . '-' . $request->year);
        $slug = $slugBase;
        while (DB::table('ipcr_targets')->where('slug', $slug)->where('id', '<>', $request->id)->exists()) {
            $random = Str::random(10 * 2);
            $append = substr(preg_replace('/[^a-z1-3]/', '', $random), 0, 10);
            // if ($count > 1) {
            $slug = $slugBase . '-' . $append;
            // }
            // $count++;
        }
        // dd('opopop');
        $slug = $slugBase;
        $data = IpcrTarget::where('id', $request->id)->first();
        $data->ipcr_semestral_id = $request->ipcr_semestral_id;
        $data->individual_final_output_id = $request->individual_final_output_id;
        $data->ipcr_type = $request->ipcr_type;
        $data->employee_code = $request->employee_code;
        $data->is_additional_target = $request->is_additional_target;
        $data->semester = $request->semester;
        $data->year = $request->year;
        $data->status = $request->status;
        $data->remarks = $request->remarks;
        $data->slug = $slug;
        $data->save();
        return redirect('/ipcrtargets/r/' . $request->slug_sem)
            ->with('info', 'IPCR Target updated successfully');
    }
    public function destroy($id, $slug)
    {
        //dd($id.' empid: '.$empl_id);
        $data = $this->model->findOrFail($id);
        $data->delete();
        return redirect('/ipcrtargets/r/' . $slug)
            ->with('deleted', 'Employee Target Deleted!');
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
            $msg = 'message';
            $act = 'returned';
        }
        $iptarg = IpcrTarget::find($id_target);
        $iptarg->status = $new_stat;

        // ->update(['status' => $new_stat]);
        // dd($iptarg);
        $this->generateReturnRemarksForAdditionalTargets($act, $iptarg->ipcr_semestral_id, $iptarg->employee_code);
        $iptarg->save();
        return back()->with($msg, 'Successfully ' . $act . ' additional IPCR target!');
        // dd($new_stat);
    }

    public function review_ipcr(Request $request)
    {
        //dd($request->empl_code);
        // dd($request->empl_id);
        $targets = IpcrTarget::select(
            'ipcr_targets.individual_final_output_id',
            // 'ipcr_targets.month_1',
            // 'ipcr_targets.month_2',
            // 'ipcr_targets.month_3',
            // 'ipcr_targets.month_4',
            // 'ipcr_targets.month_5',
            // 'ipcr_targets.month_6',
            // 'ipcr_targets.quantity_sem',
            'program_and_projects.paps_desc',
            'major_final_outputs.mfo_desc',
            'ipcr_targets.ipcr_type',
            'individual_final_outputs.individual_output',
            'individual_final_outputs.performance_measure'
        )
            ->where('employee_code', $request->empl_id)
            ->where('ipcr_semestral_id', $request->sem_id)
            ->distinct('ipcr_targets.individual_final_output_id')
            ->join('individual_final_outputs', 'individual_final_outputs.id', 'ipcr_targets.individual_final_output_id')
            ->join('division_outputs', 'division_outputs.id', 'individual_final_outputs.idDPCR')
            ->join('program_and_projects', 'program_and_projects.id', 'division_outputs.idpaps')
            ->join('major_final_outputs', 'major_final_outputs.id', 'program_and_projects.idmfo')
            ->distinct('ipcr_targets.individual_final_output_id')
            ->orderBy('individual_final_outputs.id', 'ASC')
            ->get();
        return $targets;
    }

    public function additional_create1(Request $request, $id)
    {
        $sem = Ipcr_Semestral::where('id', $id)
            ->first();
        $emp_code = $sem->employee_code;
        $emp = UserEmployees::where('empl_id', $emp_code)
            ->first();
        // dd($emp);
        $dept_code = $emp->department_code;
        // dd($dept_code);
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
        // dd($ipcrs[0]);
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
    public function destroy_additional_taget(Request $request, $id, $source, $id_sem)
    {
        // dd($id);
        $id = $request->id;
        $data = $this->model->findOrFail($id);
        $ep = $data->employee_code;
        $user = UserEmployees::where('empl_id', $ep)->first();
        // dd($user->id);
        $data->delete();
        return redirect('/ipcrsemestral/' . $user->id . '/' . $source)
            ->with('deleted', 'Employee Target Deleted!');
    }
    public function generateReturnRemarksForAdditionalTargets($action, $ipcr_semester_id, $employee_code)
    {
        $retrem = new ReturnRemarks;
        $retrem->type = $action . ' additional target (new)';
        $retrem->remarks = '';
        $retrem->ipcr_semestral_id = $ipcr_semester_id;
        // $retrem->ipcr_monthly_accomplishment_id
        $retrem->employee_code = $employee_code;
        $retrem->acted_by = auth()->user()->username;
        $retrem->save();
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
    public function ipcrtargets_review(Request $request, $id, $source, $id_sem)
    {
        // dd("id: " . $id . " source: " . $source . " sem: " . $id_sem);
        IpcrTarget::find($id)->update(['status' => '0']);
        // $tar = IpcrTarget::where('id', $id)
        //     ->first();
        // $tar->status = "0";
        // $tar->save();
        return back()->with('message', 'Successfully submitted additional target!');
        // return redirect()
    }
    public function additional_create(Request $request, $slug)
    {
        // dd("create");
        // dd($slug);
        $sem = Ipcr_Semestral::where('slug', $slug)
            ->first();
        // dd($sem);
        if (!$sem) {
            return redirect('/forbidden')->with('error', 'You are not allowed to edit this IPCR');
        }
        $id = $sem->id;
        $emp_code = $sem->employee_code;
        $emp = UserEmployees::where('empl_id', $emp_code)
            ->first();
        // dd($emp);
        $dept_code = $emp->department_code;
        $desig_dept = $emp->designate_department_code;
        // dd($emp);
        $existingTargets = IpcrTarget::where('ipcr_semestral_id', $id)
            ->pluck('individual_final_output_id')
            ->toArray();
        $special_dept = EmployeeSpecialDepartment::where('employee_code', Auth::user()->username)->first();
        $dpcrs = DivisionOutput::select(
            'division_outputs.id',
            'division_outputs.output',
        )
            ->join('divisions', 'divisions.id', 'division_outputs.division_id')
            ->where('divisions.department_code', $emp->dept_code)
            ->get();
        $ipcrs = IndividualFinalOutput::select(
            'individual_final_outputs.id AS individual_final_output_id',
            'individual_final_outputs.id',
            'individual_final_outputs.individual_output',
            'individual_final_outputs.performance_measure',
            'divisions.division_name1 AS division',
            'division_outputs.output AS div_output',
            'major_final_outputs.mfo_desc',
            'major_final_outputs.FFUNCCOD',
            'individual_final_outputs.prescribed_period',
            'major_final_outputs.department_code'
        )
            ->leftjoin('division_outputs', 'division_outputs.id', 'individual_final_outputs.idDPCR')
            ->leftjoin('divisions', 'divisions.id', 'division_outputs.division_id')
            ->leftjoin('major_final_outputs', 'major_final_outputs.id', 'division_outputs.idmfo')
            ->whereNested(function ($query) use ($dept_code, $desig_dept) {
                $query->where('individual_final_outputs.department_code', '=', $dept_code)
                    // ->orWhere('major_final_outputs.department_code', '=', '')
                    // ->orWhere('major_final_outputs.department_code', '=', $desig_dept)
                    // ->orWhere('major_final_outputs.department_code', '=', '0')
                    // ->orWhere('major_final_outputs.department_code', '=', '-')
                    ->orWhere('individual_final_outputs.type', '<', 'Common')
                    ->when($dept_code >= 20 && $dept_code <= 24, function ($query) {
                        $query->orWhere('individual_final_outputs.department_code', '=', '20');
                    });
            })
            ->whereNotIn('individual_final_outputs.id', $existingTargets)
            ->orderBy('individual_final_outputs.id', 'ASC')
            ->get();

        if ($special_dept) {

            $sp = IndividualFinalOutput::select(
                'individual_final_outputs.id AS individual_final_output_id',
                'individual_final_outputs.id',
                'individual_final_outputs.individual_output',
                'individual_final_outputs.performance_measure',
                'divisions.division_name1 AS division',
                'division_outputs.output AS div_output',
                'major_final_outputs.mfo_desc',
                'major_final_outputs.FFUNCCOD',
                'individual_final_outputs.prescribed_period',
                // 'sub_mfos.submfo_description',
                'major_final_outputs.department_code'
            )
                //
                ->leftjoin('division_outputs', 'division_outputs.id', 'individual_final_outputs.idDPCR')
                ->leftjoin('divisions', 'divisions.id', 'division_outputs.division_id')
                ->leftjoin('major_final_outputs', 'major_final_outputs.id', 'division_outputs.idmfo')
                // ->leftjoin('sub_mfos', 'sub_mfos.id', 'individual_final_outputs.idsubmfo')
                ->orderBy('individual_final_outputs.id', 'ASC')
                ->get();
            $sp_dpcrs = DivisionOutput::select(
                'division_outputs.id',
                'division_outputs.output',
            )
                ->get();
            $dpcrs = $dpcrs->concat($sp_dpcrs);
            $ipcrs = $ipcrs->concat($sp);
        }

        return inertia('Targets/Create', [
            "id" => $id,
            "filters" => $request->only(['search']),
            "emp" => $emp,
            "ipcrs" => $ipcrs,
            "dpcrs" => $dpcrs,
            "sem" => $sem,
            "slug" => $slug,
            "additional" => '1'
        ]);
    }
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

        $data = IpcrTarget::select(
            'ipcr__semestrals.id AS sem_id',
            'ipcr_targets.id AS id',
            'major_final_outputs.mfo_desc',
            'program_and_projects.paps_desc',
            'division_outputs.output',
            'individual_final_outputs.id AS idifo',
            'individual_final_outputs.individual_output',
            'individual_final_outputs.performance_measure',
            // 'ipcr_targets.quantity_sem',
            // 'individual_final_outputs.quantity_type',
            // 'individual_final_outputs.success_indicator'
        )
            ->leftjoin('ipcr__semestrals', 'ipcr__semestrals.id', 'ipcr_targets.ipcr_semestral_id')
            ->leftjoin('individual_final_outputs', 'individual_final_outputs.id', 'ipcr_targets.individual_final_output_id')
            ->leftjoin('division_outputs', 'individual_final_outputs.idDPCR', 'division_outputs.id')
            ->leftjoin('program_and_projects', 'program_and_projects.id', 'division_outputs.idpaps')
            ->leftjoin('major_final_outputs', 'major_final_outputs.id', 'program_and_projects.idmfo')
            ->where('ipcr_targets.ipcr_semestral_id', $request->ipcr_sem_id)
            ->where('ipcr_targets.ipcr_type', $request->type)
            ->orderBy('individual_final_outputs.id', 'ASC')
            ->distinct('individual_final_outputs.id')
            ->get();
        // dd($data->query());
        // dd($data->toSql(), $data->getBindings());

        return $data;
    }
}
