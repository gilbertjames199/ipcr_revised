<?php

namespace App\Http\Controllers;

use App\Models\Division;
use App\Models\IndividualFinalOutput;
use App\Models\Ipcr_Semestral;
use App\Models\IPCRTargets;
use App\Models\UserEmployees;
use Illuminate\Http\Request;

class IpcrSemestralController extends Controller
{
    protected $ipcr_sem;
    public function __construct(Ipcr_Semestral $ipcr_sem)
    {
        $this->ipcr_sem=$ipcr_sem;
    }
    public function index(Request $request, $id, $source){
        $emp = UserEmployees::where('id',$id)
                ->first();
        $emp_code = $emp->empl_id;
        $division ="";
        if($emp->division_code){
            //dd($emp->division_code);
            $division = Division::where('division_code', $emp->division_code)
                        ->first()->division_name1;
        }
        //dd($emp_code);
        $data = IndividualFinalOutput::select('individual_final_outputs.ipcr_code','i_p_c_r_targets.id',
                    'individual_final_outputs.individual_output', 'individual_final_outputs.performance_measure',
                    'divisions.division_name1 AS division', 'division_outputs.output AS div_output', 'major_final_outputs.mfo_desc',
                    'major_final_outputs.FFUNCCOD','sub_mfos.submfo_description'
                )
                ->leftjoin('division_outputs','division_outputs.id','individual_final_outputs.id_div_output')
                ->leftjoin('divisions','divisions.id','division_outputs.division_id')
                ->leftjoin('major_final_outputs','major_final_outputs.id', 'division_outputs.idmfo')
                ->leftjoin('sub_mfos','sub_mfos.id','individual_final_outputs.idsubmfo')
                ->join('i_p_c_r_targets', 'i_p_c_r_targets.ipcr_code','individual_final_outputs.ipcr_code')
                ->where('i_p_c_r_targets.employee_code', $emp_code)
                ->orderBy('individual_final_outputs.ipcr_code')
                ->paginate(10)
                ->withQueryString();

        $sem_data = Ipcr_Semestral::where('employee_code', $emp_code)
                        ->paginate(10);
        //dd($sem_data);
        //dd($source);
        //return inertia('IPCR/Semestral/Index');
        return inertia('IPCR/Semestral/Index',[
            "id"=>$id,
            "data"=>$data,
            "sem_data"=>$sem_data,
            "division"=>$division,
            "emp"=>$emp,
            "source"=>$source,
        ]);

    }
    public function create(Request $request, $id, $source){
        $emp = UserEmployees::where('id',$id)
                ->first();
        $dept_code = $emp->department_code;
        $supervisors = UserEmployees::where('department_code',$dept_code)
                    ->get();

        return inertia('IPCR/Semestral/Create',[
            'supervisors'=>$supervisors,
            'id'=>$id,
            'emp'=>$emp,
            'dept_code'=>$dept_code,
            'source'=>$source
        ]);
    }
    public function store(Request $request){
        //dd($request->source);
        $id = UserEmployees::where('empl_id', $request->employee_code)
                    ->first()->id;
        $attributes = $request->validate([
            'sem' => 'required',
            'employee_code' => 'required',
            'immediate_id'=>'required',
            'next_higher'=>'required',
            'year'=>'required',
        ]);
        $ipcr_targg = Ipcr_Semestral::where('employee_code', $request->employee_code)
                        ->where('year', $request->year)
                        ->where('sem', $request->sem)
                        ->get();
        if(count($ipcr_targg)<1){
            $this->ipcr_sem->create($attributes);
        }
        return redirect('/ipcrsemestral/'.$id.'/'.$request->source)
                ->with('message','Employee Targets added');
    }
}
