<?php

namespace App\Http\Controllers;

use App\Models\Division;
use App\Models\DivisionOutput;
use App\Models\DpcrTarget;
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
use App\Models\MonthlyTarget;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DpcrTargetController extends Controller
{
    protected $model;
    public function __construct(DpcrTarget $model)
    {
        $this->model = $model;
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
        $existingTargets = DpcrTarget::where('ipcr_semestral_id', $id)
            ->pluck('idDPCR')
            ->toArray();
        $special_dept = EmployeeSpecialDepartment::where('employee_code', Auth::user()->username)->first();
        // $dpcrs = DivisionOutput::select(
        //     'division_outputs.id',
        //     'division_outputs.output',
        // )
        //     ->join('divisions', 'divisions.id', 'division_outputs.division_id')
        //     ->where('divisions.department_code', $emp->dept_code)
        //     ->get();
        $dpcrs = DivisionOutput::select(
            // 'division_outputs.id AS individual_final_output_id',
            'division_outputs.id',
            // 'division_outputs.output',
            'division_outputs.performance_measure',
            'division_outputs.efficiency1',
            'division_outputs.timeliness',
            'divisions.division_name1 AS division',
            'division_outputs.output AS div_output',
            'major_final_outputs.mfo_desc',
            'major_final_outputs.FFUNCCOD',
            'division_outputs.prescribed_period',
            'major_final_outputs.department_code'
        )
            // ->leftjoin('division_outputs', 'division_outputs.id', 'division_outputs.idDPCR')
            ->leftjoin('divisions', 'divisions.id', 'division_outputs.division_id')
            ->leftjoin('program_and_projects', 'program_and_projects.id', 'division_outputs.idpaps')
            ->leftjoin('major_final_outputs', 'major_final_outputs.id', 'program_and_projects.idmfo')
            ->whereNested(function ($query) use ($dept_code, $desig_dept) {
                $query->where('major_final_outputs.department_code', '=', $dept_code)
                    // ->orWhere('major_final_outputs.department_code', '=', '')
                    // ->orWhere('major_final_outputs.department_code', '=', $desig_dept)
                    // ->orWhere('major_final_outputs.department_code', '=', '0')
                    // ->orWhere('major_final_outputs.department_code', '=', '-')
                    // ->orWhere('individual_final_outputs.type', '<', 'Common')
                    ->orWhereIn('division_outputs.idpaps', [1357, 1358])
                    ->when($dept_code >= 20 && $dept_code <= 24, function ($query) {
                        $query->orWhere('division_outputs.department_code', '=', '20');
                    });
            })
            ->whereNotIn('division_outputs.id', $existingTargets)
            ->orderBy('division_outputs.id', 'ASC')
            ->get();
        // dd($dpcrs);
        if ($special_dept) {

            $sp =
                DivisionOutput::select(
                    // 'division_outputs.id AS individual_final_output_id',
                    'division_outputs.id',
                    // 'division_outputs.output',
                    'division_outputs.performance_measure',
                    'division_outputs.efficiency1',
                    'division_outputs.timeliness',
                    'divisions.division_name1 AS division',
                    'division_outputs.output AS div_output',
                    'major_final_outputs.mfo_desc',
                    'major_final_outputs.FFUNCCOD',
                    'division_outputs.prescribed_period',
                    'major_final_outputs.department_code'
                )
                // ->leftjoin('division_outputs', 'division_outputs.id', 'division_outputs.idDPCR')
                ->leftjoin('divisions', 'divisions.id', 'division_outputs.division_id')
                ->leftjoin('program_and_projects', 'program_and_projects.id', 'division_outputs.idpaps')
                ->leftjoin('major_final_outputs', 'major_final_outputs.id', 'program_and_projects.idmfo')
                ->whereNested(function ($query) use ($dept_code, $desig_dept) {
                    $query->where('major_final_outputs.department_code', '=', $dept_code)
                        // ->orWhere('major_final_outputs.department_code', '=', '')
                        // ->orWhere('major_final_outputs.department_code', '=', $desig_dept)
                        // ->orWhere('major_final_outputs.department_code', '=', '0')
                        // ->orWhere('major_final_outputs.department_code', '=', '-')
                        // ->orWhere('individual_final_outputs.type', '<', 'Common')
                        ->when($dept_code >= 20 && $dept_code <= 24, function ($query) {
                            $query->orWhere('division_outputs.department_code', '=', '20');
                        });
                })
                ->whereNotIn('division_outputs.id', $existingTargets)
                ->orderBy('division_outputs.id', 'ASC')
                ->get();
            // $sp_dpcrs = DivisionOutput::select(
            //     'division_outputs.id',
            //     'division_outputs.output',
            // )
            //     ->get();
            $dpcrs = $dpcrs->concat($sp);
            // $ipcrs = $ipcrs->concat($sp);
        }

        return inertia('Targets/DPCR/Create', [
            "id" => $id,
            "filters" => $request->only(['search']),
            "emp" => $emp,
            // "ipcrs" => $ipcrs,
            "dpcrs" => $dpcrs,
            "sem" => $sem,
            "slug" => $slug
        ]);
    }
    public function store(Request $request)
    {
        // dd($request->all());
        //VALIDATE DPCR
        $request->validate([
            'ipcr_semestral_id' => 'required',
            'employee_code' => 'required',
            'idDPCR' => 'required',
            'dpcr_type' => 'required',
            // 'remarks' => 'required',
        ]);


        // dd('opopop');
        $slug = $this->generateSlugDPCR($request->ifo_desc, $request->semester, $request->year);
        $data = new DpcrTarget();
        $data->ipcr_semestral_id = $request->ipcr_semestral_id;
        $data->idDPCR = $request->idDPCR;
        $data->dpcr_type = $request->dpcr_type;
        $data->employee_code = $request->employee_code;
        $data->is_additional_target = $request->is_additional_target;
        $data->semester = $request->semester;
        $data->year = $request->year;
        $data->status = $request->status;
        $data->remarks = $request->remarks;
        $data->slug = $slug;
        $data->identifier = $request->identifier;
        $data->save();
        // dd($data);
        // $data->store();
        // $data['created_by'] = Auth::user()->username;
        // $data['updated_by'] = Auth::user()->username;
        // $this->model->create($data);
        $this->generateMonthlyTargetRatings($request->semester, $request->year, $request->ipcr_semestral_id, $data->id);
        if (intval($request->is_additional_target) > 0) {
            return redirect('/ipcrsemestral/r/' . auth()->user()->id . '/direct')
                ->with('success', 'DPCR Additional Target created successfully');
        }
        return redirect('/ipcrtargets/r/' . $request->slug_sem)
            ->with('success', 'DPCR Target created successfully');
    }

    public function generateSlugDPCR($ifo_desc, $sem, $year)
    {
        //GENERATE SLUG
        $random = Str::random(7 * 2);
        $append = substr(preg_replace('/[^a-z1-3]/', '', $random), 0, 7);
        $slugBase = Str::slug($ifo_desc . '-' . $append . '-' . $sem . '-' . $year);
        $slug = $slugBase;
        while (DB::table('dpcr_targets')->where('slug', $slug)->exists()) {
            $random = Str::random(10 * 2);
            $append = substr(preg_replace('/[^a-z1-3]/', '', $random), 0, 10);
            // if ($count > 1) {
            $slug = $slugBase . '-' . $append;
            // }
            // $count++;
        }
        return $slug;
    }
    public function generateMonthlyTargetRatings($sem, $year, $sem_id, $id)
    {
        // dd($idDPCR);
        // $months = ($sem == 1) ? ['1', '2', '3', '4', '5', '6'] : ['7', '8', '9', '10', '11', '12'];
        //used as index
        $months = ['1', '2', '3', '4', '5', '6'];
        foreach ($months as $month) {
            $month_param = ($sem == 1) ? $month : $month + 6;
            $slug = $this->slugMonthly($month_param, $year);

            $existingRecord = MonthlyTarget::where('month', $month)
                ->where('dpcr_target_id', $id)
                ->first();

            if (!$existingRecord) {
                MonthlyTarget::create([
                    'month' => $month,
                    'year' => $year,
                    'sem_id' => $sem_id,
                    'status' => '-1',
                    'dpcr_target_id' => $id,
                    'slug' => $slug, // Save the unique slug
                    'type' => 'dpcr',
                ]);
            }
        }
    }
    public function slugMonthly($month, $year)
    {
        // Convert month number to month name
        $monthName = date('F', mktime(0, 0, 0, $month, 1));

        // Base slug
        $baseSlug = Str::slug($monthName . '-' . $year);
        $random = Str::random(7 * 2);
        $append = substr(preg_replace('/[^a-z1-3]/', '', $random), 0, 7);
        $slug = $baseSlug . '-' . $append;
        // $counter = 1;
        // dd($slug);
        // Ensure slug is unique
        while (MonthlyTarget::where('slug', $slug)->exists()) {
            $random = Str::random(10 * 2);
            $append = substr(preg_replace('/[^a-z1-3]/', '', $random), 0, 10);
            // if ($count > 1) {
            $slug = $baseSlug . '-' . $append;
        }
        return $slug;
    }
    public function edit(Request $request, $slug, $slug_sem)
    {
        // dd("create");
        // dd($slug);
        $data = DpcrTarget::where('slug', $slug)
            ->first();
        $sem = Ipcr_Semestral::where('slug', $slug_sem)
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
        $existingTargets = DpcrTarget::where('ipcr_semestral_id', $id)
            ->where('idDPCR', '<>', $data->idDPCR)
            ->pluck('idDPCR')
            ->toArray();
        $special_dept = EmployeeSpecialDepartment::where('employee_code', Auth::user()->username)->first();
        // $dpcrs = DivisionOutput::select(
        //     'division_outputs.id',
        //     'division_outputs.output',
        // )
        //     ->join('divisions', 'divisions.id', 'division_outputs.division_id')
        //     ->where('divisions.department_code', $emp->dept_code)
        //     ->get();
        $dpcrs = DivisionOutput::select(
            // 'division_outputs.id AS individual_final_output_id',
            'division_outputs.id',
            // 'division_outputs.output',
            'division_outputs.performance_measure',
            'division_outputs.efficiency1',
            'division_outputs.timeliness',
            'divisions.division_name1 AS division',
            'division_outputs.output AS div_output',
            'major_final_outputs.mfo_desc',
            'major_final_outputs.FFUNCCOD',
            'division_outputs.prescribed_period',
            'major_final_outputs.department_code'
        )
            // ->leftjoin('division_outputs', 'division_outputs.id', 'division_outputs.idDPCR')
            ->leftjoin('divisions', 'divisions.id', 'division_outputs.division_id')
            ->leftjoin('program_and_projects', 'program_and_projects.id', 'division_outputs.idpaps')
            ->leftjoin('major_final_outputs', 'major_final_outputs.id', 'program_and_projects.idmfo')
            ->whereNested(function ($query) use ($dept_code, $desig_dept) {
                $query->where('major_final_outputs.department_code', '=', $dept_code)
                    // ->orWhere('major_final_outputs.department_code', '=', '')
                    // ->orWhere('major_final_outputs.department_code', '=', $desig_dept)
                    // ->orWhere('major_final_outputs.department_code', '=', '0')
                    // ->orWhere('major_final_outputs.department_code', '=', '-')
                    // ->orWhere('individual_final_outputs.type', '<', 'Common')
                    ->when($dept_code >= 20 && $dept_code <= 24, function ($query) {
                        $query->orWhere('division_outputs.department_code', '=', '20');
                    });
            })
            ->whereNotIn('division_outputs.id', $existingTargets)
            ->orderBy('division_outputs.id', 'ASC')
            ->get();
        // dd($dpcrs);
        if ($special_dept) {

            $sp =
                DivisionOutput::select(
                    // 'division_outputs.id AS individual_final_output_id',
                    'division_outputs.id',
                    // 'division_outputs.output',
                    'division_outputs.performance_measure',
                    'division_outputs.efficiency1',
                    'division_outputs.timeliness',
                    'divisions.division_name1 AS division',
                    'division_outputs.output AS div_output',
                    'major_final_outputs.mfo_desc',
                    'major_final_outputs.FFUNCCOD',
                    'division_outputs.prescribed_period',
                    'major_final_outputs.department_code'
                )
                // ->leftjoin('division_outputs', 'division_outputs.id', 'division_outputs.idDPCR')
                ->leftjoin('divisions', 'divisions.id', 'division_outputs.division_id')
                ->leftjoin('program_and_projects', 'program_and_projects.id', 'division_outputs.idpaps')
                ->leftjoin('major_final_outputs', 'major_final_outputs.id', 'program_and_projects.idmfo')
                ->whereNested(function ($query) use ($dept_code, $desig_dept) {
                    $query->where('major_final_outputs.department_code', '=', $dept_code)
                        // ->orWhere('major_final_outputs.department_code', '=', '')
                        // ->orWhere('major_final_outputs.department_code', '=', $desig_dept)
                        // ->orWhere('major_final_outputs.department_code', '=', '0')
                        // ->orWhere('major_final_outputs.department_code', '=', '-')
                        // ->orWhere('individual_final_outputs.type', '<', 'Common')
                        ->when($dept_code >= 20 && $dept_code <= 24, function ($query) {
                            $query->orWhere('division_outputs.department_code', '=', '20');
                        });
                })
                ->whereNotIn('division_outputs.id', $existingTargets)
                ->orderBy('division_outputs.id', 'ASC')
                ->get();
            // $sp_dpcrs = DivisionOutput::select(
            //     'division_outputs.id',
            //     'division_outputs.output',
            // )
            //     ->get();
            $dpcrs = $dpcrs->concat($sp);
            // $ipcrs = $ipcrs->concat($sp);
        }

        return inertia('Targets/DPCR/Create', [
            "id" => $id,
            "filters" => $request->only(['search']),
            "emp" => $emp,
            // "ipcrs" => $ipcrs,
            "dpcrs" => $dpcrs,
            "sem" => $sem,
            "slug" => $slug_sem,
            "editData" => $data
        ]);
    }
    public function update(Request $request)
    {
        // dd($request->all());
        //VALIDATE DPCR
        $request->validate([
            'ipcr_semestral_id' => 'required',
            'employee_code' => 'required',
            'idDPCR' => 'required',
            'dpcr_type' => 'required',
            // 'remarks' => 'required',
        ]);

        //GENERATE SLUG
        $random = Str::random(7 * 2);
        $append = substr(preg_replace('/[^a-z1-3]/', '', $random), 0, 7);
        $slugBase = Str::slug($request->ifo_desc . '-' . $append . '-' . $request->sem . '-' . $request->year);
        $slug = $slugBase;
        while (DB::table('dpcr_targets')->where('slug', $slug)->exists()) {
            $random = Str::random(10 * 2);
            $append = substr(preg_replace('/[^a-z1-3]/', '', $random), 0, 10);
            // if ($count > 1) {
            $slug = $slugBase . '-' . $append;
            // }
            // $count++;
        }
        // dd('opopop');
        $slug = $slugBase;
        $data = DpcrTarget::where('id', $request->id)
            ->first();
        $data->ipcr_semestral_id = $request->ipcr_semestral_id;
        $data->idDPCR = $request->idDPCR;
        $data->dpcr_type = $request->dpcr_type;
        $data->employee_code = $request->employee_code;
        $data->is_additional_target = $request->is_additional_target;
        $data->semester = $request->semester;
        $data->year = $request->year;
        $data->status = $request->status;
        $data->remarks = $request->remarks;
        $data->slug = $slug;
        $data->identifier = $request->identifier;
        $data->save();
        // dd($data);
        // $data->store();
        // $data['created_by'] = Auth::user()->username;
        // $data['updated_by'] = Auth::user()->username;
        // $this->model->create($data);
        if (intval($request->is_additional_target) > 0) {
            return redirect('/ipcrsemestral/r/' . auth()->user()->id . '/direct')
                ->with('success', 'DPCR Additional Target created successfully');
        }
        return redirect('/ipcrtargets/r/' . $request->slug_sem)
            ->with('success', 'DPCR Target created successfully');
    }
    public function updateMonthlyTargetRatings($sem, $sem_prev, $year, $year_prev, $sem_id, $idDPCR)
    {

        $months = ($sem == 1) ? ['1', '2', '3', '4', '5', '6'] : ['7', '8', '9', '10', '11', '12'];
        $monthlyTargets = MonthlyTarget::where('sem_id', $sem_id)->get();
        foreach ($monthlyTargets as $monthlyTarget) {
            $monthlyTarget->delete();
        }
        // foreach ($months as $month) {
        //     if()
        //     $slug = $this->slugMonthly($month, $year);

        //     $existingRecord = MonthlyTarget::where('sem_id', $sem_id)
        //         ->where('month', $month)
        //         ->where('idDPCR', $idDPCR)
        //         ->first();

        //     if (!$existingRecord) {
        //         MonthlyTarget::create([
        //             'month' => $month,
        //             'year' => $year,
        //             'sem_id' => $sem_id,
        //             'status' => '-1',
        //             'idDpcr' => $idDPCR,
        //             'slug' => $slug // Save the unique slug
        //         ]);
        //     }
        // }
    }
    public function destroy($id, $slug)
    {
        //dd($id.' empid: '.$empl_id);
        $data = $this->model->findOrFail($id);
        if ($data) {
            $data->monthlyTargets()->delete(); // Delete related MonthlyTarget records
            $data->delete(); // Delete the DpcrTarget itself
        }
        $data->delete();
        return redirect('/ipcrtargets/r/' . $slug)
            ->with('deleted', 'Employee Target Deleted!');
    }
}
