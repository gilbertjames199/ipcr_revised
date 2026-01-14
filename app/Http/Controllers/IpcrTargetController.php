<?php

namespace App\Http\Controllers;

use App\Models\Division;
use App\Models\DivisionOutput;
use App\Models\DpcrTarget;
use App\Models\EmployeeSpecialDepartment;
use App\Models\hospital_individual_output;
use App\Models\HospitalTarget;
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
        $user = auth()->user()->userEmployee;
        $designated_division_head = $user->DesignatedDivisionHead;
        $is_div_head = false;
        // dd($designated_division_head, $user);
        // dd($user);
        $auth_code = $user->empl_id;
        // dd($auth_code);
        // dd(auth()->user()->userEmployee['salary_grade']);
        // dd($auth_code);
        $sg = $user->salary_grade;
        // dd($sg);
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
        $emp_type = employee_division_head($emp_code);
        // dd($designated_division_head, $user, $emp_type);
        // dd($is_div_head);
        // if (intval($sg) >= 22 || isset($designated_division_head)) {
        //     // dd("user tagged as designated division head");
        //     $is_div_head = true;
        //     $data = $this->getDPCRTarget($request, $emp_code, $id);
        //     // dd($data);
        // } else {
        //     $data = $this->getIfoTarget($request, $emp_code, $id);
        // }

        if ($emp_type == 'emp') {
            $data = $this->getIfoTarget($request, $emp_code, $id);
            // dd($data);
            if(intval($user->salary_grade)>21){
                // dd("sobra 21", $this->getDPCRTarget($request, $emp_code, $id));
                // $dpcr_data=$this->getDPCRTarget_forDesignated($request, $emp_code, $id);
                $dpcr_data=$this->getDPCRTarget_forDesignated($request, $emp_code, $id);
                // dd($data, $dpcr_data);
                $data=$data->concat($dpcr_data);
            }
            // dd($data);
        } else if ($emp_type == 'div') {
            $is_div_head = true;
            $data = $this->getDPCRTarget($request, $emp_code, $id);
        }

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
            "emp" => $emp,
            "filters" => $request->only(['search']),
            "is_div_head" => $is_div_head
        ]);
    }
    public function getDPCRTarget(Request $request, $emp_code, $id)
    {
        // dd($id);
        return DpcrTarget::select(
            'division_outputs.id AS individual_final_output_id',
            'dpcr_targets.id',
            'dpcr_targets.dpcr_type',
            'dpcr_targets.remarks',
            'division_outputs.output AS individual_output',
            'division_outputs.performance_measure',
            'division_outputs.prescribed_period',
            'division_outputs.timeliness',
            'division_outputs.efficiency1',
            'dpcr_targets.is_additional_target',
            'divisions.division_name1 AS division',
            'division_outputs.output AS div_output',
            'major_final_outputs.mfo_desc',
            'major_final_outputs.FFUNCCOD',
            'dpcr_targets.slug',
            // 'sub_mfos.submfo_description',
            'major_final_outputs.department_code',
            'dpcr_targets.ipcr_semestral_id',
        )
            // ->leftjoin('division_outputs', 'division_outputs.id', 'ipcr_targets.individual_final_output_id')
            ->leftjoin('division_outputs', 'division_outputs.id', 'dpcr_targets.idDPCR')
            ->leftjoin('divisions', 'divisions.id', 'division_outputs.division_id')
            ->leftjoin('major_final_outputs', 'major_final_outputs.id', 'division_outputs.idmfo')
            // ->leftjoin('sub_mfos', 'sub_mfos.id', 'individual_final_outputs.idsubmfo')
            ->when($request->search, function ($query, $searchValue) {
                // dd($searchValue);
                return $query->where(function ($query) use ($searchValue) {
                    $query->where('dpcr_targets.output', 'LIKE', '%' . $searchValue . '%')
                        ->orWhere('dpcr_targets.performance_measure', 'LIKE', '%' . $searchValue . '%');
                    // ->orWhere('dpcr_targets.ipcr_code', 'LIKE', '%' . $searchValue . '%');
                });
            })
            ->where('dpcr_targets.employee_code', $emp_code)
            ->where('dpcr_targets.ipcr_semestral_id', $id)
            ->orderBy('dpcr_type')
            ->orderBy('division_outputs.id')
            ->get();
    }
    public function getIfoTarget(Request $request, $emp_code, $id)
    {
        // dd($id);
        return IpcrTarget::select(
            'individual_final_outputs.id AS individual_final_output_id',
            'ipcr_targets.id',
            'ipcr_targets.ipcr_type',
            'ipcr_targets.remarks',
            'individual_final_outputs.individual_output',
            'individual_final_outputs.performance_measure',
            'individual_final_outputs.prescribed_period',
            'individual_final_outputs.timeliness',
            'individual_final_outputs.efficiency1',
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
                        ->orWhere('division_outputs.output', 'LIKE', '%' . $searchValue . '%');
                    // ->orWhere('individual_final_outputs.ipcr_code', 'LIKE', '%' . $searchValue . '%');
                });
            })
            ->where('ipcr_targets.employee_code', $emp_code)
            ->where('ipcr_targets.ipcr_semestral_id', $id)
            ->orderBy('ipcr_type')
            ->orderBy('individual_final_outputs.id')
            ->get();
    }

    public function getDPCRTarget_forDesignated(Request $request, $emp_code, $id)
    {
        // dd($id);
        return DpcrTarget::select(
            'division_outputs.id AS individual_final_output_id',
            'dpcr_targets.id',
            'dpcr_targets.dpcr_type AS ipcr_type',
            'dpcr_targets.remarks',
            'division_outputs.output AS individual_output',
            'division_outputs.performance_measure',
            'division_outputs.prescribed_period',
            'division_outputs.timeliness',
            'division_outputs.efficiency1',
            'dpcr_targets.is_additional_target',
            'divisions.division_name1 AS division',
            'division_outputs.output AS div_output',
            'major_final_outputs.mfo_desc',
            'major_final_outputs.FFUNCCOD',
            'dpcr_targets.slug',
            // 'sub_mfos.submfo_description',
            'major_final_outputs.department_code',
            'dpcr_targets.ipcr_semestral_id',
        )
            // ->leftjoin('division_outputs', 'division_outputs.id', 'ipcr_targets.individual_final_output_id')
            ->leftjoin('division_outputs', 'division_outputs.id', 'dpcr_targets.idDPCR')
            ->leftjoin('divisions', 'divisions.id', 'division_outputs.division_id')
            ->leftjoin('major_final_outputs', 'major_final_outputs.id', 'division_outputs.idmfo')
            // ->leftjoin('sub_mfos', 'sub_mfos.id', 'individual_final_outputs.idsubmfo')
            ->when($request->search, function ($query, $searchValue) {
                // dd($searchValue);
                return $query->where(function ($query) use ($searchValue) {
                    $query->where('dpcr_targets.output', 'LIKE', '%' . $searchValue . '%')
                        ->orWhere('dpcr_targets.performance_measure', 'LIKE', '%' . $searchValue . '%');
                    // ->orWhere('dpcr_targets.ipcr_code', 'LIKE', '%' . $searchValue . '%');
                });
            })
            ->where('dpcr_targets.employee_code', $emp_code)
            ->where('dpcr_targets.ipcr_semestral_id', $id)
            ->orderBy('dpcr_type')
            ->orderBy('division_outputs.id')
            ->get();
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
            'individual_final_outputs.efficiency1',
            'individual_final_outputs.timeliness',
            'individual_final_outputs.type',
            'divisions.division_name1 AS division',
            'division_outputs.output AS div_output',
            'major_final_outputs.mfo_desc',
            'major_final_outputs.FFUNCCOD',
            'individual_final_outputs.prescribed_period',
            'major_final_outputs.department_code'
        )
            ->leftjoin('division_outputs', 'division_outputs.id', 'individual_final_outputs.idDPCR')
            ->leftjoin('divisions', 'divisions.id', 'division_outputs.division_id')
            ->leftjoin('program_and_projects', 'program_and_projects.id', 'division_outputs.idpaps')
            ->leftjoin('major_final_outputs', 'major_final_outputs.id', 'program_and_projects.idmfo')
            ->whereNested(function ($query) use ($dept_code, $desig_dept) {
                $query->where('individual_final_outputs.department_code', '=', $dept_code)
                    // ->orWhere('major_final_outputs.department_code', '=', '')
                    // ->orWhere('major_final_outputs.department_code', '=', $desig_dept)
                    // ->orWhere('major_final_outputs.department_code', '=', '0')
                    // ->orWhere('major_final_outputs.department_code', '=', '-')
                    ->orWhere('individual_final_outputs.type', 'Common')
                    ->when($dept_code >= 20 && $dept_code <= 24, function ($query) {
                        $query->orWhere('individual_final_outputs.department_code', '=', '20');
                    });
            })
            ->whereNotIn('individual_final_outputs.id', $existingTargets)
            ->where('individual_final_outputs.deleted_at', null)
            ->orderBy('individual_final_outputs.type', 'ASC')
            ->orderBy('individual_final_outputs.id', 'ASC')
            ->get();

        if ($special_dept) {

            $sp = IndividualFinalOutput::select(
                'individual_final_outputs.id AS individual_final_output_id',
                'individual_final_outputs.id',
                'individual_final_outputs.individual_output',
                'individual_final_outputs.performance_measure',
                'individual_final_outputs.efficiency1',
                'individual_final_outputs.timeliness',
                'individual_final_outputs.type',
                'divisions.division_name1 AS division',
                'division_outputs.output AS div_output',
                'major_final_outputs.mfo_desc',
                'major_final_outputs.FFUNCCOD',
                'individual_final_outputs.prescribed_period',
                // 'sub_mfos.submfo_description',
                'major_final_outputs.department_code'
            )
                //
                ->where('individual_final_outputs.deleted_at', null)
                ->leftjoin('division_outputs', 'division_outputs.id', 'individual_final_outputs.idDPCR')
                ->leftjoin('divisions', 'divisions.id', 'division_outputs.division_id')
                ->leftjoin('program_and_projects', 'program_and_projects.id', 'division_outputs.idpaps')
                ->leftjoin('major_final_outputs', 'major_final_outputs.id', 'program_and_projects.idmfo')
                // ->leftjoin('sub_mfos', 'sub_mfos.id', 'individual_final_outputs.idsubmfo')
                ->orderBy('individual_final_outputs.type', 'ASC')
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

        $request->validate([
            'ipcr_semestral_id' => 'required',
            'employee_code' => 'required',
            'individual_final_output_id' => 'required',
            'ipcr_type' => 'required',
            // 'remarks' => 'required',
        ]);
        $check_if_exists = IpcrTarget::where('ipcr_semestral_id', $request->ipcr_semestral_id)
            ->where('individual_final_output_id', $request->individual_final_output_id)
            ->first();
        // dd($check_if_exists);
        // dd($request);
        if ($check_if_exists) {
            return redirect('/ipcrtargets/r/' . $request->slug_sem)
                ->with('error', 'IPCR Target already exists for this Semestral ID and Individual Final Output ID');
        }
        $random = Str::random(7 * 2);
        $append = substr(preg_replace('/[^a-z1-3]/', '', $random), 0, 7);
        $desc = Str::limit($request->ifo_desc, 100, '');
        $slugBase = Str::slug($desc . '-' . $append . '-' . $request->sem . '-' . $request->year);
        $slug = $slugBase;
        while (DB::table('ipcr_targets')->where('slug', $slug)->exists()) {
            $random = Str::random(10 * 2);
            $append = substr(preg_replace('/[^a-z1-3]/', '', $random), 0, 10);
            // if ($count > 1) {
            $slug = $slugBase . '-' . $append;
            // }
            // $count++;
        }
        // dd($slug);

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
        $data->identifier = $request->identifier;
        $data->save();
        // dd($data);
        // $data->store();
        // $data['created_by'] = Auth::user()->username;
        // $data['updated_by'] = Auth::user()->username;
        // $this->model->create($data);
        $this->generateMonthlyTargetRatings($request->semester, $request->year, $request->ipcr_semestral_id, $data->id);
        if (intval($request->is_additional_target) > 0) {
            return redirect('/ipcrsemestral/' . auth()->user()->id . '/direct')
                ->with('success', 'IPCR Target created successfully');
        }
        return redirect('/ipcrtargets/r/' . $request->slug_sem)
            ->with('success', 'IPCR Target created successfully');
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
                ->where('ipcr_target_id', $id)
                ->first();

            if (!$existingRecord) {
                MonthlyTarget::create([
                    'month' => $month,
                    'year' => $year,
                    'sem_id' => $sem_id,
                    'status' => '-1',
                    'ipcr_target_id' => $id,
                    'type' => 'ipcr',
                    'slug' => $slug // Save the unique slug
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
            'individual_final_outputs.efficiency1',
            'individual_final_outputs.timeliness',
            'individual_final_outputs.type',
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
                    ->orWhere('individual_final_outputs.type', 'Common')
                    ->when($dept_code >= 20 && $dept_code <= 24, function ($query) {
                        $query->orWhere('individual_final_outputs.department_code', '=', '20');
                    });
            })
            ->where('individual_final_outputs.deleted_at', null)
            ->whereNotIn('individual_final_outputs.id', $existingTargets)
            ->orderBy('individual_final_outputs.id', 'ASC')
            ->get();

        if ($special_dept) {
            // 'individual_final_outputs.id AS individual_final_output_id',
            //             'individual_final_outputs.id',
            //             'individual_final_outputs.individual_output',
            //             'individual_final_outputs.performance_measure',
            //             'individual_final_outputs.efficiency1',
            //             'individual_final_outputs.timeliness',
            //             'individual_final_outputs.type',
            //             'divisions.division_name1 AS division',
            //             'division_outputs.output AS div_output',
            //             'major_final_outputs.mfo_desc',
            //             'major_final_outputs.FFUNCCOD',
            //             'individual_final_outputs.prescribed_period',
            //             'major_final_outputs.department_code'
            $sp = IndividualFinalOutput::select(
                'individual_final_outputs.id AS individual_final_output_id',
                'individual_final_outputs.id',
                'individual_final_outputs.individual_output',
                'individual_final_outputs.efficiency1',
                'individual_final_outputs.timeliness',
                'individual_final_outputs.type',
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
                ->where('individual_final_outputs.deleted_at', null)
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
        $desc = Str::limit($request->ifo_desc, 100, '');
        $slugBase = Str::slug($desc . '-' . $append . '-' . $request->sem . '-' . $request->year);
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
        $data->identifier = $request->identifier;
        $data->slug = $slug;
        $data->save();
        return redirect('/ipcrtargets/r/' . $request->slug_sem)
            ->with('info', 'IPCR Target updated successfully');
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
    public function ipcrtargets_update_status(Request $request, $id_target, $target_status, $type)
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
        if ($type == 'ipcr') {
            $iptarg = IpcrTarget::find($id_target);
        } else if ($type == 'dpcr') {
            $iptarg = DpcrTarget::find($id_target);
        } else {
            $iptarg = HospitalTarget::find($id_target);
        }

        $iptarg->status = $new_stat;

        // ->update(['status' => $new_stat]);
        // dd($iptarg);
        $this->generateReturnRemarksForAdditionalTargets($act, $iptarg->ipcr_semestral_id, $iptarg->employee_code, $type);
        $iptarg->save();
        return back()->with($msg, 'Successfully ' . $act . ' additional IPCR target!');
        // dd($new_stat);
    }

    // public function is_division_head(Request $request) {}
    public function review_ipcr(Request $request)
    {
        //dd($request->empl_code);
        // dd($request->empl_id);
        $is_division_head = employee_division_head($request->empl_id);
        // dd($is_division_head);
        // $is_div_head = "emp";
        // $us = UserEmployees::with('DesignatedDivisionHead')->where('empl_id', $request->empl_id)->first();
        // // dd($us->designatedDivisionHead);
        // if ($us) {
        //     $is_div_head = ($us->DesignatedDivisionHead !== null ||
        //         $us->salary_grade >= 22) ? 'div' : 'emp';
        //     // dd($is_div_head);
        // }
        // dd($is_div_head);
        // dd($is_division_head);
        $ipcr_sem = Ipcr_Semestral::where('id', $request->sem_id)->first();
        $sal = $ipcr_sem->salary_grade;
        if ($is_division_head == 'emp') {
            // $is_division_head = 'emp';

            $targets = $this->view_ipcr_targets($request);
            // dd($request, $ipcr_sem);
            if(intval($sal)>21){
                // dd($this->view_dpcr_targets($request));
                $targets = $targets->concat($this->view_dpcr_targets($request));
            }
        } else if ($is_division_head == 'div') {
            $hdpcr = $this->view_hdpcr_targets($request);
            $dpcr = $this->view_dpcr_targets($request);
            $targets=$dpcr->concat($hdpcr);
        } else if ($is_division_head == 'hemp') {
            $targets = $this->view_hipcr_targets($request);
        } else if ($is_division_head == 'hsec') {
            $targets = $this->view_hspcr_targets($request);
        } else if ($is_division_head == 'hdiv') {
            $targets = $this->view_hdpcr_targets($request);
        } else if ($is_division_head == 'hos') {
            $targets = $this->view_hpcr_targets($request);
        }
        // return $targets;
        // $targets =$this->getHospitalOutputTarget($request, $request->empl_id, $request->sem_id, $is_division_head);
        // $targets = $is_division_head == 'emp' ? $this->view_ipcr_targets($request) : $this->view_dpcr_targets($request);
        return $targets;
    }
    public function getHospitalOutputTargetMain(){
        $main = HospitalTarget::with([
                // Hospital PCR
                'hpcr',
                'hpcr.programAndProject.MFO',

                // Hospital Division PCR
                'hDPCR',
                'hDPCR.hospitalOutput.programAndProject.MFO',

                // Division PCR
                'dpcr',
                'dpcr.program_and_projects.paps_desc',
                'dpcr.major_final_outputs.mfo_desc',

                // Hospital Section PCR
                'hSPCR',
                'hSPCR.hospitalDivisionOutput.hospitalOutput.programAndProject.MFO',

                // IPCR
                'ipcr',
                'ipcr.program_and_projects.paps_desc',
                'ipcr.major_final_outputs.mfo_desc',

                // Hospital Individual PCR
                'hIPCR',
                'hIPCR.hospitalSectionOutput.hospitalDivisionOutput.hospitalOutput.programAndProject.MFO'
            ])
            ->where('hospital_targets.employee_code', $emp_code)
            ->where('hospital_targets.ipcr_semestral_id', $id)
            ->orderBy('type')
            ->orderBy('hospital_targets.id')
            ->get();
        $main = $main->map(function ($item) use ($pcr_type) {

                // --------------------------------------------------------
                // HOSPITAL OUTPUT (HOS)
                // --------------------------------------------------------
                if ($pcr_type == 'hos') {

                    return [
                        "individual_final_output_id" => $item->id,

                        "paps_desc" => optional(optional($item->hpcr)->program_and_projects)->paps_desc,
                        "mfo_desc"  => optional(optional($item->hpcr)->major_final_outputs)->mfo_desc,

                        "ipcr_type" => optional($item->hpcr)->type,
                        "individual_output" => optional($item->hpcr)->individual_output,
                        "performance_measure" => optional($item->hpcr)->performance_measure,
                    ];
                }

                // --------------------------------------------------------
                // DIVISION OUTPUT (HDIV / DPCR)
                // --------------------------------------------------------
                if ($pcr_type == 'hdiv') {

                    // choose between HDPCR or DPCR
                    $model = $item->idHDPCR
                        ? optional($item->hDPCR)
                        : optional($item->dpcr);

                    return [
                        "individual_final_output_id" => $item->id,

                        "paps_desc" => optional($model->program_and_projects)->paps_desc,
                        "mfo_desc"  => optional($model->major_final_outputs)->mfo_desc,

                        "ipcr_type" => $model->type ?? optional($item->dpcr)->type,
                        "individual_output" => $model->individual_output ?? optional($item->dpcr)->individual_output,
                        "performance_measure" => $model->performance_measure ?? optional($item->dpcr)->performance_measure,
                    ];
                }

                // --------------------------------------------------------
                // SECTION OUTPUT (HSEC = HSPCR or HIPCR)
                // --------------------------------------------------------
                if ($pcr_type == 'hsec') {

                    // choose between HIPCR or HSPCR
                    $model = $item->pcr_type == 'hipcr'
                        ? optional($item->hIPCR)
                        : optional($item->hSPCR);

                    return [
                        "individual_final_output_id" => $item->id,

                        "paps_desc" => optional(optional($model->hospitalDivisionOutput)->hospitalOutput->program_and_projects)->paps_desc,
                        "mfo_desc"  => optional(optional($model->hospitalDivisionOutput)->hospitalOutput->major_final_outputs)->mfo_desc,

                        "ipcr_type" => $model->type,
                        "individual_output" => $model->individual_output,
                        "performance_measure" => $model->performance_measure,
                    ];
                }

                // --------------------------------------------------------
                // EMPLOYEE OUTPUT (HEMP = HIPCR or IPCR)
                // --------------------------------------------------------
                if ($pcr_type == 'hemp') {

                    // choose between HIPCR or IPCR
                    $model = $item->idHIPCR
                        ? optional($item->hIPCR)
                        : optional($item->ipcr);

                    return [
                        "individual_final_output_id" => $item->id,

                        "paps_desc" => optional($model->program_and_projects)->paps_desc,
                        "mfo_desc"  => optional($model->major_final_outputs)->mfo_desc,

                        "ipcr_type" => $model->type,
                        "individual_output" => $model->individual_output,
                        "performance_measure" => $model->performance_measure,
                    ];
                }

                // --------------------------------------------------------
                // DEFAULT FALLBACK (no match)
                // --------------------------------------------------------
                return [
                    "individual_final_output_id" => $item->id,
                    "paps_desc" => null,
                    "mfo_desc"  => null,
                    "ipcr_type" => null,
                    "individual_output" => null,
                    "performance_measure" => null,
                ];
            });



        return $main;

    }
    public function getHospitalOutputTarget2(Request $request, $emp_code, $id, $pcr_type){
        $main = HospitalTarget::with([
            'hpcr.programAndProject.MFO',
            'hDPCR.hospitalOutput.programAndProject.MFO',
            'dpcr.program_and_projects.paps_desc',
            'dpcr.major_final_outputs.mfo_desc',
            'hSPCR.hospitalDivisionOutput.hospitalOutput.programAndProject.MFO',
            'ipcr.program_and_projects.paps_desc',
            'ipcr.major_final_outputs.mfo_desc',
            'hIPCR.hospitalSectionOutput.hospitalDivisionOutput.hospitalOutput.programAndProject.MFO'
        ])
        ->where('hospital_targets.employee_code', $emp_code)
        ->where('hospital_targets.ipcr_semestral_id', $id)
        ->orderBy('type')
        ->orderBy('hospital_targets.id')
        ->get()
        ->map(function ($item) use ($pcr_type) {

            // 1. Identify the active PCR relation automatically
            $relations = [
                'hos'  => 'hpcr',
                'hdiv' => $item->idHDPCR ? 'hDPCR' : ($item->idDPCR ? 'dpcr' : null),
                'hsec' => $item->pcr_type == 'hipcr' ? 'hIPCR' : 'hSPCR',
                'hemp' => $item->idHIPCR ? 'hIPCR' : 'ipcr',
            ];

            $rel = $relations[$pcr_type] ?? null;
            $model = $rel ? $item->$rel : null;

            return [
                "individual_final_output_id" => $item->id,
                "paps_desc"   => $model->program_and_projects->paps_desc ?? null,
                "mfo_desc"    => $model->major_final_outputs->mfo_desc ?? null,
                "ipcr_type"   => $model->type ?? null, // or replace with your ipcr_type logic
                "individual_output"     => $model->individual_output ?? null,
                "performance_measure"   => $model->performance_measure ?? null,
            ];
        });

        return $main;
    }
    public function getHospitalOutputTarget(Request $request, $emp_code, $id, $pcr_type)
    {
        // dd($id, $emp_code);
        $main = HospitalTarget::with(['hpcr', 'hDPCR', 'dpcr', 'hSPCR', 'ipcr', 'hIPCR'])
            // ->leftjoin('sub_mfos', 'sub_mfos.id', 'individual_final_outputs.idsubmfo')
            ->where('hospital_targets.employee_code', $emp_code)
            ->where('hospital_targets.ipcr_semestral_id', $id)
            ->when($request->search, function ($query, $searchValue) {
                // dd($searchValue);
                return $query->where(function ($query) use ($searchValue) {
                    $query->where('dpcr_targets.output', 'LIKE', '%' . $searchValue . '%')
                        ->orWhere('dpcr_targets.performance_measure', 'LIKE', '%' . $searchValue . '%');
                    // ->orWhere('dpcr_targets.ipcr_code', 'LIKE', '%' . $searchValue . '%');
                });
            })
            ->orderBy('type')
            ->orderBy('hospital_targets.id')
            ->get()
            // use ($pcr_type)
            ->map(function ($item) use ($pcr_type) {
                // dd($item, $pcr_type);
                if ($pcr_type == 'hos') {
                    return [
                        'individual_output_id' => $item->hpcr ? $item->hpcr->individual_output_id : null,
                        'paps_desc'=>$item->paps->paps_desc,
                        'mfo_desc'=>$item->mfo->mfo_desc,
                        'ipcr_type' => $item->type,
                        'individual_output' => $item->hpcr ? $item->hpcr->output : null,
                        'performance_measure' => $item->hpcr ? $item->hpcr->performance_measure : null,
                    ];
                } else if ($pcr_type == 'hdiv') {
                    // dd($item);
                    $pcr_type = $item->idHDPCR ? 'hdpcr' : ($item->idDPCR ? 'dpcr' : null);
                    $output = $item->hDPCR ? $item->hDPCR->output : ($item->idDPCR ? $item->dpcr->output : null);
                    $performance_measure = $item->hDPCR ? $item->hDPCR->performance_measure : ($item->idDPCR ? $item->dpcr->performance_measure : null);
                    $efficiency1 = $item->hDPCR ? $item->hDPCR->efficiency1 : ($item->idDPCR ? $item->dpcr->efficiency1 : null);
                    $timeliness = $item->hDPCR ? $item->hDPCR->timeliness : ($item->idDPCR ? $item->dpcr->timeliness : null);
                    $individual_output = $item->hDPCR ? $item->hDPCR->individual_output : ($item->idDPCR ? $item->dpcr->individual_output : null);
                    $prescribed_period = $item->hDPCR ? $item->hDPCR->prescribed_period : ($item->idDPCR ? $item->dpcr->prescribed_period : null);
                    // $slug = $item->hDPCR ? $item->hDPCR->slug : ($item->idDPCR ? $item->DPCR->slug : null);
                    return [
                        'id' => $item->id,
                        'output' => $output,
                        'year' => $item->year,
                        'semester' => $item->semester,
                        'type' => $item->type,
                        'slug' => $item->slug,
                        'performance_measure' => $performance_measure,
                        'efficiency1' => $efficiency1,
                        'timeliness' => $timeliness,
                        'individual_output' => $individual_output,
                        'prescribed_period' => $prescribed_period,
                        'pcr_type' => $pcr_type,
                        'remarks' => $item->remarks,
                    ];
                } else if ($pcr_type == 'hsec') {
                    // dd($item);
                    // dd("hsec");
                    if($item->pcr_type == 'hipcr'){
                        $output = $item->hIPCR ? $item->hIPCR->output  : null;
                        $performance_measure = $item->hIPCR ? $item->hIPCR->performance_measure : null;
                        $efficiency1 = $item->hIPCR ? $item->hIPCR->efficiency1 : null;
                        $timeliness = $item->hIPCR ? $item->hIPCR->timeliness : null;
                        $individual_output = $item->hIPCR ? $item->hIPCR->individual_output : null;
                        $prescribed_period = $item->hIPCR ? $item->hIPCR->prescribed_period : null;
                        $pcr_type = 'hipcr';
                        return [
                            'id' => $item->id,
                            'output' => $output,
                            'year' => $item->year,
                            'semester' => $item->semester,
                            'type' => $item->type,
                            'slug' => $item->slug,
                            'performance_measure' => $performance_measure,
                            'efficiency1' => $efficiency1,
                            'timeliness' => $timeliness,
                            'individual_output' => $individual_output,
                            'prescribed_period' => $prescribed_period,
                            'pcr_type' => $pcr_type,
                            'remarks' => $item->remarks,
                        ];
                    }else{
                        $output = $item->hSPCR ? $item->hSPCR->output  : null;
                        $performance_measure = $item->hSPCR ? $item->hSPCR->performance_measure : null;
                        $efficiency1 = $item->hSPCR ? $item->hSPCR->efficiency1 : null;
                        $timeliness = $item->hSPCR ? $item->hSPCR->timeliness : null;
                        $individual_output = $item->hSPCR ? $item->hSPCR->individual_output : null;
                        $prescribed_period = $item->hSPCR ? $item->hSPCR->prescribed_period : null;
                        // $slug = $item->hDPCR ? $item->hDPCR->slug : ($item->idDPCR ? $item->DPCR->slug : null);
                        return [
                            'id' => $item->id,
                            'output' => $output,
                            'year' => $item->year,
                            'semester' => $item->semester,
                            'type' => $item->type,
                            'slug' => $item->slug,
                            'performance_measure' => $performance_measure,
                            'efficiency1' => $efficiency1,
                            'timeliness' => $timeliness,
                            'individual_output' => $individual_output,
                            'prescribed_period' => $prescribed_period,
                            'pcr_type' => 'hspcr',
                            'remarks' => $item->remarks,
                        ];
                    }

                } else if ($pcr_type == 'hemp') {
                    // dd($item);
                    $pcr_type = 'ipcr';
                    if ($item->idIPCR) {
                        $output = $item->ipcr ? $item->ipcr->individual_output  : null;
                        $performance_measure = $item->ipcr ? $item->ipcr->performance_measure : null;
                        $efficiency1 = $item->ipcr ? $item->ipcr->efficiency1 : null;
                        $timeliness = $item->ipcr ? $item->ipcr->timeliness : null;
                        $individual_output = $item->ipcr ? $item->ipcr->individual_output : null;
                        $prescribed_period = $item->ipcr ? $item->ipcr->prescribed_period : null;
                        $pcr_type = 'ipcr';
                    }
                    if ($item->idHIPCR) {
                        $output = $item->hIPCR ? $item->hIPCR->output  : null;
                        $performance_measure = $item->hIPCR ? $item->hIPCR->performance_measure : null;
                        $efficiency1 = $item->hIPCR ? $item->hIPCR->efficiency1 : null;
                        $timeliness = $item->hIPCR ? $item->hIPCR->timeliness : null;
                        $individual_output = $item->hIPCR ? $item->hIPCR->individual_output : null;
                        $prescribed_period = $item->hIPCR ? $item->hIPCR->prescribed_period : null;
                        $pcr_type = 'hipcr';
                    }

                    return [
                        'id' => $item->id,
                        'output' => $output,
                        'year' => $item->year,
                        'semester' => $item->semester,
                        'type' => $item->type,
                        'slug' => $item->slug,
                        'performance_measure' => $performance_measure,
                        'efficiency1' => $efficiency1,
                        'timeliness' => $timeliness,
                        'individual_output' => $individual_output,
                        'prescribed_period' => $prescribed_period,
                        'pcr_type' => $pcr_type,
                        'remarks' => $item->remarks,
                    ];
                }
            });

        return $main;
    }
    public function view_ipcr_targets(Request $request)
    {
        // dd("ipcr");
        return IpcrTarget::select(
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
            ->leftjoin('individual_final_outputs', 'individual_final_outputs.id', 'ipcr_targets.individual_final_output_id')
            ->leftjoin('division_outputs', 'division_outputs.id', 'individual_final_outputs.idDPCR')
            ->leftjoin('program_and_projects', 'program_and_projects.id', 'division_outputs.idpaps')
            ->leftjoin('major_final_outputs', 'major_final_outputs.id', 'program_and_projects.idmfo')
            ->distinct('ipcr_targets.individual_final_output_id')
            ->orderBy('individual_final_outputs.id', 'ASC')
            ->get();
    }
    public function view_dpcr_targets(Request $request)
    {
        // dd($request->sem_id);
        return DpcrTarget::select(
            'dpcr_targets.idDPCR AS individual_final_output_id',
            // 'ipcr_targets.month_1',
            // 'ipcr_targets.month_2',
            // 'ipcr_targets.month_3',
            // 'ipcr_targets.month_4',
            // 'ipcr_targets.month_5',
            // 'ipcr_targets.month_6',
            // 'ipcr_targets.quantity_sem',
            'program_and_projects.paps_desc',
            'major_final_outputs.mfo_desc',
            'dpcr_targets.dpcr_type AS ipcr_type',
            'division_outputs.output AS individual_output',
            'division_outputs.performance_measure'
        )
            ->where('employee_code', $request->empl_id)
            ->where('ipcr_semestral_id', $request->sem_id)
            ->distinct('dpcr_targets.idDPCR')
            // ->join('division_outputs', 'division_outputs.id', 'dpcr_targets.individual_final_output_id')
            ->leftjoin('division_outputs', 'division_outputs.id', 'dpcr_targets.idDPCR')
            ->leftjoin('program_and_projects', 'program_and_projects.id', 'division_outputs.idpaps')
            ->leftjoin('major_final_outputs', 'major_final_outputs.id', 'program_and_projects.idmfo')
            ->distinct('dpcr_targets.idDPCR')
            ->orderBy('dpcr_targets.idDPCR', 'ASC')
            ->get();
    }
    public function view_hipcr_targets(Request $request)
    {
        // select(
        //     'ipcr_targets.individual_final_output_id',

        //     'program_and_projects.paps_desc',
        //     'major_final_outputs.mfo_desc',
        //     'ipcr_targets.ipcr_type',
        //     'individual_final_outputs.individual_output',
        //     'individual_final_outputs.performance_measure'
        // )
        // hospital_individual_output

        // else if($item->pcr_type=="hspcr"){
        //     $id=$item->idHSPCR;
        // }else if($item->pcr_type=="hdpcr"){
        //     $id=$item->idHDPCR;
        // }else if($item->pcr_type=="dpcr"){
        //     $id=$item->idDPCR;
        // }else if($item->pcr_type=="hpcr"){
        //     $id=$item->idHPCR;
        // }
        $targets = HospitalTarget::with([
            'ipcr',
            'ipcr.divisionOutput',
            'ipcr.divisionOutput.programAndProject',
            'ipcr.divisionOutput.programAndProject.MFO',
            'hIPCR',
            'hIPCR.hospitalSectionOutput',
            'hIPCR.hospitalSectionOutput.hospitalDivisionOutput',
            'hIPCR.hospitalSectionOutput.hospitalDivisionOutput.hospitalOutput',
            'hIPCR.hospitalSectionOutput.hospitalDivisionOutput.hospitalOutput.programAndProject',
            'hIPCR.hospitalSectionOutput.hospitalDivisionOutput.hospitalOutput.programAndProject.MFO'
        ])
            ->where('employee_code', $request->empl_id)
            ->where('ipcr_semestral_id', $request->sem_id)
            ->where(function ($query) {
                $query->whereHas('hIPCR')
                    ->orWhereHas('ipcr');
            })
            ->get(); // Reindex the collection after sorting
        // dd($targets);
        $sortedTargets = $targets->sortBy(function ($item) {
            return optional($item->hIPCR)->id; // Sorting by hIPCR.id
        });

        // If you want to reindex the collection after sorting
        $sortedTargets = $sortedTargets->values();

        // Now you can use the sorted collection
        return $sortedTargets->map(function ($item) {
            //Hospital IPCR -for hospital employees
            $id = $item->id;
            $paps = "";
            $mfo = "";
            $output = "";
            $pm = "";
            if ($item->pcr_type == 'hipcr') {
                $id = $item->idHIPCR;
                $paps = optional(optional(optional(optional(optional($item->hIPCR)->hospitalSectionOutput)->hospitalDivisionOutput)->hospitalOutput)->programAndProject)->paps_desc;
                $mfo = optional(optional(optional(optional(optional(optional($item->hIPCR)->hospitalSectionOutput)->hospitalDivisionOutput)->hospitalOutput)->programAndProject)->MFO)->mfo_desc;
                $output = optional($item->hIPCR)->output;
                $pm = optional($item->hIPCR)->performance_measure;
            } else if ($item->pcr_type == 'ipcr') {
                $id = $item->idIPCR;
                $paps = optional(optional(optional($item->ipcr)->divisionOutput)->programAndProject)->paps_desc;
                $mfo = optional(optional(optional(optional($item->ipcr)->divisionOutput)->programAndProject)->MFO)->mfo_desc;

                $output = optional($item->ipcr)->individual_output;
                $pm = optional($item->ipcr)->performance_measure;
            }
            return [
                "individual_final_output_id" => $id,
                "paps_desc" => $paps,
                "mfo_desc" => $mfo,
                "ipcr_type" => $item->type,
                "individual_output" => $output,
                "performance_measure" => $pm
            ];
        });
        // return $sortedTargets;
    }
    public function view_hspcr_targets(Request $request)
    {

        $targets = HospitalTarget::with([
            'hSPCR',
            'hSPCR.hospitalDivisionOutput',
            'hSPCR.hospitalDivisionOutput.hospitalOutput',
            'hSPCR.hospitalDivisionOutput.hospitalOutput.programAndProject',
            'hSPCR.hospitalDivisionOutput.hospitalOutput.programAndProject.MFO'
        ])
            ->where('employee_code', $request->empl_id)
            ->where('ipcr_semestral_id', $request->sem_id)
            // ->whereHas('hSPCR')
            ->get(); // Reindex the collection after sorting
        // dd($targets);
        $sortedTargets = $targets->sortBy(function ($item) {
            return optional($item->hSPCR)->id; // Sorting by hIPCR.id
        });

        // If you want to reindex the collection after sorting
        $sortedTargets = $sortedTargets->values();

        // Now you can use the sorted collection
        return $sortedTargets->map(function ($item) {
            //Hospital IPCR -for hospital employees
            $id = $item->id;
            $paps = "";
            $mfo = "";
            $output = "";
            $pm = "";
            // dd($item);

            // if ($item->pcr_type == 'hspcr') {
            $id = $item->idHSPCR; // Use idHSPCR for hSPCR type

            // Get paps_desc from hSPCR relation
            $paps = optional(
                optional(
                    optional(
                        optional($item->hSPCR)->hospitalDivisionOutput
                    )->hospitalOutput
                )->programAndProject
            )->paps_desc;

            // Get mfo_desc from hSPCR relation
            $mfo = $mfoDesc = optional(
                optional(
                    optional(
                        optional($item->hSPCR)
                            ->hospitalDivisionOutput
                    )
                        ->hospitalOutput
                )
                    ->programAndProject
            )
                ->MFO
                ->mfo_desc ?? null;

            // Get individual_output and performance_measure from hSPCR relation
            $output = optional($item->hSPCR)->output;
            $pm = optional($item->hSPCR)->performance_measure;
            // }

            return [
                "individual_final_output_id" => $id,
                "paps_desc" => $paps,
                "mfo_desc" => $mfo,
                "ipcr_type" => $item->type,
                "individual_output" => $output,
                "performance_measure" => $pm
            ];
        });
        // return $sortedTargets;
    }
    public function view_hdpcr_targets(Request $request)
    {

        $targets = HospitalTarget::with([
            'dpcr',
            'dpcr.programAndProject',
            'hDPCR',
            'hDPCR.hospitalOutput',
            'hDPCR.hospitalOutput.programAndProject',
            'hDPCR.hospitalOutput.programAndProject.MFO'
        ])
            ->where('employee_code', $request->empl_id)
            ->where('ipcr_semestral_id', $request->sem_id)
            ->where(function ($query) {
                $query->whereHas('hDPCR')
                    ->orWhereHas('dpcr');
            })
            ->get(); // Reindex the collection after sorting
        // dd($targets);
        $sortedTargets = $targets->sortBy(function ($item) {
            return optional($item->hSPCR)->id; // Sorting by hIPCR.id
        });

        // If you want to reindex the collection after sorting
        $sortedTargets = $sortedTargets->values();

        // Now you can use the sorted collection
        return $sortedTargets->map(function ($item) {
            //Hospital IPCR -for hospital employees
            $id = $item->id;
            $paps = "";
            $mfo = "";
            $output = "";
            $pm = "";
            // dd($item);

            if ($item->pcr_type == 'dpcr') {
                $id = $item->idDPCR;
                $paps = optional(optional($item->dpcr)->programAndProject)->paps_desc;
                $mfo = optional(optional($item->dpcr)->programAndProject)->MFO->mfo_desc;
                $output = optional($item->dpcr)->individual_output;
                $pm = optional($item->dpcr)->performance_measure;
            }
            // Handle 'hDPCR' pcr_type
            else if ($item->pcr_type == 'hdpcr') {
                $id = $item->idHDPCR;
                $paps = optional(optional(optional($item->hDPCR)->hospitalOutput)->programAndProject)->paps_desc;
                $mfo = optional(optional(optional($item->hDPCR)->hospitalOutput)->programAndProject)->MFO->mfo_desc;
                $output = optional($item->hDPCR)->individual_output;
                $pm = optional($item->hDPCR)->performance_measure;
            }

            return [
                "individual_final_output_id" => $id,
                "paps_desc" => $paps,
                "mfo_desc" => $mfo,
                "ipcr_type" => $item->type,
                "individual_output" => $output,
                "performance_measure" => $pm
            ];
        });
        // return $sortedTargets;
    }
    public function view_hpcr_targets(Request $request)
    {
        $targets = HospitalTarget::with([
            'hpcr',
            'hpcr.programAndProject',
            'hpcr.programAndProject.MFO'
        ])
            ->where('employee_code', $request->empl_id)
            ->where('ipcr_semestral_id', $request->sem_id)
            ->whereHas('hpcr')
            ->get(); // Reindex the collection after sorting
        // dd($targets);
        $sortedTargets = $targets->sortBy(function ($item) {
            return optional($item->hpcr)->id; // Sorting by hIPCR.id
        });

        // If you want to reindex the collection after sorting
        $sortedTargets = $sortedTargets->values();

        // Now you can use the sorted collection
        return $sortedTargets->map(function ($item) {
            //Hospital IPCR -for hospital employees
            $id = $item->id;
            $paps = "";
            $mfo = "";
            $output = "";
            $pm = "";
            // dd($item);

            if ($item->pcr_type == 'hpcr') {
                $id = $item->idHPCR; // Use idHPCR for hpcr type

                // Get paps_desc from hpcr's programAndProject relation
                $paps = optional(optional($item->hpcr)->programAndProject)->paps_desc;

                // Get mfo_desc from hpcr's programAndProject->MFO relation
                $mfo = optional(optional(optional($item->hpcr)->programAndProject)->MFO)->mfo_desc;

                // Get individual_output and performance_measure from hpcr
                $output = optional($item->hpcr)->output;
                $pm = optional($item->hpcr)->performance_measure;
            }

            return [
                "individual_final_output_id" => $id,
                "paps_desc" => $paps,
                "mfo_desc" => $mfo,
                "ipcr_type" => $item->type,
                "individual_output" => $output,
                "performance_measure" => $pm
            ];
        });
        // return $sortedTargets;
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
    public function destroy_additional_taget(Request $request, $id, $source, $id_sem, $emp_type)
    {

        // dd("ippp",$id, intval($id), $emp_type, $id_sem, $ippp);
        $id = $request->id;
        if ($emp_type == 'emp') {
            $data = IpcrTarget::findOrFail($id);

        } else if ($emp_type == 'div') {
            $data = DpcrTarget::findOrFail($id);
        } else {
            $data = HospitalTarget::findOrFail($id);
        }

        $ep = $data->employee_code;
        $user = UserEmployees::where('empl_id', $ep)->first();
        // dd($user->id);
        $data->delete();
        return redirect('/ipcrsemestral/' . $user->id . '/' . $source)
            ->with('deleted', 'Employee Target Deleted!');
    }
    public function generateReturnRemarksForAdditionalTargets($action, $ipcr_semester_id, $employee_code, $type)
    {
        $retrem = new ReturnRemarks;
        $retrem->type = $action . ' additional target (new) -' . $type;
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
        // 'individual_final_outputs.id AS individual_final_output_id',
        // 'individual_final_outputs.id',
        // 'individual_final_outputs.individual_output',
        // 'individual_final_outputs.performance_measure',
        // 'individual_final_outputs.efficiency1',
        // 'individual_final_outputs.timeliness',
        // 'individual_final_outputs.type',
        // 'divisions.division_name1 AS division',
        // 'division_outputs.output AS div_output',
        // 'major_final_outputs.mfo_desc',
        // 'major_final_outputs.FFUNCCOD',
        // 'individual_final_outputs.prescribed_period',
        // 'major_final_outputs.department_code'
        $ipcrs = IndividualFinalOutput::select(
            'individual_final_outputs.id AS individual_final_output_id',
            'individual_final_outputs.id',
            'individual_final_outputs.individual_output',
            'individual_final_outputs.performance_measure',
            'individual_final_outputs.efficiency1',
            'individual_final_outputs.timeliness',
            'individual_final_outputs.type',
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
                    ->orWhere('individual_final_outputs.type', 'Common')
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
                'individual_final_outputs.efficiency1',
                'individual_final_outputs.timeliness',
                'individual_final_outputs.type',
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
        // dd($request->idsemestral);

        $date_now = Carbon::now();
        $dn = $date_now->format('m-d-Y');
        $ipcr_sem = Ipcr_Semestral::where('id', $request->idsemestral)
            ->first();
        // dd($ipcr_sem);
        $is_division_head = "emp";
        $type = 'INDIVIDUAL';
        if ($ipcr_sem) {
            // dd($ipcr_sem);
            $is_division_head = employee_division_head($ipcr_sem->employee_code);
        }
        $type = $is_division_head == 'emp' ? "INDIVIDUAL" : "DIVISION";
        $acronym = $is_division_head == 'emp' ? "IPCR" : "DPCR";

        $pcr_type = optional($ipcr_sem)->pcr_type;
        if ($pcr_type) {
            $is_division_head = $pcr_type;
        }
        if ($is_division_head == 'hdiv') {
            $type = 'DIVISION';
            $acronym = "HPCR";
        }
        if ($is_division_head == 'hsec') {
            $type = 'SECTION';
            $acronym = "SPCR";
        }
        if ($is_division_head == 'hos') {
            $type = 'HOSPITAL';
            $acronym = "HPCR";
        }
        if ($is_division_head == 'hemp') {
            $type = 'INDIVIDUAL';
            $acronym = "IPCR";
        }

        $arr = [
            [
                "type_employment" => $type,
                "acronym" => $acronym,
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
                "type_employment" => $type,
                "acronym" => $acronym,
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
        // dd($request->ipcr_sem_id);
        $ipcr_sem = Ipcr_Semestral::where('id', $request->ipcr_sem_id)
            ->first();
            $sg= $ipcr_sem?intval($ipcr_sem->salary_grade):0;
        // dd($ipcr_sem);
        $is_division_head = "emp";

        if ($ipcr_sem) {
            // dd($ipcr_sem);
            $is_division_head = employee_division_head($ipcr_sem->employee_code);
            $pcr_type = optional($ipcr_sem)->pcr_type;
            if ($pcr_type) {
                $is_division_head = $pcr_type;
            }
        }
        // dd("wala naabot");
        // dd($ipcr_sem);
        // dd($is_division_head);
        if ($is_division_head == "emp") {
            //OK
            // dd($is_division_head);
            $data = $this->getIPCRTargets($request);
            if(intval($sg)>21){
                $data = $data->concat($this->getDPCRTargets($request));
            }
        } else if ($is_division_head == "div") {
            //OK
            $data = $this->getDPCRTargets($request);
        } else if ($is_division_head == "hdiv") {
            //
            $data = $this->getHPCRTargets($request);
        } else if ($is_division_head == "hsec") {
            //
            $data = $this->getHPCRTargets($request);
        } else if ($is_division_head == "hemp") {
            $data = $this->getHPCRTargets($request);
        } else if ($is_division_head == "hos") {
            $data = $this->getHPCRTargets($request);
        }
        // $data = $is_division_head == 'emp' ? $this->getIPCRTargets($request) : $this->getDPCRTargets($request);

        // dd($data->query());
        // dd($data->toSql(), $data->getBindings());

        return $data;
    }
    public function getIPCRTargets(Request $request)
    {
        // dd($request);
        return IpcrTarget::select(
            'ipcr__semestrals.id AS sem_id',
            'ipcr_targets.id AS id',
            'major_final_outputs.mfo_desc',
            'program_and_projects.paps_desc',
            'division_outputs.output',
            'individual_final_outputs.id AS idifo',
            'individual_final_outputs.individual_output',
            'individual_final_outputs.performance_measure',
            'individual_final_outputs.prescribed_period',
            'individual_final_outputs.timeliness',
            'individual_final_outputs.efficiency1',
            DB::raw("
                CASE
                    WHEN ipcr_targets.remarks IS NULL OR ipcr_targets.remarks = '' THEN ipcr_targets.identifier
                    WHEN ipcr_targets.identifier IS NULL OR ipcr_targets.identifier = '' THEN ipcr_targets.remarks
                    ELSE CONCAT(ipcr_targets.remarks, ' (', ipcr_targets.identifier, ')')
                END AS remarks
            ")
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
            ->orderBy('division_outputs.output', 'ASC')
            ->distinct('individual_final_outputs.id')
            ->get();
    }
    public function getDPCRTargets(Request $request)
    {

        return DpcrTarget::select([
            'dpcr_targets.ipcr_semestral_id AS sem_id',
            'dpcr_targets.id AS id',
            'major_final_outputs.mfo_desc',
            'program_and_projects.paps_desc',
            'division_outputs.output',
            'division_outputs.id AS idifo',
            DB::raw('NULL AS individual_output'),
            'division_outputs.performance_measure',
            'division_outputs.prescribed_period',
            'division_outputs.timeliness',
            'division_outputs.efficiency1',
            DB::raw("
                CASE
                    WHEN dpcr_targets.remarks IS NULL OR dpcr_targets.remarks = '' THEN dpcr_targets.identifier
                    WHEN dpcr_targets.identifier IS NULL OR dpcr_targets.identifier = '' THEN dpcr_targets.remarks
                    ELSE CONCAT(dpcr_targets.remarks, ' (', dpcr_targets.identifier, ')')
                END AS remarks
            ")
        ])
            ->leftjoin('division_outputs', 'division_outputs.id', '=', 'dpcr_targets.idDPCR')
            ->leftjoin('program_and_projects', 'program_and_projects.id', '=', 'division_outputs.idpaps')
            ->leftjoin('major_final_outputs', 'major_final_outputs.id', '=', 'program_and_projects.idmfo')
            ->where('dpcr_targets.ipcr_semestral_id', $request->ipcr_sem_id)
            ->where('dpcr_targets.dpcr_type',  $request->type)
            ->orderBy('division_outputs.output', 'ASC')
            ->get();
    }
    public function getHPCRTargets(Request $request)
    {
        // dd($request->ipcr_sem_id);
        // dd($request->ipcr_sem_id);
        $get_ifo = $this->getIfoTargetPrint($request, $request->type, $request->ipcr_sem_id);
        // dd( $get_ifo);
        $data = HospitalTarget::with([
            'ipcr.divisionOutput.programAndProject.MFO',
            'dpcr.programAndProject.MFO',
            'hIPCR.hospitalSectionOutput.hospitalDivisionOutput.hospitalOutput.programAndProject.MFO',
            'hSPCR.hospitalDivisionOutput.hospitalOutput.programAndProject.MFO',
            'hDPCR.hospitalOutput.programAndProject.MFO',
            'hpcr.programAndProject.MFO',
        ])
            ->where('ipcr_semestral_id', $request->ipcr_sem_id)
            ->where('type',  $request->type)
            ->get()
            ->map(function ($item) {
                // Default values
                $output = null;
                $idifo = null;
                $individual_output = null;
                $performance_measure = null;
                $prescribed_period = null;
                $timeliness = null;
                $efficiency1 = null;
                $mfo_desc = null;
                $paps_desc = null;

                // dd($item->pcr_type);
                switch ($item->pcr_type) {
                    case 'ipcr':
                        $individualOutput = optional(optional($item->ipcr)->divisionOutput);
                        // dd($individualOutput);
                        $output = optional($individualOutput)->output;
                        $idifo = optional($item->ipcr)->id ?? null;
                        $individual_output = optional($item->ipcr)->individual_output ?? null;
                        $performance_measure = optional($item->ipcr)->performance_measure ?? null;
                        $prescribed_period = optional($item->ipcr)->prescribed_period ?? null;
                        $timeliness = optional($item->ipcr)->timeliness ?? null;
                        $efficiency1 = optional($item->ipcr)->efficiency1 ?? null;
                        $mfo_desc = optional(optional($individualOutput)->programAndProject)->MFO->mfo_desc ?? null;
                        $paps_desc = optional($individualOutput)->programAndProject->paps_desc ?? null;
                        break;

                    case 'dpcr':
                        $individualOutput = optional($item->dpcr);
                        $output = optional($item->dpcr)->output;
                        $idifo = optional($item->dpcr)->id ?? null;
                        $individual_output = optional($item->dpcr)->output ?? null;
                        $performance_measure = optional($item->dpcr)->performance_measure ?? null;
                        $prescribed_period = optional($item->dpcr)->prescribed_period ?? null;
                        $timeliness = optional($item->dpcr)->timeliness ?? null;
                        $efficiency1 = optional($item->dpcr)->efficiency1 ?? null;
                        $mfo_desc = optional(optional($individualOutput)->programAndProject)->MFO->mfo_desc ?? null;
                        $paps_desc = optional($individualOutput)->programAndProject->paps_desc ?? null;
                        break;

                    case 'hipcr':
                        $sectionOutput = optional(optional($item->hIPCR)->hospitalSectionOutput);
                        $divisionOutput = optional($sectionOutput)->hospitalDivisionOutput;
                        $hospitalOutput = optional($divisionOutput)->hospitalOutput;
                        $programAndProject = optional($hospitalOutput)->programAndProject;
                        $output = optional($item->hIPCR)->output;
                        $idifo = optional($item->hIPCR)->id ?? null;
                        $individual_output = optional($item->hIPCR)->output ?? null;
                        $performance_measure = optional($item->hIPCR)->performance_measure ?? null;
                        $prescribed_period = optional($item->hIPCR)->prescribed_period ?? null;
                        $timeliness = optional($item->hIPCR)->timeliness ?? null;
                        $efficiency1 = optional($item->hIPCR)->efficiency1 ?? null;
                        $mfo_desc = optional($programAndProject)->MFO->mfo_desc ?? null;
                        $paps_desc = optional($programAndProject)->paps_desc ?? null;
                        break;

                    case 'hspcr':
                        $divisionOutput = optional(optional($item->hSPCR)->hospitalDivisionOutput);
                        // dd($divisionOutput);
                        $hospitalOutput = optional($divisionOutput)->hospitalOutput;
                        $programAndProject = optional($hospitalOutput)->programAndProject;
                        $output = optional($item->hSPCR)->output;
                        $idifo = optional($item->hSPCR)->id ?? null;
                        $individual_output = optional($item->hSPCR)->output ?? null;
                        $performance_measure = optional($item->hSPCR)->performance_measure ?? null;
                        $prescribed_period = optional($item->hSPCR)->prescribed_period ?? null;
                        $timeliness = optional($item->hSPCR)->timeliness ?? null;
                        $efficiency1 = optional($item->hSPCR)->efficiency1 ?? null;
                        $mfo_desc = optional($programAndProject)->MFO->mfo_desc ?? null;
                        $paps_desc = optional($programAndProject)->paps_desc ?? null;
                        break;

                    case 'hdpcr':
                        $hospitalOutput = optional(optional($item->hDPCR)->hospitalOutput);
                        $programAndProject = optional($hospitalOutput)->programAndProject;
                        $output = optional($item->hDPCR)->output;
                        $idifo = optional($item->hDPCR)->id ?? null;
                        $individual_output = optional($item->hDPCR)->output ?? null;
                        $performance_measure = optional($item->hDPCR)->performance_measure ?? null;
                        $prescribed_period = optional($item->hDPCR)->prescribed_period ?? null;
                        $timeliness = optional($item->hDPCR)->timeliness ?? null;
                        $efficiency1 = optional($item->hDPCR)->efficiency1 ?? null;
                        $mfo_desc = optional($programAndProject)->MFO->mfo_desc ?? null;
                        $paps_desc = optional($programAndProject)->paps_desc ?? null;
                        break;

                    case 'hpcr':
                        $programAndProject = optional(optional($item->hpcr)->programAndProject);
                        $output = optional($item->hpcr)->output;
                        $idifo = optional($item->hpcr)->id ?? null;
                        $individual_output = optional($item->hpcr)->output ?? null;
                        $performance_measure = optional($item->hpcr)->performance_measure ?? null;
                        $prescribed_period = optional($item->hpcr)->prescribed_period ?? null;
                        $timeliness = optional($item->hpcr)->timeliness ?? null;
                        $efficiency1 = optional($item->hpcr)->efficiency1 ?? null;
                        $mfo_desc = optional($programAndProject)->MFO->mfo_desc ?? null;
                        $paps_desc = optional($programAndProject)->paps_desc ?? null;
                        break;
                }
                $remarks = trim($item->remarks);
                $identifier = trim($item->identifier);
                return [
                    'sem_id' => $item->ipcr_semestral_id,
                    'id' => $item->id,
                    'mfo_desc' => $mfo_desc,
                    'paps_desc' => $paps_desc,
                    'output' => $output,
                    'idifo' => $idifo,
                    'individual_output' => $individual_output,
                    'performance_measure' => $performance_measure,
                    'prescribed_period' => $prescribed_period,
                    'timeliness' => $timeliness,
                    'efficiency1' => $efficiency1,
                    'remarks' => empty($remarks)
                        ? $identifier
                        : (empty($identifier) ? $remarks : "$remarks ($identifier)"),
                ];
            });
        // dd($data, $request->ipcr_sem_id, $request->type);
        return $data->concat($get_ifo);
    }


    public function getIfoTargetPrint(Request $request, $type, $id)
    {
        // dd($id);

        return IpcrTarget::select(
                'individual_final_outputs.id AS individual_final_output_id',
                'ipcr_targets.id',
                'ipcr_targets.ipcr_type',
                'ipcr_targets.remarks',
                'individual_final_outputs.individual_output',
                'individual_final_outputs.performance_measure',
                'individual_final_outputs.prescribed_period',
                'individual_final_outputs.timeliness',
                'individual_final_outputs.efficiency1',
                'ipcr_targets.is_additional_target',
                'divisions.division_name1 AS division',
                'division_outputs.output AS div_output',
                'major_final_outputs.mfo_desc',
                'major_final_outputs.FFUNCCOD',
                'ipcr_targets.slug',
                'ipcr_targets.year',
                // 'sub_mfos.submfo_description',
                'major_final_outputs.department_code',
                'ipcr_targets.ipcr_semestral_id',
                'program_and_projects.paps_desc',
            )
            ->leftjoin('individual_final_outputs', 'individual_final_outputs.id', 'ipcr_targets.individual_final_output_id')
            ->leftjoin('division_outputs', 'division_outputs.id', 'individual_final_outputs.idDPCR')
            ->leftjoin('divisions', 'divisions.id', 'division_outputs.division_id')
            ->leftjoin('major_final_outputs', 'major_final_outputs.id', 'division_outputs.idmfo')
            ->leftjoin('program_and_projects', 'program_and_projects.id', 'division_outputs.idpaps')
            ->where('ipcr_targets.ipcr_type', $type)
            // ->leftjoin('sub_mfos', 'sub_mfos.id', 'individual_final_outputs.idsubmfo')

            // ->where('ipcr_targets.employee_code', $emp_code)
            ->where('ipcr_targets.ipcr_semestral_id', $id)
            ->orderBy('ipcr_type')
            ->orderBy('individual_final_outputs.id')
            ->get()
            ->map(function($item){
                // return [
                //     'id' => $item->id,
                //     'output' => $item->individual_output,
                //     'year' => $item->year,
                //     'semester' => $item->semester,
                //     'type' => $item->ipcr_type,
                //     'slug' => $item->slug,
                //     'performance_measure' => $item->performance_measure,
                //     'efficiency1' => $item->efficiency1,
                //     'timeliness' => $item->timeliness,
                //     'individual_output' => $item->individual_output,
                //     'prescribed_period' => $item->prescribed_period,
                //     'pcr_type' => $item->pcr_type,
                //     'remarks' => $item->remarks,
                // ];
                return [
                    'sem_id' => $item->ipcr_semestral_id,
                    'id' => $item->id,
                    'mfo_desc' => $item->mfo_desc,
                    'paps_desc' => $item->paps_desc,
                    'output' => $item->output,
                    'idifo' => $item->idifo,
                    'individual_output' => $item->individual_output,
                    'performance_measure' => $item->performance_measure,
                    'prescribed_period' => $item->prescribed_period,
                    'timeliness' => $item->timeliness,
                    'efficiency1' => $item->efficiency1,
                    'remarks' => " ",
                ];
            });
    }
}
