<?php

namespace App\Http\Controllers;

use App\Helpers\PaginationHelper;
use App\Models\Division;
use App\Models\FFUNCCOD;
use App\Models\IndividualFinalOutput;
use App\Models\Ipcr_Semestral;
use App\Models\IPCRTargets;
use App\Models\MonthlyAccomplishment;
use App\Models\Office;
use App\Models\ReturnRemarks;
use App\Models\UserEmployees;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class IpcrSemestralController extends Controller
{
    protected $ipcr_sem;
    public function __construct(Ipcr_Semestral $ipcr_sem)
    {
        $this->ipcr_sem = $ipcr_sem;
    }
    public function index(Request $request, $id, $source)
    {
        $emp = UserEmployees::where('id', $id)
            ->first();
        $emp_code = $emp->empl_id;
        // dd($emp_code);
        $division = "";
        if ($emp->division_code) {
            $division = Division::where('division_code', $emp->division_code)
                ->first()->division_name1;
        }
        $office = FFUNCCOD::where('department_code', $emp->department_code)->first();
        $dept = Office::where('department_code', $emp->department_code)->first();
        $pgHead = UserEmployees::where('empl_id', $dept->empl_id)->first();
        $pgHead = $pgHead->first_name . ' ' . $pgHead->middle_name[0] . '. ' . $pgHead->last_name;

        $is_add = '';

        $sem_data
            = Ipcr_Semestral::select(
                'ipcr__semestrals.id as ipcr_sem_id',
                DB::raw('NULL as id_target'),
                'ipcr__semestrals.employee_code',
                'ipcr__semestrals.immediate_id',
                'ipcr__semestrals.next_higher',
                'ipcr__semestrals.sem',
                'ipcr__semestrals.status',
                'ipcr__semestrals.year',
                DB::raw('NULL as is_additional_target'),
                DB::raw('NULL as target_status')
            )
            ->where('ipcr__semestrals.employee_code', $emp_code)
            ->union(
                Ipcr_Semestral::select(
                    'ipcr__semestrals.id as ipcr_sem_id',
                    'i_p_c_r_targets.id as id_target',
                    'ipcr__semestrals.employee_code',
                    'ipcr__semestrals.immediate_id',
                    'ipcr__semestrals.next_higher',
                    'ipcr__semestrals.sem',
                    'ipcr__semestrals.status',
                    'ipcr__semestrals.year',
                    'i_p_c_r_targets.is_additional_target',
                    'i_p_c_r_targets.status AS target_status'
                )
                    ->leftJoin('i_p_c_r_targets', 'ipcr__semestrals.id', '=', 'i_p_c_r_targets.ipcr_semester_id')
                    ->where('i_p_c_r_targets.is_additional_target', 1)
                    ->where('ipcr__semestrals.employee_code', $emp_code)
            )
            ->orderBy('year', 'DESC')
            ->orderBy('sem', 'DESC')
            // ->orderBy(DB::raw('NULL'))
            ->orderBy('is_additional_target', 'asc')
            ->get()
            ->map(function ($item) {
                // dd($item->ipcr_sem_id);
                $rem = ReturnRemarks::where('ipcr_semestral_id', $item->ipcr_sem_id)
                    ->orderBy('created_at', 'DESC')
                    ->first();
                $immediate = UserEmployees::where('empl_id', $item->immediate_id)
                    ->first();
                $next_higher = UserEmployees::where('empl_id', $item->next_higher)
                    ->first();
                return [
                    'ipcr_sem_id' => $item->ipcr_sem_id,
                    'ipcr_target_id' => $item->id_target,
                    'employee_code' => $item->employee_code,
                    'immediate_id' => $item->immediate_id,
                    'next_higher' => $item->next_higher,
                    "imm" => $immediate,
                    "next" => $next_higher,
                    'sem' => $item->sem,
                    'status' => $item->status,
                    'year' => $item->year,
                    'rem' => $rem,
                    'is_additional_target' => $item->is_additional_target,
                    'target_status' => $item->target_status
                ];
            });

        $showPerPage = 10;

        $sem_data = PaginationHelper::paginate($sem_data, $showPerPage);

        // dd($sem_data);

        return inertia('IPCR/Semestral/Index', [
            "id" => $id,
            "sem_data" => $sem_data,
            "division" => $division,
            "emp" => $emp,
            "source" => $source,
            "office" => $office,
            "pgHead" => $pgHead,
        ]);
    }
    public function create(Request $request, $id, $source)
    {
        // dd($id);
        // dd(auth()->user());
        $emp = UserEmployees::where('id', $id)
            ->first();
        // dd($emp);
        $sg = $emp->salary_grade;
        $dept_code = $emp->department_code;
        $supervisors = UserEmployees::where('salary_grade', '>=', $sg)
            ->where('user_employees.department_code', $dept_code)
            ->get();

        // ->join('ipcr__semestrals', 'ipcr__semestrals.employee_code', 'user_employees.empl_id')
        // ->where(function ($query) use ($dept_code) {
        //     $query->where('user_employees.department_code', $dept_code);
        //     // ->orWhere('user_employees.designate_department_code', $dept_code);
        // })
        // dd($supervisors);
        if ($dept_code == '01') {
            $pgo_add = UserEmployees::where('empl_id', '10106')
                ->orWhere('empl_id', '0361')
                ->get();
            $supervisors = $supervisors->merge($pgo_add);
        }


        // dd($supervisors);
        return inertia('IPCR/Semestral/Create', [
            'supervisors' => $supervisors,
            'id' => $id,
            'emp' => $emp,
            'dept_code' => $dept_code,
            'source' => $source
        ]);
    }
    public function store(Request $request)
    {
        //dd($request->source);
        $emp = UserEmployees::where('empl_id', $request->employee_code)
            ->first();
        // dd($emp);
        $id = $emp->id;
        // dd(auth()->user());
        //For Automatic approved ra ni
        // $request['status'] = 2;

        $attributes = $request->validate([
            'sem' => 'required',
            'employee_code' => 'required',
            'immediate_id' => 'required',
            'next_higher' => 'required',
            'year' => 'required',
            'status' => 'required',
            ''
        ]);
        $ipcr_targg = Ipcr_Semestral::where('employee_code', $request->employee_code)
            ->where('year', $request->year)
            ->where('sem', $request->sem)
            ->get();
        if (count($ipcr_targg) < 1) {
            // $this->ipcr_sem->create($attributes);
            $ipcrsem = new Ipcr_Semestral;
            $ipcrsem->sem = $request->sem;
            $ipcrsem->employee_code = $request->employee_code;
            $ipcrsem->immediate_id = $request->immediate_id;
            $ipcrsem->next_higher = $request->next_higher;
            $ipcrsem->employee_name = $emp->employee_name;
            $ipcrsem->position = $emp->position_title1;
            $ipcrsem->salary_grade = $emp->salary_grade;
            $ipcrsem->division = $emp->division_code;
            $ipcrsem->year = $request->year;
            $ipcrsem->status = $request->status;
            $ipcrsem->save();
            //CREATE MONTHLY ACCOMPLISHMENT
            $ipcr_m_id = $ipcrsem->id;
            $sem = $request->sem;
            $year = $request->year;
            // Define the months based on the semester value
            $months = ($sem == 1) ? ['1', '2', '3', '4', '5', '6'] : ['7', '8', '9', '10', '11', '12'];

            // Create Ipcr_monthly records for each month
            foreach ($months as $month) {
                $existingRecord = MonthlyAccomplishment::where('ipcr_semestral_id', $ipcr_m_id)
                    ->where('month', $month)
                    ->first();
                if (!$existingRecord) {
                    MonthlyAccomplishment::create([
                        'month' => $month,
                        'year' => $year,
                        'ipcr_semestral_id' => $ipcr_m_id, // Reference to the parent semestral record
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
            return redirect('/ipcrsemestral/' . $id . '/' . $request->source)
                ->with('message', 'Semestral target added');
        } else {
            return redirect('/ipcrsemestral/' . $id . '/' . $request->source)
                ->with('error', 'Error adding semestral target');
        }
    }
    public function edit(Request $request, $semid, $source)
    {
        $data = Ipcr_Semestral::where('id', $semid)
            ->first();
        // dd($data->);
        $id = $data->employee_code;
        $emp = UserEmployees::where('empl_id', $id)
            ->first();
        $dept_code = $emp->department_code;
        $supervisors = UserEmployees::where('department_code', $dept_code)
            ->get();

        // dd($supervisors);
        return inertia('IPCR/Semestral/Create', [
            'supervisors' => $supervisors,
            'id' => $id,
            'emp' => $emp,
            'dept_code' => $dept_code,
            'source' => $source,
            'editData' => $data
        ]);
    }
    public function update(Request $request, $id)
    {
        // dd($request);
        $data = $this->ipcr_sem->findOrFail($id);
        // dd($data);
        $curr_sem = $data->sem;
        $new_sem = $request->sem;
        $curr_year = $data->year;
        $new_year = $request->year;
        $user = UserEmployees::where('empl_id', $request->employee_code)
            ->first();
        $ipcr_targg = Ipcr_Semestral::where('employee_code', $request->employee_code)
            ->where('year', $request->year)
            ->where('sem', $request->sem)
            ->where('id', '<>', $id)
            ->get();
        // dd(count($ipcr_targg) >= 1);
        // dd(count($ipcr_targg));
        $user_id = $user->id;
        $typ = "info";
        $msg = "IPCR Semestral updated!";
        if (count($ipcr_targg) < 1) {
            // dd("here: " . count($ipcr_targg));
            // if ($curr_sem != $new_sem && $curr_year != $new_year) {
            $monthly_accomplishment = MonthlyAccomplishment::where("ipcr_semestral_id", $id)
                ->orderByRaw('CAST(month AS UNSIGNED)', 'ASC')
                ->get();

            for ($i = 0; $i < count($monthly_accomplishment); $i++) {
                $curr_mon_sem = MonthlyAccomplishment::where('id', $monthly_accomplishment[$i]['id'])->first();
                $prevmon = $curr_mon_sem->month;
                $monthval = 0;
                if ($new_sem == "2") {
                    $monthval = (int)$i + 7;
                } else {
                    $monthval = (int)$i + 1;
                }
                $monthly_acc = MonthlyAccomplishment::find($monthly_accomplishment[$i]['id']);
                $monthly_acc->month = $monthval;
                $monthly_acc->year = $new_year;
                $monthly_acc->save();
            }
            $ipcr_sem = Ipcr_Semestral::find($id);
            $ipcr_sem->immediate_id = $request->immediate_id;
            $ipcr_sem->next_higher = $request->next_higher;
            $ipcr_sem->year = $request->year;
            $ipcr_sem->sem = $request->sem;
            $ipcr_sem->save();
            // ->map(function ($item) use ($new_sem, $curr_sem, $new_year) {
            // $curr_mon_sem = MonthlyAccomplishment::where('id', $item->id)->first();
            // $prevmon = $curr_mon_sem->month;
            // $monthval = 0;
            // dd($new_year);
            // if ($new_sem == "2") {
            // dd("new_sem: " . $new_sem);
            // if ($curr_sem == "1") {
            //     $monthval = (int)$prevmon + 6;
            // } else {
            //     $monthval = (int)$prevmon;
            // }
            //     if ((int)$prevmon < 7) {
            //         $monthval = (int)$prevmon + 6;
            //     } else {
            //         $monthval = (int)$prevmon;
            //     }
            // } else {
            //     if ((int)$prevmon < 7) {
            //         $monthval = (int)$prevmon;
            //     } else {
            //         $monthval = (int)$prevmon + 6;
            //     }
            // }
            // dd("current: " . $monthval . " prevmon: " . $prevmon);
            // dd($item->id);

            // $monthly_acc = MonthlyAccomplishment::find($item->id);
            // if ($item->id == '1') {
            //     dd($monthly_acc);
            // }
            // $monthly_acc->month = $monthval;
            // $monthly_acc->year = $new_year;
            // $monthly_acc->save();
            // dd($new_year);
            // MonthlyAccomplishment::where('id', $item->id)
            //     ->update([
            //         "month" => $monthval,
            //         "year" => $new_year
            //     ]);
            // });
            // }
            // dd($request->year);
            // dd($data);
            // $ipcr_sem = Ipcr_Semestral::find($id);
            // dd($ipcr_sem);
            // $ipcr_sem->immediate_id = $request->immediate_id;
            // $ipcr_sem->next_higher = $request->next_higher;
            // $ipcr_sem->year = $request->year;
            // $ipcr_sem->sem = $request->sem;
            // $ipcr_sem->save();
            // IPCRTargets::where("ipcr_semester_id", $id)
            //     ->update([
            //         'semester' => $request->sem,
            //         'year' => $request->year
            //     ]);
            // $data = $this->ipcr_sem->findOrFail($request->id);
            // dd($data);
        } else {
            $typ = "error";
            $msg = "Update results to duplication of an existing IPCR! Update unsuccessful.";
        }


        return redirect('/ipcrsemestral/' . $user_id . '/' . $request->source)
            ->with($typ, $msg);
    }
    // if (count($ipcr_targg) == 1) {
    //     // dd("count");

    // } else {
    //     return redirect('/ipcrsemestral/' . $user_id . '/' . $request->source)
    //         ->with('error', 'Error updating semestral target!');
    // }
    // $data->update([
    //     'sem' => $request->sem,
    //     'employee_code' => $request->employee_code,
    //     'immediate_id' => $request->immediate_id,
    //     'next_higher' => $request->next_higher,
    //     'ipcr_semester_id' => $request->ipcr_semester_id,
    //     'status' => $request->status,
    //     'year' => $request->year,
    // ]);
    public function destroy(Request $request, $id, $source)
    {
        // dd('delete : '.$id);
        $emp_code = auth()->user()->username;
        $emp = UserEmployees::where('empl_id', $emp_code)
            ->first()->id;

        $data = $this->ipcr_sem->findOrFail($id);
        $data->delete();

        $ipcr_monthly_accomp = MonthlyAccomplishment::where('ipcr_semestral_id', $id)->delete();
        $ipcr_targ = IPCRTargets::where('ipcr_semester_id', $id)->delete();
        return redirect('/ipcrsemestral/' . $emp . '/' . $source)
            ->with('deleted', 'Employee IPCR Deleted!');
    }
    public function submission(Request $request, $id, $source)
    {

        $data = $this->ipcr_sem->findOrFail($id);
        $user = UserEmployees::where('empl_id', $data->employee_code)
            ->first();
        $user_id = $user->id;
        $data->update([
            'status' => '0',
        ]);

        if ($source == 'targets') {
            return redirect('/ipcrtargets/' . $id)
                ->with('message', 'IPCR submitted');
        } else {
            return redirect('/ipcrsemestral/' . $user_id . '/' . $request->source)
                ->with('message', 'IPCR submitted');
        }
    }
    public function copyIpcr(Request $request, $ipcr_id_copied, $ipcr_id_passed)
    {
        // dd(" ipcr_id_copied: " . $ipcr_id_copied . " ipcr_id_passed: " . $ipcr_id_passed);
        $targetsForCopy = IPCRTargets::where('ipcr_semester_id', $ipcr_id_copied)
            ->get()
            ->map(function ($item) use ($ipcr_id_passed) {
                $sem_s = IPCRTargets::where('ipcr_semester_id', $ipcr_id_passed)
                    ->where('ipcr_code', $item->ipcr_code)
                    ->first();
                if (empty($sem_s)) {
                    $sem = Ipcr_Semestral::where('id', $ipcr_id_passed)->first();
                    $my_new = new IPCRTargets();
                    $my_new->employee_code = $sem->employee_code;
                    $my_new->ipcr_code = $item->ipcr_code;
                    $my_new->semester = $sem->sem;
                    $my_new->ipcr_type = $item->ipcr_type;
                    $my_new->is_additional_target = '';
                    $my_new->ipcr_semester_id = $ipcr_id_passed;
                    $my_new->quantity_sem = $item->quantity_sem;
                    $my_new->month_1 = $item->month_1;
                    $my_new->month_2 = $item->month_2;
                    $my_new->month_3 = $item->month_3;
                    $my_new->month_4 = $item->month_4;
                    $my_new->month_5 = $item->month_5;
                    $my_new->month_6 = $item->month_6;
                    $my_new->year = $item->year;
                    $my_new->remarks = $item->remarks;
                    $my_new->deleted_at = $item->deleted_at;
                    $my_new->created_at = $item->created_at;
                    $my_new->updated_at = $item->updated_at;
                    $my_new->save();
                }
            });

        return back()->with('message', 'Successfully copied targets');
    }
}
