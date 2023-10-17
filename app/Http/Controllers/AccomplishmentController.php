<?php

namespace App\Http\Controllers;

use App\Models\Daily_Accomplishment;
use App\Models\Division;
use App\Models\IndividualFinalOutput;
use App\Models\Ipcr_Semestral;
use App\Models\UserEmployees;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AccomplishmentController extends Controller
{
    private $model;
    public function __construct(Daily_Accomplishment $model)
    {
        $this->model = $model;
    }

    public function index(Request $request)
    {
        $emp_code = Auth()->user()->username;
        $datefrom = $request->date_from;
        $dateto = $request->date_to;
        $month = $request->month;
        $distinctDivisionOutputs = Division::select('output')
            ->distinct();

        $data = Daily_Accomplishment::select(
            'ipcr_daily_accomplishments.idIPCR',
            DB::raw('SUM(ipcr_daily_accomplishments.quantity) as TotalQuantity'),
            'individual_final_outputs.individual_output',
            'individual_final_outputs.performance_measure',
            'major_final_outputs.mfo_desc',
            'division_outputs.output',
            'i_p_c_r_targets.ipcr_type'
        )
            ->where('emp_code', $emp_code)
            ->whereBetween('Date', [$datefrom, $dateto])
            ->join('individual_final_outputs', 'ipcr_daily_accomplishments.idIPCR', '=', 'individual_final_outputs.ipcr_code')
            ->join('major_final_outputs', 'individual_final_outputs.idmfo', '=', 'major_final_outputs.id')
            ->join('division_outputs', 'individual_final_outputs.id_div_output', '=', 'division_outputs.id')
            ->join('i_p_c_r_targets', 'ipcr_daily_accomplishments.idIPCR', '=', 'i_p_c_r_targets.ipcr_code')
            ->groupBy('ipcr_daily_accomplishments.idIPCR')
            ->paginate(10)
            ->withQueryString();


        return inertia('Monthly_Accomplishment/Index', [
            // "data" => $data,
            "emp_code" => $emp_code,
            "month" => $month,
            "date_from" => $datefrom,
            "date_to" => $dateto,
            "data" => $data
        ]);
    }

    public function semestral_monthly(Request $request)
    {
<<<<<<< HEAD
        $id = Auth()->user()->username;
=======
        $id = auth()->user()->username;
>>>>>>> 837948de3f7058d13af42de639d2dcc59ae6d7a4
        // dd($id);
        $emp = UserEmployees::where('empl_id', $id)
            ->first();
        // dd($emp);
        $emp_code = $emp->empl_id;
        $division = "";
        if ($emp->division_code) {
            //dd($emp->division_code);
            $division = Division::where('division_code', $emp->division_code)
                ->first()->division_name1;
        }
        //dd($emp_code);
        $data = IndividualFinalOutput::select(
            'individual_final_outputs.ipcr_code',
            'i_p_c_r_targets.id',
            'individual_final_outputs.individual_output',
            'individual_final_outputs.performance_measure',
            'divisions.division_name1 AS division',
            'division_outputs.output AS div_output',
            'major_final_outputs.mfo_desc',
            'major_final_outputs.FFUNCCOD',
            'sub_mfos.submfo_description'
        )
            ->leftjoin('division_outputs', 'division_outputs.id', 'individual_final_outputs.id_div_output')
            ->leftjoin('divisions', 'divisions.id', 'division_outputs.division_id')
            ->leftjoin('major_final_outputs', 'major_final_outputs.id', 'division_outputs.idmfo')
            ->leftjoin('sub_mfos', 'sub_mfos.id', 'individual_final_outputs.idsubmfo')
            ->join('i_p_c_r_targets', 'i_p_c_r_targets.ipcr_code', 'individual_final_outputs.ipcr_code')
            ->where('i_p_c_r_targets.employee_code', $emp_code)
            ->orderBy('individual_final_outputs.ipcr_code')
            ->paginate(10)
            ->withQueryString();

        $sem_data = Ipcr_Semestral::where('employee_code', $emp_code)
            ->paginate(10);
        $source = "direct";
        //dd($sem_data);
        //dd($source);
        //return inertia('IPCR/Semestral/Index');
        return inertia('IPCR/Accomplishment/Index', [
            "id" => $id,
            "data" => $data,
            "sem_data" => $sem_data,
            "division" => $division,
            "emp" => $emp,
            "source" => $source,
        ]);
    }
}
