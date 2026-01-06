<?php

namespace App\Http\Controllers;

use App\Helpers\TimeHelper;
use App\Models\Daily_Accomplishment;
use App\Models\Division;
use App\Models\EmployeeSpecialDepartment;
use App\Models\FFUNCCOD;
use App\Models\HospitalTarget;
use App\Models\IndividualFinalOutput;
use App\Models\Ipcr_Semestral;
use App\Models\MonthlyAccomplishment;
use App\Models\MonthlyAccomplishmentRating;
use App\Models\MonthlyRemarks;
use App\Models\MonthlyTarget;
use App\Models\Office;
use App\Models\ReturnRemarks;
use App\Models\TimeRange;
use App\Models\UserEmployeeCredential;
use App\Models\UserEmployees;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use PDO;

class AccomplishmentController extends Controller
{
    private $model;
    public function __construct(Daily_Accomplishment $model)
    {
        $this->model = $model;
    }

    public function index(Request $request)
    {
        // dd($request->ipcr_semestral_id);

        $ipcr_semestral_id = $request->ipcr_semestral_id;
        $emp_code = Auth()->user()->username;
        $emp = Auth()->user()->userEmployee;
        $year = $request->year;
        $emp_type = employee_division_head($emp_code);
        $month = $this->monthNameToNumber($request->month);
        // dd($emp_type);
        $mo2 = $month;

        $semt = 1;
        if ($mo2 > 6) {
            $mo2 = intval($mo2) - 6;
            $semt = 2;
        }

        $data = $this->getAccomplishmenttData($emp_type, $emp_code, $ipcr_semestral_id, $month, $year);
        // dd(count($data));
        if (count($data) < 1) {
            if ($month > 6) {
                // dd($month);
                $month_pass = $month - 6;
                $data = $this->getAccomplishmenttData($emp_type, $emp_code, $ipcr_semestral_id, $month_pass, $year);
            }
        }
        // dd($data);
        $year = $request->year;

        $div = auth()->user()->division_code;

        if (count($data) > 0) {
            $us = auth()->user()->load([
                'userEmployee.Division',
                'userEmployee.Office',
                'userEmployee.Office.pgHead',
                'employeeSpecialDepartment',
                'employeeSpecialDepartment.Office',
                'employeeSpecialDepartment.PGDH',
            ]);
            // dd($us);
            $office = "";


            $mo = $data[0];
            // dd($mo);
            $div = "";
            $div = $us->userEmployee->Division;
            $immh = $mo['imm'];
            $nxth = $mo['next'];
            // dd($immh);
            // $div = $this->getDivision($div, $immh, $nxth);
            // dd($div);
            // dd($data[0]['sem_data']->division_name);
            // if (
            //     is_array($data)
            //     && isset($data[0])
            //     && is_array($data[0])
            //     && isset($data[0]['sem_data'])
            //     && is_object($data[0]['sem_data'])
            //     && property_exists($data[0]['sem_data'], 'division_name')
            // ) {
            $div = $data[0]['sem_data']->division_name;
            // }
            // dd($div);
            $rm = '';
            // if ($mo['monthly_accomp']->returnRemarks) {
            //     $rm = $mo['monthly_accomp']->returnRemarks->remarks;
            // }
            $my_stat = $mo['monthly_accomp'][0]->status;
            // dd($my_stat);
            $my_sem_id = $mo['sem_id'];
            $mo_data = [
                "id" => $mo['monthly_accomp'][0]->id,
                "division" => $div,
                "employee_code" => $emp->empl_id,
                "imm" => $immh,
                "next" => $nxth,
                "sem" => $mo['sem_data']->sem,
                "status" => $my_stat,
                "year" => $year,
                "rem" => $rm,
                "month" => $mo2
            ];

            $off_pg = $this->getOffice($us);
            $office = $off_pg['office'];
            $pgHead = $off_pg['pgHead'];
            $dept = $office;

            return inertia('Monthly_Accomplishment/Index', [
                // "data" => $data,
                "emp_code" => $emp_code,
                "month" => $request->month,
                "year" => $year,
                "data" => $data,
                "month_data" => $mo_data,
                "office" => $office,
                "dept" => $dept,
                "pgHead" => $this->getPGDH($pgHead),
                'sem_id' => $my_sem_id,
                "status" => $my_stat,
                // "sel_month"=>
            ]);
        } else {
            $per = $request->month . ', ' . $year;
            return redirect()->back()->with('error', 'Accomplishments for ' . $per . ' is empty');
        }
    }

    public function getAccomplishmenttData($is_division_head, $emp_code, $ipcr_semestral_id, $month, $year)
    {
        // dd($is_division_head);
        if ($is_division_head == 'emp') {
            // $is_division_head = 'emp';
            $accomplishment = $this->data_ipcr($emp_code, $ipcr_semestral_id, $month, $year);
        } else if ($is_division_head == 'div') {
            $accomplishment = $this->data_dpcr($emp_code, $ipcr_semestral_id, $month);
        } else if ($is_division_head == 'hemp') {
            $accomplishment = $this->view_hipcr_targets($emp_code, $ipcr_semestral_id, $month);
        } else if ($is_division_head == 'hsec') {
            $accomplishment = $this->view_hspcr_targets($emp_code, $ipcr_semestral_id, $month);
        } else if ($is_division_head == 'hdiv') {
            $accomplishment = $this->view_hdpcr_targets($emp_code, $ipcr_semestral_id, $month);
        } else if ($is_division_head == 'hos') {
            $accomplishment = $this->view_hpcr_targets($emp_code, $ipcr_semestral_id, $month);
        }
        // dd($targets);
        return $accomplishment;
    }
    public function data_ipcr($emp_code, $ipcr_semestral_id, $month, $year)
    {

        // dd($month);
        $month_as_is = $month;
        if ($month > 6) {
            $month = $month - 6;
        }
        $semestrals = Ipcr_Semestral::where('id', $ipcr_semestral_id)->first();
        $year=$semestrals->year;
        // dd($semestrals);
        return MonthlyTarget::with([
            'ipcrTargets',
            'ipcrTargets.individualOutput',
            'ipcrTargets.individualOutput.monthlyRemarks' => function ($query) use ($month, $ipcr_semestral_id) {
                $query->where('monthly_remarks.month', '=', $month);
                $query->where('monthly_remarks.idSemestral', '=', $ipcr_semestral_id);

            },
            'ipcr_Semestral.immediate.Division',
            'ipcr_Semestral.next_higher1.Division',
            'monthlyAccomplishmentMany' => function ($query) use ($month_as_is, $year) {
                $query->where('ipcr_monthly_accomplishments.month', '=', $month_as_is)
                ->where('ipcr_monthly_accomplishments.year', '=', $year);
            },
        ])
            ->where('sem_id', $ipcr_semestral_id)
            ->where('month', $month)
            ->where('year', $year)
            ->get()
            ->map(fn($item, $key) => [

                "individual_output_id" => $item->ipcrTargets->individualOutput->id ?? '',
                "individual_output" => $item->ipcrTargets->individualOutput->individual_output ?? '',
                "performance_measure" => $item->ipcrTargets->individualOutput->performance_measure ?? '',
                "prescribed_period" => $item->ipcrTargets->individualOutput->prescribed_period ?? '',
                "quality1" => $item->ipcrTargets->individualOutput->quality1 ?? '',
                "quality2" => $item->ipcrTargets->individualOutput->quality2 ?? '',
                "quality3" => $item->ipcrTargets->individualOutput->quality3 ?? '',
                "efficiency1" => $item->ipcrTargets->individualOutput->efficiency1 ?? '',
                "efficiency2" => $item->ipcrTargets->individualOutput->efficiency2 ?? '',
                "efficiency3" => $item->ipcrTargets->individualOutput->efficiency3 ?? '',
                "timeliness" => $item->ipcrTargets->individualOutput->timeliness ?? '',
                "type" => $item->ipcrTargets->individualOutput->type ?? '',
                "remarks" =>
                $item->ipcrTargets &&
                    $item->ipcrTargets->individualOutput &&
                    $item->ipcrTargets->individualOutput->monthlyRemarks->first()
                    ? $item->ipcrTargets->individualOutput->monthlyRemarks->first()->remarks
                    : '',

                "remarks_id" =>
                $item->ipcrTargets &&
                    $item->ipcrTargets->individualOutput &&
                    $item->ipcrTargets->individualOutput->monthlyRemarks->first()
                    ? $item->ipcrTargets->individualOutput->monthlyRemarks->first()->id
                    : '',
                'ipcr_type' => $item->ipcrTargets->ipcr_type ?? '',
                "target_remarks" => $item->ipcrTargets->remarks ?? '',
                // "q1" => $item->q1,
                // "q2" => $item->q2,
                // "q3" => $item->q3,
                // "e1" => $item->e1,
                // "e2" => $item->e2,
                // "e3" => $item->e3,
                // "time" => $item->t1,
                "q1" => $item->q1 !== null ? floatval($item->q1) : $item->q1,
                "q2" => $item->q2 !== null ? floatval($item->q2) : $item->q2,
                "q3" => $item->q3 !== null ? floatval($item->q3) : $item->q3,
                "e1" => $item->e1 !== null ? floatval($item->e1) : $item->e1,
                "e2" => $item->e2 !== null ? floatval($item->e2) : $item->e2,
                "e3" => $item->e3 !== null ? floatval($item->e3) : $item->e3,
                "time" => $item->t1 !== null ? floatval($item->t1) : $item->t1,
                "year" => $item->year,
                "month" => $item->month,
                "sem_id" => $item->sem_id,
                "imm" => $item->ipcr_Semestral->immediate,
                "next" => $item->ipcr_Semestral->next_higher1,
                'sem_data' => $item->ipcr_Semestral,
                "monthly_accomp" => $item->monthlyAccomplishmentMany ? $item->monthlyAccomplishmentMany : "",
                "Accomplishment_type" => "ipcr",
                // "individual_output" => $item[0]['ipcrTargets'] ? $item[0]['ipcrTargets']->individual_output : '',
            ])



            ->values();
    }

    public function data_dpcr($emp_code, $ipcr_semestral_id, $month)
    {
        // dd('dpcr');
        $month_as_is = $month;
        if ($month > 6) {
            $month = $month - 6;
        }
        return MonthlyTarget::with([
            'dpcrTargets',
            'dpcrTargets.divisionOutput',
            'dpcrTargets.divisionOutput.monthlyRemarks' => function ($query) use ($month, $ipcr_semestral_id) {
                $query->where('monthly_remarks.month', '=', $month);
                $query->where('monthly_remarks.idSemestral', '=', $ipcr_semestral_id);
            },
            'ipcr_Semestral.immediate.Division',
            'ipcr_Semestral.next_higher1.Division',
            'monthlyAccomplishmentMany' => function ($query) use ($month_as_is) {
                $query->where('ipcr_monthly_accomplishments.month', '=', $month_as_is);
            },
        ])
            ->where('sem_id', $ipcr_semestral_id)
            ->where('month', $month)
            ->get()
            ->map(function ($item) {
                $dpcr = $item->dpcrTargets;
                $divisionOutput = $dpcr && $dpcr->divisionOutput ? $dpcr->divisionOutput : null;
                $monthlyRemarks = $divisionOutput && $divisionOutput->monthlyRemarks ? $divisionOutput->monthlyRemarks->first() : null;
                $ipcrSemestral = $item->ipcr_Semestral;
                $immediate = $ipcrSemestral && $ipcrSemestral->immediate ? $ipcrSemestral->immediate : null;
                $nextHigher = $ipcrSemestral && $ipcrSemestral->next_higher1 ? $ipcrSemestral->next_higher1 : null;

                return [
                    "individual_output_id" => $divisionOutput ? $divisionOutput->id : '',
                    "individual_output" => $divisionOutput ? $divisionOutput->output : '',
                    "performance_measure" => $divisionOutput ? $divisionOutput->performance_measure : '',
                    "prescribed_period" => $divisionOutput ? $divisionOutput->prescribed_period : '',
                    "quality1" => $divisionOutput ? $divisionOutput->quality1 : '',
                    "quality2" => $divisionOutput ? $divisionOutput->quality2 : '',
                    "quality3" => $divisionOutput ? $divisionOutput->quality3 : '',
                    "efficiency1" => $divisionOutput ? $divisionOutput->efficiency1 : '',
                    "efficiency2" => $divisionOutput ? $divisionOutput->efficiency2 : '',
                    "efficiency3" => $divisionOutput ? $divisionOutput->efficiency3 : '',
                    "timeliness" => $divisionOutput ? $divisionOutput->timeliness : '',
                    "type" => $divisionOutput ? $divisionOutput->type : '',
                    "remarks" => $monthlyRemarks ? $monthlyRemarks->remarks : '',
                    "remarks_id" => $monthlyRemarks ? $monthlyRemarks->id : '',
                    'ipcr_type' => $dpcr ? $dpcr->dpcr_type : '',
                    "target_remarks" => $dpcr ? $dpcr->remarks : '',
                    // "q1" => $item->q1 ?? '',
                    // "q2" => $item->q2 ?? '',
                    // "q3" => $item->q3 ?? '',
                    // "e1" => $item->e1 ?? '',
                    // "e2" => $item->e2 ?? '',
                    // "e3" => $item->e3 ?? '',
                    // "time" => $item->t1 ?? '',
                    "q1" => $item->q1 !== null ? floatval($item->q1) : $item->q1,
                    "q2" => $item->q2 !== null ? floatval($item->q2) : $item->q2,
                    "q3" => $item->q3 !== null ? floatval($item->q3) : $item->q3,
                    "e1" => $item->e1 !== null ? floatval($item->e1) : $item->e1,
                    "e2" => $item->e2 !== null ? floatval($item->e2) : $item->e2,
                    "e3" => $item->e3 !== null ? floatval($item->e3) : $item->e3,
                    "time" => $item->t1 !== null ? floatval($item->t1) : $item->t1,
                    "year" => $item->year ?? '',
                    "month" => $item->month ?? '',
                    "sem_id" => $item->sem_id ?? '',
                    "imm" => $immediate ?: '',
                    "next" => $nextHigher ?: '',
                    'sem_data' => $ipcrSemestral ?: '',
                    "monthly_accomp" => $item->monthlyAccomplishmentMany ?? '',
                    "Accomplishment_type" => "dpcr",
                ];
            })
            ->values();
        // ->map(fn($item, $key) => [
        //     "individual_output_id" => $item->dpcrTargets->divisionOutput->id ?? '',
        //     "individual_output" => $item->dpcrTargets->divisionOutput->output ?? '',
        //     "performance_measure" => $item->dpcrTargets->divisionOutput->performance_measure,
        //     "prescribed_period" => $item->dpcrTargets->divisionOutput->prescribed_period,
        //     "quality1" => $item->dpcrTargets->divisionOutput->quality1,
        //     "quality2" => $item->dpcrTargets->divisionOutput->quality2,
        //     "quality3" => $item->dpcrTargets->divisionOutput->quality3,
        //     "efficiency1" => $item->dpcrTargets->divisionOutput->efficiency1,
        //     "efficiency2" => $item->dpcrTargets->divisionOutput->efficiency2,
        //     "efficiency3" => $item->dpcrTargets->divisionOutput->efficiency3,
        //     "timeliness" => $item->dpcrTargets->divisionOutput->timeliness,
        //     "type" => $item->dpcrTargets->divisionOutput->type,
        //     "remarks" => $item->dpcrTargets->divisionOutput->monthlyRemarks->first()->remarks ?? '',
        //     "remarks_id" => $item->dpcrTargets->divisionOutput->monthlyRemarks->first()->id ?? '',
        //     'ipcr_type' => $item->dpcrTargets->dpcr_type ?? '',
        //     "target_remarks" => $item->dpcrTargets->remarks ?? '',
        //     "q1" => $item->q1,
        //     "q2" => $item->q2,
        //     "q3" => $item->q3,
        //     "e1" => $item->e1,
        //     "e2" => $item->e2,
        //     "e3" => $item->e3,
        //     "time" => $item->t1,
        //     "year" => $item->year,
        //     "month" => $item->month,
        //     "sem_id" => $item->sem_id,
        //     "imm" => $item->ipcr_Semestral->immediate,
        //     "next" => $item->ipcr_Semestral->next_higher1,
        //     'sem_data' => $item->ipcr_Semestral,
        //     "monthly_accomp" => $item->monthlyAccomplishmentMany ? $item->monthlyAccomplishmentMany : "",
        //     "Accomplishment_type" => "dpcr",
        //     // "individual_output" => $item[0]['ipcrTargets'] ? $item[0]['ipcrTargets']->individual_output : '',
        // ])
        // ->values();

        // dd($data);
    }

    public function view_hpcr_targets($emp_code, $ipcr_semestral_id, $month)
    {
        // dd('dpcr');
        return MonthlyTarget::with([
            'hpcrTargets',
            'hpcrTargets.hpcr',
            'ipcr_Semestral.immediate.Division',
            'ipcr_Semestral.next_higher1.Division',
            'monthlyAccomplishmentMany' => function ($query) use ($month) {
                $query->where('ipcr_monthly_accomplishments.month', '=', $month);
            },
        ])
            ->where('sem_id', $ipcr_semestral_id)
            ->where('month', $month)
            ->get()
            ->map(fn($item, $key) => [
                "individual_output_id" => optional(optional($item->hpcrTargets)->hpcr)->id ?? '',
                "individual_output" => optional(optional($item->hpcrTargets)->hpcr)->output ?? '',
                "performance_measure" => optional(optional($item->hpcrTargets)->hpcr)->performance_measure,
                "prescribed_period" => optional(optional($item->hpcrTargets)->hpcr)->prescribed_period,
                "quality1" => optional(optional($item->hpcrTargets)->hpcr)->quality1,
                "quality2" => optional(optional($item->hpcrTargets)->hpcr)->quality2,
                "quality3" => optional(optional($item->hpcrTargets)->hpcr)->quality3,
                "efficiency1" => optional(optional($item->hpcrTargets)->hpcr)->efficiency1,
                "efficiency2" => optional(optional($item->hpcrTargets)->hpcr)->efficiency2,
                "efficiency3" => optional(optional($item->hpcrTargets)->hpcr)->efficiency3,
                "timeliness" => optional(optional($item->hpcrTargets)->hpcr)->timeliness,
                "type" => optional(optional($item->hpcrTargets)->hpcr)->type,
                "remarks" => optional(optional(optional($item->hpcrTargets)->hpcr)->monthlyRemarks->first())->remarks ?? '',
                "remarks_id" => optional(optional(optional($item->hpcrTargets)->hpcr)->monthlyRemarks->first())->id ?? '',
                'ipcr_type' => optional($item->hpcrTargets)->type ?? '',
                // "q1" => $item->q1,
                // "q2" => $item->q2,
                // "q3" => $item->q3,
                // "e1" => $item->e1,
                // "e2" => $item->e2,
                // "e3" => $item->e3,
                // "time" => $item->t1,
                "q1" => $item->q1 !== null ? floatval($item->q1) : $item->q1,
                "q2" => $item->q2 !== null ? floatval($item->q2) : $item->q2,
                "q3" => $item->q3 !== null ? floatval($item->q3) : $item->q3,
                "e1" => $item->e1 !== null ? floatval($item->e1) : $item->e1,
                "e2" => $item->e2 !== null ? floatval($item->e2) : $item->e2,
                "e3" => $item->e3 !== null ? floatval($item->e3) : $item->e3,
                "time" => $item->t1 !== null ? floatval($item->t1) : $item->t1,
                "year" => $item->year,
                "month" => $item->month,
                "sem_id" => $item->sem_id,
                "imm" => optional($item->ipcr_Semestral)->immediate,
                "next" => optional($item->ipcr_Semestral)->next_higher1,
                'sem_data' => $item->ipcr_Semestral,
                "monthly_accomp" => $item->monthlyAccomplishmentMany ? $item->monthlyAccomplishmentMany : "",
                "Accomplishment_type" => "hpcr",
                // "individual_output" => $item[0]['ipcrTargets'] ? $item[0]['ipcrTargets']->individual_output : '',
            ])
            ->values();

        // dd($data);
    }
    public function view_hdpcr_targets($emp_code, $ipcr_semestral_id, $month)
    {
        // dd('dpcr');
        // dd($month, $month);
        // dd("ipcr_semestral_id: ".$ipcr_semestral_id." month: ".$month);
        $month_sem = $month;
        if ($month > 6) {
            $month_sem = $month - 6;
        }
        $hdpcr = MonthlyTarget::with([
            'hpcrTargets',
            'hpcrTargets.hDPCR',
            'hpcrTargets.dpcr',
            'ipcr_Semestral.immediate.Division',
            'ipcr_Semestral.next_higher1.Division',
            'monthlyAccomplishmentMany' => function ($query) use ($month) {
                $query->where('ipcr_monthly_accomplishments.month', '=', $month);
            },
        ])
            ->where('sem_id', $ipcr_semestral_id)
            ->where('month', $month_sem)
            ->get()
            ->map(function ($item) {
                $id_output = 0;
                $output = "";
                $prescribed_period = "";
                $pm = "";
                $q1 = "";
                $q2 = "";
                $q3 = "";
                $e1 = "";
                $e2 = "";
                $e3 = "";
                $t1 = "";
                $type = "";
                $pcr_type = "hdpcr";
                $remarks = "";
                $remarks_id = "";
                if ($item->hpcrTargets) {
                    $type = optional($item->hpcrTargets)->type;
                    if ($item->hpcrTargets->pcr_type == 'hdpcr') {
                        // $id_output = $item->hpcrTargets
                        if ($item->hpcrTargets->hDPCR) {
                            $id_output = optional(optional($item->hpcrTargets)->hDPCR)->id;
                            $output = optional(optional($item->hpcrTargets)->hDPCR)->output;
                            $prescribed_period = optional(optional($item->hpcrTargets)->hDPCR)->prescribed_period;
                            $pm = optional(optional($item->hpcrTargets)->hDPCR)->performance_measure;
                            $q1 = optional(optional($item->hpcrTargets)->hDPCR)->quality1;
                            $q2 = optional(optional($item->hpcrTargets)->hDPCR)->quality2;
                            $q3 = optional(optional($item->hpcrTargets)->hDPCR)->quality3;
                            $e1 = optional(optional($item->hpcrTargets)->hDPCR)->efficiency1;
                            $e2 = optional(optional($item->hpcrTargets)->hDPCR)->efficiency2;
                            $e3 = optional(optional($item->hpcrTargets)->hDPCR)->efficiency3;
                            $t1 = optional(optional($item->hpcrTargets)->hDPCR)->timeliness;
                        }
                    } else if ($item->hpcrTargets->pcr_type == 'dpcr') {
                        // dd($item);
                        $pcr_type = "dpcr";
                        if ($item->hpcrTargets->dpcr) {
                            $id_output = optional(optional($item->hpcrTargets)->dpcr)->id;
                            $output = optional(optional($item->hpcrTargets)->dpcr)->output;
                            $prescribed_period = optional(optional($item->hpcrTargets)->dpcr)->prescribed_period;
                            $pm = optional(optional($item->hpcrTargets)->dpcr)->performance_measure;
                            $q1 = optional(optional($item->hpcrTargets)->dpcr)->quality1;
                            $q2 = optional(optional($item->hpcrTargets)->dpcr)->quality2;
                            $q3 = optional(optional($item->hpcrTargets)->dpcr)->quality3;
                            $e1 = optional(optional($item->hpcrTargets)->dpcr)->efficiency1;
                            $e2 = optional(optional($item->hpcrTargets)->dpcr)->efficiency2;
                            $e3 = optional(optional($item->hpcrTargets)->dpcr)->efficiency3;
                            $t1 = optional(optional($item->hpcrTargets)->dpcr)->timeliness;
                        }
                        // dd($id_output);
                    } else {
                    }
                }
                // dd($type);
                return [
                    "individual_output_id" => $id_output,
                    "individual_output" => $output,
                    "performance_measure" => $pm,
                    "prescribed_period" => $prescribed_period,
                    "quality1" => $q1,
                    "quality2" => $q2,
                    "quality3" => $q3,
                    "efficiency1" => $e1,
                    "efficiency2" => $e2,
                    "efficiency3" => $e3,
                    "timeliness" => $t1,
                    "type" => $pcr_type,
                    "remarks" => $remarks,
                    "remarks_id" => $remarks_id,
                    'ipcr_type' => $type,
                    // "q1" => $item->q1,
                    // "q2" => $item->q2,
                    // "q3" => $item->q3,
                    // "e1" => $item->e1,
                    // "e2" => $item->e2,
                    // "e3" => $item->e3,
                    // "time" => $item->t1,
                    "q1" => $item->q1 !== null ? floatval($item->q1) : $item->q1,
                    "q2" => $item->q2 !== null ? floatval($item->q2) : $item->q2,
                    "q3" => $item->q3 !== null ? floatval($item->q3) : $item->q3,
                    "e1" => $item->e1 !== null ? floatval($item->e1) : $item->e1,
                    "e2" => $item->e2 !== null ? floatval($item->e2) : $item->e2,
                    "e3" => $item->e3 !== null ? floatval($item->e3) : $item->e3,
                    "time" => $item->t1 !== null ? floatval($item->t1) : $item->t1,
                    "year" => $item->year,
                    "month" => $item->month,
                    "sem_id" => $item->sem_id,
                    "imm" => $item->ipcr_Semestral->immediate,
                    "next" => $item->ipcr_Semestral->next_higher1,
                    'sem_data' => $item->ipcr_Semestral,
                    "monthly_accomp" => $item->monthlyAccomplishmentMany ? $item->monthlyAccomplishmentMany : "",
                    "Accomplishment_type" => "hpcr",
                ];
            });
        // dd($hdpcr);
        // if(count($hdpcr) >0){
        //     dd($hdpcr);
        // }
        return $hdpcr;
        // ->map(fn($item, $key) => [
        //     "individual_output_id" => $item->hpcrTargets->hospital_output->id ?? '',
        //     "individual_output" => $item->hpcrTargets->hospital_output->output ?? '',
        //     "performance_measure" => $item->hpcrTargets->hospital_output->performance_measure,
        //     "prescribed_period" => $item->hpcrTargets->hospital_output->prescribed_period,
        //     "quality1" => $item->hpcrTargets->hospital_output->quality1,
        //     "quality2" => $item->hpcrTargets->hospital_output->quality2,
        //     "quality3" => $item->hpcrTargets->hospital_output->quality3,
        //     "efficiency1" => $item->hpcrTargets->hospital_output->efficiency1,
        //     "efficiency2" => $item->hpcrTargets->hospital_output->efficiency2,
        //     "efficiency3" => $item->hpcrTargets->hospital_output->efficiency3,
        //     "timeliness" => $item->hpcrTargets->hospital_output->timeliness,
        //     "type" => $item->hpcrTargets->hospital_output->type,
        //     "remarks" => $item->hpcrTargets->hospital_output->monthlyRemarks->first()->remarks ?? '',
        //     "remarks_id" => $item->hpcrTargets->hospital_output->monthlyRemarks->first()->id ?? '',
        //     'ipcr_type' => $item->hpcrTargets->type ?? '',
        //     "q1" => $item->q1,
        //     "q2" => $item->q2,
        //     "q3" => $item->q3,
        //     "e1" => $item->e1,
        //     "e2" => $item->e2,
        //     "e3" => $item->e3,
        //     "time" => $item->t1,
        //     "year" => $item->year,
        //     "month" => $item->month,
        //     "sem_id" => $item->sem_id,
        //     "imm" => $item->ipcr_Semestral->immediate,
        //     "next" => $item->ipcr_Semestral->next_higher1,
        //     'sem_data' => $item->ipcr_Semestral,
        //     "monthly_accomp" => $item->monthlyAccomplishmentMany ? $item->monthlyAccomplishmentMany : "",
        //     "Accomplishment_type" => "hpcr",
        //     // "individual_output" => $item[0]['ipcrTargets'] ? $item[0]['ipcrTargets']->individual_output : '',
        // ])
        // ->values();

        // dd($data);
    }
    public function view_hipcr_targets_api($emp_code, $ipcr_semestral_id, $month, $function_type)
    {
        // dd("eeee");
        // dd(HospitalTarget::where('id', 3661)->get());

        $data = MonthlyTarget::with([
            'hpcrTargets',
            'hpcrTargets.ipcr',
            'hpcrTargets.ipcr.divisionOutput',
            'hpcrTargets.ipcr.divisionOutput.programAndProject',
            'hpcrTargets.ipcr.divisionOutput.programAndProject.MFO',
            'hpcrTargets.hIPCR',
            'hpcrTargets.hIPCR.hospitalSectionOutput',
            'hpcrTargets.hIPCR.hospitalSectionOutput.hospitalDivisionOutput',
            'hpcrTargets.hIPCR.hospitalSectionOutput.hospitalDivisionOutput.hospitalOutput',
            'hpcrTargets.hIPCR.hospitalSectionOutput.hospitalDivisionOutput.hospitalOutput.programAndProject',
            'hpcrTargets.hIPCR.hospitalSectionOutput.hospitalDivisionOutput.hospitalOutput.programAndProject.MFO',
            'hpcrTargets.ipcr_Semestral',
            'monthlyAccomplishmentMany' => function ($query) use ($month) {
                $query->where('ipcr_monthly_accomplishments.month', '=', $month);
            },
        ])
            ->where('sem_id', $ipcr_semestral_id)
            ->where('month', $month)
            ->whereHas('hpcrTargets', function ($query) use ($function_type) {
                $query->where('type', $function_type);
            })
            ->get()
            ->map(function ($item) {
                // dd($item);

                $ifo_id = 0;
                $output = "";
                $pm = "";
                $pres_period = "";
                $q1 = "";
                $q2 = "";
                $q3 = "";
                $e1 = "";
                $e2 = "";
                $e3 = "";
                $t1 = "";
                $type = "";
                $target_type = "";
                if ($item->hpcrTargets) {
                    $hos = $item->hpcrTargets;
                    $target_type = $hos->type;
                    $output = "";
                    $ifo_id = $hos->idHIPCR;
                    if ($item->type == 'ipcr') {
                        $ifo_id = $hos->idIPCR;
                        if ($hos->ipcr) {
                            $ipcr = $hos->ipcr;
                            $output = $ipcr->individual_output;
                            $pm = $ipcr->performance_measure;
                            $pres_period = $ipcr->prescribed_period;
                            $q1 = $ipcr->quality1;
                            $q2 = $ipcr->quality2;
                            $q3 = $ipcr->quality3;
                            $e1 = $ipcr->efficiency1;
                            $e2 = $ipcr->efficiency2;
                            $e3 = $ipcr->efficiency3;
                            $t1 = $ipcr->timeliness;
                            $type = $ipcr->type;
                        }
                    } else {
                        if ($hos->hIPCR) {
                            $hIPCR = $hos->hIPCR;
                            $output = $hIPCR->output;
                            $pm = $hIPCR->performance_measure;
                            $pres_period = $hIPCR->prescribed_period;
                            $q1 = $hIPCR->quality1;
                            $q2 = $hIPCR->quality2;
                            $q3 = $hIPCR->quality3;
                            $e1 = $hIPCR->efficiency1;
                            $e2 = $hIPCR->efficiency2;
                            $e3 = $hIPCR->efficiency3;
                            $t1 = $hIPCR->timeliness;
                            $type = $hIPCR->type;
                        }
                    }
                    // dd($ifo_id);
                }

                return [
                    "individual_output_id" => $ifo_id,
                    "individual_output" => $output,
                    "performance_measure" => $pm,
                    "prescribed_period" => $pres_period,
                    "quality1" => $q1,
                    "quality2" => $q2,
                    "quality3" => $q3,
                    "efficiency1" => $e1,
                    "efficiency2" => $e2,
                    "efficiency3" => $e3,
                    "timeliness" => $t1,
                    "type" => $type,
                    "remarks" => '',
                    "remarks_id" => '',
                    'ipcr_type' => $target_type,
                    // "q1" => $item->q1,
                    // "q2" => $item->q2,
                    // "q3" => $item->q3,
                    // "e1" => $item->e1,
                    // "e2" => $item->e2,
                    // "e3" => $item->e3,
                    // "time" => $item->t1,
                    "q1" => $item->q1 !== null ? floatval($item->q1) : $item->q1,
                    "q2" => $item->q2 !== null ? floatval($item->q2) : $item->q2,
                    "q3" => $item->q3 !== null ? floatval($item->q3) : $item->q3,
                    "e1" => $item->e1 !== null ? floatval($item->e1) : $item->e1,
                    "e2" => $item->e2 !== null ? floatval($item->e2) : $item->e2,
                    "e3" => $item->e3 !== null ? floatval($item->e3) : $item->e3,
                    "time" => $item->t1 !== null ? floatval($item->t1) : $item->t1,
                    "year" => $item->year,
                    "month" => $item->month,
                    "sem_id" => $item->sem_id,
                    "imm" => $item->ipcr_Semestral->immediate,
                    "next" => $item->ipcr_Semestral->next_higher1,
                    'sem_data' => $item->ipcr_Semestral,
                    "monthly_accomp" => $item->monthlyAccomplishmentMany ? $item->monthlyAccomplishmentMany : "",
                    "Accomplishment_type" => $item->type,
                ];
            })
            ->values();
        // dd($data);
        return $data;
    }
    public function view_hipcr_targets($emp_code, $ipcr_semestral_id, $month)
    {
        // dd("eeee");
        $month_as_is = $month;
        if ($month > 6) {
            $month = $month - 6;
        }
        // dd(HospitalTarget::where('id', 3661)->get());
        $data = MonthlyTarget::with([
            'hpcrTargets',
            'hpcrTargets.ipcr',
            'hpcrTargets.ipcr.divisionOutput',
            'hpcrTargets.ipcr.divisionOutput.programAndProject',
            'hpcrTargets.ipcr.divisionOutput.programAndProject.MFO',
            'hpcrTargets.hIPCR',
            'hpcrTargets.hIPCR.hospitalSectionOutput',
            'hpcrTargets.hIPCR.hospitalSectionOutput.hospitalDivisionOutput',
            'hpcrTargets.hIPCR.hospitalSectionOutput.hospitalDivisionOutput.hospitalOutput',
            'hpcrTargets.hIPCR.hospitalSectionOutput.hospitalDivisionOutput.hospitalOutput.programAndProject',
            'hpcrTargets.hIPCR.hospitalSectionOutput.hospitalDivisionOutput.hospitalOutput.programAndProject.MFO',
            'hpcrTargets.ipcr_Semestral',
            'monthlyAccomplishmentMany' => function ($query) use ($month_as_is) {
                $query->where('ipcr_monthly_accomplishments.month', '=', $month_as_is);
            },
        ])
            ->where('sem_id', $ipcr_semestral_id)
            ->where('month', $month)
            ->get()
            ->map(function ($item) {
                // dd($item);

                $ifo_id = 0;
                $output = "";
                $pm = "";
                $pres_period = "";
                $q1 = "";
                $q2 = "";
                $q3 = "";
                $e1 = "";
                $e2 = "";
                $e3 = "";
                $t1 = "";
                $type = "";
                $target_type = "";
                if ($item->hpcrTargets) {
                    $hos = $item->hpcrTargets;
                    $target_type = $hos->type;
                    $output = "";
                    $ifo_id = $hos->idHIPCR;
                    if ($item->type == 'ipcr') {
                        $ifo_id = $hos->idIPCR;
                        if ($hos->ipcr) {
                            $ipcr = $hos->ipcr;
                            $output = $ipcr->individual_output;
                            $pm = $ipcr->performance_measure;
                            $pres_period = $ipcr->prescribed_period;
                            $q1 = $ipcr->quality1;
                            $q2 = $ipcr->quality2;
                            $q3 = $ipcr->quality3;
                            $e1 = $ipcr->efficiency1;
                            $e2 = $ipcr->efficiency2;
                            $e3 = $ipcr->efficiency3;
                            $t1 = $ipcr->timeliness;
                            $type = $ipcr->type;
                        }
                    } else {
                        if ($hos->hIPCR) {
                            $hIPCR = $hos->hIPCR;
                            $output = $hIPCR->output;
                            $pm = $hIPCR->performance_measure;
                            $pres_period = $hIPCR->prescribed_period;
                            $q1 = $hIPCR->quality1;
                            $q2 = $hIPCR->quality2;
                            $q3 = $hIPCR->quality3;
                            $e1 = $hIPCR->efficiency1;
                            $e2 = $hIPCR->efficiency2;
                            $e3 = $hIPCR->efficiency3;
                            $t1 = $hIPCR->timeliness;
                            $type = $hIPCR->type;
                        }
                    }
                    // dd($ifo_id);
                }

                return [
                    "individual_output_id" => $ifo_id,
                    "individual_output" => $output,
                    "performance_measure" => $pm,
                    "prescribed_period" => $pres_period,
                    "quality1" => $q1,
                    "quality2" => $q2,
                    "quality3" => $q3,
                    "efficiency1" => $e1,
                    "efficiency2" => $e2,
                    "efficiency3" => $e3,
                    "timeliness" => $t1,
                    "type" => $type,
                    "remarks" => '',
                    "remarks_id" => '',
                    'ipcr_type' => $target_type,
                    // "q1" => $item->q1,
                    // "q2" => $item->q2,
                    // "q3" => $item->q3,
                    // "e1" => $item->e1,
                    // "e2" => $item->e2,
                    // "e3" => $item->e3,
                    // "time" => $item->t1,
                    "q1" => $item->q1 !== null ? floatval($item->q1) : $item->q1,
                    "q2" => $item->q2 !== null ? floatval($item->q2) : $item->q2,
                    "q3" => $item->q3 !== null ? floatval($item->q3) : $item->q3,
                    "e1" => $item->e1 !== null ? floatval($item->e1) : $item->e1,
                    "e2" => $item->e2 !== null ? floatval($item->e2) : $item->e2,
                    "e3" => $item->e3 !== null ? floatval($item->e3) : $item->e3,
                    "time" => $item->t1 !== null ? floatval($item->t1) : $item->t1,
                    "year" => $item->year,
                    "month" => $item->month,
                    "sem_id" => $item->sem_id,
                    "imm" => $item->ipcr_Semestral->immediate,
                    "next" => $item->ipcr_Semestral->next_higher1,
                    'sem_data' => $item->ipcr_Semestral,
                    "monthly_accomp" => $item->monthlyAccomplishmentMany ? $item->monthlyAccomplishmentMany : "",
                    "Accomplishment_type" => $item->type,
                ];
            })
            ->values();
        // dd($data);
        return $data;
    }
    public function view_hspcr_targets($emp_code, $ipcr_semestral_id, $month)
    {

        $targets = HospitalTarget::with([
            'hSPCR',
            'hSPCR.hospitalDivisionOutput',
            'hSPCR.hospitalDivisionOutput.hospitalOutput',
            'hSPCR.hospitalDivisionOutput.hospitalOutput.programAndProject',
            'hSPCR.hospitalDivisionOutput.hospitalOutput.programAndProject.MFO',
            'ipcr_Semestral',
            'monthlyTargets' => function ($query) use ($month) {
                $query->where('monthly_targets.month', '=', $month);
            },
            'monthlyAccomplishmentMany' => function ($query) use ($month) {
                $query->where('ipcr_monthly_accomplishments.month', '=', $month);
            },
        ])
            ->where('ipcr_semestral_id', $ipcr_semestral_id)
            ->where('employee_code', $emp_code)

            ->whereHas('hSPCR')
            ->get(); // Reindex the collection after sorting
        // dd($targets);
        $sortedTargets = $targets->sortBy(function ($item) {
            return optional($item->hSPCR)->id; // Sorting by hIPCR.id
        });

        // If you want to reindex the collection after sorting
        $sortedTargets = $sortedTargets->values();

        return $sortedTargets->map(function ($item) {
            $pcr_type = "";

            $id = optional($item->hSPCR)->id;
            $output = optional($item->hSPCR)->output;
            $pm = optional($item->hSPCR)->performance_measure;
            $pcr_type = "hspcr";

            // dd($item->monthlyTargets);
            return [
                "id" => $item->id,
                "semester" => $item->semester,
                "individual_final_output_id" => $id,
                "individual_output" => $output,
                "performance_measure" => $pm,
                "quality1" => $item->hSPCR->quality1,
                "quality2" => $item->hSPCR->quality2,
                "quality3" => $item->hSPCR->quality3,
                "efficiency1" => $item->hSPCR->efficiency1,
                "efficiency2" => $item->hSPCR->efficiency2,
                "efficiency3" => $item->hSPCR->efficiency3,
                "timeliness" => $item->hSPCR->timeliness,
                "type" => $item->type,
                "remarks" => '',
                "remarks_id" => '',
                "ipcr_type" => $item->type,
                "q1" => optional($item->monthlyTargets->first())->q1 ?? '',
                "q2" => optional($item->monthlyTargets->first())->q2 ?? '',
                "q3" => optional($item->monthlyTargets->first())->q3 ?? '',
                "e1" => optional($item->monthlyTargets->first())->e1 ?? '',
                "e2" => optional($item->monthlyTargets->first())->e2 ?? '',
                "e3" => optional($item->monthlyTargets->first())->e3 ?? '',
                "time" => optional($item->monthlyTargets->first())->t1 ?? '',
                "year" => optional($item->ipcr_Semestral)->year,
                "month" => optional($item->monthlyTargets->first())->month ?? '',
                "sem_id" => optional($item->ipcr_Semestral)->id,
                "sem" => optional($item->ipcr_Semestral)->sem,
                "status" => optional($item->ipcr_Semestral)->status,
                "imm" => $item->ipcr_Semestral->immediate,
                "next" => $item->ipcr_Semestral->next_higher1,
                "monthly_accomp" => $item->monthlyAccomplishmentMany ? $item->monthlyAccomplishmentMany : "",
                'sem_data' => $item->ipcr_Semestral,
                "pcr_type" => $pcr_type
            ];
        });
        // return $sortedTargets;
    }
    public function getSelectedMonth($month, $monum)
    {
        // dd('monthhh');
        // dd($month);
        // foreach ($month as $mo) {
        //     dd($mo);
        //     // if ($mo->month == $monum) {

        //     //     dd($mo->status);
        //     // }
        // }
        return 1;
    }

    public function monthNameToNumber(string $month): ?int
    {
        $months = [
            'January' => 1,
            'February' => 2,
            'March' => 3,
            'April' => 4,
            'May' => 5,
            'June' => 6,
            'July' => 7,
            'August' => 8,
            'September' => 9,
            'October' => 10,
            'November' => 11,
            'December' => 12,
        ];

        // $month = strtolower(trim($month));

        return $months[$month] ?? null;
    }
    private function getPGDH($pgHead)
    {
        $suff = "";
        $post = "";
        $mn = "";
        if (
            $pgHead->suffix_name != ''
        ) {
            $suff = ', ' . $pgHead->suffix_name;
        }
        if (
            $pgHead->postfix_name != ''
        ) {
            // dd('fsdfdsfsdf');
            $post = ', ' . $pgHead->postfix_name;
        }
        if (
            $pgHead->middle_name != ''
        ) {
            $mn = $pgHead->middle_name[0] . '. ';
        }
        $pgHead = $pgHead->first_name . ' ' . $mn  . $pgHead->last_name . '' . $suff . '' . $post;
        return $pgHead;
    }
    private function getOffice($us)
    {
        $office = "";
        $pgHead = "";
        $esd = $us->employeeSpecialDepartment;
        $office_main = $us->userEmployee->Office;
        $pgdh_main = $us->userEmployee->Office->pgHead;
        // dd($pgdh_main);
        // dd($esd);
        if ($esd) {
            $off = $esd->Office;
            $pg_esd = $esd->PGDH;
            if ($off) {
                $office = $off;
                // dd($office);
            } else {
                $office = $office_main;
            }

            if ($pg_esd) {
                $pgHead = $pg_esd;
                // dd($pg_esd);
            } else {
                $pgHead = $pgdh_main;
            }
            // dd($office);
        } else {
            $office = $office_main;
            $pgHead = $pgdh_main;
        }

        return [
            "office" => $office,
            "pgHead" => $pgHead
        ];
    }

    private function getDivision($div, $immh, $nxth)
    {
        if ($div) {
            $div = $div->division_name1;
        } else {
            if ($immh['Division'] != null) {
                $div = $immh['Division']->division_name1;
            } else {
                if ($nxth['Division'] != null) {
                    $div = $nxth['Division']->division_name1;
                }
            };
        }
        if ($div == null) {
            $div = "";
        }
        return $div;
    }
    public function semestral_monthly(Request $request)
    {
        $id = auth()->user()->username;
        $emp = auth()->user()->userEmployee;
        $emp_code = $emp->empl_id;
        $sem_data = Ipcr_Semestral::with([
            'monthly_accomplishment.returnRemarks'
        ])
            ->where('employee_code', $emp_code)
            ->where('status', '2')
            ->orderBy('year', 'asc')
            ->orderBy('sem', 'asc')
            ->get();

        $source = "direct";

        $div = "";
        if ($emp->Division) {
            $div = $emp->Division->division_name1;
        }

        return inertia('IPCR/Accomplishment/Index', [
            "id" => $id,
            "sem_data" => $sem_data,
            "division" => $div,
            "emp" => $emp,
            "source" => $source,
        ]);
    }

    public function summaryRating(Request $request)
    {
        $id = auth()->user()->username;
        $emp = auth()->user()->userEmployee;
        $emp_code = $emp->empl_id;
        $sem_data = Ipcr_Semestral::with([
            'monthly_accomplishment.returnRemarks'
        ])
            ->where('employee_code', $emp_code)
            ->where('status', '2')
            ->orderBy('year', 'asc')
            ->orderBy('sem', 'asc')
            ->get();

        $source = "direct";

        $div = "";
        if ($emp->Division) {
            $div = $emp->Division->division_name1;
        }

        return inertia('SummaryOfRating/Index', [
            "id" => $id,
            "sem_data" => $sem_data,
            "division" => $div,
            "emp" => $emp,
            "source" => $source,
        ]);
    }
    public function summaryRatingAll(Request $request, $department_code)
    {
        // $id = auth()->user()->username;
        // $emp = auth()->user()->userEmployee;
        // $emp_code = $emp->empl_id;

        // // $all_users =UserEmployeeCredential
        // dd($department_code);
        $sem_data = Ipcr_Semestral::with([
            'monthly_accomplishment.returnRemarks'
        ])
            ->where('department_code', $department_code)
            ->where('status', '2')
            ->orderBy('year', 'asc')
            ->orderBy('sem', 'asc')
            ->groupBy('year', 'sem')
            ->get();
        // dd($sem_data->pluck('year'));
        $source = "direct";

        $div = "";
        // if ($emp->Division) {
        //     $div = $emp->Division->division_name1;
        // }

        return inertia('Offices/SummaryOfRating/Index', [
            // "id" => $id,
            "sem_data" => $sem_data,
            "division" => $div,
            // "emp" => $emp,
            "source" => $source,
        ]);
    }
    public function monthly(Request $request)
    {
        // dd($request->all());

        $office = $request->department_code;
        $month = $request->month;
        $date = Carbon::createFromFormat('F', $month);
        $monthNumber = $date->month;
        $year = $request->year;
        $sem_id = $request->ipcr_semestral_id;

        // dd($monthNumber);

        $mo2 = $monthNumber;
        $semt = 1;
        if ($mo2 > 6) {
            $mo2 = intval($mo2) - 6;
            $semt = 2;
        }

        // dd(($semt . " " . $office . " " . $year));
        $data = UserEmployees::with([
            'manySemestral' => function ($query) use ($year, $semt, $office) {
                $query->where('year', $year)
                    ->where('sem', $semt)
                    ->where('department_code', $office);
            },
            'manySemestral.monthRate' => function ($query) use ($year, $monthNumber) {
                $query->where('year', $year)
                    ->where('month', $monthNumber)
                    ->orderBy('created_at', 'desc');
            }
        ])
            ->whereHas('manySemestral', function ($query) use ($office, $semt, $year) {
                $query->where('department_code', $office)
                    ->where('sem', $semt)
                    ->where('year', $year);
            })
            // ->where('department_code', $office)
            ->where('active_status', 'ACTIVE')
            ->where('salary_grade', '!=', 26)
            ->orderBy('last_name', 'ASC')
            ->get()
            ->map(function ($item, $key) {
                $numericalRating = $item->manySemestral->map(function ($semestral) {
                    return optional($semestral->monthRate)->first()->numerical_rating ?? 0;
                })->first() ?? 0;

                // dd($item->manySemestral);

                $adjectivalRating =
                    $item->manySemestral->map(function ($semestral) {
                        return optional($semestral->monthRate)->first()->adjectival_rating ?? "";
                    })->first() ?? "";

                $middleInitial = $item->middle_name ? $item->middle_name[0] . '.' : '';
                // dd($item->empl_id);
                // if ($item->empl_id == "8354") {
                //     dd($item->manySemestral);
                // }
                return [
                    'Fullname' => $item->last_name . ", " . $item->first_name . " " . $middleInitial,
                    'numericalRating' => $numericalRating,
                    'adjectivalRating' => $adjectivalRating,
                ];
            });

        // dd($data);
        return inertia('SummaryOfRating/MonthlyRating', [
            "data" => $data,
            "month" => $month,
            "year" => $year,
            "office" => $request->department_code
        ]);
    }
    public function monthlyAll(Request $request)
    {
        $office = $request->department_code;
        $month = $request->month;
        $date = Carbon::createFromFormat('F', $month);
        $monthNumber = $date->month;
        $year = $request->year;
        $sem_id = $request->ipcr_semestral_id;

        // dd($monthNumber);

        $mo2 = $monthNumber;
        $semt = 1;
        if ($mo2 > 6) {
            $mo2 = intval($mo2) - 6;
            $semt = 2;
        }

        // dd(($semt . " " . $office . " " . $year));
        $data = UserEmployees::with([
            'manySemestral' => function ($query) use ($year, $semt, $office) {
                $query->where('year', $year)
                    ->where('sem', $semt)
                    ->where('department_code', $office);
            },
            'manySemestral.monthRate' => function ($query) use ($year, $monthNumber) {
                $query->where('year', $year)
                    ->where('month', $monthNumber)
                    ->orderBy('created_at', 'desc');
            },
            'Office'
        ])
            ->whereHas('manySemestral', function ($query) use ($office, $semt, $year) {
                $query->where('department_code', $office)
                    ->where('sem', $semt)
                    ->where('year', $year);
            })
            // ->where('department_code', $office)
            ->where('active_status', 'ACTIVE')
            ->where('salary_grade', '!=', 26)
            ->orderBy('last_name', 'ASC')
            ->get()
            ->map(function ($item, $key) {
                $numericalRating = $item->manySemestral->map(function ($semestral) {
                    return optional($semestral->monthRate)->first()->numerical_rating ?? 0;
                })->first() ?? 0;

                // dd($item->manySemestral);

                $adjectivalRating =
                    $item->manySemestral->map(function ($semestral) {
                        return optional($semestral->monthRate)->first()->adjectival_rating ?? "";
                    })->first() ?? "";

                $middleInitial = $item->middle_name ? $item->middle_name[0] . '.' : '';
                // dd($item->Office);
                return [
                    'Fullname' => $item->last_name . ", " . $item->first_name . " " . $middleInitial,
                    'numericalRating' => $numericalRating,
                    'adjectivalRating' => $adjectivalRating,
                    'office' => $item->Office
                ];
            });

        // dd($data);
        return inertia('Offices/SummaryOfRating/MonthlyRating', [
            "data" => $data,
            "month" => $month,
            "year" => $year,
            "office" => $request->department_code
        ]);
    }
    public function SemesterRatingAll(Request $request)
    {
        // dd($request->all());
        $office = $request->department_code;
        $year = $request->year;
        $sem = $request->sem;

        // $data = UserEmployees::with([
        //     'manySemestral' => function ($query) use ($year, $sem, $office) {
        //         $query->where('year', $year)
        //             ->where('sem', $sem)
        //             ->where('department_code', $office);
        //     },
        //     'manySemestral.semRate' => function ($query) use ($year, $sem) {
        //         $query->where('year', $year)
        //             ->where('sem', $sem);
        //     },
        //     'Office'
        // ])
        //     ->whereHas('manySemestral', function ($query) use ($office, $sem, $year) {
        //         $query->where('department_code', $office)
        //             ->where('sem', $sem)
        //             ->where('year', $year);
        //     })
        //     ->where('active_status', 'ACTIVE')
        //     ->where('salary_grade', '!=', 26)
        //     ->orderBy('last_name', 'ASC')
        //     ->get()

        //     ->map(function ($item, $key) {
        //         $numericalRating = $item->manySemestral->map(function ($semestral) {
        //             return optional($semestral->semRate)->first()->numerical_rating ?? 0;
        //         })->first() ?? 0;

        //         $adjectivalRating =
        //             $item->manySemestral->map(function ($semestral) {
        //                 return optional($semestral->semRate)->first()->adjectival_rating ?? "";
        //             })->first() ?? "";


        //         $middleInitial = $item->middle_name ? $item->middle_name[0] . '.' : '';
        //         return [
        //             'Fullname' => $item->last_name . ", " . $item->first_name . " " . $middleInitial,
        //             'numericalRating' => $numericalRating,
        //             'adjectivalRating' => $adjectivalRating,
        //             'office' => $item->Office
        //         ];
        //     });

        // return inertia('Offices/SummaryOfRating/SemestralRating', [
        //     "data" => $data,
        //     "year" => $year,
        //     "office" => $request->department_code,
        //     "sem" => $request->sem,
        // ]);

        $data = UserEmployees::with([
            'manySemestral' => function ($query) use ($year, $sem, $office) {
                $query->where('year', $year)
                    ->where('sem', $sem)
                    ->where('department_code', $office);
            },
            'manySemestral.semRate' => function ($query) use ($year, $sem) {
                $query->where('year', $year)
                    ->where('sem', $sem);
            },
            'semestralRatingRemarks' => function ($query) use ($year, $sem) {
                $query->where('year', $year)
                    ->where('semester', $sem);
            }
        ])
            ->whereHas('manySemestral', function ($query) use ($office, $sem, $year) {
                $query->where('department_code', $office)
                    ->where('sem', $sem)
                    ->where('year', $year);
            })
            ->where('active_status', 'ACTIVE')
            ->where('salary_grade', '!=', 26)
            ->orderBy('last_name', 'ASC')
            ->get()
            // dd($data[1]);
            ->map(function ($item, $key) {


                $numericalRating = $item->manySemestral->map(function ($semestral) {
                    return optional($semestral->semRate)->first()->numerical_rating ?? 0;
                })->first() ?? 0;

                $adjectivalRating =
                    $item->manySemestral->map(function ($semestral) {
                        return optional($semestral->semRate)->first()->adjectival_rating ?? "";
                    })->first() ?? "";

                $semesterRemarks = $item->semestralRatingRemarks->map(function ($semestral) use ($item) {
                    if ($item->empl_id == $semestral->employee_code) {
                        return optional($semestral)->remarks ?? "";
                    }
                })->first() ?? "";
                // dd($item->semestralRatingRemarks);

                // if ($item->empl_id == 2089) {
                //
                // }
                $semesterRemarksId = $item->semestralRatingRemarks->map(function ($semestral) {
                    return optional($semestral)->id ?? "";
                })->first() ?? "";

                $middleInitial = $item->middle_name ? $item->middle_name[0] . '.' : '';
                return [
                    'emp_code' => $item->empl_id,
                    'Fullname' => $item->last_name . ", " . $item->first_name . " " . $middleInitial,
                    'numericalRating' => $numericalRating,
                    'adjectivalRating' => $adjectivalRating,
                    'remarks' => $semesterRemarks,
                    'remarks_id' => $semesterRemarksId,
                ];
            });
        // dd($data[0]);
        return inertia('SummaryOfRating/SemestralRating', [
            "data" => $data,
            "year" => $year,
            "office" => $request->department_code,
            "sem" => $request->sem,
        ]);
    }
    public function monthlyPrintSummary(Request $request)
    {
        // dd($request->all());
        $office = $request->department_code;
        $month = $request->month;
        $year = $request->year;


        if (!$office || !$month || !$year) {
            return [];
        }
        $date = Carbon::createFromFormat('F', $month);
        $monthNumber = $date->month;

        // $sem_id = $request->ipcr_semestral_id;

        // dd($monthNumber);

        $mo2 = $monthNumber;
        $semt = 1;
        if ($mo2 > 6) {
            $mo2 = intval($mo2) - 6;
            $semt = 2;
        }

        // dd(($semt));
        $data = UserEmployees::with([
            'Office',
            'manySemestral' => function ($query) use ($year, $semt) {
                $query->where('year', $year)
                    ->where('sem', $semt);
            },
            'manySemestral.monthRate' => function ($query) use ($year, $monthNumber) {
                $query->where('year', $year)
                    ->where('month', $monthNumber);
            },
            'manySemestral.Office' => function ($query) use ($office) {
                $query->where('department_code', $office);
            },
            'manySemestral.Office.pgHead'
        ])
            ->whereHas('manySemestral', function ($query) use ($office, $semt, $year) {
                $query->where('department_code', $office)
                    ->where('sem', $semt)
                    ->where('year', $year);
            })
            ->where('active_status', 'ACTIVE')
            ->where('salary_grade', '!=', 26)
            ->orderBy('last_name', 'ASC')
            ->get();

        if ($data->isEmpty()) {
            return [];
        }
        // dd($data[1]);
        return $data->map(function ($item, $key) {
            // Extract numerical and adjectival ratings
            // ->sortByDesc(function ($semestral) {
            //     return $semestral->created_at ?? null;
            // })
            $numericalRating = $item->manySemestral->map(function ($semestral) {
                return optional($semestral->monthRate)->last()->numerical_rating ?? 0;
            })->last() ?? 0;

            $adjectivalRating = $item->manySemestral->map(function ($semestral) {
                return optional($semestral->monthRate)->last()->adjectival_rating ?? "";
            })->first() ?? "";
            // dd($adjectivalRating);

            // Handle possible nulls in the name fields
            $firstName = $item->first_name ?? '';
            $middleName = $item->middle_name ?? '';
            $lastName = $item->last_name ?? '';

            $Office_Name =
                $item->manySemestral->map(function ($semestral) {
                    // dd($semestral->Office->pgHead);
                    return optional($semestral->Office)->office ?? "";
                })->first() ?? "";


            $pgHeadFirst =
                $item->manySemestral->map(function ($semestral) {
                    return optional($semestral->Office->pgHead)->first_name ?? "";
                })->first() ?? "";

            // dd($pgHeadFirst);
            $pgHeadMiddle
                =
                $item->manySemestral->map(function ($semestral) {
                    return optional($semestral->Office->pgHead)->middle_name ?? "";
                })->first() ?? "";

            $pgHeadLast
                =
                $item->manySemestral->map(function ($semestral) {
                    return optional($semestral->Office->pgHead)->last_name ?? "";
                })->first() ?? "";

            $pgHeadMiddleInitial = $pgHeadMiddle ?  $pgHeadMiddle[0] . '. ' : '';

            $pgHeadFull = $pgHeadFirst . " " . $pgHeadMiddleInitial . $pgHeadLast;
            // dd($pgHeadFull);
            $middleInitial = $middleName ? $middleName[0] . '.' : '';

            // Handle case where all name parts are null or empty
            $fullName = trim($lastName . ", " . $firstName . ' ' . $middleInitial);
            $fullName = $fullName !== '' ? $fullName : 'Unknown Name'; // Fallback to a default name if all are null or empty

            // Return the final array with fallback values
            return [
                'Fullname' => $fullName,
                'numericalRating' => $numericalRating,
                'adjectivalRating' => $adjectivalRating !== '' ? $adjectivalRating : 'No Rating', // Fallback to 'No Rating' if null or empty
                'Office' => $Office_Name,
                'pgHead' => $pgHeadFull,
                'Point' => $numericalRating == 0 ? 0 : $this->point($numericalRating),
            ];
        });
    }

    public function point($points)
    {
        if ($points >= 4.51 && $points <= 5.00) {
            return 25;
        } else if ($points >= 4.46 && $points <= 4.5) {
            return 24;
        } else if ($points >= 4.41 && $points <= 4.45) {
            return 23;
        } else if ($points >= 4.36 && $points <= 4.4) {
            return 22;
        } else if ($points >= 4.31 && $points <= 4.35) {
            return 21;
        } else if ($points >= 4.26 && $points <= 4.3) {
            return 20;
        } else if ($points >= 4.21 && $points <= 4.25) {
            return 19;
        } else if ($points >= 4.16 && $points <= 4.2) {
            return 18;
        } else if ($points >= 4.11 && $points <= 4.15) {
            return 17;
        } else if ($points >= 4.06 && $points <= 4.1) {
            return 16;
        } else if ($points >= 4.01 && $points <= 4.05) {
            return 15;
        } else if ($points >= 3.51 && $points <= 4) {
            return 13;
        } else if ($points >= 2.51 && $points <= 3.5) {
            return 10;
        } else if ($points >= 1 && $points <= 2.5) {
            return 5;
        }
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
    public function get_this_monthly(Request $request)
    {
        $mo = $request->month;
        $year = $request->year;
        $stat = intval($request->status);
        $currentDate = TimeHelper::getCurrentTime();
        // dd($currentDate);
        // dd($mo);
        // dd($year);
        // dd($request->id);
        // dd(Carbon::parse("1 $mo 2025")->month);
        $mo_num = Carbon::parse("1 $mo 2025")->month;
        // dd($mo . ' ' . $mo_num);
        $data = MonthlyAccomplishment::where('ipcr_semestral_id', $request->id)
            ->where('year', $year)
            ->where('month', $mo_num)
            ->first();
        // dd($request->id);
        // dd($data);
        if ($data) {
            if ($stat == -1) {
                $data->update([
                    'status' => '0',
                    'submitted_at' => $currentDate
                ]);
            } else {
                $data->update([
                    'status' => '0',
                    'resubmitted_at' => $currentDate
                ]);
            }

            $rem = new ReturnRemarks();
            $rem->type = "Submit Monthly Accomplishment";
            $rem->ipcr_semestral_id = $data->ipcr_semestral_id;
            $rem->ipcr_monthly_accomplishment_id = $data->id;
            $rem->employee_code = auth()->user()->username;
            $rem->save();
            // return redirect('/Accomplishment/?month=' . $mo . '&year=' . $year . '&ipcr_semestral_id=' . $request->id)
            return redirect()->back()
                ->with('info', 'IPCR for the month of ' . $mo . ' year ' . $year . ' successfully submitted');
        } else {
            // return redirect('/Accomplishment/?month=' . $mo . '&year=' . $year . '&ipcr_semestral_id=' . $request->id)
            //     ->with('error', 'IPCR for the month of ' . $mo . ' year ' . $year . ' submitted successfully');
            return redirect()->back()
                ->with('info', 'IPCR for the month of ' . $mo . ' year ' . $year . ' successfully submitted');
        }


        // dd($data);

    }
    public function recall_this_monthly(Request $request)
    {
        $mo = $request->month;
        $year = $request->year;
        // dd($year);
        // dd($request->id);
        $mo_num = Carbon::parse("1 $mo 2025")->month;
        // Carbon::parse($request->month)->month;
        // dd($mo . ' ' . $mo_num);
        $data = MonthlyAccomplishment::where('ipcr_semestral_id', $request->id)
            ->where('year', $year)
            ->where('month', $mo_num)
            ->first();
        // dd($data);
        if ($data) {
            $data->update([
                'status' => '-1',
            ]);
            $rem = new ReturnRemarks();
            $rem->type = "Recall Monthly Accomplishment";
            $rem->ipcr_semestral_id = $data->ipcr_semestral_id;
            $rem->ipcr_monthly_accomplishment_id = $data->id;
            $rem->employee_code = auth()->user()->username;
            $rem->save();
            // return redirect('/Accomplishment/?month=' . $mo . '&year=' . $year)
            //     ->with('info', 'Recall of IPCR for the month of ' . $mo . ' year ' . $year . ' successful');
            return redirect()->back()
                ->with('info', 'Recall of IPCR for the month of ' . $mo . ' year ' . $year . ' successful');
        } else {
            // return redirect('/Accomplishment/?month=' . $mo . '&year=' . $year)
            return redirect()->back()
                ->with('error', 'Recall unsuccessful');
        }
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


    public function MonthlyPrintTypes(Request $request)
    {
        $date_now = Carbon::now();
        $dn = $date_now->format('m-d-Y');
        $arr = [
            [
                "emp_code" => $request->emp_code,
                "employee_name" => $request->employee_name,
                "emp_status" => $request->emp_status,
                "position" => $request->position,
                "office" => $request->office,
                "division" => $request->division,
                "immediate" => $request->immediate,
                "next_higher" => $request->next_higher,
                "sem" => $request->sem,
                "year" => $request->year,
                "idsemestral" => $request->idsemestral,
                "date" => $dn,
                "period" => $request->period,
                "type" => "Core Function",
                "pghead" => $request->pghead,
            ],
            [
                "emp_code" => $request->emp_code,
                "employee_name" => $request->employee_name,
                "emp_status" => $request->emp_status,
                "position" => $request->position,
                "office" => $request->office,
                "division" => $request->division,
                "immediate" => $request->immediate,
                "next_higher" => $request->next_higher,
                "sem" => $request->sem,
                "year" => $request->year,
                "idsemestral" => $request->idsemestral,
                "date" => $dn,
                "period" => $request->period,
                "type" => "Support Function",
                "pghead" => $request->pghead,
            ]
        ];
        return $arr;
    }

    public function MonthlyPrint(Request $request)
    {

        $emp_code = $request->emp_code;
        $month = Carbon::parse($request->month)->month;
        $Score = $request->Score;
        $Percentage = $request->Percentage;
        $QualityType = $request->QualityType;
        $QuantityType = $request->QuantityType;
        $QualityRating = $request->QualityRating;
        $TimeRating = $request->TimeRating;
        $year = $request->year;
        // dd($year);
        $sem = 1;
        $months = $month;
        if ($month > 6) {
            $months = $month - 6;
            $sem = 2;
        }
        $TimeRange5 = '';
        $prescribed_period = '';
        $time_unit = '';
        $Prescribed_period = '';
        $data = Daily_Accomplishment::select(
            'ipcr_daily_accomplishments.idIPCR',
            DB::raw('SUM(ipcr_daily_accomplishments.quantity) as TotalQuantity'),
            DB::raw('SUM(ipcr_daily_accomplishments.average_timeliness) as TotalTimeliness'),
            DB::raw('ROUND(SUM(ipcr_daily_accomplishments.average_timeliness) / SUM(ipcr_daily_accomplishments.quantity)) as Final_Average_Timeliness'),
            'individual_final_outputs.individual_output',
            'individual_final_outputs.success_indicator',
            'individual_final_outputs.quantity_type',
            'individual_final_outputs.quality_error',
            'individual_final_outputs.time_range_code',
            'individual_final_outputs.activity',
            'individual_final_outputs.verb',
            'individual_final_outputs.error_feedback',
            'individual_final_outputs.within',
            'individual_final_outputs.unit_of_time',
            'individual_final_outputs.concatenate',
            'individual_final_outputs.time_based',
            'monthly_remarks.remarks',
            'monthly_remarks.id AS remarks_id',
            'major_final_outputs.mfo_desc',
            'division_outputs.output',
            'i_p_c_r_targets.ipcr_type',
            'i_p_c_r_targets.ipcr_semester_id',
            'i_p_c_r_targets.semester',
            "i_p_c_r_targets.month_$months as month",
            'ipcr__semestrals.year',
            DB::raw('COUNT(ipcr_daily_accomplishments.quality) as NumberofQuality'),
            DB::raw('SUM(CASE WHEN ipcr_daily_accomplishments.quality IS NOT NULL AND ipcr_daily_accomplishments.quality != "" THEN ipcr_daily_accomplishments.quality ELSE 0 END) AS total_quality'),
            DB::raw('ROUND(CASE WHEN COUNT(ipcr_daily_accomplishments.quality) > 0 THEN SUM(CASE WHEN ipcr_daily_accomplishments.quality IS NOT NULL AND ipcr_daily_accomplishments.quality != "" THEN ipcr_daily_accomplishments.quality ELSE 0 END) / COUNT(ipcr_daily_accomplishments.quality) ELSE 0 END, 0) AS quality_average'),
            DB::raw("'$Score' AS Score"),
            DB::raw("'$QualityType' AS QualityType"),
            DB::raw("'$QuantityType' AS QuantityType"),
            DB::raw("'$QualityRating' AS QualityRating"),
            DB::raw("'$TimeRating' AS TimeRating"),
            DB::raw("'$prescribed_period' AS prescribed_period"),
            DB::raw("'$time_unit' AS time_unit"),
            // DB::raw("'$TimeRange5' AS TimeRange5"),
        )
            ->where('emp_code', $emp_code)
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->join('individual_final_outputs', 'ipcr_daily_accomplishments.idIPCR', '=', 'individual_final_outputs.ipcr_code')
            ->join('major_final_outputs', 'individual_final_outputs.idmfo', '=', 'major_final_outputs.id')
            ->join('division_outputs', 'individual_final_outputs.id_div_output', '=', 'division_outputs.id')
            ->join(
                'i_p_c_r_targets',
                function ($join) use ($emp_code) {
                    $join->on('ipcr_daily_accomplishments.idIPCR', '=', 'i_p_c_r_targets.ipcr_code')
                        ->where('ipcr_daily_accomplishments.emp_code', '=', $emp_code)
                        ->where('i_p_c_r_targets.employee_code', '=', $emp_code);
                }
            )
            ->join('ipcr__semestrals', 'i_p_c_r_targets.ipcr_semester_id', '=', 'ipcr__semestrals.id')
            ->leftJoin('monthly_remarks', function ($join) use ($month) {
                $join->on('ipcr_daily_accomplishments.idIPCR', '=', 'monthly_remarks.idIPCR')
                    ->where('monthly_remarks.month', '=', $month)
                    ->whereMonth('ipcr_daily_accomplishments.date', '=', $month);
            })
            ->where('ipcr__semestrals.year', $year)
            ->where('i_p_c_r_targets.semester', $sem)
            ->where('i_p_c_r_targets.ipcr_type', $request->type)
            ->groupBy('ipcr_daily_accomplishments.idIPCR')
            ->get();


        foreach ($data as $key => $value) {
            if ($value->month == 0) {
                $value->month = 1;
            }
            $value->Percentage = round(($value->TotalQuantity / $value->month) * 100);


            if ($value->quantity_type == 1) {
                if ($value->Percentage >= 130) {
                    $value->Score = "5";
                } else if ($value->Percentage <= 129 && $value->Percentage >= 115) {
                    $value->Score = "4";
                } else if ($value->Percentage <= 114 && $value->Percentage >= 90) {
                    $value->Score = "3";
                } else if ($value->Percentage <= 89 && $value->Percentage >= 51) {
                    $value->Score = "2";
                } else if ($value->Percentage <= 50) {
                    $value->Score = "1";
                } else {
                    $value->Score = 0.00;
                }
            } else if ($value->quantity_type == 2) {
                if ($value->Percentage = 100) {
                    $value->Score = 5;
                } else {
                    $value->Score = 2;
                }
            }

            if ($value->quantity_type == 1) {
                $value->QuantityType = "TO BE RATED";
            } else {
                $value->QuantityType = "ACCURACY RULE (100%=5,2 if less than 100%)";
            }

            if ($value->quality_error == 1) {
                if ($value->quality_average == 0) {
                    $value->QualityRating = "5";
                } else if ($value->quality_average >= .01 && $value->quality_average <= 2.99) {
                    $value->QualityRating = "4";
                } else if ($value->quality_average >= 3 && $value->quality_average <= 4.99) {
                    $value->QualityRating = "3";
                } else if ($value->quality_average >= 5 && $value->quality_average <= 6.99) {
                    $value->QualityRating = "2";
                } else if ($value->quality_average >= 7) {
                    $value->QualityRating = "1";
                }
            } else if ($value->quality_error == 2) {
                if ($value->quality_average == 5) {
                    $value->QualityRating = "5";
                } else if ($value->quality_average >= 4 && $value->quality_average <= 4.99) {
                    $value->QualityRating = "4";
                } else if ($value->quality_average >= 3 && $value->quality_average <= 3.99) {
                    $value->QualityRating = "3";
                } else if ($value->quality_average >= 2 && $value->quality_average <= 2.99) {
                    $value->QualityRating = "2";
                } else if ($value->quality_average >= 1 && $value->quality_average <= 1.99) {
                    $value->QualityRating = "1";
                } else {
                    $value->QualityRating = "0";
                }
            } else if ($value->quality_error == 4) {
                if ($value->quality_average >= 1) {
                    $value->QualityRating = "2";
                } else {
                    $value->QualityRating = "5";
                }
            }

            if ($value->quality_error == 1) {
                $value->QualityType = 'NO. OF ERROR';
            } else if ($value->quality_error == 2) {
                $value->QualityType = "AVE. FEEDBACK";
            } else if ($value->quality_error == 3) {
                $value->QualityType = "NOT TO BE RATED";
            } else if ($value->quality_error == 4) {
                $value->QualityType = "ACCURACY RULE";
            }



            if ($value->time_range_code > 0 && $value->time_range_code < 47) {
                if ($value->time_based == 1) {
                    $time_range5 = TimeRange::where('time_code', $value->time_range_code)->orderBY('rating', 'DESC')->get();
                    if (!$value->Final_Average_Timeliness) {
                        $value->TimeRating = 0;
                        $value->time_unit = "";
                        $value->prescribed_period = "";
                        $value->Prescribed_period = "Prescribed Period is " . $value->prescribed_period . " " . $value->time_unit;
                    } else if (
                        $value->Final_Average_Timeliness <= $time_range5[0]->equivalent_time_from
                    ) {
                        $value->TimeRating = 5;
                        $value->time_unit = $time_range5[0]->time_unit;
                        $value->prescribed_period = $time_range5[0]->prescribed_period;
                        $value->Prescribed_period = "Prescribed Period is " . $value->prescribed_period . " " . $value->time_unit;
                    } else if (
                        $value->Final_Average_Timeliness >= $time_range5[4]->equivalent_time_from
                    ) {
                        $value->TimeRating = 1;
                        $value->time_unit = $time_range5[4]->time_unit;
                        $value->prescribed_period = $time_range5[4]->prescribed_period;
                        $value->Prescribed_period = "Prescribed Period is " . $value->prescribed_period . " " . $value->time_unit;
                    } else if (
                        $value->Final_Average_Timeliness >= $time_range5[3]->equivalent_time_from
                    ) {
                        $value->TimeRating = 2;
                        $value->time_unit = $time_range5[3]->time_unit;
                        $value->prescribed_period = $time_range5[3]->prescribed_period;
                        $value->Prescribed_period = "Prescribed Period is " . $value->prescribed_period . " " . $value->time_unit;
                    } else if (
                        $value->Final_Average_Timeliness >= $time_range5[2]->equivalent_time_from
                    ) {
                        $value->TimeRating = 3;
                        $value->time_unit = $time_range5[2]->time_unit;
                        $value->prescribed_period = $time_range5[2]->prescribed_period;
                        $value->Prescribed_period = "Prescribed Period is " . $value->prescribed_period . " " . $value->time_unit;
                    } else if ($value->Final_Average_Timeliness >= $time_range5[1]->equivalent_time_from) {
                        $value->TimeRating = 4;
                        $value->time_unit = $time_range5[1]->time_unit;
                        $value->prescribed_period = $time_range5[1]->prescribed_period;
                        $value->Prescribed_period = "Prescribed Period is " . $value->prescribed_period . " " . $value->time_unit;
                    } else {
                        $value->TimeRating = 0;
                        $value->time_unit = "";
                        $value->prescribed_period = "";
                    }
                }
            } else {
                $value->TotalTimeliness = "";
                $value->Final_Average_Timeliness = "";
                $value->TimeRating = 0;
                $value->Prescribed_period = "Not to be Rated";
            }
        }
        return $data;
    }


    public function store(Request $request)
    {

        // dd($request->all());
        $year = $request->year;
        $month1 = $request->month;
        $months = $request->month;

        // dd($month1);
        if ($months == "January") {
            $months = 1;
        } else if ($months ==  "Febraury") {
            $months = 2;
        } else if ($months ==  "March") {
            $months = 3;
        } else if ($months ==  "April") {
            $months = 4;
        } else if ($months ==  "May") {
            $months = 5;
        } else if ($months == "June") {
            $months = 6;
        } else if ($months ==  "July") {
            $months = 7;
        } else if ($months ==  "August") {
            $months = 8;
        } else if ($months ==  "September") {
            $months = 9;
        } else if ($months ==  "October") {
            $months = 10;
        } else if ($months ==  "November") {
            $months = 11;
        } else if ($months ==  "December") {
            $months = 12;
        }
        // dd($month);
        // dd($request->all());
        // dd($request);
        MonthlyRemarks::create([
            'remarks' => $request->remarks,
            'remarks_id' => $request->remarks_id,
            'year' => $request->year,
            'month' => $months,
            'target_output_id' => $request->idIPCR,
            'idSemestral' => $request->idSemestral,
            'emp_code' => $request->emp_code,
            'target_output_type' => $request->accomplishment_type,
        ]);

        // return redirect('/Accomplishment/?month=' . $month1 . '&year=' . $year)
        //     ->with('message', 'Remarks added');
        return redirect()->back()->with('message', 'Remark added');
    }
    public function update(Request $request)
    {

        $year = $request->year;
        $months = $request->month;
        if ($months == 1) {
            $months = "January";
        } else if ($months == 2) {
            $months = "Febraury";
        } else if ($months == 3) {
            $months = "March";
        } else if ($months == 4) {
            $months = "April";
        } else if ($months == 5) {
            $months = "May";
        } else if ($months == 6) {
            $months = "June";
        } else if ($months == 7) {
            $months = "July";
        } else if ($months == 8) {
            $months = "August";
        } else if ($months == 9) {
            $months = "September";
        } else if ($months == 10) {
            $months = "October";
        } else if ($months == 11) {
            $months = "November";
        } else if ($months == 12) {
            $months = "December";
        }
        $data = MonthlyRemarks::findOrFail($request->id);
        $data->update([
            'remarks' => $request->remarks,
        ]);

        // return redirect('/Accomplishment/?month=' . $months . '&year=' . $year)
        //     ->with('info', 'Remarks updated');
        return redirect()->back()->with('info', 'Remark updated');
    }
    public function destroy(Request $request)
    {

        $data = MonthlyRemarks::findOrFail($request->id);
        $year = $data->year;

        $months = $data->month;
        if ($months == 1) {
            $months = "January";
        } else if ($months == 2) {
            $months = "Febraury";
        } else if ($months == 3) {
            $months = "March";
        } else if ($months == 4) {
            $months = "April";
        } else if ($months == 5) {
            $months = "May";
        } else if ($months == 6) {
            $months = "June";
        } else if ($months == 7) {
            $months = "July";
        } else if ($months == 8) {
            $months = "August";
        } else if ($months == 9) {
            $months = "September";
        } else if ($months == 10) {
            $months = "October";
        } else if ($months == 11) {
            $months = "November";
        } else if ($months == 12) {
            $months = "December";
        }

        $data->delete();

        // return redirect('/Accomplishment/?month=' . $months . '&year=' . $year)
        //     ->with('info', 'Remarks deleted');
        return redirect()->back()->with('info', 'Remark deleted');
        //dd($request->raao_id);
        // return redirect('/Daily_Accomplishment')->with('warning', 'Accomplishment Deleted');
    }
    public function MonthlyPrintMain(Request $request)
    {
        $Point_Core = 0;
        $Point_Support = 0;
        if ($request->Average_Point_Core == null) {
            $Point_Core = 0;
        } else {
            $Point_Core = floatval($request->Average_Point_Core);
        }

        if ($request->Average_Point_Support == null) {
            $Point_Support = 0;
        } else {
            $Point_Support = floatval($request->Average_Point_Support);
        }

        $months = 0;
        if ($request->period == "January") {
            $months = 1;
        } else if ($request->period == "February") {
            $months = 2;
        } else if ($request->period == "March") {
            $months = 3;
        } else if ($request->period == "April") {
            $months = 4;
        } else if ($request->period == "May") {
            $months = 5;
        } else if ($request->period == "June") {
            $months = 6;
        } else if ($request->period == "July") {
            $months = 7;
        } else if ($request->period == "August") {
            $months = 8;
        } else if ($request->period == "September") {
            $months = 9;
        } else if ($request->period == "October") {
            $months = 10;
        } else if ($request->period == "November") {
            $months = 11;
        } else if ($request->period == "December") {
            $months = 12;
        }


        $month_sem = 0;
        $monthly = MonthlyAccomplishment::select(
            'ipcr_monthly_accomplishments.id',
            'ipcr_monthly_accomplishments.month',
        )
            ->where('ipcr_monthly_accomplishments.ipcr_semestral_id', $request->idsemestral)
            ->where('ipcr_monthly_accomplishments.month', $months)
            ->first();
        // dd($monthly);
        if (isset($monthly)) {
            $month_sem = $monthly->id;
        };
        // dd($request->emp_code);
        $remarks = ReturnRemarks::select(
            'return_remarks.remarks',
            'return_remarks.ipcr_monthly_accomplishment_id',
            'return_remarks.created_at',
            'ipcr_monthly_accomplishments.status',
        )
            ->leftjoin('ipcr_monthly_accomplishments', 'ipcr_monthly_accomplishments.ipcr_semestral_id', 'return_remarks.ipcr_semestral_id')
            ->where('return_remarks.type', 'review accomplishment')
            ->where('return_remarks.employee_code', $request->emp_code)
            ->where('return_remarks.ipcr_monthly_accomplishment_id', $month_sem)
            ->orderBy('return_remarks.created_at', 'DESC')
            ->first();
        // dd($remarks);

        $monthly_review = "";
        $monthly_status = 0;
        if (isset($remarks)) {
            $monthly_review = $remarks->remarks;
            $monthly_status = $remarks->status;
        };
        // dd($remarks);

        $emp_type = employee_division_head($request->emp_code);

        // dd($emp_type);
        $date_now = Carbon::now();
        $dn = $date_now->format('m-d-Y');
        $arr = [
            [
                "emp_code" => $request->emp_code,
                "employee_name" => $request->employee_name,
                "emp_status" => $request->emp_status,
                "position" => $request->position,
                "office" => $request->office,
                "division" => $request->division,
                "immediate" => $request->immediate,
                "next_higher" => $request->next_higher,
                "sem" => $request->sem,
                "year" => $request->year,
                "idsemestral" => $request->idsemestral,
                "date" => $dn,
                "period" => $request->period,
                "type" => "Core Function",
                "pghead" => $request->pghead,
                "MonthlyStatus" => $request->MonthlyStatus,
                "Average_Point" => $Point_Core,
                "Multiply" => 70,
                "Average_Score_Function" => round($Point_Core * .70, 2),
                "Total_Average_Score" => round(($Point_Core * .70) + ($Point_Support * .30), 2),
                "Monthly_Remarks" => $monthly_review,
                "Monthly_Status" => $monthly_status,
                "emp_type" => $emp_type,
            ],
            [
                "emp_code" => $request->emp_code,
                "employee_name" => $request->employee_name,
                "emp_status" => $request->emp_status,
                "position" => $request->position,
                "office" => $request->office,
                "division" => $request->division,
                "immediate" => $request->immediate,
                "next_higher" => $request->next_higher,
                "sem" => $request->sem,
                "year" => $request->year,
                "idsemestral" => $request->idsemestral,
                "date" => $dn,
                "period" => $request->period,
                "type" => "Support Function",
                "pghead" => $request->pghead,
                "MonthlyStatus" => $request->MonthlyStatus,
                "Average_Point" => $Point_Support,
                "Multiply" => 30,
                "Average_Score_Function" => round($Point_Support * .30, 2),
                "Total_Average_Score" => round(($Point_Core * .70) + ($Point_Support * .30), 2),
                "Monthly_Remarks" => $monthly_review,
                "Monthly_Status" => $monthly_status,
                "emp_type" => $emp_type,
            ]
        ];
        // dd($arr);
        return $arr;
    }

    public function MonthlyPrintMainTypes(Request $request)
    {

        // dd($request->all());
        $month = Carbon::parse($request->month)->month;


        $month = $month <= 6 ? $month : $month - 6;

        $ipcr_semestral_id = $request->ipcr_semester_id;
        $type = $request->type;
        $emp_type = $request->emp_type;

        // dd($month);
        if (empty($emp_type)) {
            return [];
        }


        $data = $this->getAccomplishmenttData1($emp_type, $type, $ipcr_semestral_id, $month);

        // dd($ipcr_semestral_id);

        // dd($data);

        return $data;
    }

    public function getAccomplishmenttData1($is_division_head, $type, $ipcr_semestral_id, $month)
    {
        // dd($type);
        // dd($is_division_head);
        if ($is_division_head == 'emp') {
            // $is_division_head = 'emp';
            $accomplishment = $this->data_ipcr1($type, $ipcr_semestral_id, $month);
        } else if ($is_division_head == 'div') {
            $accomplishment = $this->data_dpcr1($type, $ipcr_semestral_id, $month);
        } else if ($is_division_head == 'hemp') {
            $accomplishment = $this->view_hipcr_targets_api($type, $ipcr_semestral_id, $month, $type);
        } else if ($is_division_head == 'hsec') {
            $accomplishment = $this->view_hspcr_targets($type, $ipcr_semestral_id, $month);
        } else if ($is_division_head == 'hdiv') {
            $accomplishment = $this->view_hdpcr_targets($type, $ipcr_semestral_id, $month);
        } else if ($is_division_head == 'hos') {
            $accomplishment = $this->view_hpcr_targets($type, $ipcr_semestral_id, $month);
        }
        // dd($targets);
        return $accomplishment;
    }


    public function data_ipcr1($type, $ipcr_semestral_id, $month)
    {

        // dd($month);
        return MonthlyTarget::with([
            'ipcrTargets',
            'ipcrTargets.individualOutput.monthlyRemarks' => function ($query) use ($month, $ipcr_semestral_id) {
                $query->where('monthly_remarks.month', '=', $month);
                $query->where('monthly_remarks.idSemestral', '=', $ipcr_semestral_id);
            },
            'ipcrTargets.individualOutput',
            'ipcrTargets.individualOutput.divisionOutput',
            'ipcrTargets.individualOutput.divisionOutput.programAndProject',
            'ipcrTargets.individualOutput.divisionOutput.programAndProject.MFO',
            'ipcr_Semestral.immediate.Division',
            'ipcr_Semestral.next_higher1.Division',
            'monthlyAccomplishmentMany' => function ($query) use ($month) {
                $query->where('ipcr_monthly_accomplishments.month', '=', $month);
            },
        ])
            ->where('sem_id', $ipcr_semestral_id)
            ->where('month', $month)
            ->whereHas('ipcrTargets', function ($query) use ($type) {
                $query->where('ipcr_type', $type);
            })
            ->get()
            ->map(fn($item, $key) => [
                "individual_output_id" => $item->ipcrTargets->individualOutput->id ?? '',
                "individual_output" => $item->ipcrTargets->individualOutput->individual_output ?? '',
                "performance_measure" => $item->ipcrTargets->individualOutput->performance_measure ?? '',
                "prescribed_period" => $item->ipcrTargets->individualOutput->prescribed_period ?? '',
                "quality1" => $item->ipcrTargets->individualOutput->quality1 ?? '',
                "quality2" => $item->ipcrTargets->individualOutput->quality2 ?? '',
                "quality3" => $item->ipcrTargets->individualOutput->quality3 ?? '',
                "efficiency1" => $item->ipcrTargets->individualOutput->efficiency1 ?? '',
                "efficiency2" => $item->ipcrTargets->individualOutput->efficiency2 ?? '',
                "efficiency3" => $item->ipcrTargets->individualOutput->efficiency3 ?? '',
                "timeliness" => $item->ipcrTargets->individualOutput->timeliness ?? '',
                "remarks" =>
                $item->ipcrTargets &&
                    $item->ipcrTargets->individualOutput &&
                    $item->ipcrTargets->individualOutput->monthlyRemarks->first()
                    ? $item->ipcrTargets->individualOutput->monthlyRemarks->first()->remarks
                    : '',

                "remarks_id" =>
                $item->ipcrTargets &&
                    $item->ipcrTargets->individualOutput &&
                    $item->ipcrTargets->individualOutput->monthlyRemarks->first()
                    ? $item->ipcrTargets->individualOutput->monthlyRemarks->first()->id
                    : '',
                'ipcr_type' => $item->ipcrTargets->ipcr_type ?? '',
                "target_remarks" => $item->ipcrTargets->remarks ?? '',
                "q1" => $item->q1,
                "q2" => $item->q2,
                "q3" => $item->q3,
                "quality_avg" => collect([$item->q1, $item->q2, $item->q3])
                    ->filter(fn($val) => $val != 0)
                    ->avg()
                    ? round(collect([$item->q1, $item->q2, $item->q3])->filter(fn($val) => $val != 0)->avg(), 2)
                    : 0,
                "e1" => $item->e1,
                "e2" => $item->e2,
                "e3" => $item->e3,
                "efficiency_avg" => collect([$item->e1, $item->e2, $item->e3])
                    ->filter(fn($val) => $val != 0)
                    ->avg()
                    ? round(collect([$item->e1, $item->e2, $item->e3])->filter(fn($val) => $val != 0)->avg(), 2)
                    : 0,
                "time" => $item->t1 == null ? 0 : $item->t1,
                "year" => $item->year,
                "month" => $item->month,
                "sem_id" => $item->sem_id,
                "DivisionOutput" => $item->ipcrTargets->individualOutput->divisionOutput->output ?? '',
                "PPA" => $item->ipcrTargets->individualOutput->divisionOutput->programAndProject->paps_desc ?? '',
                "MFO" => $item->ipcrTargets->individualOutput->divisionOutput->programAndProject->MFO->mfo_desc ?? '',
                // "individual_output" => $item[0]['ipcrTargets'] ? $item[0]['ipcrTargets']->individual_output : '',
            ]);
    }

    public function data_dpcr1($type, $ipcr_semestral_id, $month)
    {
        return MonthlyTarget::with([
            'dpcrTargets',
            'dpcrTargets.divisionOutput',
            'dpcrTargets.divisionOutput.programAndProject',
            'dpcrTargets.divisionOutput.programAndProject.MFO',
            'ipcr_Semestral.immediate.Division',
            'ipcr_Semestral.next_higher1.Division',
            'monthlyAccomplishmentMany' => function ($query) use ($month) {
                $query->where('ipcr_monthly_accomplishments.month', '=', $month);
            },
        ])
            ->where('sem_id', $ipcr_semestral_id)
            ->where('month', $month)
            ->whereHas('dpcrTargets', function ($query) use ($type) {
                $query->where('dpcr_type', $type);
            })
            ->get()
            ->map(fn($item, $key) => [
                "individual_output" => '',
                "DivisionOutput" => $item->dpcrTargets->divisionOutput->id ?? '',
                "DivisionOutput" => $item->dpcrTargets->divisionOutput->output ?? '',
                "performance_measure" => $item->dpcrTargets->divisionOutput->performance_measure ?? '',
                "prescribed_period" => $item->dpcrTargets->divisionOutput->prescribed_period ?? '',
                "quality1" => $item->dpcrTargets->divisionOutput->quality1 ?? '',
                "quality2" => $item->dpcrTargets->divisionOutput->quality2 ?? '',
                "quality3" => $item->dpcrTargets->divisionOutput->quality3 ?? '',
                "efficiency1" => $item->dpcrTargets->divisionOutput->efficiency1 ?? '',
                "efficiency2" => $item->dpcrTargets->divisionOutput->efficiency2 ?? '',
                "efficiency3" => $item->dpcrTargets->divisionOutput->efficiency3 ?? '',
                "timeliness" => $item->dpcrTargets->divisionOutput->timeliness ?? '',
                "remarks" =>
                $item->ipcrTargets &&
                    $item->ipcrTargets->individualOutput &&
                    $item->ipcrTargets->individualOutput->monthlyRemarks->first()
                    ? $item->ipcrTargets->individualOutput->monthlyRemarks->first()->remarks
                    : '',

                "remarks_id" =>
                $item->ipcrTargets &&
                    $item->ipcrTargets->individualOutput &&
                    $item->ipcrTargets->individualOutput->monthlyRemarks->first()
                    ? $item->ipcrTargets->individualOutput->monthlyRemarks->first()->id
                    : '',
                'ipcr_type' => $item->dpcrTargets->dpcr_type ?? '',
                "target_remarks" => $item->dpcrTargets->remarks ?? '',
                "q1" => $item->q1,
                "q2" => $item->q2,
                "q3" => $item->q3,
                "quality_avg" => collect([$item->q1, $item->q2, $item->q3])
                    ->filter(fn($val) => $val != 0)
                    ->avg()
                    ? round(collect([$item->q1, $item->q2, $item->q3])->filter(fn($val) => $val != 0)->avg(), 2) : 0,
                "e1" => $item->e1,
                "e2" => $item->e2,
                "e3" => $item->e3,
                "efficiency_avg" => collect([$item->e1, $item->e2, $item->e3])
                    ->filter(fn($val) => $val != 0)
                    ->avg()
                    ? round(collect([$item->e1, $item->e2, $item->e3])->filter(fn($val) => $val != 0)->avg(), 2)
                    : 0,
                "time" => $item->t1,
                "year" => $item->year,
                "month" => $item->month,
                "sem_id" => $item->sem_id,
                "PPA" => $item->dpcrTargets->divisionOutput->programAndProject->paps_desc ?? '',
                "MFO" => $item->dpcrTargets->divisionOutput->programAndProject->MFO->mfo_desc ?? '',
            ])
            ->values();
    }
    // public function data_hpcr($type, $ipcr_semestral_id, $month)
    // {
    //     return MonthlyTarget::with([
    //         'dpcrTargets',
    //         'dpcrTargets.divisionOutput',
    //         'dpcrTargets.divisionOutput.programAndProject',
    //         'dpcrTargets.divisionOutput.programAndProject.MFO',
    //         'ipcr_Semestral.immediate.Division',
    //         'ipcr_Semestral.next_higher1.Division',
    //         'monthlyAccomplishmentMany' => function ($query) use ($month) {
    //             $query->where('ipcr_monthly_accomplishments.month', '=', $month);
    //         },
    //     ])
    //         ->where('sem_id', $ipcr_semestral_id)
    //         ->where('month', $month)
    //         ->whereHas('dpcrTargets', function ($query) use ($type) {
    //             $query->where('dpcr_type', $type);
    //         })
    //         ->get()
    //         ->map(fn($item, $key) => [
    //             "individual_output" => '',
    //             "DivisionOutput" => $item->dpcrTargets->divisionOutput->id ?? '',
    //             "DivisionOutput" => $item->dpcrTargets->divisionOutput->output ?? '',
    //             "performance_measure" => $item->dpcrTargets->divisionOutput->performance_measure ?? '',
    //             "prescribed_period" => $item->dpcrTargets->divisionOutput->prescribed_period ?? '',
    //             "quality1" => $item->dpcrTargets->divisionOutput->quality1 ?? '',
    //             "quality2" => $item->dpcrTargets->divisionOutput->quality2 ?? '',
    //             "quality3" => $item->dpcrTargets->divisionOutput->quality3 ?? '',
    //             "efficiency1" => $item->dpcrTargets->divisionOutput->efficiency1 ?? '',
    //             "efficiency2" => $item->dpcrTargets->divisionOutput->efficiency2 ?? '',
    //             "efficiency3" => $item->dpcrTargets->divisionOutput->efficiency3 ?? '',
    //             "timeliness" => $item->dpcrTargets->divisionOutput->timeliness ?? '',
    //             "remarks" =>
    //             $item->ipcrTargets &&
    //                 $item->ipcrTargets->individualOutput &&
    //                 $item->ipcrTargets->individualOutput->monthlyRemarks->first()
    //                 ? $item->ipcrTargets->individualOutput->monthlyRemarks->first()->remarks
    //                 : '',

    //             "remarks_id" =>
    //             $item->ipcrTargets &&
    //                 $item->ipcrTargets->individualOutput &&
    //                 $item->ipcrTargets->individualOutput->monthlyRemarks->first()
    //                 ? $item->ipcrTargets->individualOutput->monthlyRemarks->first()->id
    //                 : '',
    //             'ipcr_type' => $item->dpcrTargets->dpcr_type ?? '',
    //             "target_remarks" => $item->dpcrTargets->remarks ?? '',
    //             "q1" => $item->q1,
    //             "q2" => $item->q2,
    //             "q3" => $item->q3,
    //             "quality_avg" => collect([$item->q1, $item->q2, $item->q3])
    //                 ->filter(fn($val) => $val != 0)
    //                 ->avg()
    //                 ? round(collect([$item->q1, $item->q2, $item->q3])->filter(fn($val) => $val != 0)->avg(), 2) : 0,
    //             "e1" => $item->e1,
    //             "e2" => $item->e2,
    //             "e3" => $item->e3,
    //             "efficiency_avg" => collect([$item->e1, $item->e2, $item->e3])
    //                 ->filter(fn($val) => $val != 0)
    //                 ->avg()
    //                 ? round(collect([$item->e1, $item->e2, $item->e3])->filter(fn($val) => $val != 0)->avg(), 2)
    //                 : 0,
    //             "time" => $item->t1,
    //             "year" => $item->year,
    //             "month" => $item->month,
    //             "sem_id" => $item->sem_id,
    //             "PPA" => $item->dpcrTargets->divisionOutput->programAndProject->paps_desc ?? '',
    //             "MFO" => $item->dpcrTargets->divisionOutput->programAndProject->MFO->mfo_desc ?? '',
    //         ])
    //         ->values();
    // }


    public function index_back(Request $request)
    {
        // dd("Function");
        $emp_code = Auth()->user()->username;
        $emp = UserEmployees::where('empl_id', $emp_code)
            ->first();

        $month = Carbon::parse($request->month)->month;
        $year = $request->year;
        $sem = 1;

        $months = $month;
        if ($month > 6) {
            $months = $month - 6;
            $sem = 2;
        }
        $TimeRating = $request->TimeRating;
        $prescribed_period = '';
        $time_unit = '';
        $div = auth()->user()->division_code;
        $division = [];
        // dd($div);
        if ($div) {
            $division = Division::where('division_code', $div)
                ->first()->division_name1;
        }
        $esd = EmployeeSpecialDepartment::where('employee_code', $emp_code)->first();
        $office = FFUNCCOD::where('department_code', auth()->user()->department_code)->first();
        if ($esd) {
            if ($esd->department_code) {
                $office = FFUNCCOD::where('department_code', $esd->department_code)->first();
                $dept = Office::where('department_code', $esd->department_code)->first();
            } else {
                $office = FFUNCCOD::where('department_code', $emp->department_code)->first();
                $dept = Office::where('department_code', $emp->department_code)->first();
            }

            if ($esd->pgdh_cats) {

                $pgHead = UserEmployees::where('empl_id', $esd->pgdh_cats)->first();
            } else {

                $pgHead = UserEmployees::where('empl_id', $dept->empl_id)->first();
            }
        } else {
            $office = FFUNCCOD::where('department_code', $emp->department_code)->first();
            $dept = Office::where('department_code', $emp->department_code)->first();
            $pgHead = UserEmployees::where('empl_id', $dept->empl_id)->first();
        }


        // $dept = Office::where('department_code', auth()->user()->department_code)->first();
        // $pgHead = UserEmployees::where('empl_id', $dept->empl_id)->first();
        $suff = "";
        $post = "";
        $mn = "";
        if (
            $pgHead->suffix_name != ''
        ) {
            $suff = ', ' . $pgHead->suffix_name;
        }
        if (
            $pgHead->postfix_name != ''
        ) {
            // dd('fsdfdsfsdf');
            $post = ', ' . $pgHead->postfix_name;
        }
        if (
            $pgHead->middle_name != ''
        ) {
            $mn = $pgHead->middle_name[0] . '. ';
        }
        $pgHead = $pgHead->first_name . ' ' . $mn  . $pgHead->last_name . '' . $suff . '' . $post;
        // $data = Daily_Accomplishment::with([
        //     'ipcr_Semestral',
        //     'ipcr_Semestral.ipcrTarget',
        //     'individualFinalOutput',
        // ])
        //     ->where('emp_code', $emp_code)
        //     ->whereMonth('date', $month)
        //     ->whereYear('date', $year)
        //     ->get()
        //     ->groupBy('idIPCR')
        //     ->map(fn ($item, $key) => [

        //         dd($item),
        //     ]);
        // dd($data);
        $data = Daily_Accomplishment::with([
            'individualFinalOutput',
            'ipcrTarget' => function ($query) use ($emp_code, $month, $year) {
                $query->where('i_p_c_r_targets.employee_code', '=', $emp_code);
                // ->whereMonth('date', $month)
                // ->whereYear('date', $year);
            },
            'ipcr_Semestral.immediate.Division',
            'ipcr_Semestral.next_higher1.Division',
            'monthlyAccomplishment',
            'monthlyAccomplishment.returnRemarks'
        ])
            ->where('emp_code', $emp_code)
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->select()
            // ->selectRaw('ipcr_daily_accomplishments.idIPCR, SUM(quantity) as totalQuantity')
            // ->selectRaw('SUM(ipcr_daily_accomplishments.average_timeliness) as TotalTimeliness')
            // ->selectRaw('ROUND(CASE WHEN COUNT(ipcr_daily_accomplishments.quality) > 0 THEN SUM
            // (CASE WHEN ipcr_daily_accomplishments.quality IS NOT NULL AND ipcr_daily_accomplishments.quality != ""
            // THEN ipcr_daily_accomplishments.quality ELSE 0 END) / COUNT(ipcr_daily_accomplishments.quality) ELSE 0 END, 0) AS quality_average')
            // ->selectRaw('COUNT(ipcr_daily_accomplishments.quality) as NumberofQuality')
            // ->selectRaw('SUM(CASE WHEN ipcr_daily_accomplishments.quality IS NOT NULL AND ipcr_daily_accomplishments.quality != "" THEN ipcr_daily_accomplishments.quality ELSE 0 END) AS total_quality')
            // ->groupBy('ipcr_daily_accomplishments.idIPCR')
            ->get()
            ->groupBy('idIPCR')
            ->map(fn($item, $key) => [
                dd($item),
                // dd($item[0]['ipcrTarget']->ipcr_Semestral),
                // dd($item[0]['individualFinalOutput']->majorFinalOutputs),
                // 'total_qty' => $item->sum('quantity'),
                // 'ipcr_code' => $key,
                // 'quality_average' => number_format($item->sum('quality') / $item->count(), 2),

                dd($item),
                // dd($item[0]['ipcrTarget']->ipcr_Semestral),
                "idIPCR" => $key,
                "TotalQuantity" => $item->sum('quantity'),
                "TotalTimeliness" => $item->sum('average_timeliness'),
                "Final_Average_Timeliness" =>
                number_format($item->sum('quality') / $item->count(), 2),
                "individual_output" => $item[0]['individualFinalOutput']->individual_output,
                "success_indicator" => $item[0]['individualFinalOutput']->success_indicator,
                "quantity_type" => $item[0]['individualFinalOutput']->quantity_type,
                "quality_error" => $item[0]['individualFinalOutput']->quality_error,
                "time_range_code" => $item[0]['individualFinalOutput']->time_range_code,
                "time_based" => $item[0]['individualFinalOutput']->time_based,
                "mfo_desc" => $item[0]['individualFinalOutput']->majorFinalOutputs->mfo_desc,
                "remarks" => $item[0]['monthlyAccomplishment']->returnRemarks ? $item[0]['monthlyAccomplishment']->returnRemarks->remarks : '',
                "remarks_id" => $item[0]['monthlyAccomplishment']->returnRemarks ? $item[0]['monthlyAccomplishment']->returnRemarks->id : '',
                "output" => $item[0]['individualFinalOutput']->divisionOutput->output,
                "ipcr_type" => $item[0]['ipcrTarget']->ipcr_type,
                "ipcr_semester_id" => $item[0]['ipcrTarget']->ipcr_semester_id,
                "semester" => $item[0]['ipcrTarget']->semester,
                "month" => $month,
                "year" => $year,
                "NumberofQuality" => $item->count('quality'),
                "total_quality" => number_format($item->sum('quality') / $item->count(), 2),
                "quality_average" => number_format($item->sum('quality') / $item->count(), 2),
                "timeRanges" => $item[0]['monthlyAccomplishment']->timeRanges,
                // "prescribed_period" => $this->getTimeRatingAndUnit(),
                "time_unit" => "",
                "TimeRating" => "",
                "monthly_accomp" => $item[0]['monthlyAccomplishment'],
                "imm" => $item[0]['ipcr_Semestral']->immediate,
                "next" => $item[0]['ipcr_Semestral']->next_higher1,
                'sem_data' => $item[0]['ipcr_Semestral']
            ])
            ->values();
        $data = Daily_Accomplishment::select(
            'ipcr_daily_accomplishments.idIPCR',
            DB::raw('SUM(ipcr_daily_accomplishments.quantity) as TotalQuantity'),
            DB::raw('SUM(ipcr_daily_accomplishments.average_timeliness) as TotalTimeliness'),
            DB::raw('ROUND(SUM(ipcr_daily_accomplishments.average_timeliness) / SUM(ipcr_daily_accomplishments.quantity)) as Final_Average_Timeliness'),
            'individual_final_outputs.individual_output',
            'individual_final_outputs.success_indicator',
            'individual_final_outputs.quantity_type',
            'individual_final_outputs.quality_error',
            'individual_final_outputs.time_range_code',
            'individual_final_outputs.time_based',
            'major_final_outputs.mfo_desc',
            'monthly_remarks.remarks',
            'monthly_remarks.id AS remarks_id',
            'division_outputs.output',
            'i_p_c_r_targets.ipcr_type',
            'i_p_c_r_targets.ipcr_semester_id',
            'i_p_c_r_targets.semester',
            "i_p_c_r_targets.month_$months as month",
            'ipcr__semestrals.year',
            DB::raw('COUNT(ipcr_daily_accomplishments.quality) as NumberofQuality'),
            DB::raw('SUM(CASE WHEN ipcr_daily_accomplishments.quality IS NOT NULL AND ipcr_daily_accomplishments.quality != "" THEN ipcr_daily_accomplishments.quality ELSE 0 END) AS total_quality'),
            DB::raw('ROUND(CASE WHEN COUNT(ipcr_daily_accomplishments.quality) > 0 THEN SUM(CASE WHEN ipcr_daily_accomplishments.quality IS NOT NULL AND ipcr_daily_accomplishments.quality != "" THEN ipcr_daily_accomplishments.quality ELSE 0 END) / COUNT(ipcr_daily_accomplishments.quality) ELSE 0 END, 0) AS quality_average'),
            DB::raw("'$prescribed_period' AS prescribed_period"),
            DB::raw("'$time_unit' AS time_unit"),
            DB::raw("'$TimeRating' AS TimeRating"),
        )
            ->join('individual_final_outputs', 'ipcr_daily_accomplishments.idIPCR', '=', 'individual_final_outputs.ipcr_code')
            ->join('major_final_outputs', 'individual_final_outputs.idmfo', '=', 'major_final_outputs.id')
            ->join('division_outputs', 'individual_final_outputs.id_div_output', '=', 'division_outputs.id')
            ->join(
                'i_p_c_r_targets',
                function ($join) use ($emp_code) {
                    $join->on('ipcr_daily_accomplishments.idIPCR', '=', 'i_p_c_r_targets.ipcr_code')
                        ->where('ipcr_daily_accomplishments.emp_code', '=', $emp_code)
                        ->where('i_p_c_r_targets.employee_code', '=', $emp_code);
                }
            )
            ->join('ipcr__semestrals', 'i_p_c_r_targets.ipcr_semester_id', '=', 'ipcr__semestrals.id')
            ->leftJoin('monthly_remarks', function ($join) use ($month) {
                $join->on('ipcr_daily_accomplishments.idIPCR', '=', 'monthly_remarks.idIPCR')
                    ->where('monthly_remarks.month', '=', $month)
                    ->whereMonth('ipcr_daily_accomplishments.date', '=', $month);
            })
            ->where('ipcr__semestrals.year', $year)
            ->where('i_p_c_r_targets.semester', $sem)
            ->where('emp_code', $emp_code)
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->groupBy('ipcr_daily_accomplishments.idIPCR')
            ->get();
        return $data;
        foreach ($data as $key => $value) {
            if ($value->time_range_code > 0 && $value->time_range_code < 47) {
                if ($value->time_based == 1) {
                    $time_range5 = TimeRange::where('time_code', $value->time_range_code)->orderBY('rating', 'DESC')->get();
                    if ($value->Final_Average_Timeliness == null) {
                        // dd($value->Final_Average_Timeliness);
                        $value->TimeRating = 0;
                        $value->time_unit = "";
                        $value->prescribed_period = "";
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


        // dd(auth()->user()->userEmployee->division);
        $my_sem_id = "";
        $my_stat = "";
        // $mo_data =[
        //     ""
        // ]
        // $mo_data = Ipcr_Semestral::where('employee_code', $emp_code)
        //     ->where('ipcr__semestrals.year', $year)
        //     ->where('ipcr__semestrals.sem', $sem)
        //     ->orderBy('year', 'DESC')
        //     ->orderBy('sem', 'DESC')
        //     ->get()
        //     ->map(function ($item) {
        //         $rem = ReturnRemarks::where('ipcr_semestral_id', $item->id)
        //             ->orderBy('created_at', 'DESC')
        //             ->first();
        //         $immediate = UserEmployees::where('empl_id', $item->immediate_id)
        //             ->first();
        //         $next_higher = UserEmployees::where('empl_id', $item->next_higher)
        //             ->first();
        //         $user = UserEmployees::where('empl_id', $item->employee_code)
        //             ->first();

        //         $division_code = "";
        //         if ($user->division_code == "") {
        //             $division_code = $immediate->division_code;
        //         } else {
        //             $division_code = $user->division_code;
        //         }
        //         // dd($division_code);
        //         $division = Division::where('division_code', $division_code)
        //             ->first();
        //         // $userEmployee = UserEmployees::
        //         // dd($division);
        //         $division_assigned = "";
        //         // dd($item);
        //         if ($division == "") {
        //             $division_assigned = "";
        //         } else {
        //             if ($item->division == "") {
        //                 $division_assigned = $division->division_name1;
        //             } else {
        //                 $division_assigned = $division->division_name1;
        //             }
        //         }
        //         //
        //         // dd($division_assigned);
        //         return [
        //             'id' => $item->id,
        //             'division' => $division_assigned,
        //             'employee_code' => $item->employee_code,
        //             'immediate_id' => $item->immediate_id,
        //             'next_higher' => $item->next_higher,
        //             "imm" => $immediate,
        //             "next" => $next_higher,
        //             'sem' => $item->sem,
        //             'status' => $item->status,
        //             'year' => $item->year,
        //             'rem' => $rem
        //         ];
        //     });
        // dd($mo_data);
        // dd($mo_data);['Division']
        // dd($data[0]);
        $mo = $data[0];
        // dd(auth()->user()->userEmployee->Division);
        // dd($mo['remarks']);
        // dd($mo['sem_data']);
        $div = "";
        // dd('mmomo');
        $div = auth()->user()->load('userEmployee.Division')->userEmployee->Division;
        // dd($div);
        // dd(auth()->user()->userEmployee);
        // auth()->user()->userEmployee->Division
        $immh = $mo['imm'];
        $nxth = $mo['next'];
        if ($div) {
            // dd($div->division_name1);
            $div = $div->division_name1;
        } else {
            // dd($immh);
            // dd($immh['Division']->division_name1);
            // if($immh['Division']);
        }
        // dd($mo);
        $mo_data = [
            "id" => 0,
            "division" => $div,
            "employee_code" => $emp->empl_id,
            "imm" => $immh,
            "next" => $nxth,
            "sem" => $mo['sem_data']->semester,
            "status" => $mo['sem_data']->status,
            "year" => $year,
            "rem" => $mo['remarks']
        ];
        dd($data);
        dd($mo_data);

        $my_mo_data = $mo_data;

        return inertia('Monthly_Accomplishment/Index', [
            // "data" => $data,
            "emp_code" => $emp_code,
            "month" => $request->month,
            "year" => $year,
            "data" => $data,
            "month_data" => $my_mo_data,
            "office" => $office,
            "dept" => $dept,
            "pgHead" => $pgHead,
            'sem_id' => $my_sem_id,
            "status" => $my_stat,
            // "sel_month"=>
        ]);
    }
    public function monthly_object(
        Request $request,
        $emp_code,
        $semt,
        $year,
        $ipcr_semestral_id,
        $month
    ) {
        // dd($month);
        $mo2 = $month;
        if ($month > 6) {
            $mo2 = $month - 6;
        }

        $data = Daily_Accomplishment::with([
            'individualFinalOutput',
            'ipcrTarget' => function ($query) use ($emp_code, $semt, $year, $ipcr_semestral_id) {
                $query->where('i_p_c_r_targets.employee_code', '=', $emp_code)
                    ->where('i_p_c_r_targets.ipcr_semester_id', $ipcr_semestral_id);
            },
            'ipcr_Semestral.immediate.Division',
            'ipcr_Semestral.next_higher1.Division',
            'monthlyAccomplishment',
            'monthlyAccomplishment.returnRemarks'
        ])
            ->where('emp_code', $emp_code)
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->orderBy('idIPCR', 'ASC')
            ->get()
            ->groupBy('idIPCR')
            ->map(fn($item, $key) => [
                // "return_remarks"=> $item[0]['monthlyAccomplishment']
                "idIPCR" => $key,
                "TotalQuantity" => $item->sum('quantity'),
                "TotalTimeliness" => $item->sum('average_timeliness'),
                "Final_Average_Timeliness" =>
                number_format($item->sum('average_timeliness') / $item->sum('quantity'), 0),
                "individual_output" => $item[0]['individualFinalOutput'] ? $item[0]['individualFinalOutput']->individual_output : '',
                "success_indicator" => $item[0]['individualFinalOutput'] ? $item[0]['individualFinalOutput']->success_indicator : '',
                "quantity_type" => $item[0]['individualFinalOutput']->quantity_type,
                "quality_error" => $item[0]['individualFinalOutput']->quality_error,
                "time_range_code" => $item[0]['individualFinalOutput']->time_range_code,
                "time_based" => $item[0]['individualFinalOutput']->time_based,
                "mfo_desc" => $item[0]['individualFinalOutput']->majorFinalOutputs->mfo_desc,
                "remarks" => $item[0]['monthlyAccomplishment']->returnRemarks ? $item[0]['monthlyAccomplishment']->returnRemarks->remarks : '',
                "remarks_id" => $item[0]['monthlyAccomplishment']->returnRemarks ? $item[0]['monthlyAccomplishment']->returnRemarks->id : '',
                "output" => $item[0]['individualFinalOutput']->divisionOutput->output,
                "ipcr_type" => $item[0]['ipcrTarget'] ? $item[0]['ipcrTarget']->ipcr_type : "",
                "ipcr_semester_id" => $item[0]['ipcrTarget'] ? $item[0]['ipcrTarget']->ipcr_semester_id : '',
                "semester" => $item[0]['ipcrTarget'] ? $item[0]['ipcrTarget']->semester : '',
                "month" => $item[0]['ipcrTarget'] ? (($item[0]['ipcrTarget']["month_" . $mo2] > 0) ? $item[0]['ipcrTarget']["month_" . $mo2] : 0) : '',
                "year" => $year,
                "NumberofQuality" => $item->count(),
                "total_quality" => number_format($item->sum('quality') / $item->count(), 2),
                // ROUND(CASE WHEN COUNT(ipcr_daily_accomplishments.quality) > 0 THEN SUM(CASE WHEN ipcr_daily_accomplishments.quality IS NOT NULL AND ipcr_daily_accomplishments.quality != "" THEN ipcr_daily_accomplishments.quality ELSE 0 END) / COUNT(ipcr_daily_accomplishments.quality) ELSE 0 END, 0)
                "quality_average" => ($item->count() > 0) ? number_format($item->sum('quality') / $item->count(), 2) : 0,
                "timeRanges" => $item[0]['individualFinalOutput']->timeRanges,
                "prescribed_period" => $this->getTimeRatingAndUnit(
                    $item[0]['individualFinalOutput']->time_range_code,
                    $item[0]['individualFinalOutput']->time_based,
                    $item[0]['individualFinalOutput']->timeRanges,
                    // number_format($item->sum('timeliness') / $item->sum('quantity'), 0),
                    number_format($item->sum('average_timeliness') / $item->sum('quantity'), 0),
                    'pr'
                ),
                // getTimeRatingAndUnit($time_range_code, $time_based, $time_range, $Final_Average_Timeliness)
                "time_unit" => $this->getTimeRatingAndUnit(
                    $item[0]['individualFinalOutput']->time_range_code,
                    $item[0]['individualFinalOutput']->time_based,
                    $item[0]['individualFinalOutput']->timeRanges,
                    number_format($item->sum('average_timeliness') / $item->sum('quantity'), 0),
                    'tu'
                ),
                "TimeRating" => $this->getTimeRatingAndUnit(
                    $item[0]['individualFinalOutput']->time_range_code,
                    $item[0]['individualFinalOutput']->time_based,
                    $item[0]['individualFinalOutput']->timeRanges,
                    number_format($item->sum('average_timeliness') / $item->sum('quantity'), 0),
                    'tr'
                ),
                "monthly_accomp" => $item[0]['monthlyAccomplishment'],
                "sem_id" => $item[0]->sem_id,
                "imm" => $item[0]['ipcr_Semestral']->immediate,
                "next" => $item[0]['ipcr_Semestral']->next_higher1,
                'sem_data' => $item[0]['ipcr_Semestral']
            ])
            // ->dd()
            ->values();

        // dd('return_remarks');
        // $return_remarks = ReturnRemarks::
        $month = MonthlyAccomplishment::where('ipcr_semestral_id', $ipcr_semestral_id)
            ->where('month', $month)
            ->where('year', $year)
            ->first();
        // dd($)
        $retrem = [];
        if ($month) {
            $retrem = ReturnRemarks::where('ipcr_semestral_id', $ipcr_semestral_id)
                ->where('ipcr_monthly_accomplishment_id', $month->id)
                ->orderBy('created_at', 'DESC')
                ->first();
        }

        $val =
            [
                "data" => $data,
                "return_remarks" => $retrem->remarks
            ];
        return $data;
    }
    // API FOR ACTED MONTHLY TARGETS
    public function monthly_ipcr_api(Request $request)
    {
        // dd($request->ipcr_semestral_id);

        $ipcr_semestral_id = $request->ipcr_semestral_id;
        $emp_code = $request->empl_id;
        $emp = UserEmployees::where('empl_id', $emp_code)->first();

        $emp_type = employee_division_head($emp_code);
        $month = $request->month;

        $mo2 = $month;
        $semt = 1;
        if ($mo2 > 6) {
            $mo2 = intval($mo2) - 6;
            $semt = 2;
        }
        $ipcr_sem = Ipcr_Semestral::where('id', $ipcr_semestral_id)->first();
        // dd($ipcr_sem);
        if (!$ipcr_sem) {
            $div_head = $ipcr_sem->pcr_type;
            if ($div_head != NULL || $div_head != "") {
                $emp_type = $div_head;
            }
        }
        // dd($month);
        // dd($emp_type);
        $data = $this->getAccomplishmenttData($emp_type, $emp_code, $ipcr_semestral_id, $month);
        // dd($data);
        $year = $request->year;

        $div = auth()->user()->division_code;

        if (count($data) > 0) {
            $us = auth()->user()->load([
                'userEmployee.Division',
                'userEmployee.Office',
                'userEmployee.Office.pgHead',
                'employeeSpecialDepartment',
                'employeeSpecialDepartment.Office',
                'employeeSpecialDepartment.PGDH',
            ]);
            // dd($us);
            $office = "";

            $mo = $data[0];

            $div = "";
            $div = $us->userEmployee->Division;
            $immh = $mo['imm'];
            $nxth = $mo['next'];
            // dd($immh);
            $div = $this->getDivision($div, $immh, $nxth);
            $rm = '';
            // if ($mo['monthly_accomp']->returnRemarks) {
            //     $rm = $mo['monthly_accomp']->returnRemarks->remarks;
            // }
            $my_stat = $mo['monthly_accomp'][0]->status;
            // dd($my_stat);
            $my_sem_id = $mo['sem_id'];
            $mo_data = [
                "id" => $mo['monthly_accomp'][0]->id,
                "division" => $div,
                "employee_code" => $emp->empl_id,
                "imm" => $immh,
                "next" => $nxth,
                "sem" => $mo['sem_data']->sem,
                "status" => $my_stat,
                "year" => $year,
                "rem" => $rm,
                "month" => $mo2
            ];

            $off_pg = $this->getOffice($us);
            $office = $off_pg['office'];
            $pgHead = $off_pg['pgHead'];
            $dept = $office;

            $data = [
                // "data" => $data,
                "emp_code" => $emp_code,
                "month" => $request->month,
                "year" => $year,
                "data" => $data,
                "month_data" => $mo_data,
                "office" => $office,
                "dept" => $dept,
                "pgHead" => $this->getPGDH($pgHead),
                'sem_id' => $my_sem_id,
                "status" => $my_stat,
                // "sel_month"=>
            ];
            return $data;
        } else {
            $per = $request->month . ', ' . $year;
            return redirect()->back()->with('error', 'Accomplishments for ' . $per . ' is empty');
        }
    }
    // MONTHLY
    public function update_latest_monthly(Request $request)
    {
        // dd($request);
        $mo_num = Carbon::parse("1 $request->month")->month;

        // dd($mo_num);
        $data = MonthlyAccomplishmentRating::where("month", $mo_num)
            ->where("year", $request->year)
            ->where("ipcr_sem_id", $request->id)
            ->orderBy("id", "DESC")
            ->first();
        $monthly_status = MonthlyAccomplishment::where("ipcr_semestral_id", $request->id)
            ->where("month", $mo_num)
            ->where("year", $request->year)
            ->first();
        // dd($data);
        if ($data) {
            if ($monthly_status) {
                // dd($monthly_status);
            }
            $core = round((float) $request->core, 2);
            $support = round((float) $request->support, 2);

            $numerical_rating = round(($core * 0.7) + ($support * 0.3), 2);

            $data->ave_core = $core;
            $data->ave_support = $support;
            $data->numerical_rating = $numerical_rating;
            $data->adjectival_rating = $request->adjectival_rating;
            $data->save();
        }

        return back();
    }
}
