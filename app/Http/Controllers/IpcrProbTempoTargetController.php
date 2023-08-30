<?php

namespace App\Http\Controllers;

use App\Models\Division;
use App\Models\IndividualFinalOutput;
use App\Models\IpcrProbTempoTarget;
use App\Models\ProbationaryTemporaryEmployees;
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
        $prob = ProbationaryTemporaryEmployees::where('id', $id)
                ->first();

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
                    ->join('probationary_temporary_employees','probationary_temporary_employees.id','ipcr_prob_tempo_targets.probationary_temporary_employees_id')
                    ->where('probationary_temporary_employees.employee_code', $emp_code)
                    ->where('ipcr_prob_tempo_targets.probationary_temporary_employees_id', $id)
                    ->orderBy('ipcr_prob_tempo_targets.ipcr_type')
                    ->orderBy('individual_final_outputs.ipcr_code')
                    ->paginate(10)
                    ->withQueryString();

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
        $prob = ProbationaryTemporaryEmployees::where('id', $id)
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
        $date_from = json_decode($prob->date_from);
        $date_to = json_decode($prob->date_to);
        return inertia('Employees/ProbationaryFlex/Targets/Create',[
            "id"=>$id,
            "emp"=>$emp,
            "ipcrs"=>$ipcrs,
            "prob"=>$prob,
            "date_from"=>$date_from,
            "date_to"=>$date_to,
        ]);
    }
    public function store(Request $request, $id){
        // dd($request);
        $attributes = $request->validate([
            'probationary_temporary_employees_id' => 'required',
            'ipcr_code' => 'required',
            'ipcr_type'=>'required',
            'quantity'=>'required',
        ]);


        // Encode the 'quantity' as JSON
        $attributes['quantity'] = json_encode($attributes['quantity']);

        $ipcr_targg = IpcrProbTempoTarget::where('probationary_temporary_employees_id', $request->probationary_temporary_employees_id)
                        ->where('ipcr_code', $request->ipcr_code)
                        ->get();

        if(count($ipcr_targg)<1){
            // dd($attributes);
            $this->ipcr_prob_tempo_target->create($attributes);
        }
        return redirect('/prob/individual/targets/'.$id)
                ->with('message','Probationary/Temporary Employee Target added');
    }
    public function edit(Request $request, $id, $probid){

        $prob = ProbationaryTemporaryEmployees::where('id', $id)
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
        // dd($data->quantity);
        // dd($ipcrs->pluck('department_code'));
        // dd($data);
        $date_from = json_decode($prob->date_from);
        $date_to = json_decode($prob->date_to);
        $editQuantity =  json_decode($data->quantity);
        // dd($editQuantity);
        return inertia('Employees/ProbationaryFlex/Targets/Create',[
            "id"=>$id,
            "emp"=>$emp,
            "ipcrs"=>$ipcrs,
            "prob"=>$prob,
            "editData"=>$data,
            "date_from"=>$date_from,
            "date_to"=>$date_to,
            "editQuantity"=>$editQuantity
        ]);
    }
    public function update(Request $request, $id){
        // dd($id.' update');
        // dd($request);
        $data = $this->ipcr_prob_tempo_target->findOrFail($request->id);

        $data->update([
            'probationary_temporary_employees_id' => $request->probationary_temporary_employees_id,
            'ipcr_code' => $request->ipcr_code,
            'ipcr_type'=>$request->ipcr_type,
            'target_quantity'=>$request->target_quantity,
            'quantity'=>$request->quantity
        ]);

        //$data = $this->ipcr_prob_tempo_target->findOrFail($request->id);
        // dd($data);

        return redirect('/prob/individual/targets/'.$id)
                ->with('message','Probationary/Temporary Employee Target updated');
    }
    public function destroy($id){
        //dd($id.' empid: '.$empl_id);
        // dd($id);
        $data = $this->ipcr_prob_tempo_target->findOrFail($id);
        $my_id = $data->probationary_temporary_employees_id;
        $data->delete();
        return redirect('/prob/individual/targets/'.$my_id)
                ->with('error','Employee Target Deleted!');
    }
    public function submit($id){
        $prob_emp = ProbationaryTemporaryEmployees::where('id', $id)
                    ->first();
        $my_id = $prob_emp->probationary_temporary_employees_id;
        $stat = $prob_emp->status;
        if($stat<0){
            $prob_emp->status='0';
        }elseif($stat<1){
            $prob_emp->status='-1';
        }
        $prob_emp->save();
        return redirect('/probationary/temporary/individual/targets/list')
                ->with('message','Submitted!');

    }
}
