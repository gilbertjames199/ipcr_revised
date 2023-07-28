<?php

namespace App\Http\Controllers;

use App\Models\Daily_Accomplishment;
use App\Models\IndividualFinalOutput;
use App\Models\UserEmployees;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DailyAccomplishmentController extends Controller
{
    private $model;
     public function __construct(Daily_Accomplishment $model)
    {
        $this->model = $model;
    }

    public function index(Request $request)
    {
        $emp_code = Auth()->user()->username;
        // dd($emp_code);
        //dd($emp_code);
        $data = $this->model->with('IPCRCode')
                ->get();
        // $data = IndividualFinalOutput::select('individual_final_outputs.ipcr_code','i_p_c_r_targets.id',
        //             'individual_final_outputs.individual_output', 'individual_final_outputs.performance_measure',
        //             'divisions.division_name1 AS division', 'division_outputs.output AS div_output', 'major_final_outputs.mfo_desc',
        //             'major_final_outputs.FFUNCCOD','sub_mfos.submfo_description'
        //         )
        //         ->leftjoin('division_outputs','division_outputs.id','individual_final_outputs.id_div_output')
        //         ->leftjoin('divisions','divisions.id','division_outputs.division_id')
        //         ->leftjoin('major_final_outputs','major_final_outputs.id', 'division_outputs.idmfo')
        //         ->leftjoin('sub_mfos','sub_mfos.id','individual_final_outputs.idsubmfo')
        //         ->join('i_p_c_r_targets', 'i_p_c_r_targets.ipcr_code','individual_final_outputs.ipcr_code')
        //         ->where('i_p_c_r_targets.employee_code', $emp_code)
        //         ->orderBy('individual_final_outputs.ipcr_code')
        //         ->paginate(10)
        //         ->withQueryString();
        return inertia('Daily_Accomplishment/Index',[
            "data"=>$data,
            "usercode"=>$emp_code
        ]);
    }

    public function create(Request $request){
        // dd('create');
        // $paps = ProgramAndProject::get();
        // $mfo = MajorFinalOutput::get();
        return inertia('Daily_Accomplishment/Create',[
            // 'paps'=>$paps,
            // 'mfo'=>$mfo,
            // 'can'=>[
            //     'can_access_validation' => Auth::user()->can('can_access_validation',User::class),
            //     'can_access_indicators' => Auth::user()->can('can_access_indicators',User::class)
            // ],
        ]);
    }

}
