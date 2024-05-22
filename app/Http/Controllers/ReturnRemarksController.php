<?php

namespace App\Http\Controllers;

use App\Models\Division;
use App\Models\FFUNCCOD;
use App\Models\Ipcr_Semestral;
use App\Models\IPCRTargets;
use App\Models\MonthlyAccomplishment;
use App\Models\Office;
use App\Models\ProbationaryTemporaryEmployees;
use App\Models\ReturnRemarks;
use App\Models\UserEmployees;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReturnRemarksController extends Controller
{
    protected $return_remarks, $prob_tempo, $ipcr_semestral, $monthly_accomplishments;
    public function __construct(
        ReturnRemarks $return_remarks,
        ProbationaryTemporaryEmployees $prob_tempo,
        Ipcr_Semestral $ipcr_semestral,
        MonthlyAccomplishment $monthly_accomplishments
    ) {
        $this->return_remarks = $return_remarks;
        $this->prob_tempo = $prob_tempo;
        $this->ipcr_semestral = $ipcr_semestral;
        $this->monthly_accomplishments = $monthly_accomplishments;
    }
    //
    public function returnRemarks(Request $request)
    {
        // dd('return monthly');
        $attributes = $request->validate([
            'type' => 'required',
            'remarks' => 'required',
            'ipcr_semestral_id' => 'required',
            'employee_code' => 'required',
        ]);
        $type = $request->type;
        $id = $request->ipcr_semestral_id;
        if ($type === 'probationary/temporary') {
            $data = $this->prob_tempo->findOrFail($id);
            $data->update([
                'status' => '-2'
            ]);
        } else {
            $data = $this->ipcr_semestral->findOrFail($id);
            $data->update([
                'status' => '-2'
            ]);
        }
        $this->return_remarks->create($attributes);
        return redirect('/review/approve')
            ->with('message', 'Return remarks');
    }
    public function returnRemarksAccomplishments(Request $request)
    {
        // dd('returnRemarksAccomplishments: ' . $request->ipcr_monthly_accomplishment_id);
        $attributes = $request->validate([
            'type' => 'required',
            'remarks' => 'required',
            'ipcr_semestral_id' => 'required',
            'employee_code' => 'required',
            'ipcr_monthly_accomplishment_id' => 'required',
        ]);
        // dd("after validate");
        $type = $request->type;
        $id = $request->ipcr_monthly_accomplishment_id;
        if ($type === 'probationary/temporary') {
            $data = $this->prob_tempo->findOrFail($id);
            $data->update([
                'status' => '-2'
            ]);
        } else {
            // dd('gfdgdfgdfgdfg');
            $data = $this->monthly_accomplishments->findOrFail($id);
            // dd($data);
            $data->update([
                'status' => '-2'
            ]);
        }
        $this->return_remarks->create($attributes);
        return redirect('/approve/accomplishments')
            ->with('update', 'Return remarks');
    }
    public function returnRemarksResponsible(Request $request)
    {
        //Generate return remarks for ipcr semestrals with no entries in return_remarks table
        $ipcr_sem = Ipcr_Semestral::all();
        for ($i = 0; $i < count($ipcr_sem); $i++) {
            // dd($ipcr_sem[$i]);
            // dd($ipcr_sem[$i]);
            $idipcr = $ipcr_sem[$i]['id'];
            $employee_code = $ipcr_sem[$i]['employee_code'];
            $status = $ipcr_sem[$i]['status'];
            $status_accomplishment = $ipcr_sem[$i]['status_accomplishment'];
            $immediate_id = $ipcr_sem[$i]['immediate_id'];
            $next_higher = $ipcr_sem[$i]['next_higher'];
            //Check if ipcr_semestral targets has been reviewed
            if ($status > 0) {
                $target_rev = ReturnRemarks::where('type', 'review target')
                    ->where('ipcr_semestral_id', $idipcr)
                    ->get();
                //if the return_remarks entry is less than 1, generate return remarks
                if (count($target_rev) < 1) {
                    $target_rev_retrem = new ReturnRemarks();
                    $target_rev_retrem->type = 'review target';
                    $target_rev_retrem->remarks = '';
                    $target_rev_retrem->ipcr_semestral_id = $idipcr;
                    $target_rev_retrem->ipcr_monthly_accomplishment_id = '';
                    $target_rev_retrem->employee_code = $employee_code;
                    $target_rev_retrem->acted_by = $immediate_id;
                    $target_rev_retrem->save();
                }
            }


            //Check if approve exists (targets)

            //Check if IPCR has been approved
            if ($status > 1) {
                $target_app = ReturnRemarks::where('type', 'approve target')
                    ->where('ipcr_semestral_id', $idipcr)
                    ->get();
                //if the return_remarks entry is less than 1, generate return remarks
                if (count($target_app) < 1) {
                    $target_app_retrem = new ReturnRemarks();
                    $target_app_retrem->type = 'approve target';
                    $target_app_retrem->remarks = '';
                    $target_app_retrem->ipcr_semestral_id = $idipcr;
                    $target_app_retrem->ipcr_monthly_accomplishment_id = '';
                    $target_app_retrem->employee_code = $employee_code;
                    $target_app_retrem->acted_by = $next_higher;
                    $target_app_retrem->save();
                }
            }

            //Check if ipcr_semestral (semestral accomplishments) has been reviewed
            if ($status_accomplishment > 0) {
                $sem_accomp_rev = ReturnRemarks::where('type', 'review semestral accomplishment')
                    ->where('ipcr_semestral_id', $idipcr)
                    ->get();
                //if the return_remarks entry is less than 1, generate return remarks
                if (count($sem_accomp_rev) < 1) {
                    $sem_accomp_rev_retrem = new ReturnRemarks();
                    $sem_accomp_rev_retrem->type = 'review semestral accomplishment';
                    $sem_accomp_rev_retrem->remarks = '';
                    $sem_accomp_rev_retrem->ipcr_semestral_id = $idipcr;
                    $sem_accomp_rev_retrem->ipcr_monthly_accomplishment_id = '';
                    $sem_accomp_rev_retrem->employee_code = $employee_code;
                    $sem_accomp_rev_retrem->acted_by = $immediate_id;
                    $sem_accomp_rev_retrem->save();
                }
            }

            //Check if ipcr_semestrals (semestral accomplishments) is approved
            if ($status_accomplishment > 1) {
                $sem_accomp_rev = ReturnRemarks::where('type', 'approve semestral accomplishment')
                    ->where('ipcr_semestral_id', $idipcr)
                    ->get();
                //if the return_remarks entry is less than 1, generate return remarks
                if (count($sem_accomp_rev) < 1) {
                    $sem_accomp_rev_retrem = new ReturnRemarks();
                    $sem_accomp_rev_retrem->type = 'approve semestral accomplishment';
                    $sem_accomp_rev_retrem->remarks = '';
                    $sem_accomp_rev_retrem->ipcr_semestral_id = $idipcr;
                    $sem_accomp_rev_retrem->ipcr_monthly_accomplishment_id = '';
                    $sem_accomp_rev_retrem->employee_code = $employee_code;
                    $sem_accomp_rev_retrem->acted_by = $next_higher;
                    $sem_accomp_rev_retrem->save();
                }
            }
        }
        // dd("person responsible");
        $retrem = ReturnRemarks::all();

        for ($i = 0; $i < count($retrem); $i++) {
            $id = $retrem[$i]['id'];
            $sem_id = $retrem[$i]['ipcr_semestral_id'];
            // $ipcr_monthly_accomp_id = $retrem[$i][''];
            $rem_type = $retrem[$i]['type'];
            $ipcr_semestrals = Ipcr_Semestral::where('id', $sem_id)->first();
            $acted_by = '';
            // dd($sem_id);
            if ($ipcr_semestrals) {
                // dd($ipcr_semestrals);

                if ($rem_type == 'review target') {
                    // dd($rem_type);
                    // $acted_by = $ipcr_semestrals->ipcr;
                    $acted_by = $ipcr_semestrals->immediate_id;
                }
                if ($rem_type == 'approve target') {
                    // dd($rem_type);
                    $acted_by = $ipcr_semestrals->next_higher;
                }
                if ($rem_type == 'review accomplishment') {
                    // dd($rem_type);
                    $acted_by = $ipcr_semestrals->immediate_id;
                }
                if ($rem_type == 'approve accomplishment') {
                    // dd($rem_type);
                    $acted_by = $ipcr_semestrals->next_higher;
                }
                if ($rem_type == 'final approve accomplishment') {
                    // dd($rem_type);
                    $acted_by = $ipcr_semestrals->immediate_id;
                }
                if ($rem_type == 'return accomplishment') {
                    // dd($rem_type);
                    $acted_by = '';
                }
                if ($rem_type == 'return target') {
                    // dd($rem_type);
                    $acted_by = '';
                }
                if ($rem_type == 'review semestral accomplishment') {
                    // dd($rem_type);
                    $acted_by = $ipcr_semestrals->next_higher;
                }
                if ($rem_type == 'approve semestral accomplishment') {
                    // dd($rem_type);$acted_by = $ipcr_semestrals->immediate_id;
                    $acted_by = $ipcr_semestrals->immediate_id;
                }
                if ($rem_type == 'return semestral accomplishment') {
                    // dd($rem_type);
                    $acted_by = '';
                }
                if ($acted_by == '') {
                } else {
                    $my_ipcr = ReturnRemarks::find($id);
                    $my_ipcr->acted_by = $acted_by;
                    $my_ipcr->save();
                }
            }
            // dd($retrem[$i]);
            // dd($rem_type);
        }
    }
    public function actedParticulars(Request $request)
    {
        $user_id = auth()->user()->username;
        $data = ReturnRemarks::where('return_remarks.acted_by', $user_id)
            ->join('user_employees', 'user_employees.empl_id', 'return_remarks.employee_code')
            ->join('ipcr__semestrals', 'ipcr__semestrals.id', 'return_remarks.ipcr_semestral_id')
            ->paginate(10);

        return inertia('Acted_Review/Index', [
            "data" => $data
        ]);
    }
    public function actedParticularsTargets(Request $request)
    {
        // at.id, dat.empl_id, dat.employee_name, dat.year, dat.sem, dat.status
        $user_id = auth()->user()->username;
        $data = ReturnRemarks::select(
            'return_remarks.id',
            'return_remarks.type',
            'return_remarks.ipcr_semestral_id',
            'return_remarks.ipcr_monthly_accomplishment_id',
            'user_employees.empl_id',
            'return_remarks.acted_by',
            'user_employees.employee_name',
            'ipcr__semestrals.sem',
            'ipcr__semestrals.immediate_id',
            'ipcr__semestrals.next_higher',
            'ipcr__semestrals.position',
            'user_employees.salary_grade',
            'ipcr__semestrals.year',
            'ipcr__semestrals.status',
        )
            ->where('return_remarks.acted_by', $user_id)
            ->where('type', 'LIKE', '%target%')
            ->join('user_employees', 'user_employees.empl_id', 'return_remarks.employee_code')
            ->join('ipcr__semestrals', 'ipcr__semestrals.id', 'return_remarks.ipcr_semestral_id')
            ->paginate(10);
        // dd($data);
        return inertia('Acted_Review/Targets', [
            "data" => $data
        ]);
    }
    public function actedParticularsAccomplishments(Request $request)
    {
        // dd('actedParticularsAccomplishments');
        $user_id = auth()->user()->username;
        $data = ReturnRemarks::select(
            'user_employees.empl_id',
            'user_employees.employee_name',
            'return_remarks.ipcr_semestral_id',
            'return_remarks.ipcr_monthly_accomplishment_id',
            'return_remarks.remarks',
            'ipcr__semestrals.year',
            'ipcr__semestrals.sem',
            'ipcr__semestrals.status_accomplishment AS a_status',
            'ipcr_monthly_accomplishments.id AS accomp_id',
            'ipcr_monthly_accomplishments.month',
            'user_employees.position_long_title AS position',
            // DB::raw($dv . ' as division'),
            'user_employees.department_code AS office',
            'ipcr__semestrals.immediate_id AS immediate',
            'ipcr__semestrals.next_higher',
            'user_employees.employment_type_descr',
            'ipcr_monthly_accomplishments.id AS ipcr_monthly_accomplishments',
            'return_remarks.type',
        )
            ->where('return_remarks.acted_by', $user_id)
            ->where('type', 'LIKE', '%accomplishment%')
            ->where('return_remarks.ipcr_monthly_accomplishment_id', NULL)
            ->leftjoin('user_employees', 'user_employees.empl_id', 'return_remarks.employee_code')
            ->leftjoin('ipcr__semestrals', 'ipcr__semestrals.id', 'return_remarks.ipcr_semestral_id')
            ->leftjoin('ipcr_monthly_accomplishments', 'ipcr_monthly_accomplishments.id', 'return_remarks.ipcr_monthly_accomplishment_id')
            ->paginate(10);

        // dd($data);
        $data->getCollection()->transform(function ($item) {
            // Modify the item as needed
            $of = "";
            $div = "";
            $imm = "";
            $next = "";
            $dv = Division::where('division_code', $item->division_code)->first();
            if ($dv) {
                $div = $dv->division_name1;
            }
            $imm_emp = UserEmployees::where('empl_id', $item->immediate)->first();
            if ($imm_emp) {
                $imm = $imm_emp->first_name . ' ' . $imm_emp->last_name;
            }


            $nx = UserEmployees::where(
                'empl_id',
                $item->next_higher
            )->first();
            if ($nx) {
                $next = $nx->first_name . ' ' . $nx->last_name;
            }

            $of = FFUNCCOD::where(
                'department_code',
                $item->office
            )->first();
            // dd($item->department_code);
            if ($of) {
                $off = $of->FFUNCTION;
            }
            $item['office'] = $off;
            $item['division'] = $div; // Set division based on some condition or calculation
            $item['immediate'] = $imm;
            $item['next_higher'] = $next;

            return $item;
        });

        $emp = UserEmployees::where('empl_id', auth()->user()->username)
            ->first();
        $dept = Office::where('department_code', $emp->department_code)->first();
        $pgHead = UserEmployees::where('empl_id', $dept->empl_id)->first();
        $pgHeadn = $pgHead->first_name . ' ' . $pgHead->middle_name[0] . '. ' . $pgHead->last_name;
        if ($pgHead->suffix_name != NULL) {
            $pgHeadn = $pgHeadn . ', ' . $pgHead->suffix_name;
        }
        if ($pgHead->postfix_name != NULL) {
            $pgHeadn = $pgHeadn . ', ' . $pgHead->postfix_name;
        }
        return inertia('Acted_Review/Accomplishments', [
            "data" => $data,
            'pghead' => $pgHeadn
        ]);
    }
    public function actedParticularsAccomplishmentsMonthly(Request $request)
    {
        $user_id = auth()->user()->username;
        $imm =  NULL;
        $next = NULL;
        $dv = NULL;
        $data = ReturnRemarks::select(
            'user_employees.empl_id',
            'user_employees.employee_name',
            'return_remarks.ipcr_semestral_id',
            'return_remarks.ipcr_monthly_accomplishment_id',
            'return_remarks.remarks',
            'ipcr__semestrals.year',
            'ipcr__semestrals.sem',
            'ipcr__semestrals.status_accomplishment AS a_status',
            'ipcr_monthly_accomplishments.id AS accomp_id',
            'ipcr_monthly_accomplishments.month',
            'user_employees.position_long_title AS position',
            // DB::raw($dv . ' as division'),
            'user_employees.department_code AS office',
            'ipcr__semestrals.immediate_id AS immediate',
            'ipcr__semestrals.next_higher',
            'user_employees.employment_type_descr',
            'ipcr_monthly_accomplishments.id AS ipcr_monthly_accomplishments',
            'return_remarks.type',
        )
            ->where('return_remarks.acted_by', $user_id)
            ->where('type', 'LIKE', '%accomplishment%')
            ->where('return_remarks.ipcr_monthly_accomplishment_id', '<>', '')
            ->leftjoin('user_employees', 'user_employees.empl_id', 'return_remarks.employee_code')
            ->leftjoin('ipcr__semestrals', 'ipcr__semestrals.id', 'return_remarks.ipcr_semestral_id')
            ->leftjoin('ipcr_monthly_accomplishments', 'ipcr_monthly_accomplishments.id', 'return_remarks.ipcr_monthly_accomplishment_id')
            ->orderBy('return_remarks.created_at', 'DESC')
            ->paginate(10);

        $data->getCollection()->transform(function ($item) {
            // Modify the item as needed
            $of = "";
            $div = "";
            $imm = "";
            $next = "";
            $dv = Division::where('division_code', $item->division_code)->first();
            if ($dv) {
                $div = $dv->division_name1;
            }
            $imm_emp = UserEmployees::where('empl_id', $item->immediate)->first();
            if ($imm_emp) {
                $imm = $imm_emp->first_name . ' ' . $imm_emp->last_name;
            }


            $nx = UserEmployees::where(
                'empl_id',
                $item->next_higher
            )->first();
            if ($nx) {
                $next = $nx->first_name . ' ' . $nx->last_name;
            }

            $of = FFUNCCOD::where(
                'department_code',
                $item->department_code
            )->first();
            if ($of) {
                $off = $of->FFUNCTION;
            }
            $item['office'] = $off;
            $item['division'] = $div; // Set division based on some condition or calculation
            $item['immediate'] = $imm;
            $item['next_higher'] = $next;

            return $item;
        });
        return inertia('Acted_Review/AccomplishmentsMonthly', [
            "data" => $data
        ]);
    }
}
