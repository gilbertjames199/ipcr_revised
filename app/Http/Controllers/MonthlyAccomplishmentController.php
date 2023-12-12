<?php

namespace App\Http\Controllers;

use App\Models\Division;
use App\Models\FFUNCCOD;
use App\Models\Ipcr_Semestral;
use App\Models\IPCRTargets;
use App\Models\MonthlyAccomplishment;
use App\Models\ProbationaryTemporaryEmployees;
use App\Models\TimeRange;
use App\Models\UserEmployees;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class MonthlyAccomplishmentController extends Controller
{
    protected $model, $ipcr_sem;
    public function __construct(MonthlyAccomplishment $model, Ipcr_Semestral $ipcr_sem)
    {
        $this->model = $model;
        $this->ipcr_sem = $ipcr_sem;
    }
    public function approve_monthly(Request $request)
    {
        $empl_code = auth()->user()->username;
        // dd($empl_code);


        $accomp_review = $this->ipcr_sem
            ->select(
                'ipcr__semestrals.id AS id',
                'ipcr__semestrals.status AS status',
                'ipcr__semestrals.year AS year',
                'ipcr__semestrals.sem AS sem',
                'user_employees.employee_name',
                'user_employees.empl_id',
                'user_employees.position_long_title',
                'user_employees.department_code',
                'user_employees.division_code',
                'ipcr__semestrals.immediate_id',
                'ipcr__semestrals.next_higher',
                'ipcr_monthly_accomplishments.id AS id_accomp',
                'ipcr_monthly_accomplishments.month AS a_month',
                'ipcr_monthly_accomplishments.year AS a_year',
                'ipcr_monthly_accomplishments.status AS a_status'
            )
            ->where('ipcr_monthly_accomplishments.status', '0')
            ->where('ipcr__semestrals.immediate_id', $empl_code)
            ->join('user_employees', 'user_employees.empl_id', 'ipcr__semestrals.employee_code')
            ->join('ipcr_monthly_accomplishments', 'ipcr_monthly_accomplishments.ipcr_semestral_id', 'ipcr__semestrals.id')
            ->distinct('ipcr_monthly_accomplishments.id')
            ->get()->map(function ($item) {
                //office, division, immediate, next_higher, sem, year, idsemestral, period,
                $of = "";
                $imm = "";
                $next = "";
                $div = "";
                $of = FFUNCCOD::where('department_code', $item->department_code)->first();
                if ($of) {
                    $off = $of->FFUNCTION;
                }


                $imm_emp = UserEmployees::where('empl_id', $item->immediate_id)->first();
                if ($imm_emp) {
                    $imm = $imm_emp->first_name . ' ' . $imm_emp->last_name;
                }


                $nx = UserEmployees::where('empl_id', $item->next_higher)->first();
                if ($nx) {
                    $next = $nx->first_name . ' ' . $nx->last_name;
                }


                $dv = Division::where('division_code', $item->division_code)->first();
                if ($dv) {
                    $div = $dv->division_name1;
                }

                return [
                    'id' => $item->id,
                    'status' => $item->status,
                    'year' => $item->year,
                    'sem' => $item->sem,
                    'employee_name' => $item->employee_name,
                    'empl_id' => $item->empl_id,
                    'position' => $item->position_long_title,
                    'office' => $off,
                    'division' => $div,
                    'immediate' => $imm,
                    'next_higher' => $next,
                    'accomp_id' => $item->id_accomp,
                    'month' => $item->a_month,
                    'a_year' => $item->a_year,
                    'a_status' => $item->a_status,
                ];
            });
        // dd($accomp_review->count());
        $accomp_approve = $this->ipcr_sem
            ->select(
                'ipcr__semestrals.id AS id',
                'ipcr__semestrals.status AS status',
                'ipcr__semestrals.year AS year',
                'ipcr__semestrals.sem AS sem',
                'user_employees.employee_name',
                'user_employees.empl_id',
                'user_employees.position_long_title',
                'user_employees.department_code',
                'user_employees.division_code',
                'ipcr__semestrals.immediate_id',
                'ipcr__semestrals.next_higher',
                'ipcr_monthly_accomplishments.id AS id_accomp',
                'ipcr_monthly_accomplishments.month AS a_month',
                'ipcr_monthly_accomplishments.year AS a_year',
                'ipcr_monthly_accomplishments.status AS a_status'
            )
            ->where('ipcr_monthly_accomplishments.status', '1')
            ->where('ipcr__semestrals.next_higher', $empl_code)
            ->join('user_employees', 'user_employees.empl_id', 'ipcr__semestrals.employee_code')
            ->join('ipcr_monthly_accomplishments', 'ipcr_monthly_accomplishments.ipcr_semestral_id', 'ipcr__semestrals.id')
            ->distinct('ipcr_monthly_accomplishments.id')
            ->get()->map(function ($item) {
                $of = "";
                $imm = "";
                $next = "";
                $div = "";
                $of = FFUNCCOD::where('department_code', $item->department_code)->first();
                if ($of) {
                    $off = $of->FFUNCTION;
                }


                $imm_emp = UserEmployees::where('empl_id', $item->immediate_id)->first();
                if ($imm_emp) {
                    $imm = $imm_emp->first_name . ' ' . $imm_emp->last_name;
                }


                $nx = UserEmployees::where('empl_id', $item->next_higher)->first();
                if ($nx) {
                    $next = $nx->first_name . ' ' . $nx->last_name;
                }


                $dv = Division::where('division_code', $item->division_code)->first();
                if ($dv) {
                    $div = $dv->division_name1;
                }

                return [
                    'id' => $item->id,
                    'status' => $item->status,
                    'year' => $item->year,
                    'sem' => $item->sem,
                    'employee_name' => $item->employee_name,
                    'empl_id' => $item->empl_id,
                    'position' => $item->position_long_title,
                    'office' => $off,
                    'division' => $div,
                    'immediate' => $imm,
                    'next_higher' => $next,
                    'accomp_id' => $item->id_accomp,
                    'month' => $item->a_month,
                    'a_year' => $item->a_year,
                    'a_status' => $item->a_status,
                ];
            });
        $accomplished = $accomp_review->concat($accomp_approve);

        // Paginate the merged collection
        $perPage = 10; // Set the number of items per page here
        $page = request()->get('page', 1); // Get the current page number from the request

        $accomplishments = new LengthAwarePaginator(
            $accomplished->forPage($page, $perPage),
            $accomplished->count(),
            $perPage,
            $page,
            ['path' => request()->url()] // Use the current URL as the path
        );


        return inertia(
            'IPCR/Review_Accomplishments/Index',
            ['accomplishments' => $accomplishments]
        );
    }
    public function specific_accomplishment(Request $request)
    {
        // dd('specific_accomplishment');
        $month = $request->month;
        $sel_month = $month;
        if ($month > 6) {
            $sel_month = $month - 6;
        }
        $ipcr_semestral_id = $request->ipcr_semestral_id;
        $accomp_id = $request->accomp_id;
        $empl_code = $request->empl_id;
        // dd('specific_accomplishment: ' . $accomp_id);
        // $accomp = IPCRTargets::select(
        //     'i_p_c_r_targets.ipcr_code',
        //     'i_p_c_r_targets.month_' . $month . ' AS month',
        //     'i_p_c_r_targets.quantity_sem',
        //     'i_p_c_r_targets.ipcr_type',
        //     'individual_final_outputs.individual_output'
        // )
        //     ->where('employee_code', $request->empl_id)
        //     ->where('ipcr_semester_id', $ipcr_semestral_id)
        //     ->distinct('i_p_c_r_targets.ipcr_code')
        //     ->join('individual_final_outputs', 'individual_final_outputs.ipcr_code', 'i_p_c_r_targets.ipcr_code')
        //     ->distinct('i_p_c_r_targets.ipcr_code')
        //     ->orderBy('individual_final_outputs.ipcr_code', 'ASC')
        //     ->get();
        $prescribed_period = '';
        $time_unit = '';
        $TimeRating = '';
        $accomp = IPCRTargets::select(
            'i_p_c_r_targets.ipcr_code',
            'i_p_c_r_targets.month_' . $sel_month . ' AS monthly_target',
            'i_p_c_r_targets.quantity_sem',
            'i_p_c_r_targets.ipcr_type',
            'individual_final_outputs.quantity_type',
            'individual_final_outputs.quality_error',
            'individual_final_outputs.time_range_code',
            'individual_final_outputs.time_based',
            'time_ranges.time_unit',
            'major_final_outputs.mfo_desc',
            'individual_final_outputs.success_indicator',
            DB::raw($accomp_id . ' AS id_accomp ', $accomp_id),
            'individual_final_outputs.individual_output',
            DB::raw($month . ' AS month', $month),
            DB::raw('(SELECT SUM(ipcr_daily_accomplishments.quantity) FROM ipcr_daily_accomplishments
                WHERE ipcr_daily_accomplishments.emp_code = ' . $empl_code . ' AND MONTH(ipcr_daily_accomplishments.date) = ' . $month . '
                AND ipcr_daily_accomplishments.idIPCR = i_p_c_r_targets.ipcr_code) as total_quantity'),
            DB::raw('(SELECT AVG(ipcr_daily_accomplishments.timeliness) FROM ipcr_daily_accomplishments
                WHERE ipcr_daily_accomplishments.emp_code = ' . $empl_code . ' AND MONTH(ipcr_daily_accomplishments.date) = ' . $month . '
                AND ipcr_daily_accomplishments.idIPCR = i_p_c_r_targets.ipcr_code) as ave_time'),
            DB::raw('(SELECT AVG(ipcr_daily_accomplishments.quality) FROM ipcr_daily_accomplishments
                WHERE ipcr_daily_accomplishments.emp_code = ' . $empl_code . ' AND MONTH(ipcr_daily_accomplishments.date) = ' . $month . '
                AND ipcr_daily_accomplishments.idIPCR = i_p_c_r_targets.ipcr_code) as total_quality_avg'),
            DB::raw('(SELECT SUM(ipcr_daily_accomplishments.quality) FROM ipcr_daily_accomplishments
                WHERE ipcr_daily_accomplishments.emp_code = ' . $empl_code . ' AND MONTH(ipcr_daily_accomplishments.date) = ' . $month . '
                AND ipcr_daily_accomplishments.idIPCR = i_p_c_r_targets.ipcr_code) as total_quality'),
            DB::raw("'$TimeRating' AS TimeRating"),
            DB::raw("'$prescribed_period' AS prescribed_period"),
            DB::raw("'$time_unit' AS time_unit"),

        )
            ->where('employee_code', $request->empl_id)
            ->where('ipcr_semester_id', $ipcr_semestral_id)
            ->distinct('i_p_c_r_targets.ipcr_code')
            ->join('individual_final_outputs', 'individual_final_outputs.ipcr_code', 'i_p_c_r_targets.ipcr_code')
            ->join('time_ranges', 'time_ranges.time_code', 'individual_final_outputs.time_range_code')
            ->join('major_final_outputs', 'major_final_outputs.id', 'individual_final_outputs.idmfo')
            ->distinct('i_p_c_r_targets.ipcr_code')
            ->distinct('individual_final_outputs.time_range_code')
            ->orderBy('individual_final_outputs.ipcr_code', 'ASC')
            ->get();
        foreach ($accomp as $key => $value) {
            if ($value->time_range_code > 0 && $value->time_range_code < 47) {
                if ($value->time_based == 1) {
                    $time_range5 = TimeRange::where('time_code', $value->time_range_code)->orderBY('rating', 'DESC')->get();
                    if ($value->Final_Average_Timeliness == null) {
                        $value->TimeRating = 0;
                        $value->time_unit = $time_range5[0]->time_unit;
                        $value->prescribed_period = $time_range5[0]->prescribed_period;
                    } else if ($value->Final_Average_Timeliness <= $time_range5[0]->equivalent_time_from) {
                        $value->TimeRating = 5;
                        $value->time_unit = $time_range5[0]->time_unit;
                        $value->prescribed_period = $time_range5[0]->prescribed_period;
                    } else if (
                        $value->Final_Average_Timeliness >= $time_range5[4]->equivalent_time_from
                    ) {
                        $value->TimeRating = 1;
                        $value->time_unit = $time_range5[4]->time_unit;
                        $value->prescribed_period = $time_range5[4]->prescribed_period;
                    } else if (
                        $value->Final_Average_Timeliness >= $time_range5[3]->equivalent_time_from
                    ) {
                        $value->TimeRating = 2;
                        $value->time_unit = $time_range5[3]->time_unit;
                        $value->prescribed_period = $time_range5[3]->prescribed_period;
                    } else if (
                        $value->Final_Average_Timeliness >= $time_range5[2]->equivalent_time_from
                    ) {
                        $value->TimeRating = 3;
                        $value->time_unit = $time_range5[2]->time_unit;
                        $value->prescribed_period = $time_range5[2]->prescribed_period;
                    } else if ($value->Final_Average_Timeliness >= $time_range5[1]->equivalent_time_from) {
                        $value->TimeRating = 4;
                        $value->time_unit = $time_range5[1]->time_unit;
                        $value->prescribed_period = $time_range5[1]->prescribed_period;
                    } else {
                        $value->TimeRating = 0;
                        $value->time_unit = "";
                        $value->prescribed_period = "";
                    }
                }
            }
        }
        // dd($accomp);
        return $accomp;
    }
    public function updateStatus(Request $request, $status, $acc_id)
    {
        dd($request);
        // dd('status: ' . $status . ' sem_id:' . $acc_id);
        $data = $this->model::findOrFail($acc_id);
        $data->update([
            'status' => $status,
        ]);
        $msg = "Reviewed IPCR Target!";
        if ($status == "2") {
            $msg = "Approved ipcr Target!";
        }
        return redirect('/review/approve')
            ->with('message', $msg);
    }
    public function api_kobo()
    {
        $apiToken = env('4f9297d58684fb2784df4eee1c603d3e4f8fdc4e');
        // $baseUrl = 'https://kobo.humanitarianresponse.info/api/v1/';
        $baseUrl = 'https://eu.kobotoolbox.org/api/v2/';
        $client = new Client();

        // Example: Fetch a list of surveys
        $response = $client->get($baseUrl . 'surveys', [
            'headers' => [
                'Authorization' => 'Token ' . $apiToken,
            ],
        ]);

        $data = json_decode($response->getBody());

        // Process the retrieved data as needed

        return view($data);
    }
}
