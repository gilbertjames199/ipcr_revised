<?php

namespace App\Http\Controllers;

use App\Models\Daily_Accomplishment;
use App\Models\Ipcr_Semestral;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashBoardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    //$totalAll = $this->totalAll();



    public function index()
    {
        //dd('create: '.auth()->user()->can('create',User::class).'edit: '.auth()->user()->can('edit',User::class).'delete: '.auth()->user()->can('delete',User::class));

        return inertia('Home');
    }

    public function dashboard(Request $request)
    {
        $dept_code = auth()->user()->department_code;
        if ($request->dept_code) {
            $dept_code = $dept_code;
        }

        //****************************************************************/
        //LAST 30 DAYS
        $startDate = Carbon::now()->subDays(30)->toDateString();
        $endDate = Carbon::now()->toDateString();
        $last_30_days = $this->countAccomp($startDate, $endDate, $dept_code);

        //****************************************************************/
        //THIS WEEK
        $w_startDate = Carbon::now()->startOfWeek()->toDateString();
        $w_endDate = Carbon::now()->toDateString();
        $week_current = $this->countAccomp($w_startDate, $w_endDate, $dept_code);

        //*****************************************************************/
        //PREVIOUS WEEK
        $wprev_startDate = Carbon::now()->startOfWeek()->subWeek()->toDateString();
        $wprev_endDate = Carbon::now()->endOfWeek()->subWeek()->toDateString();
        $week_prev_current = $this->countAccomp($wprev_startDate, $wprev_endDate, $dept_code);

        //*******************************************************************/
        $currentMonthStartDate = Carbon::now()->startOfMonth()->toDateString();
        $currentMonthEndDate = Carbon::now()->endOfMonth()->toDateString();
        $current_month = $this->countAccomp($currentMonthStartDate, $currentMonthEndDate, $dept_code);


        //*******************************************************************/
        //PREVIOUS MONTH
        $mprev_startDate = Carbon::now()->subMonth()->startOfMonth()->toDateString();
        $mprev_endDate = Carbon::now()->subMonth()->endOfMonth()->toDateString();
        $prev_month = $this->countAccomp($mprev_startDate, $mprev_endDate, $dept_code);
        // dd($prev_month);

        //TWO MONTHS AGO
        $twomonths_startDate = Carbon::now()->subMonths(2)->startOfMonth()->toDateString();
        $twomonths_endDate = Carbon::now()->subMonths(2)->endOfMonth()->toDateString();
        $twomonths_data = $this->countAccomp($twomonths_startDate, $twomonths_endDate, $dept_code);

        //******************************************************************/
        //FOR THE ENTIRE YEAR
        $annual_startDate = Carbon::now()->startOfYear()->toDateString();
        $annual_endDate = Carbon::now()->toDateString();
        $annual_current = $this->countAccomp($annual_startDate, $annual_endDate, $dept_code);

        return inertia('Dashboard/Index', [
            'last_30_days' => $last_30_days,
            'week_current' => $week_current,
            'week_prev_current' => $week_prev_current,
            'annual_current' => $annual_current,
            'current_month' => $current_month,
            'prev_month' => $prev_month,
            'twomonths_data' => $twomonths_data
        ]);
        // dd($annual_current);
    }

    public function countAccomp($start, $end, $dept_code)
    {
        return Daily_Accomplishment::join('user_employees', 'user_employees.empl_id', 'ipcr_daily_accomplishments.emp_code')
            ->where('user_employees.department_code', $dept_code)
            ->whereDate('ipcr_daily_accomplishments.date', '>=', $start)
            ->whereDate('ipcr_daily_accomplishments.date', '<=', $end)
            ->sum('ipcr_daily_accomplishments.quantity');
    }
}
