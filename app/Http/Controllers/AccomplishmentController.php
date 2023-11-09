<?php

namespace App\Http\Controllers;

use App\Models\Daily_Accomplishment;
use App\Models\Division;
use App\Models\IndividualFinalOutput;
use App\Models\Ipcr_Semestral;
use App\Models\MonthlyAccomplishment;
use App\Models\UserEmployees;
use Carbon\Carbon;
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
        $month = Carbon::parse($request->month)->month;
        $year = $request->year;
        $sem = 1;
        $months = $month;
        if ($month > 6) {
            $months = $month - 6;
            $sem = 2;
        }
        // dd($month);

        $data = Daily_Accomplishment::select(
            'ipcr_daily_accomplishments.idIPCR',
            DB::raw('SUM(ipcr_daily_accomplishments.quantity) as TotalQuantity'),
            'individual_final_outputs.individual_output',
            'individual_final_outputs.success_indicator',
            'individual_final_outputs.quantity_type',
            'individual_final_outputs.quality_error',
            'major_final_outputs.mfo_desc',
            'division_outputs.output',
            'i_p_c_r_targets.ipcr_type',
            'i_p_c_r_targets.ipcr_semester_id',
            'i_p_c_r_targets.semester',
            "i_p_c_r_targets.month_$months as month",
            'ipcr__semestrals.year',
            DB::raw('COUNT(ipcr_daily_accomplishments.quality) as NumberofQuality'),
            DB::raw('SUM(CASE WHEN ipcr_daily_accomplishments.quality IS NOT NULL AND ipcr_daily_accomplishments.quality != "" THEN ipcr_daily_accomplishments.quality ELSE 0 END) AS total_quality'),
            DB::raw('ROUND(CASE WHEN COUNT(ipcr_daily_accomplishments.quality) > 0 THEN SUM(CASE WHEN ipcr_daily_accomplishments.quality IS NOT NULL AND ipcr_daily_accomplishments.quality != "" THEN ipcr_daily_accomplishments.quality ELSE 0 END) / COUNT(ipcr_daily_accomplishments.quality) ELSE 0 END, 2) AS quality_average')
        )
            ->where('emp_code', $emp_code)
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->join('individual_final_outputs', 'ipcr_daily_accomplishments.idIPCR', '=', 'individual_final_outputs.ipcr_code')
            ->join('major_final_outputs', 'individual_final_outputs.idmfo', '=', 'major_final_outputs.id')
            ->join('division_outputs', 'individual_final_outputs.id_div_output', '=', 'division_outputs.id')
            ->join('i_p_c_r_targets', 'ipcr_daily_accomplishments.idIPCR', '=', 'i_p_c_r_targets.ipcr_code')
            ->join('ipcr__semestrals', 'i_p_c_r_targets.ipcr_semester_id', '=', 'ipcr__semestrals.id')
            ->where('ipcr__semestrals.year', $year)
            ->where('i_p_c_r_targets.semester', $sem)
            ->groupBy('ipcr_daily_accomplishments.idIPCR')
            ->paginate(10)
            ->withQueryString();


        return inertia('Monthly_Accomplishment/Index', [
            // "data" => $data,
            "emp_code" => $emp_code,
            "month" => $request->month,
            "data" => $data
        ]);
    }

    public function semestral_monthly(Request $request)
    {
        // dd($request->id_shown);

        $id = auth()->user()->username;
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
        //
        $sem_data = Ipcr_Semestral::where('employee_code', $emp_code)
            ->with('monthly_accomplishment')
            ->where('status', '2')
            ->orderBy('year', 'asc')
            ->orderBy('sem', 'asc')
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
            // "id_shown" => $id_shown
        ]);
    }

    public function submit_monthly(Request $request, $id)
    {
        // dd($request->id_shown);
        $data = MonthlyAccomplishment::findOrFail($request->id);
        //dd($request->plan_period);

        $data->update([
            'status' => '0',
        ]);
        // dd($data);
        return redirect('/monthly-accomplishment')
            ->with('message', 'Successfully submitted')
            ->with('id_shown', $request->id_shown);
    }

    public function generate_monthly_accomplishment(Request $request)
    {
        // dd("generate_monthly_accomplishment");
        //generate_monthly_accomplishment
        $ipcr_semestral = Ipcr_Semestral::get()
            ->map(function ($item) {
                $id = $item->id;
                $sem = $item->sem;
                $year = $item->year;
                // Define the months based on the semester value
                $months = ($sem == 1) ? ['1', '2', '3', '4', '5', '6'] : ['7', '8', '9', '10', '11', '12'];

                // Create Ipcr_monthly records for each month
                foreach ($months as $month) {
                    $existingRecord = MonthlyAccomplishment::where('ipcr_semestral_id', $id)
                        ->where('month', $month)
                        ->first();
                    if (!$existingRecord) {
                        MonthlyAccomplishment::create([
                            'month' => $month,
                            'year' => $year,
                            'ipcr_semestral_id' => $id, // Reference to the parent semestral record
                            'status' => '-1'
                            // Add other fields as needed
                        ]);
                    }
                    // $existingRecord=MonthlyAccomplishment::create([
                    //     'month' => $month,
                    //     'year' => $year,
                    //     'ipcr_semestral_id' => $id, // Reference to the parent semestral record
                    //     'status' => '-1'
                    //     // Add other fields as needed
                    // ]);

                }
            });

        return redirect()->back()->with('message', 'Successfully generated monthly IPCR!');
    }
}
