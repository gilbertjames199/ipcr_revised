<?php

namespace App\Http\Controllers;

use App\Models\MonthlyTarget;
use App\Models\Ipcr_Semestral;
use Illuminate\Http\Request;

class SemesterTemporaryHalfPeriodController extends Controller
{
    public function getAccomplishmenttData($is_division_head, $emp_code, $ipcr_semestral_id, $semm){
        $is_hybrid = $semm->is_hybrid ? $semm->is_hybrid : "0";
        // dd($semm);
        if ($is_division_head == 'emp') {
            // $is_division_head = 'emp';
            $accomplishment = $this->data_ipcr($emp_code, $ipcr_semestral_id);
        } else if ($is_division_head == 'div') {

            $dpcr = $this->data_dpcr($emp_code, $ipcr_semestral_id);

            if ($is_hybrid == "1") {
                $ipcr = $this->data_ipcr($emp_code, $ipcr_semestral_id);
                $accomplishment = $dpcr->concat($ipcr);
            } else {
                $accomplishment = $dpcr;
            }
        } else if ($is_division_head == 'hemp') {
            $accomplishment = $this->data_hipcr($emp_code, $ipcr_semestral_id);
            // dd(count($accomplishment));
        } else if ($is_division_head == 'hsec') {
            $accomplishment = $this->data_spcr($emp_code, $ipcr_semestral_id);
        } else if ($is_division_head == 'hdiv') {

            $accomplishment = $this->data_hdpcr($emp_code, $ipcr_semestral_id);
            // dd("div");
        } else if ($is_division_head == 'hos') {
            // dd($ipcr_semestral_id);
            $accomplishment = $this->view_hpcr_targets($emp_code, $ipcr_semestral_id);
        }
        // dd($targets);
        return $accomplishment;
    }
    public function data_ipcr($emp_code, $ipcr_semestral_id)
    {
        return MonthlyTarget::with([
            'ipcrTargets',
            'ipcrTargets.individualOutput',
            'ipcrTargets.individualOutput.semestralRemarks' => function ($query) use ($ipcr_semestral_id) {
                $query->where('semestral_remarks.idSemestral', '=', $ipcr_semestral_id);
            },
            'ipcr_Semestral.probationaryTemporaryEmployee',
            'ipcr_Semestral.immediate.Division',
            'ipcr_Semestral.next_higher1.Division',
        ])
            ->where('sem_id', $ipcr_semestral_id)
            ->get()
            ->groupBy(function ($item) {
                return $item->ipcrTargets->individualOutput->id ?? null;
            })
            ->filter(fn($group, $key) => $key !== null)
            ->map(function ($groupedItems, $individual_output_id) {
                $first = $groupedItems->first();
                // $individualOutput = $first->ipcrTargets->individualOutput;

                $individualOutput = null;

                if ($first && $first->ipcrTargets && $first->ipcrTargets->individualOutput) {
                    $individualOutput = $first->ipcrTargets->individualOutput;
                }

                // dd($first->ipcrTargets->returnRemarks);
                $count = $groupedItems->count();
                // dd($count);
                $avg_q1 = round($groupedItems->pluck('q1')->filter(fn($val) => $val != 0)->avg(), 2);
                $avg_q2 = round($groupedItems->pluck('q2')->filter(fn($val) => $val != 0)->avg(), 2);
                $avg_q3 = round($groupedItems->pluck('q3')->filter(fn($val) => $val != 0)->avg(), 2);

                $avg_e1 = round($groupedItems->pluck('e1')->filter(fn($val) => $val != 0)->avg(), 2);
                $avg_e2 = round($groupedItems->pluck('e2')->filter(fn($val) => $val != 0)->avg(), 2);
                $avg_e3 = round($groupedItems->pluck('e3')->filter(fn($val) => $val != 0)->avg(), 2);

                $avg_t1 = round($groupedItems->pluck('t1')->filter(fn($val) => $val != 0)->avg(), 2);

                $total_avg = round($avg_q1 + $avg_q2 + $avg_q3 + $avg_e1 + $avg_e2 + $avg_e3 + $avg_t1, 2);


                return [
                    "individual_output_id" => $individual_output_id,
                    "individual_output" => $individualOutput->individual_output ?? '',
                    "performance_measure" => $individualOutput->performance_measure ?? '',
                    "prescribed_period" => $individualOutput->prescribed_period ?? '',
                    "quality1" => $individualOutput->quality1 ?? '',
                    "quality2" => $individualOutput->quality2 ?? '',
                    "quality3" => $individualOutput->quality3 ?? '',
                    "efficiency1" => $individualOutput->efficiency1 ?? '',
                    "efficiency2" => $individualOutput->efficiency2 ?? '',
                    "efficiency3" => $individualOutput->efficiency3 ?? '',
                    "timeliness" => $individualOutput->timeliness ?? '',
                    "type" => $individualOutput->type ?? '',
                    "remarks" => ($individualOutput &&
                        $individualOutput->semestralRemarks &&
                        $individualOutput->semestralRemarks->first())
                        ? $individualOutput->semestralRemarks->first()->remarks
                        : '',
                    "remarks_id" => ($individualOutput &&
                        $individualOutput->semestralRemarks &&
                        $individualOutput->semestralRemarks->first())
                        ? $individualOutput->semestralRemarks->first()->id
                        : '',
                    'ipcr_type' => $first->ipcrTargets->ipcr_type ?? '',
                    "target_remarks" => $first->ipcrTargets->remarks ?? '',
                    "imm" => $first->ipcr_Semestral->immediate,
                    "next" => $first->ipcr_Semestral->next_higher1,
                    "sem_id" => $first->sem_id,
                    "sem_data" => $first->ipcr_Semestral,
                    "division" => $first->ipcr_Semestral->division_name ?? '',
                    "office" => $first->ipcr_Semestral->department ?? '',
                    "pghead" => $first->ipcr_Semestral->pg_dept_head ?? '',
                    "sem" => $first->ipcr_Semestral,

                    // Group all 6 months of scores under this output
                    "result" => $groupedItems->map(function ($item) {
                        return [
                            "time" => $item->t1,
                            "year" => $item->year,
                            "month" => $item->month,
                            "monthly_accomp" => $item->monthlyAccomplishmentMany ?? '',
                            "Accomplishment_type" => "ipcr",
                            "q1" => $item->q1,
                            "q2" => $item->q2,
                            "q3" => $item->q3,
                            "e1" => $item->e1,
                            "e2" => $item->e2,
                            "e3" => $item->e3,
                        ];
                    })->values(),

                    // Computed Averages
                    "avg_q1" => $avg_q1,
                    "avg_q2" => $avg_q2,
                    "avg_q3" => $avg_q3,
                    "avg_e1" => $avg_e1,
                    "avg_e2" => $avg_e2,
                    "avg_e3" => $avg_e3,
                    "avg_t1" => $avg_t1,
                    "total_avg" => $total_avg,
                ];
            })->values();
    }

    public function data_dpcr($emp_code, $ipcr_semestral_id)
    {
        $hdpcr = $this->data_hdpcr($emp_code, $ipcr_semestral_id);
        $div = MonthlyTarget::with([
            'dpcrTargets',
            'dpcrTargets.divisionOutput.semestralRemarks' => function ($query) use ($ipcr_semestral_id) {
                $query->where('semestral_remarks.idSemestral', '=', $ipcr_semestral_id);
            },
            'ipcr_Semestral.probationaryTemporaryEmployee',
            'ipcr_Semestral.immediate.Division',
            'ipcr_Semestral.next_higher1.Division',
            'monthlyAccomplishmentMany',
        ])
            ->where('sem_id', $ipcr_semestral_id)
            ->get()
            ->groupBy(function ($item) {
                return $item->dpcrTargets->divisionOutput->id ?? null;
            })
            ->filter(fn($group, $key) => $key !== null)
            ->map(function ($groupedItems, $division_output_id) {
                $first = $groupedItems->first();
                $divisionOutput = optional($first->dpcrTargets)->divisionOutput ?? '';

                $avg_q1 = round($groupedItems->pluck('q1')->filter(fn($val) => $val != 0)->avg(), 2);
                $avg_q2 = round($groupedItems->pluck('q2')->filter(fn($val) => $val != 0)->avg(), 2);
                $avg_q3 = round($groupedItems->pluck('q3')->filter(fn($val) => $val != 0)->avg(), 2);

                $avg_e1 = round($groupedItems->pluck('e1')->filter(fn($val) => $val != 0)->avg(), 2);
                $avg_e2 = round($groupedItems->pluck('e2')->filter(fn($val) => $val != 0)->avg(), 2);
                $avg_e3 = round($groupedItems->pluck('e3')->filter(fn($val) => $val != 0)->avg(), 2);

                $avg_t1 = round($groupedItems->pluck('t1')->filter(fn($val) => $val != 0)->avg(), 2);

                $total_avg = round($avg_q1 + $avg_q2 + $avg_q3 + $avg_e1 + $avg_e2 + $avg_e3 + $avg_t1, 2);

                return [
                    "individual_output_id" => $division_output_id,
                    "individual_output" => $divisionOutput->output ?? '',
                    "performance_measure" => $divisionOutput->performance_measure ?? '',
                    "prescribed_period" => $divisionOutput->prescribed_period ?? '',
                    "quality1" => $divisionOutput->quality1 ?? '',
                    "quality2" => $divisionOutput->quality2 ?? '',
                    "quality3" => $divisionOutput->quality3 ?? '',
                    "efficiency1" => $divisionOutput->efficiency1 ?? '',
                    "efficiency2" => $divisionOutput->efficiency2 ?? '',
                    "efficiency3" => $divisionOutput->efficiency3 ?? '',
                    "timeliness" => $divisionOutput->timeliness ?? '',
                    "type" => $divisionOutput->type ?? '',
                    "remarks" => optional(optional(optional($divisionOutput)->semestralRemarks)->first())->remarks ?? '',
                    "remarks_id" => optional(optional(optional($divisionOutput)->semestralRemarks)->first())->id ?? '',
                    'ipcr_type' => $first->dpcrTargets->dpcr_type ?? '',
                    "target_remarks" => $first->dpcrTargets->remarks ?? '',
                    "imm" => $first->ipcr_Semestral->immediate ?? '',
                    "next" => $first->ipcr_Semestral->next_higher1 ?? '',
                    "sem_id" => $first->sem_id ?? '',
                    "sem_data" => $first->ipcr_Semestral ?? '',
                    "division" => $first->ipcr_Semestral->division_name ?? '',
                    "office" => $first->ipcr_Semestral->department ?? '',
                    "pghead" => $first->ipcr_Semestral->pg_dept_head ?? '',
                    "sem" => $first->ipcr_Semestral,

                    "result" => $groupedItems->map(function ($item) {
                        return [
                            "time" => $item->t1,
                            "year" => $item->year,
                            "month" => $item->month,
                            "monthly_accomp" => $item->monthlyAccomplishmentMany ?? '',
                            "Accomplishment_type" => "dpcr",
                            "q1" => $item->q1,
                            "q2" => $item->q2,
                            "q3" => $item->q3,
                            "e1" => $item->e1,
                            "e2" => $item->e2,
                            "e3" => $item->e3,
                        ];
                    })->values(),

                    "avg_q1" => $avg_q1,
                    "avg_q2" => $avg_q2,
                    "avg_q3" => $avg_q3,
                    "avg_e1" => $avg_e1,
                    "avg_e2" => $avg_e2,
                    "avg_e3" => $avg_e3,
                    "avg_t1" => $avg_t1,
                    "total_avg" => $total_avg,
                ];
            })->values();
        return $div->concat($hdpcr);
    }
    public function data_hipcr($emp_code, $ipcr_semestral_id)
    {
        // dd($emp_code, $ipcr_semestral_id);
        $hipcr = $this->view_hipcr_targets($emp_code, $ipcr_semestral_id);
        $ipcr = $this->view_ipcr_targets($emp_code, $ipcr_semestral_id);
        // dd($ipcr, $hipcr);
        return $hipcr->concat($ipcr);
    }
    protected function for_ipcr_in_hospital($emp_code, $ipcr_semestral_id)
    {
        $data = MonthlyTarget::with([
            // 'ipcrTargets',
            // 'ipcrTargets.individualOutput',
            'ipcr_Semestral.immediate.Division',
            'ipcr_Semestral.next_higher1.Division',
            'ipcr_Semestral.probationaryTemporaryEmployee',
            'hpcrTargets',
            'hpcrTargets.ipcr',
            // 'hpcrTargets.hIPCR.semestralRemarks' => function ($query) use ($ipcr_semestral_id) {
            //     $query->where('semestral_remarks.idSemestral', '=', $ipcr_semestral_id);
            // },

        ])
            ->where('sem_id', $ipcr_semestral_id)
            ->where('ipcr_target_id', '<>', NULL)
            ->whereHas('hpcrTargets', function ($query) use ($emp_code) {
                $query->where('employee_code', $emp_code);
            })
            ->get()
            ->groupBy(function ($item) {
                return $item->hpcrTargets->ipcr->id ?? null;
                // return $item->hospital_target_id ?? null;
            })
            ->filter(fn($group, $key) => $key !== null)
            ->map(function ($groupedItems, $individual_output_id) {
                $first = $groupedItems->first();
                $individualOutput = optional(optional($first->hpcrTargets)->ipcr);
                $hpcr = optional($first->hpcrTargets);
                // dd($hpcr);
                $count = $groupedItems->count();
                // dd($groupedItems[0]);
                // dd($count);
                // dd($individualOutput);
                $avg_q1 = round($groupedItems->pluck('q1')->filter(fn($val) => $val != 0)->avg(), 2);
                $avg_q2 = round($groupedItems->pluck('q2')->filter(fn($val) => $val != 0)->avg(), 2);
                $avg_q3 = round($groupedItems->pluck('q3')->filter(fn($val) => $val != 0)->avg(), 2);

                $avg_e1 = round($groupedItems->pluck('e1')->filter(fn($val) => $val != 0)->avg(), 2);
                $avg_e2 = round($groupedItems->pluck('e2')->filter(fn($val) => $val != 0)->avg(), 2);
                $avg_e3 = round($groupedItems->pluck('e3')->filter(fn($val) => $val != 0)->avg(), 2);

                $avg_t1 = round($groupedItems->pluck('t1')->filter(fn($val) => $val != 0)->avg(), 2);

                $total_avg = round($avg_q1 + $avg_q2 + $avg_q3 + $avg_e1 + $avg_e2 + $avg_e3 + $avg_t1, 2);

                // dd($hpcr->hIPCR);
                return [
                    "individual_output_id" => $individual_output_id,
                    "individual_output" => $individualOutput->output ?? '',
                    "performance_measure" => $individualOutput->performance_measure ?? '',
                    "prescribed_period" => $individualOutput->prescribed_period ?? '',
                    "quality1" => $individualOutput->quality1 ?? '',
                    "quality2" => $individualOutput->quality2 ?? '',
                    "quality3" => $individualOutput->quality3 ?? '',
                    "efficiency1" => $individualOutput->efficiency1 ?? '',
                    "efficiency2" => $individualOutput->efficiency2 ?? '',
                    "efficiency3" => $individualOutput->efficiency3 ?? '',
                    "timeliness" => $individualOutput->timeliness ?? '',
                    "type" => $individualOutput->type ?? '',
                    "remarks" => optional(optional(optional($hpcr->ipcr)->semestralRemarks)->first())->remarks ?? '',
                    "remarks_id" => optional(optional(optional($hpcr->ipcr)->semestralRemarks)->first())->id ?? '',
                    "ipcr_type" => $hpcr->type ?? '',
                    "target_remarks" => $hpcr->remarks ?? '',
                    "imm" => $first->ipcr_Semestral->immediate,
                    "next" => $first->ipcr_Semestral->next_higher1,
                    "sem_id" => $first->sem_id,
                    "sem_data" => $first->ipcr_Semestral,
                    "division" => $first->ipcr_Semestral->division_name ?? '',
                    "office" => $first->ipcr_Semestral->department ?? '',
                    "pghead" => $first->ipcr_Semestral->pg_dept_head ?? '',
                    "sem" => $first->ipcr_Semestral,

                    // Group all 6 months of scores under this output
                    "result" => $groupedItems->map(function ($item) {
                        return [
                            "time" => $item->t1,
                            "year" => $item->year,
                            "month" => $item->month,
                            "monthly_accomp" => $item->monthlyAccomplishmentMany ?? '',
                            "Accomplishment_type" => "ipcr",
                            "q1" => $item->q1,
                            "q2" => $item->q2,
                            "q3" => $item->q3,
                            "e1" => $item->e1,
                            "e2" => $item->e2,
                            "e3" => $item->e3,
                        ];
                    })->values(),

                    // Computed Averages
                    "avg_q1" => $avg_q1,
                    "avg_q2" => $avg_q2,
                    "avg_q3" => $avg_q3,
                    "avg_e1" => $avg_e1,
                    "avg_e2" => $avg_e2,
                    "avg_e3" => $avg_e3,
                    "avg_t1" => $avg_t1,
                    "total_avg" => $total_avg,
                ];
            })->values();
        // dd($data);
        return $data;
    }
    public function view_hpcr_targets($emp_code, $ipcr_semestral_id)
    {
        // dd("view_hpcr_targets: " . $ipcr_semestral_id);
        return MonthlyTarget::with([
            // 'ipcrTargets',
            // 'ipcrTargets.individualOutput',
            'ipcr_Semestral.immediate.Division',
            'ipcr_Semestral.next_higher1.Division',
            'ipcr_Semestral.probationaryTemporaryEmployee',
            'hpcrTargets',
            'hpcrTargets.hIPCR',
            'hpcrTargets.hpcr',

        ])
            ->where('sem_id', $ipcr_semestral_id)
            ->where('idHPCR', '<>', NULL)
            ->get()
            ->groupBy(function ($item) {
                return $item->hpcrTargets->id ?? null;
            })
            ->filter(fn($group, $key) => $key !== null)
            ->map(function ($groupedItems, $individual_output_id) {
                $first = $groupedItems->first();
                $individualOutput = optional($first->hpcrTargets)->hpcr;
                $hpcr = optional($first->hpcrTargets);
                // dd($hpcr);
                $count = $groupedItems->count();
                // dd($groupedItems[0]);
                // dd($count);
                // dd($individualOutput);
                $avg_q1 = round($groupedItems->pluck('q1')->filter(fn($val) => $val != 0)->avg(), 2);
                $avg_q2 = round($groupedItems->pluck('q2')->filter(fn($val) => $val != 0)->avg(), 2);
                $avg_q3 = round($groupedItems->pluck('q3')->filter(fn($val) => $val != 0)->avg(), 2);

                $avg_e1 = round($groupedItems->pluck('e1')->filter(fn($val) => $val != 0)->avg(), 2);
                $avg_e2 = round($groupedItems->pluck('e2')->filter(fn($val) => $val != 0)->avg(), 2);
                $avg_e3 = round($groupedItems->pluck('e3')->filter(fn($val) => $val != 0)->avg(), 2);

                $avg_t1 = round($groupedItems->pluck('t1')->filter(fn($val) => $val != 0)->avg(), 2);

                $total_avg = round($avg_q1 + $avg_q2 + $avg_q3 + $avg_e1 + $avg_e2 + $avg_e3 + $avg_t1, 2);

                // dd($individualOutput);
                return [
                    "individual_output_id" => $individual_output_id,
                    "individual_output" => $individualOutput->output ?? '',
                    "performance_measure" => $individualOutput->performance_measure ?? '',
                    "prescribed_period" => $individualOutput->prescribed_period ?? '',
                    "quality1" => $individualOutput->quality1 ?? '',
                    "quality2" => $individualOutput->quality2 ?? '',
                    "quality3" => $individualOutput->quality3 ?? '',
                    "efficiency1" => $individualOutput->efficiency1 ?? '',
                    "efficiency2" => $individualOutput->efficiency2 ?? '',
                    "efficiency3" => $individualOutput->efficiency3 ?? '',
                    "timeliness" => $individualOutput->timeliness ?? '',
                    "type" => $individualOutput->type ?? '',
                    "remarks" =>  '',
                    "remarks_id" =>  '',
                    "ipcr_type" => $hpcr->type ?? '',
                    "target_remarks" => $hpcr->remarks ?? '',
                    "imm" => $first->ipcr_Semestral->immediate,
                    "next" => $first->ipcr_Semestral->next_higher1,
                    "sem_id" => $first->sem_id,
                    "sem_data" => $first->ipcr_Semestral,
                    "division" => $first->ipcr_Semestral->division_name ?? '',
                    "office" => $first->ipcr_Semestral->department ?? '',
                    "pghead" => $first->ipcr_Semestral->pg_dept_head ?? '',
                    "sem" => $first->ipcr_Semestral,

                    // Group all 6 months of scores under this output
                    "result" => $groupedItems->map(function ($item) {
                        return [
                            "time" => $item->t1,
                            "year" => $item->year,
                            "month" => $item->month,
                            "monthly_accomp" => $item->monthlyAccomplishmentMany ?? '',
                            "Accomplishment_type" => "ipcr",
                            "q1" => $item->q1,
                            "q2" => $item->q2,
                            "q3" => $item->q3,
                            "e1" => $item->e1,
                            "e2" => $item->e2,
                            "e3" => $item->e3,
                        ];
                    })->values(),

                    // Computed Averages
                    "avg_q1" => $avg_q1,
                    "avg_q2" => $avg_q2,
                    "avg_q3" => $avg_q3,
                    "avg_e1" => $avg_e1,
                    "avg_e2" => $avg_e2,
                    "avg_e3" => $avg_e3,
                    "avg_t1" => $avg_t1,
                    "total_avg" => $total_avg,
                ];
            })->values();
    }
    public function data_spcr($emp_code, $ipcr_semestral_id)
    {
        return MonthlyTarget::with([
            // 'ipcrTargets',
            // 'ipcrTargets.individualOutput',
            'ipcr_Semestral.immediate.Division',
            'ipcr_Semestral.next_higher1.Division',
            'ipcr_Semestral.probationaryTemporaryEmployee',
            'hpcrTargets',
            'hpcrTargets.hSPCR',
        ])
            ->where('sem_id', $ipcr_semestral_id)
            ->where('idHSPCR', '<>', NULL)
            ->get()
            ->groupBy(function ($item) {
                return $item->hpcrTargets->hSPCR->id ?? null;
            })
            ->filter(fn($group, $key) => $key !== null)
            ->map(function ($groupedItems, $individual_output_id) {
                $first = $groupedItems->first();
                $individualOutput = optional(optional($first->hpcrTargets)->hSPCR);
                $hpcr = optional($first->hpcrTargets);
                // dd($hpcr);
                $count = $groupedItems->count();
                // dd($groupedItems[0]);
                // dd($count);
                // dd($individualOutput);
                $avg_q1 = round($groupedItems->pluck('q1')->filter(fn($val) => $val != 0)->avg(), 2);
                $avg_q2 = round($groupedItems->pluck('q2')->filter(fn($val) => $val != 0)->avg(), 2);
                $avg_q3 = round($groupedItems->pluck('q3')->filter(fn($val) => $val != 0)->avg(), 2);

                $avg_e1 = round($groupedItems->pluck('e1')->filter(fn($val) => $val != 0)->avg(), 2);
                $avg_e2 = round($groupedItems->pluck('e2')->filter(fn($val) => $val != 0)->avg(), 2);
                $avg_e3 = round($groupedItems->pluck('e3')->filter(fn($val) => $val != 0)->avg(), 2);

                $avg_t1 = round($groupedItems->pluck('t1')->filter(fn($val) => $val != 0)->avg(), 2);

                $total_avg = round($avg_q1 + $avg_q2 + $avg_q3 + $avg_e1 + $avg_e2 + $avg_e3 + $avg_t1, 2);


                return [
                    "individual_output_id" => $individual_output_id,
                    "individual_output" => $individualOutput->output ?? '',
                    "performance_measure" => $individualOutput->performance_measure ?? '',
                    "prescribed_period" => $individualOutput->prescribed_period ?? '',
                    "quality1" => $individualOutput->quality1 ?? '',
                    "quality2" => $individualOutput->quality2 ?? '',
                    "quality3" => $individualOutput->quality3 ?? '',
                    "efficiency1" => $individualOutput->efficiency1 ?? '',
                    "efficiency2" => $individualOutput->efficiency2 ?? '',
                    "efficiency3" => $individualOutput->efficiency3 ?? '',
                    "timeliness" => $individualOutput->timeliness ?? '',
                    "type" => $individualOutput->type ?? '',
                    "remarks" =>  '',
                    "remarks_id" =>  '',
                    "ipcr_type" => $hpcr->type ?? '',
                    "target_remarks" => $hpcr->remarks ?? '',
                    "imm" => $first->ipcr_Semestral->immediate,
                    "next" => $first->ipcr_Semestral->next_higher1,
                    "sem_id" => $first->sem_id,
                    "sem_data" => $first->ipcr_Semestral,
                    "division" => $first->ipcr_Semestral->division_name ?? '',
                    "office" => $first->ipcr_Semestral->department ?? '',
                    "pghead" => $first->ipcr_Semestral->pg_dept_head ?? '',
                    "sem" => $first->ipcr_Semestral,

                    // Group all 6 months of scores under this output
                    "result" => $groupedItems->map(function ($item) {
                        return [
                            "time" => $item->t1,
                            "year" => $item->year,
                            "month" => $item->month,
                            "monthly_accomp" => $item->monthlyAccomplishmentMany ?? '',
                            "Accomplishment_type" => "ipcr",
                            "q1" => $item->q1,
                            "q2" => $item->q2,
                            "q3" => $item->q3,
                            "e1" => $item->e1,
                            "e2" => $item->e2,
                            "e3" => $item->e3,
                        ];
                    })->values(),

                    // Computed Averages
                    "avg_q1" => $avg_q1,
                    "avg_q2" => $avg_q2,
                    "avg_q3" => $avg_q3,
                    "avg_e1" => $avg_e1,
                    "avg_e2" => $avg_e2,
                    "avg_e3" => $avg_e3,
                    "avg_t1" => $avg_t1,
                    "total_avg" => $total_avg,
                ];
            })->values();
    }
    public function data_hdpcr($emp_code, $ipcr_semestral_id)
    {
        $hdpcr = $this->view_hdpcr_targets($emp_code, $ipcr_semestral_id);
        $dpcr = $this->view_dpcr_targets($emp_code, $ipcr_semestral_id);
        return $hdpcr->concat($dpcr);
    }
    public function view_ipcr_targets($emp_code, $ipcr_semestral_id)
    {
        $sem_data = Ipcr_Semestral::where('id', $ipcr_semestral_id)->first();
        // dd($sem_data);
        // $data = MonthlyTarget::with([
        //     'ipcrTargets',
        //     'ipcrTargets.individualOutput',
        //     'ipcr_Semestral.immediate.Division',
        //     'ipcr_Semestral.next_higher1.Division',
        // ])
        //     ->where('sem_id', $ipcr_semestral_id)
        //     ->whereHas('ipcrTargets' )
        //     ->where('year', $sem_data->year)
        //     ->get()
        //     ->map(function($item){

        //     });

        // dd($data->pluck('ipcr_target_id'));
        // $data= MonthlyTarget::with([
        //     'ipcrTargets',
        //     'ipcrTargets.individualOutput',
        //     'ipcr_Semestral.immediate.Division',
        //     'ipcr_Semestral.next_higher1.Division',
        //     // 'hpcrTargets',
        //     // 'hpcrTargets.ipcr',
        // ])
        //     ->where('sem_id', $ipcr_semestral_id)
        //     // ->whereHas('ipcrTargets', function ($query) {
        //     //     $query->where('ipcr_target', '<>', NULL);
        //     // })
        //     ->whereHas('ipcrTargets')
        //     ->get()
        //     ->groupBy(function ($item) {
        //         return $item->ipcrTargets->ipcr->id ?? null;
        //     })
        //     ->filter(fn($group, $key) => $key !== null)
        //     ->map(function ($groupedItems) {

        //         $first = $groupedItems->first();
        //         $individualOutput = optional(optional($first->hpcrTargets)->ipcr);
        //         // dd($individualOutput);
        //         $hpcr = optional($first->hpcrTargets);
        //         // dd($hpcr);
        //         $count = $groupedItems->count();
        //         // dd($groupedItems[0]);
        //         // dd($count);
        //         // dd($individualOutput);
        //         $avg_q1 = round($groupedItems->pluck('q1')->filter(fn($val) => $val != 0)->avg(), 2);
        //         $avg_q2 = round($groupedItems->pluck('q2')->filter(fn($val) => $val != 0)->avg(), 2);
        //         $avg_q3 = round($groupedItems->pluck('q3')->filter(fn($val) => $val != 0)->avg(), 2);

        //         $avg_e1 = round($groupedItems->pluck('e1')->filter(fn($val) => $val != 0)->avg(), 2);
        //         $avg_e2 = round($groupedItems->pluck('e2')->filter(fn($val) => $val != 0)->avg(), 2);
        //         $avg_e3 = round($groupedItems->pluck('e3')->filter(fn($val) => $val != 0)->avg(), 2);

        //         $avg_t1 = round($groupedItems->pluck('t1')->filter(fn($val) => $val != 0)->avg(), 2);

        //         $total_avg = round($avg_q1 + $avg_q2 + $avg_q3 + $avg_e1 + $avg_e2 + $avg_e3 + $avg_t1, 2);

        //         // dd($groupedItems);
        //         // $result = [[
        //         //     "time" => $groupedItems->t1,
        //         //     "year" => $groupedItems->year,
        //         //     "month" => $groupedItems->month,
        //         //     "monthly_accomp" => $groupedItems->monthlyAccomplishmentMany ?? '',
        //         //     "Accomplishment_type" => "ipcr",
        //         //     "q1" => $groupedItems->q1,
        //         //     "q2" => $groupedItems->q2,
        //         //     "q3" => $groupedItems->q3,
        //         //     "e1" => $groupedItems->e1,
        //         //     "e2" => $groupedItems->e2,
        //         //     "e3" => $groupedItems->e3,
        //         // ]

        //         // ];
        //         // dd($groupedItems[0]);
        //         return [
        //             "individual_output_id" => optional($groupedItems[0]->ipcrTargets)->individual_final_output_id,
        //             "individual_output" => $individualOutput->individual_output ?? '',
        //             "performance_measure" => $individualOutput->performance_measure ?? '',
        //             "prescribed_period" => $individualOutput->prescribed_period ?? '',
        //             "quality1" => $individualOutput->quality1 ?? '',
        //             "quality2" => $individualOutput->quality2 ?? '',
        //             "quality3" => $individualOutput->quality3 ?? '',
        //             "efficiency1" => $individualOutput->efficiency1 ?? '',
        //             "efficiency2" => $individualOutput->efficiency2 ?? '',
        //             "efficiency3" => $individualOutput->efficiency3 ?? '',
        //             "timeliness" => $individualOutput->timeliness ?? '',
        //             "type" => $individualOutput->type ?? '',
        //             "remarks" => ($individualOutput &&
        //                 $individualOutput->semestralRemarks &&
        //                 $individualOutput->semestralRemarks->first())
        //                 ? $individualOutput->semestralRemarks->first()->remarks
        //                 : '',
        //             "remarks_id" => ($individualOutput &&
        //                 $individualOutput->semestralRemarks &&
        //                 $individualOutput->semestralRemarks->first())
        //                 ? $individualOutput->semestralRemarks->first()->id
        //                 : '',
        //             "ipcr_type" => $hpcr->type ?? '',
        //             "target_remarks" => $hpcr->remarks ?? '',
        //             "imm"  => optional(optional($first)->ipcr_Semestral)->immediate,
        //             "next" => optional(optional($first)->ipcr_Semestral)->next_higher1,
        //             "sem_id" => $first->sem_id,
        //             "sem_data" => $first->ipcr_Semestral,
        //             "division" => $first->ipcr_Semestral->division_name ?? '',
        //             "office" => $first->ipcr_Semestral->department ?? '',
        //             "pghead" => $first->ipcr_Semestral->pg_dept_head ?? '',
        //             "sem" => $first->ipcr_Semestral,

        //             // Group all 6 months of scores under this output
        //             // "result"=>$result,
        //             "result" => $groupedItems->map(function ($item) {
        //                 return [
        //                     "time" => $item->t1,
        //                     "year" => $item->year,
        //                     "month" => $item->month,
        //                     "monthly_accomp" => $item->monthlyAccomplishmentMany ?? '',
        //                     "Accomplishment_type" => "ipcr",
        //                     "q1" => $item->q1,
        //                     "q2" => $item->q2,
        //                     "q3" => $item->q3,
        //                     "e1" => $item->e1,
        //                     "e2" => $item->e2,
        //                     "e3" => $item->e3,
        //                 ];
        //             })->values(),

        //             // Computed Averages
        //             "avg_q1" => $avg_q1,
        //             "avg_q2" => $avg_q2,
        //             "avg_q3" => $avg_q3,
        //             "avg_e1" => $avg_e1,
        //             "avg_e2" => $avg_e2,
        //             "avg_e3" => $avg_e3,
        //             "avg_t1" => $avg_t1,
        //             "total_avg" => $total_avg,
        //         ];
        //     })->values();
        // // dd($data, $ipcr_semestral_id);
        // return $data;
        $data = MonthlyTarget::with([
            'ipcrTargets',
            'ipcrTargets.individualOutput',
            'ipcrTargets.individualOutput.semestralRemarks' => function ($query) use ($ipcr_semestral_id) {
                $query->where('semestral_remarks.idSemestral', '=', $ipcr_semestral_id);
            },
            'ipcr_Semestral.immediate.Division',
            'ipcr_Semestral.next_higher1.Division',
            'ipcr_Semestral.probationaryTemporaryEmployee'
        ])
            ->where('sem_id', $ipcr_semestral_id)
            ->whereHas('ipcrTargets', function ($query) use ($emp_code) {
                $query->where('employee_code', $emp_code);
            })
            ->get()
            ->groupBy(function ($item) {
                return $item->ipcrTargets->individualOutput->id ?? null;
            })
            ->filter(fn($group, $key) => $key !== null)
            ->map(function ($groupedItems, $individual_output_id) {
                $first = $groupedItems->first();
                // $individualOutput = $first->ipcrTargets->individualOutput;

                $individualOutput = null;

                if ($first && $first->ipcrTargets && $first->ipcrTargets->individualOutput) {
                    $individualOutput = $first->ipcrTargets->individualOutput;
                }

                // dd($first->ipcrTargets->returnRemarks);
                $count = $groupedItems->count();
                // dd($count);
                $avg_q1 = round($groupedItems->pluck('q1')->filter(fn($val) => $val != 0)->avg(), 2);
                $avg_q2 = round($groupedItems->pluck('q2')->filter(fn($val) => $val != 0)->avg(), 2);
                $avg_q3 = round($groupedItems->pluck('q3')->filter(fn($val) => $val != 0)->avg(), 2);

                $avg_e1 = round($groupedItems->pluck('e1')->filter(fn($val) => $val != 0)->avg(), 2);
                $avg_e2 = round($groupedItems->pluck('e2')->filter(fn($val) => $val != 0)->avg(), 2);
                $avg_e3 = round($groupedItems->pluck('e3')->filter(fn($val) => $val != 0)->avg(), 2);

                $avg_t1 = round($groupedItems->pluck('t1')->filter(fn($val) => $val != 0)->avg(), 2);

                $total_avg = round($avg_q1 + $avg_q2 + $avg_q3 + $avg_e1 + $avg_e2 + $avg_e3 + $avg_t1, 2);


                return [
                    "individual_output_id" => $individual_output_id,
                    "individual_output" => $individualOutput->individual_output ?? '',
                    "performance_measure" => $individualOutput->performance_measure ?? '',
                    "prescribed_period" => $individualOutput->prescribed_period ?? '',
                    "quality1" => $individualOutput->quality1 ?? '',
                    "quality2" => $individualOutput->quality2 ?? '',
                    "quality3" => $individualOutput->quality3 ?? '',
                    "efficiency1" => $individualOutput->efficiency1 ?? '',
                    "efficiency2" => $individualOutput->efficiency2 ?? '',
                    "efficiency3" => $individualOutput->efficiency3 ?? '',
                    "timeliness" => $individualOutput->timeliness ?? '',
                    "type" => $individualOutput->type ?? '',
                    "remarks" => ($individualOutput &&
                        $individualOutput->semestralRemarks &&
                        $individualOutput->semestralRemarks->first())
                        ? $individualOutput->semestralRemarks->first()->remarks
                        : '',
                    "remarks_id" => ($individualOutput &&
                        $individualOutput->semestralRemarks &&
                        $individualOutput->semestralRemarks->first())
                        ? $individualOutput->semestralRemarks->first()->id
                        : '',
                    'ipcr_type' => $first->ipcrTargets->ipcr_type ?? '',
                    "target_remarks" => $first->ipcrTargets->remarks ?? '',
                    "imm" => $first->ipcr_Semestral->immediate,
                    "next" => $first->ipcr_Semestral->next_higher1,
                    "sem_id" => $first->sem_id,
                    "sem_data" => $first->ipcr_Semestral,
                    "division" => $first->ipcr_Semestral->division_name ?? '',
                    "office" => $first->ipcr_Semestral->department ?? '',
                    "pghead" => $first->ipcr_Semestral->pg_dept_head ?? '',
                    "sem" => $first->ipcr_Semestral,

                    // Group all 6 months of scores under this output
                    "result" => $groupedItems->map(function ($item) {
                        return [
                            "time" => $item->t1,
                            "year" => $item->year,
                            "month" => $item->month,
                            "monthly_accomp" => $item->monthlyAccomplishmentMany ?? '',
                            "Accomplishment_type" => "ipcr",
                            "q1" => $item->q1,
                            "q2" => $item->q2,
                            "q3" => $item->q3,
                            "e1" => $item->e1,
                            "e2" => $item->e2,
                            "e3" => $item->e3,
                        ];
                    })->values(),

                    // Computed Averages
                    "avg_q1" => $avg_q1,
                    "avg_q2" => $avg_q2,
                    "avg_q3" => $avg_q3,
                    "avg_e1" => $avg_e1,
                    "avg_e2" => $avg_e2,
                    "avg_e3" => $avg_e3,
                    "avg_t1" => $avg_t1,
                    "total_avg" => $total_avg,
                ];
            })->values();
        // dd($data);
        return $data;
    }
    public function view_hipcr_targets($emp_code, $ipcr_semestral_id)
    {
        // $hospital_target= HospitalTarget::where("ipcr_semestral_id", $ipcr_semestral_id)->get();
        // $id_reference = $hospital_target->pluck('id');

        // ->whereIn("hospital_target_id", $id_reference)
        // dd($ipcr_semestral_id);
        // dd(MonthlyTarget::where('sem_id', $ipcr_semestral_id)->get());
        $data = MonthlyTarget::with([
            // 'ipcrTargets',
            // 'ipcrTargets.individualOutput',
            'ipcr_Semestral.immediate.Division',
            'ipcr_Semestral.next_higher1.Division',
            'ipcr_Semestral.probationaryTemporaryEmployee',
            'hpcrTargets',
            'hpcrTargets.hIPCR',
            'hpcrTargets.hIPCR.semestralRemarks' => function ($query) use ($ipcr_semestral_id) {
                $query->where('semestral_remarks.idSemestral', '=', $ipcr_semestral_id);
            },

        ])
            ->where('sem_id', $ipcr_semestral_id)
            ->where('idHIPCR', '<>', NULL)
            ->whereHas('hpcrTargets', function ($query) use ($emp_code) {
                $query->where('employee_code', $emp_code);
            })
            ->get()
            ->groupBy(function ($item) {
                return $item->hpcrTargets->hIPCR->id ?? null;
                // return $item->hospital_target_id ?? null;
            })
            ->filter(fn($group, $key) => $key !== null)
            ->map(function ($groupedItems, $individual_output_id) {
                $first = $groupedItems->first();
                $individualOutput = optional(optional($first->hpcrTargets)->hIPCR);
                $hpcr = optional($first->hpcrTargets);
                // dd($hpcr);
                $count = $groupedItems->count();
                // dd($groupedItems[0]);
                // dd($count);
                // dd($individualOutput);
                $avg_q1 = round($groupedItems->pluck('q1')->filter(fn($val) => $val != 0)->avg(), 2);
                $avg_q2 = round($groupedItems->pluck('q2')->filter(fn($val) => $val != 0)->avg(), 2);
                $avg_q3 = round($groupedItems->pluck('q3')->filter(fn($val) => $val != 0)->avg(), 2);

                $avg_e1 = round($groupedItems->pluck('e1')->filter(fn($val) => $val != 0)->avg(), 2);
                $avg_e2 = round($groupedItems->pluck('e2')->filter(fn($val) => $val != 0)->avg(), 2);
                $avg_e3 = round($groupedItems->pluck('e3')->filter(fn($val) => $val != 0)->avg(), 2);

                $avg_t1 = round($groupedItems->pluck('t1')->filter(fn($val) => $val != 0)->avg(), 2);

                $total_avg = round($avg_q1 + $avg_q2 + $avg_q3 + $avg_e1 + $avg_e2 + $avg_e3 + $avg_t1, 2);

                // dd($hpcr->hIPCR);
                return [
                    "individual_output_id" => $individual_output_id,
                    "individual_output" => $individualOutput->output ?? '',
                    "performance_measure" => $individualOutput->performance_measure ?? '',
                    "prescribed_period" => $individualOutput->prescribed_period ?? '',
                    "quality1" => $individualOutput->quality1 ?? '',
                    "quality2" => $individualOutput->quality2 ?? '',
                    "quality3" => $individualOutput->quality3 ?? '',
                    "efficiency1" => $individualOutput->efficiency1 ?? '',
                    "efficiency2" => $individualOutput->efficiency2 ?? '',
                    "efficiency3" => $individualOutput->efficiency3 ?? '',
                    "timeliness" => $individualOutput->timeliness ?? '',
                    "type" => $individualOutput->type ?? '',
                    "remarks" => optional(optional(optional($hpcr->hIPCR)->semestralRemarks)->first())->remarks ?? '',
                    "remarks_id" => optional(optional(optional($hpcr->hIPCR)->semestralRemarks)->first())->id ?? '',
                    "ipcr_type" => $hpcr->type ?? '',
                    "target_remarks" => $hpcr->remarks ?? '',
                    "imm" => $first->ipcr_Semestral->immediate,
                    "next" => $first->ipcr_Semestral->next_higher1,
                    "sem_id" => $first->sem_id,
                    "sem_data" => $first->ipcr_Semestral,
                    "division" => $first->ipcr_Semestral->division_name ?? '',
                    "office" => $first->ipcr_Semestral->department ?? '',
                    "pghead" => $first->ipcr_Semestral->pg_dept_head ?? '',
                    "sem" => $first->ipcr_Semestral,

                    // Group all 6 months of scores under this output
                    "result" => $groupedItems->map(function ($item) {
                        return [
                            "time" => $item->t1,
                            "year" => $item->year,
                            "month" => $item->month,
                            "monthly_accomp" => $item->monthlyAccomplishmentMany ?? '',
                            "Accomplishment_type" => "ipcr",
                            "q1" => $item->q1,
                            "q2" => $item->q2,
                            "q3" => $item->q3,
                            "e1" => $item->e1,
                            "e2" => $item->e2,
                            "e3" => $item->e3,
                        ];
                    })->values(),

                    // Computed Averages
                    "avg_q1" => $avg_q1,
                    "avg_q2" => $avg_q2,
                    "avg_q3" => $avg_q3,
                    "avg_e1" => $avg_e1,
                    "avg_e2" => $avg_e2,
                    "avg_e3" => $avg_e3,
                    "avg_t1" => $avg_t1,
                    "total_avg" => $total_avg,
                ];
            })->values();
        // dd($data);
        $ipcr = $this->for_ipcr_in_hospital($emp_code, $ipcr_semestral_id);
        // dd($ipcr, $data);
        if (count($ipcr) > 0) {
            return $data->concat($ipcr);
        }
        return $data;
    }
}
