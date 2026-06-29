<?php

namespace App\Http\Controllers;

use App\Models\Division;
use App\Models\DivisionOutput;
use App\Models\EmployeeSpecialDepartment;
use Illuminate\Http\Request;
use App\Models\hospital_division_output;
use App\Models\hospital_individual_output;
use App\Models\hospital_output;
use App\Models\hospital_section_output;
use App\Models\HospitalTarget;
use App\Models\IndividualFinalOutput;
use App\Models\Ipcr_Semestral;
use App\Models\IpcrTarget;
use App\Models\MonthlyTarget;
use App\Models\ProbationaryTemporaryEmployees;
use App\Models\UserEmployees;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class HospitalTargetController extends Controller
{
    //
    protected $hosp_out;
    protected $hosp_sec_out;
    protected $hospital_division_output;
    protected $hospital_individual_output;

    public function __construct(
        hospital_output $hosp_out,
        hospital_section_output $hosp_sec_out,
        hospital_division_output $hospital_division_output,
        hospital_individual_output $hospital_individual_output
    ) {
        $this->hosp_out = $hosp_out;
        $this->hosp_sec_out = $hosp_sec_out;
        $this->hospital_division_output = $hospital_division_output;
        $this->hospital_individual_output = $hospital_individual_output;
    }

    public function index(Request $request, $slug)
    {
        // dd("hospital target");
        // dd($request);
        try {

            $sem = Ipcr_Semestral::with(['probationaryTemporaryEmployee'])
                ->where('slug', $slug)
                ->first();
            // dd($sem);
            // dd($slug);
            $id = $sem->id;
            $emp_code = $sem->employee_code;
            $user = auth()->user()->userEmployee;
            $designated_division_head = $user->DesignatedDivisionHead;
            $is_div_head = false;
            // dd($designated_division_head);
            // dd($user);
            $auth_code = $user->empl_id;

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
            $pcr_type = employee_division_head($emp_code);
            // dd($pcr_type);
            $data = $this->getHospitalOutputTarget($request, $emp_code, $id, $pcr_type);
            // if ($pcr_type == 'hos') {
            // } else if ($pcr_type == 'hdiv') {
            // }
            // dd($pcr_type);
            // dd($data);
            // if (intval($sg) >= 22 || isset($designated_division_head)) {
            //     // dd("user tagged as designated division head");
            //     $is_div_head = true;
            //     $data = $this->getDPCRTarget($request, $emp_code, $id);
            //     // dd($data);
            // } else {
            //     $data = $this->getIfoTarget($request, $emp_code, $id);
            // }


            // $data = Individual
            // $data
            // dd($data);
            // dd($id);
            // $data = IPCRTargets::where('i_p_c_r_targets.ipcr_semester_id', $id)
            //     ->get();
            // dd($data->pluck('ipcr_code'));
            // dd($data);
            return inertia('Targets/Hospital/Index', [
                "slug" => $slug,
                "sem" => $sem,
                "id" => $id,
                "data" => $data,
                "division" => $division,
                "emp" => $emp,
                "filters" => $request->only(['search']),
                "is_div_head" => $is_div_head,
                "pcr_type" => $pcr_type,
                'desig_data' => $designated_division_head
            ]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function getHospitalOutputTarget(Request $request, $emp_code, $id, $pcr_type)
    {
        // dd($id, $emp_code);
        $ipcr_target_capitol = $this->getIfoTarget($request, $emp_code, $id);
        // dd($ipcr_target_capitol);
        // dd(HospitalTarget::with(['hpcr', 'hDPCR', 'dpcr', 'hSPCR', 'ipcr', 'hIPCR'])
        //     // ->leftjoin('sub_mfos', 'sub_mfos.id', 'individual_final_outputs.idsubmfo')
        //     ->where('hospital_targets.employee_code', $emp_code)
        //     ->where('hospital_targets.ipcr_semestral_id', $id)
        //     // ->when($request->search, function ($query, $searchValue) {
        //     //     // dd($searchValue);
        //     //     return $query->where(function ($query) use ($searchValue) {
        //     //         $query->where('dpcr_targets.output', 'LIKE', '%' . $searchValue . '%')
        //     //             ->orWhere('dpcr_targets.performance_measure', 'LIKE', '%' . $searchValue . '%');
        //     //         // ->orWhere('dpcr_targets.ipcr_code', 'LIKE', '%' . $searchValue . '%');
        //     //     });
        //     // })
        //     ->orderBy('type')
        //     ->orderBy('id')
        //     ->get()
        //     // use ($pcr_type)
        //     ->map(function ($item) use ($pcr_type) {
        //         // dd($item, $pcr_type);
        //         if ($pcr_type == 'hos') {
        //             return [
        //                 'id' => $item->id,
        //                 'output' => $item->hpcr ? $item->hpcr->output : null,
        //                 'year' => $item->year,
        //                 'semester' => $item->semester,
        //                 'type' => $item->type,
        //                 'slug' => $item->slug,
        //                 'performance_measure' => $item->hpcr ? $item->hpcr->performance_measure : null,
        //                 'efficiency1' => $item->hpcr ? $item->hpcr->efficiency1 : null,
        //                 'timeliness' => $item->hpcr ? $item->hpcr->timeliness : null,
        //                 'individual_output' => $item->hpcr ? $item->hpcr->individual_output : null,
        //                 'prescribed_period' => $item->hpcr ? $item->hpcr->prescribed_period : null,
        //                 'pcr_type' => 'hpcr',
        //                 'remarks' => $item->remarks,
        //             ];
        //         } else if ($pcr_type == 'hdiv') {
        //             // dd($item);
        //             $pcr_type = $item->idHDPCR ? 'hdpcr' : ($item->idDPCR ? 'dpcr' : null);
        //             $output = $item->hDPCR ? $item->hDPCR->output : ($item->idDPCR ? $item->dpcr->output : null);
        //             $performance_measure = $item->hDPCR ? $item->hDPCR->performance_measure : ($item->idDPCR ? $item->dpcr->performance_measure : null);
        //             $efficiency1 = $item->hDPCR ? $item->hDPCR->efficiency1 : ($item->idDPCR ? $item->dpcr->efficiency1 : null);
        //             $timeliness = $item->hDPCR ? $item->hDPCR->timeliness : ($item->idDPCR ? $item->dpcr->timeliness : null);
        //             $individual_output = $item->hDPCR ? $item->hDPCR->individual_output : ($item->idDPCR ? $item->dpcr->individual_output : null);
        //             $prescribed_period = $item->hDPCR ? $item->hDPCR->prescribed_period : ($item->idDPCR ? $item->dpcr->prescribed_period : null);
        //             // $slug = $item->hDPCR ? $item->hDPCR->slug : ($item->idDPCR ? $item->DPCR->slug : null);
        //             return [
        //                 'id' => $item->id,
        //                 'output' => $output,
        //                 'year' => $item->year,
        //                 'semester' => $item->semester,
        //                 'type' => $item->type,
        //                 'slug' => $item->slug,
        //                 'performance_measure' => $performance_measure,
        //                 'efficiency1' => $efficiency1,
        //                 'timeliness' => $timeliness,
        //                 'individual_output' => $individual_output,
        //                 'prescribed_period' => $prescribed_period,
        //                 'pcr_type' => $pcr_type,
        //                 'remarks' => $item->remarks,
        //             ];
        //         } else if ($pcr_type == 'hsec') {
        //             // dd($item);
        //             // dd("hsec");
        //             // if($item->type=='Support Function'){
        //             //     dd($item);
        //             // }
        //             if($item->pcr_type == 'hipcr'){
        //                 $output = $item->hIPCR ? $item->hIPCR->output  : null;
        //                 $performance_measure = $item->hIPCR ? $item->hIPCR->performance_measure : null;
        //                 $efficiency1 = $item->hIPCR ? $item->hIPCR->efficiency1 : null;
        //                 $timeliness = $item->hIPCR ? $item->hIPCR->timeliness : null;
        //                 $individual_output = $item->hIPCR ? $item->hIPCR->individual_output : null;
        //                 $prescribed_period = $item->hIPCR ? $item->hIPCR->prescribed_period : null;
        //                 $pcr_type = 'hipcr';
        //                 // dd($item->pcr_type);

        //                 if($item->pcr_type != 'hspcr'){
        //                     $pcr_type = $item->pcr_type;
        //                 }
        //                 return [
        //                     'id' => $item->id,
        //                     'output' => $output,
        //                     'year' => $item->year,
        //                     'semester' => $item->semester,
        //                     'type' => $item->type,
        //                     'slug' => $item->slug,
        //                     'performance_measure' => $performance_measure,
        //                     'efficiency1' => $efficiency1,
        //                     'timeliness' => $timeliness,
        //                     'individual_output' => $individual_output,
        //                     'prescribed_period' => $prescribed_period,
        //                     'pcr_type' => $pcr_type,
        //                     'remarks' => $item->remarks,
        //                 ];
        //             }if($item->pcr_type == 'ipcr'){
        //                 $output = $item->ipcr ? $item->ipcr->individual_output  : null;
        //                 $performance_measure = $item->ipcr ? $item->ipcr->performance_measure : null;
        //                 $efficiency1 = $item->ipcr ? $item->ipcr->efficiency1 : null;
        //                 $timeliness = $item->ipcr ? $item->ipcr->timeliness : null;
        //                 $individual_output = $item->ipcr ? $item->ipcr->individual_output : null;
        //                 $prescribed_period = $item->ipcr ? $item->ipcr->prescribed_period : null;
        //                 $pcr_type = 'ipcr';
        //                 // dd($item->pcr_type);

        //                 if($item->pcr_type != 'hspcr'){
        //                     $pcr_type = $item->pcr_type;
        //                 }
        //                 return [
        //                     'id' => $item->id,
        //                     'output' => $output,
        //                     'year' => $item->year,
        //                     'semester' => $item->semester,
        //                     'type' => $item->type,
        //                     'slug' => $item->slug,
        //                     'performance_measure' => $performance_measure,
        //                     'efficiency1' => $efficiency1,
        //                     'timeliness' => $timeliness,
        //                     'individual_output' => $individual_output,
        //                     'prescribed_period' => $prescribed_period,
        //                     'pcr_type' => $pcr_type,
        //                     'remarks' => $item->remarks,
        //                 ];
        //             }else{
        //                 $output = $item->hSPCR ? $item->hSPCR->output  : null;
        //                 $performance_measure = $item->hSPCR ? $item->hSPCR->performance_measure : null;
        //                 $efficiency1 = $item->hSPCR ? $item->hSPCR->efficiency1 : null;
        //                 $timeliness = $item->hSPCR ? $item->hSPCR->timeliness : null;
        //                 $individual_output = $item->hSPCR ? $item->hSPCR->individual_output : null;
        //                 $prescribed_period = $item->hSPCR ? $item->hSPCR->prescribed_period : null;
        //                 // $slug = $item->hDPCR ? $item->hDPCR->slug : ($item->idDPCR ? $item->DPCR->slug : null);
        //                 // dd($item->pcr_type);
        //                 return [
        //                     'id' => $item->id,
        //                     'output' => $output,
        //                     'year' => $item->year,
        //                     'semester' => $item->semester,
        //                     'type' => $item->type,
        //                     'slug' => $item->slug,
        //                     'performance_measure' => $performance_measure,
        //                     'efficiency1' => $efficiency1,
        //                     'timeliness' => $timeliness,
        //                     'individual_output' => $individual_output,
        //                     'prescribed_period' => $prescribed_period,
        //                     'pcr_type' => 'hspcr',
        //                     'remarks' => $item->remarks,
        //                 ];
        //             }

        //         } else if ($pcr_type == 'hemp') {
        //             // dd($item);
        //             $pcr_type = 'ipcr';
        //             if ($item->idIPCR) {
        //                 $output = $item->ipcr ? $item->ipcr->individual_output  : null;
        //                 $performance_measure = $item->ipcr ? $item->ipcr->performance_measure : null;
        //                 $efficiency1 = $item->ipcr ? $item->ipcr->efficiency1 : null;
        //                 $timeliness = $item->ipcr ? $item->ipcr->timeliness : null;
        //                 $individual_output = $item->ipcr ? $item->ipcr->individual_output : null;
        //                 $prescribed_period = $item->ipcr ? $item->ipcr->prescribed_period : null;
        //                 $pcr_type = 'ipcr';
        //             }
        //             if ($item->idHIPCR) {
        //                 $output = $item->hIPCR ? $item->hIPCR->output  : null;
        //                 $performance_measure = $item->hIPCR ? $item->hIPCR->performance_measure : null;
        //                 $efficiency1 = $item->hIPCR ? $item->hIPCR->efficiency1 : null;
        //                 $timeliness = $item->hIPCR ? $item->hIPCR->timeliness : null;
        //                 $individual_output = $item->hIPCR ? $item->hIPCR->individual_output : null;
        //                 $prescribed_period = $item->hIPCR ? $item->hIPCR->prescribed_period : null;
        //                 $pcr_type = 'hipcr';
        //             }

        //             return [
        //                 'id' => $item->id,
        //                 'output' => $output,
        //                 'year' => $item->year,
        //                 'semester' => $item->semester,
        //                 'type' => $item->type,
        //                 'slug' => $item->slug,
        //                 'performance_measure' => $performance_measure,
        //                 'efficiency1' => $efficiency1,
        //                 'timeliness' => $timeliness,
        //                 'individual_output' => $individual_output,
        //                 'prescribed_period' => $prescribed_period,
        //                 'pcr_type' => $pcr_type,
        //                 'remarks' => $item->remarks,
        //             ];
        //         }
        //     }));
        // dd(HospitalTarget::where('hospital_targets.employee_code', $emp_code)
        //     ->where('hospital_targets.ipcr_semestral_id', $id)->get(),config('database.connections.mysql'), $id);
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
                        'id' => $item->id,
                        'output' => $item->hpcr ? $item->hpcr->output : null,
                        'year' => $item->year,
                        'semester' => $item->semester,
                        'type' => $item->type,
                        'slug' => $item->slug,
                        'performance_measure' => $item->hpcr ? $item->hpcr->performance_measure : null,
                        'efficiency1' => $item->hpcr ? $item->hpcr->efficiency1 : null,
                        'timeliness' => $item->hpcr ? $item->hpcr->timeliness : null,
                        'individual_output' => $item->hpcr ? $item->hpcr->individual_output : null,
                        'prescribed_period' => $item->hpcr ? $item->hpcr->prescribed_period : null,
                        'pcr_type' => 'hpcr',
                        'remarks' => $item->remarks,
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
                    // if($item->type=='Support Function'){
                    //     dd($item);
                    // }
                    if ($item->pcr_type == 'hipcr') {
                        $output = $item->hIPCR ? $item->hIPCR->output  : null;
                        $performance_measure = $item->hIPCR ? $item->hIPCR->performance_measure : null;
                        $efficiency1 = $item->hIPCR ? $item->hIPCR->efficiency1 : null;
                        $timeliness = $item->hIPCR ? $item->hIPCR->timeliness : null;
                        $individual_output = $item->hIPCR ? $item->hIPCR->individual_output : null;
                        $prescribed_period = $item->hIPCR ? $item->hIPCR->prescribed_period : null;
                        $pcr_type = 'hipcr';
                        // dd($item->pcr_type);

                        if ($item->pcr_type != 'hspcr') {
                            $pcr_type = $item->pcr_type;
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
                    if ($item->pcr_type == 'ipcr') {
                        $output = $item->ipcr ? $item->ipcr->individual_output  : null;
                        $performance_measure = $item->ipcr ? $item->ipcr->performance_measure : null;
                        $efficiency1 = $item->ipcr ? $item->ipcr->efficiency1 : null;
                        $timeliness = $item->ipcr ? $item->ipcr->timeliness : null;
                        $individual_output = $item->ipcr ? $item->ipcr->individual_output : null;
                        $prescribed_period = $item->ipcr ? $item->ipcr->prescribed_period : null;
                        $pcr_type = 'ipcr';
                        // dd($item->pcr_type);

                        if ($item->pcr_type != 'hspcr') {
                            $pcr_type = $item->pcr_type;
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
                    } else {
                        $output = $item->hSPCR ? $item->hSPCR->output  : null;
                        $performance_measure = $item->hSPCR ? $item->hSPCR->performance_measure : null;
                        $efficiency1 = $item->hSPCR ? $item->hSPCR->efficiency1 : null;
                        $timeliness = $item->hSPCR ? $item->hSPCR->timeliness : null;
                        $individual_output = $item->hSPCR ? $item->hSPCR->individual_output : null;
                        $prescribed_period = $item->hSPCR ? $item->hSPCR->prescribed_period : null;
                        // $slug = $item->hDPCR ? $item->hDPCR->slug : ($item->idDPCR ? $item->DPCR->slug : null);
                        // dd($item->pcr_type);
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
                    $output="";
                    $performance_measure="";
                    $efficiency1="";
                    $timeliness="";
                    $individual_output="";
                    $prescribed_period="";
                    $pcr_type="";
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
        // dd($ipcr_target_capitol);
        return $main->concat($ipcr_target_capitol);
    }
    public function getIfoTarget(Request $request, $emp_code, $id)
    {
        // dd($id);
        // dd($emp_code, $id, config('database.connections.mysql'));
        $ipcr_target = IpcrTarget::select(
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
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'output' => $item->individual_output,
                    'year' => $item->year,
                    'semester' => $item->semester,
                    'type' => $item->ipcr_type,
                    'slug' => $item->slug,
                    'performance_measure' => $item->performance_measure,
                    'efficiency1' => $item->efficiency1,
                    'timeliness' => $item->timeliness,
                    'individual_output' => $item->individual_output,
                    'prescribed_period' => $item->prescribed_period,
                    'pcr_type' => $item->pcr_type,
                    'remarks' => $item->remarks,
                ];
            });
        return $ipcr_target;
    }
    public function ipcr_for_reference()
    {
        // $ipcrs = IndividualFinalOutput::select(
        //     'individual_final_outputs.id AS individual_final_output_id',
        //     'individual_final_outputs.id',
        //     'individual_final_outputs.individual_output',
        //     'individual_final_outputs.performance_measure',
        //     'individual_final_outputs.efficiency1',
        //     'individual_final_outputs.timeliness',
        //     'individual_final_outputs.type',
        //     'divisions.division_name1 AS division',
        //     'division_outputs.output AS div_output',
        //     'major_final_outputs.mfo_desc',
        //     'major_final_outputs.FFUNCCOD',
        //     'individual_final_outputs.prescribed_period',
        //     'major_final_outputs.department_code'
        // )
        //     ->leftjoin('division_outputs', 'division_outputs.id', 'individual_final_outputs.idDPCR')
        //     ->leftjoin('divisions', 'divisions.id', 'division_outputs.division_id')
        //     ->leftjoin('program_and_projects', 'program_and_projects.id', 'division_outputs.idpaps')
        //     ->leftjoin('major_final_outputs', 'major_final_outputs.id', 'program_and_projects.idmfo')
        //     ->whereNested(function ($query) use ($dept_code, $desig_dept) {
        //         $query->where('individual_final_outputs.department_code', '=', $dept_code)
        //             // ->orWhere('major_final_outputs.department_code', '=', '')
        //             // ->orWhere('major_final_outputs.department_code', '=', $desig_dept)
        //             // ->orWhere('major_final_outputs.department_code', '=', '0')
        //             // ->orWhere('major_final_outputs.department_code', '=', '-')
        //             ->orWhere('individual_final_outputs.type', 'Common')
        //             ->when($dept_code >= 20 && $dept_code <= 24, function ($query) {
        //                 $query->orWhere('individual_final_outputs.department_code', '=', '20');
        //             });
        //     })
        //     ->whereNotIn('individual_final_outputs.id', $existingTargets)
        //     ->orderBy('individual_final_outputs.type', 'ASC')
        //     ->orderBy('individual_final_outputs.id', 'ASC')
        //     ->get();

        // if ($special_dept) {

        //     // $sp = IndividualFinalOutput::select(
        //     //     'individual_final_outputs.id AS individual_final_output_id',
        //     //     'individual_final_outputs.id',
        //     //     'individual_final_outputs.individual_output',
        //     //     'individual_final_outputs.performance_measure',
        //     //     'individual_final_outputs.efficiency1',
        //     //     'individual_final_outputs.timeliness',
        //     //     'individual_final_outputs.type',
        //     //     'divisions.division_name1 AS division',
        //     //     'division_outputs.output AS div_output',
        //     //     'major_final_outputs.mfo_desc',
        //     //     'major_final_outputs.FFUNCCOD',
        //     //     'individual_final_outputs.prescribed_period',
        //     //     // 'sub_mfos.submfo_description',
        //     //     'major_final_outputs.department_code'
        //     // )
        //     //     //
        //     //     ->leftjoin('division_outputs', 'division_outputs.id', 'individual_final_outputs.idDPCR')
        //     //     ->leftjoin('divisions', 'divisions.id', 'division_outputs.division_id')
        //     //     ->leftjoin('program_and_projects', 'program_and_projects.id', 'division_outputs.idpaps')
        //     //     ->leftjoin('major_final_outputs', 'major_final_outputs.id', 'program_and_projects.idmfo')
        //     //     // ->leftjoin('sub_mfos', 'sub_mfos.id', 'individual_final_outputs.idsubmfo')
        //     //     ->orderBy('individual_final_outputs.type', 'ASC')
        //     //     ->orderBy('individual_final_outputs.id', 'ASC')
        //     //     ->get();
        //     // $sp_dpcrs = DivisionOutput::select(
        //     //     'division_outputs.id',
        //     //     'division_outputs.output',
        //     // )
        //     //     ->get();
        //     // $dpcrs = $dpcrs->concat($sp_dpcrs);
        //     // $ipcrs = $ipcrs->concat($sp);
        // }
    }
    public function create(Request $request, $slug)
    {
        // dd($request->all());
        $sem = Ipcr_Semestral::where('slug', $slug)
            ->first();
        // SEMEESTRAL ID
        $id = auth()->user()->username;
        $emp_id = $sem->employee_code;
        //CHECK FOR ID INTEGRITY
        if ($emp_id != $id) {
            return redirect('/forbidden')->with('error', 'You are not allowed to edit this IPCR');
        }
        // GET TYPE
        $pcr_type = employee_division_head($sem->employee_code);
        // dd($pcr_type);
        //SET FULL TYPE DISPLAY
        $type_full = "HPCR";
        if ($pcr_type == 'hos') {
            $type_full = "HPCR";
        } else if ($pcr_type == 'hsec') {
            $type_full = "HSPCR";
        } else if ($pcr_type == 'hdiv') {
            $type_full = "HDPCR";
        } else if ($pcr_type == 'hemp') {
            $type_full = "HIPCR";
        }
        if (!$sem) {
            return redirect()->back()->with('error', 'The ' . $type_full . ' does not exist.');
        }
        $id = $sem->id;
        $emp_code = $sem->employee_code;
        $emp = UserEmployees::where('empl_id', $emp_code)
            ->first();
        // dd($emp);
        $dept_code = $emp->department_code;
        $desig_dept = $emp->designate_department_code;
        // dd($emp);
        $foreign_key = 'id' . $type_full;
        // dd($foreign_key . ' ' . $id);
        $existingTargets = $this->getExistingTargets($id, $foreign_key);
        // dd($existingTargets);
        $special_dept = EmployeeSpecialDepartment::where('employee_code', Auth::user()->username)->first();
        $pcrs = $this->getPCRS($existingTargets, $dept_code, $desig_dept, $special_dept, $pcr_type);
        // dd($pcr_type);
        // dd($pcrs);
        return inertia('Targets/Hospital/Create', [
            "id" => $id,
            "filters" => $request->only(['search']),
            "emp" => $emp,
            "pcrs" => $pcrs,
            "pcr_type" => $pcr_type,
            // "dpcrs" => $dpcrs,
            "is_additional_target" => 0,
            "sem" => $sem,
            "slug" => $slug
        ]);
    }

    private function getExistingTargets($id, $foreign_key)
    {
        // dd($foreign_key);
        if ($foreign_key == 'idHDPCR') {
            return HospitalTarget::where('ipcr_semestral_id', $id)
                ->select('idDPCR', $foreign_key)
                ->get();
        } else if ($foreign_key == 'idHIPCR') {
            return HospitalTarget::where('ipcr_semestral_id', $id)
                ->select('idIPCR', $foreign_key)
                ->get();
        } else {
            return HospitalTarget::where('ipcr_semestral_id', $id)
                ->select($foreign_key)
                ->get();
        }
    }
    public function getPCRS($existingTargets, $dept_code, $desig_dept, $special_dept, $pcr_type)
    {
        // dd($pcr_type);
        if ($pcr_type == 'hos') {
            $pcrs = $this->getHPCRS($existingTargets, $dept_code, $desig_dept);
        } else if ($pcr_type == 'hdiv') {
            $pcrs = $this->getHDPCRS($existingTargets, $dept_code, $desig_dept);
        } else if ($pcr_type == 'hsec') {
            $pcrs = $this->getHSPCRS($existingTargets, $dept_code, $desig_dept);
        } else {
            $pcrs = $this->getHIPCRS($existingTargets, $dept_code, $desig_dept);
        }
        return $pcrs;
    }
    public function getHPCRS($existingTargets, $dept_code, $desig_dept)
    {
        $main_query = hospital_output::with(['programAndProject',  'programAndProject.MFO'])
            ->whereNotIn('id', $existingTargets)
            // ->where(function ($query) use ($dept_code, $desig_dept) {
            //     $query->where('department_code', '=', $dept_code);
            // })
            // ->orderBy('type')
            ->orderBy('id')
            ->get()
            ->map(function ($item) {

                return [
                    // 'id' => $item->id,
                    'id' => $item->id,
                    'output' => $item->output,
                    'performance_measure' => $item->performance_measure,
                    'efficiency1' => $item->efficiency1,
                    'timeliness' => $item->timeliness,
                    // 'item_type' => $item->type,
                    // 'division' => $item->hpcr ? $item->hpcr->programAndProject->division->division_name1 : null,
                    'major_final_output_id' => $item->programAndProject ? ($item->programAndProject->MFO ? $item->programAndProject->MFO->mfo_desc : null) : null,
                    'FFUNCCOD' => $item->hpcr ? ($item->programAndProject ? $item->hpcr->programAndProject->MFO->FFUNCCOD : null) : null,
                    'prescribed_period' => $item->hpcr ? $item->hpcr->prescribed_period : null,
                    'department_code' => $item->hpcr ? ($item->hpcr->programAndProject ?
                        ($item->hpcr->programAndProject->MFO ? $item->hpcr->programAndProject->MFO->department_code : null)
                        : null)
                        : null,
                    'type' => 'hpcr',
                    'mfo' => optional(optional($item->programAndProject)->MFO)->mfo_desc
                ];
            });

        return $main_query;
    }
    public function getHDPCRS($existingTargets, $dept_code, $desig_dept)
    {
        $type = 'dpcr';
        $existingHDPCRS = $existingTargets->pluck('idHDPCR')->toArray();
        $existingDPCRS = $existingTargets->pluck('idDPCR')->toArray();
        $existingHDPCRS = array_filter($existingHDPCRS);
        $existingDPCRS = array_filter($existingDPCRS);
        $division = $dpcrs = DivisionOutput::select(
            // 'division_outputs.id AS individual_final_output_id',
            'division_outputs.id',
            'division_outputs.output',
            'division_outputs.performance_measure',
            'division_outputs.efficiency1',
            'division_outputs.timeliness',

            'major_final_outputs.mfo_desc',
            'major_final_outputs.FFUNCCOD',
            'division_outputs.prescribed_period',
            'major_final_outputs.department_code',
            DB::raw("'" . $type . "' AS type")
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
                        $query->orWhere('major_final_outputs.department_code', '=', '20');
                    });
            })
            ->whereNotIn('division_outputs.id', $existingDPCRS)
            ->orderBy('division_outputs.id', 'ASC')
            ->get();
        // dd($existingHDPCRS);

        $main_query = hospital_division_output::with(['hospitalOutput', 'hospitalOutput.programAndProject',  'hospitalOutput.programAndProject.MFO'])
            ->whereNotIn('id', $existingHDPCRS)
            // ->where(function ($query) use ($dept_code, $desig_dept) {
            //     $query->where('department_code', '=', $dept_code);
            // })
            // ->orderBy('type')
            ->orderBy('id')
            ->get()
            ->map(function ($item) {
                return [
                    // 'id' => $item->id,
                    'id' => $item->id,
                    'output' => $item->output,
                    'performance_measure' => $item->performance_measure,
                    'efficiency1' => $item->efficiency1,
                    'timeliness' => $item->timeliness,
                    'mfo_desc' => optional(optional($item->hospitalOutput)->programAndProject)->MFO,
                    // 'type' => $item->type,
                    'major_final_output_id' => $item->hospitalOutput ? ($item->hospitalOutput->programAndProject ? ($item->hospitalOutput->programAndProject->MFO ? $item->hospitalOutput->programAndProject->MFO->mfo_desc : null) : null) : null,
                    'FFUNCCOD' => "",
                    'prescribed_period' => $item->hpcr ? $item->hpcr->prescribed_period : null,
                    'department_code' => $item->hpcr ? ($item->hpcr->programAndProject ?
                        ($item->hpcr->programAndProject->MFO ? $item->hpcr->programAndProject->MFO->department_code : null)
                        : null)
                        : null,
                    'type' => 'hdpcr'
                ];
            });
        // dd($main_query);
        $main_query = $main_query->concat($division);
        return $main_query;
    }
    public function getHSPCRS($existingTargets, $dept_code, $desig_dept)
    {
        // dd("hspcrs");
        // dd($existingTargets->pluck('idHSPCR'));
        // dd($existingTargets);
        $existingIds = collect($existingTargets)
            ->pluck('idHSPCR')
            ->filter()          // removes NULL values
            ->values()
            ->toArray();
        $main_query = hospital_section_output::with([
            'hospitalDivisionOutput',
            'hospitalDivisionOutput.hospitalOutput',
            'hospitalDivisionOutput.hospitalOutput.programAndProject',
            'hospitalDivisionOutput.hospitalOutput.programAndProject.MFO'
        ])
            // ->whereNotIn('id', $existingTargets)
            ->when(!empty($existingIds), function ($q) use ($existingIds) {
                $q->whereNotIn('id', $existingIds);
            })
            // ->where(function ($query) use ($dept_code, $desig_dept) {
            //     $query->where('department_code', '=', $dept_code);
            // })
            // ->orderBy('type')

            ->orderBy('id')
            ->get()
            ->map(function ($item) {
                $mfo = optional(
                    optional(
                        optional(
                            optional($item->hospitalDivisionOutput)
                                ->hospitalOutput
                        )->programAndProject
                    )->MFO
                );
                // dd($item);
                return [
                    // 'id' => $item->id,
                    'id' => $item->id,
                    'output' => $item->output,
                    'performance_measure' => $item->performance_measure,
                    'efficiency1' => $item->efficiency1,
                    'timeliness' => $item->timeliness,
                    'type' => $item->type,
                    // 'division' => $item->hpcr ? $item->hpcr->programAndProject->division->division_name1 : null,
                    'major_final_output_id' => optional($mfo)->id, // replace with actual column you want
                    'FFUNCCOD' => optional($mfo)->FFUNCCOD,         // assuming this is a column in MFO
                    'prescribed_period' => $item->prescribed_period,
                    'department_code' => optional($mfo)->department_code,
                    'type' => 'hspcr',
                    'mfo_desc' => $mfo ? $mfo->mfo_desc : ''
                ];
            });

        return $main_query;
    }

    public function getHIPCRS($existingTargets, $dept_code, $desig_dept)
    {
        $type = 'ipcr';
        $existingHIPCRS = [];
        $existingIPCRS = [];
        // dd($existingTargets);
        if (count($existingTargets) > 0) {
            $existingHIPCRS = $existingTargets->pluck('idHIPCR')->toArray();
            $existingIPCRS = $existingTargets->pluck('idIPCR')->toArray();
            $existingHIPCRS = array_filter($existingHIPCRS);
            $existingIPCRS = array_filter($existingIPCRS);
        }
        // dd($desig_dept);
        // dd(count($existingTargets));
        $ipcrs = IndividualFinalOutput::select(
            // 'division_outputs.id AS individual_final_output_id',
            'individual_final_outputs.id',
            'individual_final_outputs.individual_output AS output',
            'individual_final_outputs.performance_measure',
            'individual_final_outputs.efficiency1',
            'individual_final_outputs.timeliness',

            'major_final_outputs.mfo_desc',
            'major_final_outputs.FFUNCCOD',
            'individual_final_outputs.prescribed_period',
            'major_final_outputs.department_code',
            DB::raw("'" . $type . "' AS type")
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
            // ->where('individual_final_outputs.individual_output', 'LIKE', '%Attended Meeting%')
            ->whereNotIn('individual_final_outputs.id', $existingIPCRS)
            ->orderBy('individual_final_outputs.type', 'ASC')
            ->orderBy('individual_final_outputs.id', 'ASC')
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'output' => $item->output,
                    'performance_measure' => $item->performance_measure,
                    'efficiency1' => $item->efficiency1,
                    'timeliness' => $item->timeliness,
                    'major_final_output_id' => $item->id, // or use a different one if needed
                    'FFUNCCOD' => $item->FFUNCCOD,
                    'prescribed_period' => $item->prescribed_period,
                    'department_code' => $item->department_code,
                    'type' => $item->type,
                    'mfo_desc' => $item->mfo_desc
                ];
            });
        // dd($ipcrs);
        // dd($ipcrs[0]);

        $main_query = hospital_individual_output::with([
            // 'hospitalOutput', 'hospitalOutput.programAndProject',  'hospitalOutput.programAndProject.MFO'
            'hospitalSectionOutput',
            'hospitalSectionOutput.hospitalDivisionOutput',
            'hospitalSectionOutput.hospitalDivisionOutput.hospitalOutput',
            'hospitalSectionOutput.hospitalDivisionOutput.hospitalOutput.programAndProject',
            'hospitalSectionOutput.hospitalDivisionOutput.hospitalOutput.programAndProject.MFO'
        ])
            ->whereNotIn('id', $existingHIPCRS)
            // ->where(function ($query) use ($dept_code, $desig_dept) {
            //     $query->where('department_code', '=', $dept_code);
            // })
            // ->orderBy('type')
            ->orderBy('id')
            ->get()
            ->map(function ($item) {
                // dd($item);
                $mfo = optional(
                    optional(
                        optional(
                            optional($item->hospitalSectionOutput)
                                ->hospitalDivisionOutput
                        )->hospitalOutput
                    )->programAndProject
                )->MFO;
                return [
                    // 'id' => $item->id,
                    'id' => $item->id,
                    'output' => $item->output,
                    'performance_measure' => $item->performance_measure,
                    'efficiency1' => $item->efficiency1,
                    'timeliness' => $item->timeliness,
                    // 'type' => $item->type,
                    'major_final_output_id' => optional($mfo)->id, // replace with actual column you want
                    'FFUNCCOD' => optional($mfo)->FFUNCCOD,         // assuming this is a column in MFO
                    'prescribed_period' => $item->prescribed_period,
                    'department_code' => optional($mfo)->department_code,
                    'type' => 'hipcr',
                    'mfo_desc' => $mfo ? $mfo->mfo_desc : ""
                ];
            });
        // dd($main_query);
        $main_query = $main_query->concat($ipcrs);
        // $mq = $main_query->map(function ($item) {
        //     return [
        //         'performance_measure' => $item['output'] . ' \\n**type: ' . $item['type'] . ' \\n**PM: ' . $item['performance_measure'],

        //     ];
        // });
        // dd($mq->pluck('performance_measure'));
        return $main_query;
    }
    //ADDITIONAL TARGETS
    public function additional_create(Request $request, $slug)
    {
        // dd($request->all());
        $sem = Ipcr_Semestral::where('slug', $slug)
            ->first();
        // SEMEESTRAL ID
        $id = auth()->user()->username;
        $emp_id = $sem->employee_code;
        //CHECK FOR ID INTEGRITY
        if ($emp_id != $id) {
            return redirect('/forbidden')->with('error', 'You are not allowed to edit this IPCR');
        }
        // GET TYPE
        $pcr_type = employee_division_head($sem->employee_code);
        //SET FULL TYPE DISPLAY
        $type_full = "HPCR";
        if ($pcr_type == 'hos') {
            $type_full = "HPCR";
        } else if ($pcr_type == 'hsec') {
            $type_full = "HSPCR";
        } else if ($pcr_type == 'hdiv') {
            $type_full = "HDPCR";
        } else if ($pcr_type == 'hemp') {
            $type_full = "HIPCR";
        }
        if (!$sem) {
            return redirect()->back()->with('error', 'The ' . $type_full . ' does not exist.');
        }
        $id = $sem->id;
        $emp_code = $sem->employee_code;
        $emp = UserEmployees::where('empl_id', $emp_code)
            ->first();
        // dd($emp);
        $dept_code = $emp->department_code;
        $desig_dept = $emp->designate_department_code;
        // dd($emp);
        $foreign_key = 'id' . $type_full;
        // dd($foreign_key . ' ' . $id);
        $existingTargets = $this->getExistingTargets($id, $foreign_key);
        // dd($existingTargets);
        $special_dept = EmployeeSpecialDepartment::where('employee_code', Auth::user()->username)->first();
        $pcrs = $this->getPCRS($existingTargets, $dept_code, $desig_dept, $special_dept, $pcr_type);
        return inertia('Targets/Hospital/Create', [
            "id" => $id,
            "filters" => $request->only(['search']),
            "emp" => $emp,
            "pcrs" => $pcrs,
            "pcr_type" => $pcr_type,
            // "dpcrs" => $dpcrs,
            "is_additional_target" => 1,
            "sem" => $sem,
            "slug" => $slug
        ]);
    }
    public function hpcrtargets_review(Request $request, $id, $source)
    {
        // dd("id: " . $id . " source: " . $source , $id,
        // HospitalTarget::find(intval($id)),
        // HospitalTarget::where('id', intval($id))->first()
        // );
        // . " sem: " . $id_sem
        HospitalTarget::find($id)->update(['status' => '0']);
        // $tar = HospitalTarget::where('id', $id)
        //     ->first();
        // $tar->status = "0";
        // $tar->save();
        return back()->with('message', 'Successfully submitted additional target!');
        // return redirect()
    }
    //*****************STORE METHOD */
    // 1.) Identify Storage Type
    // 2.) Call store Method based on type
    // 3.) Validate request
    // 4.) Generate Slug
    // 5.) Store Data
    // 6.) Generate Monthly Target Ratings
    // 7.) Redirect to the page
    // 8.) Return success message
    // 9.) Return to the page
    public function store(Request $request, $id)
    {
        // dd(auth()->user()->id);
        // $user_type = employee_division_head($request->employee_code);

        $this->storeHPCR($request, $id);
        if ($request->is_additional_target == 1) {
            return redirect('/ipcrsemestral/' . auth()->user()->id . '/direct')
                ->with('success', 'HPCR Additional Target created successfully');
        }

        return redirect('/hospital-targets/r/' . $request->slug_sem);
        // }
    }
    public function storeHPCR(Request $request, $id)
    {
        // dd($request);
        $request->validate([
            'ipcr_semestral_id' => 'required',
            'employee_code' => 'required',
            'idHPCR' => 'required',
            'type' => 'required',
            'pcr_type' => 'required',
            // 'remarks' => 'required',

            'idHIPCR' => Rule::requiredIf($request->pcr_type === 'hipcr'),
            'idHDPCR' => Rule::requiredIf($request->pcr_type === 'hdpcr'),
            'idHSPCR' => Rule::requiredIf($request->pcr_type === 'hspcr'),
            'idHPCR' => Rule::requiredIf($request->pcr_type === 'hpcr'),
            'idIPCR' => Rule::requiredIf($request->pcr_type === 'ipcr'),
            'idDPCR' => Rule::requiredIf($request->pcr_type === 'dpcr'),
        ]);
        $slug = $this->generateSlugPCR($request->ifo_desc, $request->semester, $request->year);
        $data = new HospitalTarget();
        $data->ipcr_semestral_id = $request->ipcr_semestral_id;
        $data->idHPCR = $request->idHPCR;
        $data->type = $request->type;
        $data->employee_code = $request->employee_code;
        $data->is_additional_target = $request->is_additional_target;
        $data->semester = $request->semester;
        $data->year = $request->year;
        $data->status = $request->status;
        $data->remarks = $request->remarks;
        $data->slug = $slug;
        //INDIVIDUAL
        if ($request->pcr_type === 'hipcr') {
            $data->idHIPCR = $request->idHIPCR;
            $data->pcr_type = 'hipcr';
        }
        // HOSPITAL INDIVIDUAL
        if ($request->pcr_type === 'ipcr') {
            $data->idIPCR = $request->idIPCR;
            $data->pcr_type = 'ipcr';
        }
        //SECTION
        if ($request->pcr_type === 'hspcr') {
            $data->idHSPCR = $request->idHSPCR;
            $data->pcr_type = 'hspcr';
        }
        //HOSPITAL DIVISION
        if ($request->pcr_type === 'hdpcr') {
            $data->idHDPCR = $request->idHDPCR;
            $data->pcr_type = 'hdpcr';
        }
        //DIVISION
        if ($request->pcr_type === 'dpcr') {
            $data->idDPCR = $request->idDPCR;
            $data->pcr_type = 'dpcr';
        }
        //HOSPITAL
        if ($request->pcr_type === 'hpcr') {
            $data->idHPCR = $request->idHPCR;
            $data->pcr_type = 'hpcr';
        }

        $data->identifier = $request->identifier;
        $data->save();

        $mo_rat = $this->generateMonthlyTargetRatings($request->semester, $request->year, $request->ipcr_semestral_id, $request, $request->pcr_type, $data->id);
        // dd($mo_rat);
        // if (intval($request->is_additional_target) > 0) {
        //     return redirect('/ipcrsemestral/r/' . auth()->user()->id . '/direct')
        //         ->with('success', 'HPCR Additional Target created successfully');
        // }

    }
    // public function redirector
    public function generateSlugPCR($desc, $sem, $year)
    {
        //GENERATE SLUG
        $random = Str::random(14);
        $append = substr(preg_replace('/[^a-z1-3]/', '', $random), 0, 7);
        $desc = Str::limit($desc, 100, '');
        $slugBase = Str::slug($desc . '-' . $append . '-' . $sem . '-' . $year);
        $slug = $slugBase;

        $existingSlugs = DB::table('hospital_targets')
            ->where('slug', 'LIKE', $slugBase . '%')
            ->pluck('slug')
            ->toArray();

        if (in_array($slug, $existingSlugs)) {
            do {
                $random = Str::random(20);
                $append = substr(preg_replace('/[^a-z1-3]/', '', $random), 0, 10);
                $slug = $slugBase . '-' . $append;
            } while (in_array($slug, $existingSlugs));
        }

        return $slug;
    }

    public function generateMonthlyTargetRatings($sem, $year, $sem_id, $request, $type, $data_id)
    {
        $sem = Ipcr_Semestral::where('id', $sem_id)->first();
    // dd($sem);
        //used as index
        $mo = "not generated";
        $mo_track = 0;
        $prob_tempo=[];
        if($sem->prob_type=='s'){
            $months = ['1', '2', '3', '4', '5', '6'];
        }else{
            $prob_tempo = ProbationaryTemporaryEmployees::where('sem_id', $sem_id)->first();
            $dates = json_decode($prob_tempo->date_from, true); // convert to array
            $months = array_map(function ($date) {
                return (string) Carbon::parse($date)->month; // "3", "4", etc.
            }, $dates);
        }
        // dd($months);
        $semester_number= $sem->sem;
        foreach ($months as $month) {
            if($sem->prob_type=='s'){
                $month_param = ($semester_number == 1) ? $month : $month + 6;
            }else{
                $month_param = $month;
            }

            $slug = $this->slugMonthly($month_param, $year);

            $existingRecord = MonthlyTarget::where('month', $month)
                ->when($request->idHPCR, function ($query) use ($request) {
                    $query->where('idHPCR', $request->idHPCR);
                })
                // ->when($request->idIPCR, function ($query) use ($request) {
                //     $query->where('idIPCR', $request->idIPCR);
                // })
                // ->when($request->idDPCR, function ($query) use ($request) {
                //     $query->where('idDPCR', $request->idDPCR);
                // })
                ->when($request->idHIPCR, function ($query) use ($request) {
                    $query->where('idHIPCR', $request->idHIPCR);
                })
                ->when($request->idHSPCR, function ($query) use ($request) {
                    $query->where('idHSPCR', $request->idHSPCR);
                })
                ->when($request->idHDPCR, function ($query) use ($request) {
                    $query->where('idHDPCR', $request->idHDPCR);
                })
                ->where('hospital_target_id', $data_id)
                ->where('year', $year)
                ->where('sem_id', $sem_id)
                ->first();
            // dd($existingRecord);
            $is_hospital = '1';
            if ($request->ipcr_target_id || $request->dpcr_target_id) {
                $is_hospital = '0';
            }
            if (!$existingRecord) {
                MonthlyTarget::create([
                    'month' => $month,
                    'year' => $year,
                    'sem_id' => $sem_id,
                    'status' => '-1',
                    'dpcr_target_id' => $request->idDPCR,
                    "ipcr_target_id" => $request->idIPCR,
                    'idHPCR' => $request->idHPCR,
                    'idHSPCR' => $request->idHSPCR,
                    'idHDPCR' => $request->idHDPCR,
                    'idHIPCR' => $request->idHIPCR,
                    'hospital_target_id' => $data_id,
                    'is_hospital' => $is_hospital,
                    'slug' => $slug, // Save the unique slug
                    'type' => $type,
                ]);
            }

            $mo_track += 1;
        }
        if ($mo_track > 1) {
            $mo = "generated";
        }
        return $mo;
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

        // Ensure slug is unique
        while (MonthlyTarget::where('slug', $slug)->exists()) {
            $random = Str::random(10 * 2);
            $append = substr(preg_replace('/[^a-z1-3]/', '', $random), 0, 10);
            // if ($count > 1) {
            $slug = $baseSlug . '-' . $append;
        }
        return $slug;
    }

    public function edit(Request $request, $slug_target, $slug)
    {
        // dd($request->all());
        // dd($slug_target);
        $ht = HospitalTarget::where('slug', $slug_target)
            ->first();
        $sem = Ipcr_Semestral::where('slug', $slug)
            ->first();
        // SEMEESTRAL ID
        $id = auth()->user()->username;
        $emp_id = $sem->employee_code;
        //CHECK FOR ID INTEGRITY
        if ($emp_id != $id) {
            return redirect('/forbidden')->with('error', 'You are not allowed to edit this IPCR');
        }
        // GET TYPE
        $pcr_type = employee_division_head($sem->employee_code);
        //SET FULL TYPE DISPLAY
        $type_full = "HPCR";
        if ($pcr_type == 'hos') {
            $type_full = "HPCR";
        } else if ($pcr_type == 'hsec') {
            $type_full = "HSPCR";
        } else if ($pcr_type == 'hdiv') {
            $type_full = "HDPCR";
        } else if ($pcr_type == 'hemp') {
            $type_full = "HIPCR";
        }
        if (!$sem) {
            return redirect()->back()->with('error', 'The ' . $type_full . ' does not exist.');
        }
        $id = $sem->id;
        $emp_code = $sem->employee_code;
        $emp = UserEmployees::where('empl_id', $emp_code)
            ->first();
        // dd($ht);
        $dept_code = $emp->department_code;
        $desig_dept = $emp->designate_department_code;
        // dd($emp);
        $foreign_key = 'id' . $type_full;
        // EXISTING TARGETS, REMOVE CURRENT TARGET
        $existingTargets = $this->cleanExistingTargets($ht, $this->getExistingTargets($id, $foreign_key));
        // dd($this->getExistingTargets($id, $foreign_key));
        $special_dept = EmployeeSpecialDepartment::where('employee_code', Auth::user()->username)->first();
        $pcrs = $this->getPCRS($existingTargets, $dept_code, $desig_dept, $special_dept, $pcr_type);
        // dd($pcrs);
        return inertia('Targets/Hospital/Create', [
            "editData" => $ht,
            "id" => $id,
            "filters" => $request->only(['search']),
            "emp" => $emp,
            "pcrs" => $pcrs,
            "pcr_type" => $pcr_type,
            // "dpcrs" => $dpcrs,
            "is_additional_target" => 0,
            "sem" => $sem,
            "slug" => $slug
        ]);
    }
    //FOR EDITING
    public function cleanExistingTargets($ht, $existingTargets)
    {
        $edit_idHPCR = $ht->idHPCR;
        $edit_idHSPCR = $ht->idHSPCR;
        $edit_idHDPCR = $ht->idHDPCR;
        $edit_idDPCR = $ht->idDPCR;
        $edit_idIPCR = $ht->idIPCR;
        $edit_idHIPCR = $ht->idHIPCR;
        // dd($existingTargets);
        return collect($existingTargets)->reject(
            fn($t) => (!is_null($edit_idHPCR)   && $t['idHPCR']   == $edit_idHPCR)   ||
                (!is_null($edit_idHSPCR)  && $t['idHSPCR']  == $edit_idHSPCR)  ||
                (!is_null($edit_idHDPCR)  && $t['idHDPCR']  == $edit_idHDPCR)  ||
                (!is_null($edit_idDPCR)   && $t['idDPCR']   == $edit_idDPCR)   ||
                (!is_null($edit_idIPCR)   && $t['idIPCR']   == $edit_idIPCR)   ||
                (!is_null($edit_idHIPCR)  && $t['idHIPCR']  == $edit_idHIPCR)
        )->values();
    }
    public function update(Request $request, $id)
    {
        // dd($request);

        $request->validate([
            'ipcr_semestral_id' => 'required',
            'employee_code' => 'required',
            'idHPCR' => 'required',
            'type' => 'required',
            // 'remarks' => 'required',

            'idHIPCR' => Rule::requiredIf($request->pcr_type === 'hipcr'),
            'idHDPCR' => Rule::requiredIf($request->pcr_type === 'hdpcr'),
            'idHSPCR' => Rule::requiredIf($request->pcr_type === 'hspcr'),
            'idHPCR' => Rule::requiredIf($request->pcr_type === 'hpcr'),
            'idIPCR' => Rule::requiredIf($request->pcr_type === 'ipcr'),
            'idDPCR' => Rule::requiredIf($request->pcr_type === 'dpcr'),
        ]);
        $data = HospitalTarget::findOrFail($request->id);
        $data->ipcr_semestral_id = $request->ipcr_semestral_id;
        $data->idHPCR = $request->idHPCR;
        $data->type = $request->type;
        $data->employee_code = $request->employee_code;
        $data->is_additional_target = $request->is_additional_target;
        $data->semester = $request->semester;
        $data->year = $request->year;
        $data->status = $request->status;
        $data->remarks = $request->remarks;
        $data->slug = $request->slug;
        //INDIVIDUAL
        if ($request->pcr_type === 'hipcr') {
            $data->idHIPCR = $request->idHIPCR;
            $data->pcr_type = 'hipcr';
        }
        if ($request->pcr_type === 'ipcr') {
            $data->idIPCR = $request->idIPCR;
            $data->pcr_type = 'ipcr';
        }
        //SECTION
        if ($request->pcr_type === 'hspcr') {
            $data->idHSPCR = $request->idHSPCR;
        }
        //DIVISION
        if ($request->pcr_type === 'hdpcr') {
            $data->idHDPCR = $request->idHDPCR;
            $data->pcr_type = 'hdpcr';
        }
        if ($request->pcr_type === 'dpcr') {
            $data->idDPCR = $request->idDPCR;
            $data->pcr_type = 'dpcr';
        }
        //HOSPITAL
        if ($request->pcr_type === 'hpcr') {
            $data->idHPCR = $request->idHPCR;
            $data->pcr_type = 'hpcr';
        }
        $data->identifier = $request->identifier;
        $data->save();
        return redirect('/hospital-targets/r/' . $request->slug_sem);
    }
    public function destroy($id, $slug)
    {
        //dd($id.' empid: '.$empl_id);
        $data = HospitalTarget::findOrFail($id);
        if ($data) {
            $data->monthlyTargets()->delete(); // Delete related MonthlyTarget records
            $data->delete(); // Delete the DpcrTarget itself
        }
        $data->delete();
        return redirect('/hospital-targets/r/' . $slug)
            ->with('deleted', 'Employee Target Deleted!');
    }

    //FOR ADDITION
}
