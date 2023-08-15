<?php

namespace App\Http\Controllers;

use App\Models\Division;
use App\Models\IndividualFinalOutput;
use App\Models\IpcrProbTempoTarget;
use App\Models\ProbTempoEmployees;
use App\Models\UserEmployees;
use Illuminate\Http\Request;

class IpcrProbTempoTargetController extends Controller
{
    protected $ipcr_prob_tempo_target;
    public function __construct(IpcrProbTempoTarget $ipcr_prob_tempo_target)
    {
        $this->ipcr_prob_tempo_target=$ipcr_prob_tempo_target;
    }
    public function index(Request $request, $id){
        $prob = ProbTempoEmployees::where('id', $id)
                ->first();
        // dd($prob);
        $emp_code = $prob->employee_code;

        $emp = UserEmployees::where('empl_id',$emp_code)
                    ->first();
        $division ="";
        if($emp->division_code){

            $division = Division::where('division_code', $emp->division_code)
                        ->first()->division_name1;
        }

        $data = IpcrProbTempoTarget::select('individual_final_outputs.ipcr_code','ipcr_prob_tempo_targets.id','ipcr_prob_tempo_targets.ipcr_type',
                        'individual_final_outputs.individual_output', 'individual_final_outputs.performance_measure',
                        'divisions.division_name1 AS division', 'division_outputs.output AS div_output', 'major_final_outputs.mfo_desc',
                        'major_final_outputs.FFUNCCOD','sub_mfos.submfo_description','major_final_outputs.department_code'
                    )
                    ->distinct('ipcr_prob_tempo_targets.ipcr_code')
                    ->join('individual_final_outputs', 'ipcr_prob_tempo_targets.ipcr_code','individual_final_outputs.ipcr_code')
                    ->leftjoin('division_outputs','division_outputs.id','individual_final_outputs.id_div_output')
                    ->leftjoin('divisions','divisions.id','division_outputs.division_id')
                    ->join('major_final_outputs','major_final_outputs.id', 'individual_final_outputs.idmfo')
                    ->leftjoin('sub_mfos','sub_mfos.id','individual_final_outputs.idsubmfo')
                    ->where('ipcr_prob_tempo_targets.employee_code', $emp_code)
                    ->where('ipcr_prob_tempo_targets.ipcr_pob_tempo_id', $id)
                    ->orderBy('ipcr_prob_tempo_targets.ipcr_type')
                    ->orderBy('individual_final_outputs.ipcr_code')
                    ->paginate(10)
                    ->withQueryString();
                    // dd($data);
        return inertia('Employees/Probationary/Targets/Index',[
            "prob"=>$prob,
            "id"=>$id,
            "data"=>$data,
            "division"=>$division,
            "emp"=>$emp
        ]);
    }
    public function create(Request $request, $id){
        // create//
        $prob = ProbTempoEmployees::where('id', $id)
                ->first();
        $emp_code = $prob->employee_code;
        $emp = UserEmployees::where('empl_id',$emp_code)
                ->first();
        $dept_code = auth()->user()->department_code;
        $ipcrs = IndividualFinalOutput::select('individual_final_outputs.ipcr_code','individual_final_outputs.id',
                    'individual_final_outputs.individual_output', 'individual_final_outputs.performance_measure',
                    'divisions.division_name1 AS division', 'division_outputs.output AS div_output', 'major_final_outputs.mfo_desc',
                    'major_final_outputs.FFUNCCOD','sub_mfos.submfo_description','major_final_outputs.department_code'
                )
                ->leftjoin('division_outputs','division_outputs.id','individual_final_outputs.id_div_output')
                ->leftjoin('divisions','divisions.id','division_outputs.division_id')
                ->leftjoin('major_final_outputs','major_final_outputs.id', 'division_outputs.idmfo')
                ->leftjoin('sub_mfos','sub_mfos.id','individual_final_outputs.idsubmfo')
                ->whereNested(function($query)use($dept_code){
                    $query->where('major_final_outputs.department_code', '=', $dept_code )
                        ->orWhere('major_final_outputs.department_code', '=', '')
                        ->orWhere('major_final_outputs.department_code', '=', '0')
                        ->orWhere('major_final_outputs.department_code', '=', '-');
                })
                ->orderBy('major_final_outputs.department_code', 'DESC')
                ->orderBy('individual_final_outputs.ipcr_code')
                ->get();
        // dd($ipcrs->pluck('department_code'));
        return inertia('Employees/Probationary/Targets/Create',[
            "id"=>$id,
            "emp"=>$emp,
            "ipcrs"=>$ipcrs,
            "prob"=>$prob
        ]);
    }
    public function store(Request $request, $id){
        // dd($request);
        $attributes = $request->validate([
            'employee_code' => 'required',
            'ipcr_pob_tempo_id' => 'required',
            'ipcr_code' => 'required',
            'ipcr_type'=>'required',
            'target_quantity'=>'required|numeric',
            'month_1'=>'required|numeric',
            'month_2'=>'required|numeric',
            'month_3'=>'required|numeric',
            'month_4'=>'required|numeric',
            'month_5'=>'required|numeric',
            'month_6'=>'required|numeric',
            'month_7'=>'required|numeric',
            'month_8'=>'required|numeric',
            'month_9'=>'required|numeric',
            'month_10'=>'required|numeric'
        ]);
        // dd($request);
        $ipcr_targg = IpcrProbTempoTarget::where('ipcr_pob_tempo_id', $request->ipcr_pob_tempo_id)
                        ->where('ipcr_code', $request->ipcr_code)
                        ->where('employee_code', $request->employee_code)
                        ->get();
        if(count($ipcr_targg)<1){
            $this->ipcr_prob_tempo_target->create($attributes);
        }
        return redirect('/prob/individual/targets/'.$id)
                ->with('message','Probationary/Temporary Employee Target added');
    }
    public function edit(Request $request, $id, $probid){

        $prob = ProbTempoEmployees::where('id', $id)
                ->first();

        $emp_code = $prob->employee_code;

        $emp = UserEmployees::where('empl_id',$emp_code)
                ->first();
        $dept_code = auth()->user()->department_code;
        $ipcrs = IndividualFinalOutput::select('individual_final_outputs.ipcr_code','individual_final_outputs.id',
                    'individual_final_outputs.individual_output', 'individual_final_outputs.performance_measure',
                    'divisions.division_name1 AS division', 'division_outputs.output AS div_output', 'major_final_outputs.mfo_desc',
                    'major_final_outputs.FFUNCCOD','sub_mfos.submfo_description','major_final_outputs.department_code'
                )
                ->leftjoin('division_outputs','division_outputs.id','individual_final_outputs.id_div_output')
                ->leftjoin('divisions','divisions.id','division_outputs.division_id')
                ->leftjoin('major_final_outputs','major_final_outputs.id', 'division_outputs.idmfo')
                ->leftjoin('sub_mfos','sub_mfos.id','individual_final_outputs.idsubmfo')
                ->whereNested(function($query)use($dept_code){
                    $query->where('major_final_outputs.department_code', '=', $dept_code )
                        ->orWhere('major_final_outputs.department_code', '=', '')
                        ->orWhere('major_final_outputs.department_code', '=', '0')
                        ->orWhere('major_final_outputs.department_code', '=', '-');
                })
                ->orderBy('major_final_outputs.department_code', 'DESC')
                ->orderBy('individual_final_outputs.ipcr_code')
                ->get();
        $data=IpcrProbTempoTarget::where('id',$probid)->first();
        // dd($ipcrs->pluck('department_code'));

        return inertia('Employees/Probationary/Targets/Create',[
            "id"=>$id,
            "emp"=>$emp,
            "ipcrs"=>$ipcrs,
            "prob"=>$prob,
            "editData"=>$data
        ]);
    }
    public function update(Request $request, $id){
        // dd($id.' update');
        // dd($request);
        $data = $this->ipcr_prob_tempo_target->findOrFail($request->id);
        // dd($data);
                // ->whereNot('id',$request->id)
        // $ipcr_targg = IpcrProbTempoTarget::where('employee_code', $request->employee_code)
        //         ->where('ipcr_code', $request->ipcr_code)
        //         ->where('ipcr_semester_id', $request->ipcr_semester_id)
        //         ->get();
        // dd($ipcr_targg);
        $data->update([
            'employee_code' => $request->employee_code,
            'ipcr_pob_tempo_id' => $request->ipcr_pob_tempo_id,
            'ipcr_code' => $request->ipcr_code,
            'ipcr_type'=>$request->ipcr_type,
            'target_quantity'=>$request->target_quantity,
            'month_1'=>$request->month_1,
            'month_2'=>$request->month_2,
            'month_3'=>$request->month_3,
            'month_4'=>$request->month_4,
            'month_5'=>$request->month_5,
            'month_6'=>$request->month_6,
            'month_7'=>$request->month_7,
            'month_8'=>$request->month_8,
            'month_9'=>$request->month_9,
            'month_10'=>$request->month_10
        ]);

        //$data = $this->ipcr_prob_tempo_target->findOrFail($request->id);
        // dd($data);

        return redirect('/prob/individual/targets/'.$id)
                ->with('message','Probationary/Temporary Employee Target updated');
    }
    public function destroy($id){
        //dd($id.' empid: '.$empl_id);
        $data = $this->ipcr_prob_tempo_target->findOrFail($id);
        $my_id = $data->ipcr_pob_tempo_id;
        $data->delete();
        return redirect('/prob/individual/targets/'.$my_id)
                ->with('error','Employee Target Deleted!');
    }
}
