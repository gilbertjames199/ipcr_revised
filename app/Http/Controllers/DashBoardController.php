<?php

namespace App\Http\Controllers;

use App\Models\Daily_Accomplishment;
use App\Models\Division;
use App\Models\Ipcr_Semestral;
use App\Models\MonthlyAccomplishment;
use App\Models\MonthlyAccomplishmentRating;
use App\Models\Office;
use App\Models\SPMSFAO;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\UserEmployeeCredential;
use App\Models\UserEmployees;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Expr\FuncCall;

class DashBoardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    //$totalAll = $this->totalAll();
    private $model;
    private $model1;
    public function __construct(SPMSFAO $model, UserEmployeeCredential $model1)
    {
        $this->model = $model;
        $this->model1 = $model1;
    }

    public function index(Request $request)
    {
        // dd(Carbon::create(now()->year, 4)->format('F'));
        $emp_code = Auth()->user()->username;
        $current_year = date('Y');

        $faos = SPMSFAO::all();


        $user_emp = UserEmployeeCredential::where('username', $emp_code)
            ->first();

        $data = MonthlyAccomplishmentRating::where('cats_number', $emp_code)
            ->where('year', $current_year)
            ->get();
        $month = [];
        $numerical = [];
        for ($i = 1; $i <= $data->max('month'); $i++) {
            array_push(
                $month,
                Carbon::create(now()->year, $i)->format('F')
            );
            $findFromData = $data->firstWhere('month', $i);
            if ($findFromData) {
                $rate = $findFromData->numerical_rating;
            } else {
                $rate = 0;
            }
            array_push(
                $numerical,
                $rate
            );
        }
        // dd($current_year);
        //dd('create: '.auth()->user()->can('create',User::class).'edit: '.auth()->user()->can('edit',User::class).'delete: '.auth()->user()->can('delete',User::class));


        // dd($data);
        return inertia(
            'Home',
            [
                'user_notice' => $user_emp,
                'faos' => $faos,
                'data' => $data,
                'months' => $month,
                'ratings' => $numerical
            ]
        );
    }

    public function dashboard(Request $request)
    {

        // dd('analytics dashboard');
        $can_see = $this->canSeeStats();
        if ($can_see) {
            $dept_code = auth()->user()->department_code;
            // dd($request->dept_code);
            if ($request->dept_code !== '' && $request->dept_code !== null) {
                // dd($request->dept_code . ' deptcode');
                $dept_code = $request->dept_code;
            } else {
                $dept_code = auth()->user()->department_code;
            }
            // dd($dept_code);
            // dd($request->dept_code);
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

            $division = Division::where('department_code', $request->dept_code)->get();
            // dd($request->division_code);
            $data = UserEmployees::leftJoin('ipcr_daily_accomplishments', 'user_employees.empl_id', '=', 'ipcr_daily_accomplishments.emp_code')
                ->select(
                    'user_employees.first_name',
                    'user_employees.employee_name',
                    DB::raw('COUNT(ipcr_daily_accomplishments.quantity) as quant'),
                    'user_employees.division_code',
                )
                ->when($request->month, function ($query, $searchItem) {
                    $query->whereRaw('MONTH(date) = ?', $searchItem);
                })
                ->when($request->division_code, function ($query, $searchItem) {
                    $query->whereRaw('division_code = ?', $searchItem);
                })
                ->where(function ($query) use ($dept_code) {
                    $query->where('user_employees.department_code', $dept_code)
                        ->orWhere('user_employees.designate_department_code', $dept_code);
                })
                ->where('user_employees.active_status', 'ACTIVE')
                ->where('user_employees.salary_grade', '<', 26)
                ->groupBy('user_employees.employee_name')
                ->orderBy('quant', 'desc')
                ->get();
            // dd($data->pluck('employee_name'));
            $offices = Office::where('office', 'LIKE', '%Provincial%')
                ->orWhere('office', 'LIKE', '%SANGGUNIANG%')
                ->orWhere('office', 'LIKE', '%Vice%')
                ->orderBy('office', 'ASC')
                ->get();
            // dd($last_30_days);
            return inertia('Dashboard/Index', [
                'last_30_days' => $last_30_days,
                'week_current' => $week_current,
                'week_prev_current' => $week_prev_current,
                'annual_current' => $annual_current,
                'current_month' => $current_month,
                'prev_month' => $prev_month,
                'twomonths_data' => $twomonths_data,
                'tasks' => $data,
                'offices' => $offices,
                'my_dept_code' => $dept_code,
                'can_see' => $can_see,
                'division' => $division,
            ]);
        } else {
            return redirect('/forbidden')
                ->with('error', 'Access forbidden!');
        }
        // dd($annual_current);
    }

    public function FAOS(Request $request)
    {
        $data = SPMSFAO::all();
        return inertia('FAOs/Index', [
            'data' => $data,
        ]);
    }

    public function create()
    {
        $data = SPMSFAO::select(
            's_p_m_s_f_a_o_s.id',
            's_p_m_s_f_a_o_s.Questions',
            's_p_m_s_f_a_o_s.Answers',
        )
            ->get();

        return inertia('FAOs/Create', [
            'data' => $data
        ]);
    }

    public function store(Request $request)
    {

        // dd($request);
        $request->validate([
            'Questions' => 'required',
            'Answers' => 'required',
        ]);

        // dd($request->all());
        $this->model->create($request->all());
        return redirect('/dashboard/faos')
            ->with('message', 'FAOs added');
    }

    public function edit(Request $request, $id)
    {
        $data = $this->model->where('id', $id)->first([
            'id',
            'Questions',
            'Answers',
        ]);
        return inertia('FAOs/Create', [
            "editData" => $data,
            'can' => [
                'can_access_validation' => Auth::user()->can('can_access_validation', User::class),
                'can_access_indicators' => Auth::user()->can('can_access_indicators', User::class)
            ],
        ]);
    }
    public function update(Request $request)
    {

        $data = $this->model->findOrFail($request->id);
        $data->update([
            'Questions' => $request->Questions,
            'Answers' => $request->Answers,
        ]);
        // dd($request->Questions);
        return redirect('/dashboard/faos')
            ->with('info', 'FAOs updated');
    }

    public function notice_update(Request $request)
    {

        // dd(carbon::now()->format('Y-m-d'));
        $date = carbon::now()->format('Y-m-d');
        // dd($date);
        $data = $this->model1->findOrFail($request->id);
        $data->update([
            'date_of_notice' => $date,
        ]);
        // dd($request->Questions);
        return redirect('/home/');
        // ->with('info', 'FAOs updated');
    }

    public function destroy(Request $request)
    {
        $data = $this->model->findOrFail($request->id);
        $data->delete();
        //dd($request->raao_id);
        return redirect('/dashboard/faos')->with('warning', 'FAOs Deleted');
    }

    public function canSeeStats()
    {
        $can_see = false;
        // dd(auth()->user());
        $dept_code = auth()->user()->department_code;
        $emp_code = auth()->user()->username;
        $emp = UserEmployees::where('empl_id', $emp_code)->first();

        // dd($emp);
        // $dept_code == '26' &&
        if ($emp->salary_grade >= 18) {
            $can_see = true;
        }

        if ($emp->is_pghead > 0) {
            $can_see = true;
        }
        // if (this.auth.user.name.department_code == '03') {
        //     can_see = true;
        // }
        // 2730
        //
        if ($emp_code === '2730' || $emp_code === '2960' | $emp_code === '8354' | $emp_code === '8510') {
            $can_see = true;
        }
        return $can_see;
    }
    public function countAccomp($start, $end, $dept_code)
    {
        return Daily_Accomplishment::join('user_employees', 'user_employees.empl_id', 'ipcr_daily_accomplishments.emp_code')
            ->where('user_employees.department_code', $dept_code)
            ->whereDate('ipcr_daily_accomplishments.date', '>=', $start)
            ->whereDate('ipcr_daily_accomplishments.date', '<=', $end)
            ->where('user_employees.active_status', 'ACTIVE')
            ->count();
    }
}
