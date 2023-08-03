<?php

namespace App\Http\Controllers;

use App\Models\Division;
use App\Models\IndividualFinalOutput;
use App\Models\Ipcr_Semestral;
use App\Models\IPCRTargets;
use App\Models\UserEmployeeCredential;
use App\Models\UserEmployees;
use Illuminate\Http\Request;

class IPCRTargetsController extends Controller
{
    protected $ipcr_target;
    public function __construct(IPCRTargets $ipcr_target)
    {
        $this->ipcr_target = $ipcr_target;
    }
    public function index(Request $request, $id){
        // emp_code=auth()->user()->username);
        // dd($id);
        $sem = Ipcr_Semestral::where('id', $id)
                ->first();
        $emp_code = $sem->employee_code;
        $emp = UserEmployees::where('empl_id',$emp_code)
                    ->first();
        // dd($emp);
        $division ="";
        if($emp->division_code){
            //dd($emp->division_code);
            $division = Division::where('division_code', $emp->division_code)
                        ->first()->division_name1;
        }

        $data = IndividualFinalOutput::select('individual_final_outputs.ipcr_code','i_p_c_r_targets.id',
                        'individual_final_outputs.individual_output', 'individual_final_outputs.performance_measure',
                        'divisions.division_name1 AS division', 'division_outputs.output AS div_output', 'major_final_outputs.mfo_desc',
                        'major_final_outputs.FFUNCCOD','sub_mfos.submfo_description','major_final_outputs.department_code'
                    )
                    ->leftjoin('division_outputs','division_outputs.id','individual_final_outputs.id_div_output')
                    ->leftjoin('divisions','divisions.id','division_outputs.division_id')
                    ->leftjoin('major_final_outputs','major_final_outputs.id', 'division_outputs.idmfo')
                    ->leftjoin('sub_mfos','sub_mfos.id','individual_final_outputs.idsubmfo')
                    ->join('i_p_c_r_targets', 'i_p_c_r_targets.ipcr_code','individual_final_outputs.ipcr_code')
                    ->where('i_p_c_r_targets.employee_code', $emp_code)
                    ->where('ipcr_semester_id',$id)
                    ->where(function($query)use($emp){
                        $query->where('major_final_outputs.department_code','')
                            ->orWhere('major_final_outputs.department_code', $emp->department_code);
                    })
                    ->orderBy('individual_final_outputs.ipcr_code')
                    ->paginate(10)
                    ->withQueryString();

        return inertia('IPCR/Targets/Index',[
            "sem"=>$sem,
            "id"=>$id,
            "data"=>$data,
            "division"=>$division,
            "emp"=>$emp
        ]);
    }
    public function create(Request $request, $id){
        $sem = Ipcr_Semestral::where('id', $id)
                ->first();
        $emp_code = $sem->employee_code;
        $emp = UserEmployees::where('empl_id',$emp_code)
                ->first();
        $dept_code = auth()->user()->department_code;
        $ipcrs = IndividualFinalOutput::select('individual_final_outputs.ipcr_code','individual_final_outputs.id',
                    'individual_final_outputs.individual_output', 'individual_final_outputs.performance_measure',
                    'divisions.division_name1 AS division', 'division_outputs.output AS div_output', 'major_final_outputs.mfo_desc',
                    'major_final_outputs.FFUNCCOD','sub_mfos.submfo_description'
                )
                ->leftjoin('division_outputs','division_outputs.id','individual_final_outputs.id_div_output')
                ->leftjoin('divisions','divisions.id','division_outputs.division_id')
                ->leftjoin('major_final_outputs','major_final_outputs.id', 'division_outputs.idmfo')
                ->leftjoin('sub_mfos','sub_mfos.id','individual_final_outputs.idsubmfo')
                ->whereNested(function($query)use($dept_code){
                    $query->where('major_final_outputs.department_code', '=', $dept_code )
                        ->orWhere('major_final_outputs.department_code', '=', '');
                })
                ->orderBy('major_final_outputs.department_code', 'DESC')
                ->orderBy('individual_final_outputs.ipcr_code')
                ->get();
        //dd(count($data));
        return inertia('IPCR/Targets/Create',[
            "id"=>$id,
            "emp"=>$emp,
            "ipcrs"=>$ipcrs,
            "sem"=>$sem
        ]);
    }
    public function store(Request $request, $id){
        //dd($request);
        $attributes = $request->validate([
            'employee_code' => 'required',
            'ipcr_code' => 'required',
            'semester'=>'required',
            'ipcr_type'=>'required',
            'ipcr_semester_id'=>'required',
            'quantity_sem'=>'required|numeric',
            'month_1'=>'required|numeric',
            'month_2'=>'required|numeric',
            'month_3'=>'required|numeric',
            'month_4'=>'required|numeric',
            'month_5'=>'required|numeric',
            'month_6'=>'required|numeric',
            'year'=>'required|numeric',
        ]);
        $ipcr_targg = IPCRTargets::where('employee_code', $request->employee_code)
                        ->where('ipcr_code', $request->ipcr_code)
                        ->get();
        if(count($ipcr_targg)<1){
            $this->ipcr_target->create($attributes);
        }
        return redirect('/ipcrtargets/'.$id)
                ->with('message','Employee Targets added');
    }
    public function edit(Request $request, $id){
        $data = IPCRTargets::where('id', $id)->first();
        $emp_code = $data->employee_code;

        $emp = UserEmployees::where('empl_id',$emp_code)
                ->first();
        $e_id = $emp->id;
        $dept_code = auth()->user()->department_code;
        $ipcrs = IndividualFinalOutput::select('individual_final_outputs.ipcr_code','individual_final_outputs.id',
                    'individual_final_outputs.individual_output', 'individual_final_outputs.performance_measure',
                    'divisions.division_name1 AS division', 'division_outputs.output AS div_output', 'major_final_outputs.mfo_desc',
                    'major_final_outputs.FFUNCCOD','sub_mfos.submfo_description'
                )
                ->leftjoin('division_outputs','division_outputs.id','individual_final_outputs.id_div_output')
                ->leftjoin('divisions','divisions.id','division_outputs.division_id')
                ->leftjoin('major_final_outputs','major_final_outputs.id', 'division_outputs.idmfo')
                ->leftjoin('sub_mfos','sub_mfos.id','individual_final_outputs.idsubmfo')
                ->whereNested(function($query)use($dept_code){
                    $query->where('major_final_outputs.department_code', '=', $dept_code )
                        ->orWhere('major_final_outputs.department_code', '=', '');
                })
                ->orderBy('major_final_outputs.department_code', 'DESC')
                ->orderBy('individual_final_outputs.ipcr_code')
                ->get();
        $data = IPCRTargets::where('id', $id)->first();
        return inertia('IPCR/Targets/Create',[
            "id"=>$e_id,
            "emp"=>$emp,
            "ipcrs"=>$ipcrs,
            "editData"=>$data
        ]);
    }
    public function update(Request $request, $id){
        // dd($id.' update');
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
            'employee_code'=>$request->employee_code,
            'ipcr_code'=>$request->ipcr_code,
            'semester'=>$request->semester,
            'ipcr_type'=>$request->ipcr_type,
            'quantity_sem'=>$request->quantity_sem,
            'ipcr_semester_id'=>$request->ipcr_semester_id,
            'month_1'=>$request->month_1,
            'month_2'=>$request->month_2,
            'month_3'=>$request->month_3,
            'month_4'=>$request->month_4,
            'month_5'=>$request->month_5,
            'month_6'=>$request->month_6,
            'year'=>$request->year,
        ]);

        $data = $this->ipcr_target->findOrFail($request->id);
        // dd($data);

        return redirect('/ipcrtargets/'.$request->ipcr_semester_id)
                ->with('message','Risk Management updated');
    }
    public function destroy($id, $empl_id){
        //dd($id.' empid: '.$empl_id);
        $data = $this->ipcr_target->findOrFail($id);
        $data->delete();
        return redirect('/ipcrtargets/'.$empl_id)
                ->with('error','Employee Target Deleted!');
    }
    public function review_ipcr(Request $request){
        //dd($request->empl_code);
        $targets = IPCRTargets::select('i_p_c_r_targets.ipcr_code',
                            'i_p_c_r_targets.month_1',
                            'i_p_c_r_targets.month_2',
                            'i_p_c_r_targets.month_3',
                            'i_p_c_r_targets.month_4',
                            'i_p_c_r_targets.month_5',
                            'i_p_c_r_targets.month_6',
                            'i_p_c_r_targets.quantity_sem',
                            'i_p_c_r_targets.ipcr_type',
                            'individual_final_outputs.individual_output'
                        )
                        ->where('employee_code', $request->empl_id)
                        ->where('ipcr_semester_id', $request->sem_id)
                        ->join('individual_final_outputs', 'individual_final_outputs.ipcr_code','i_p_c_r_targets.ipcr_code')
                        ->groupBy('i_p_c_r_targets.ipcr_code')
                        ->get();
        return $targets;
    }
}
