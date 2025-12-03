<?php

namespace App\Http\Controllers;

use App\Models\DpcrTarget;
use App\Models\HospitalTarget;
use App\Models\Ipcr_Semestral;
use App\Models\IpcrTarget;
use App\Models\UserEmployees;
use App\Models\MonthlyTarget;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MonthlyTargetController extends Controller
{
    public function semestral_monthly(Request $request)
    {
        $id = auth()->user()->username;
        $emp = auth()->user()->userEmployee;
        $emp_code = $emp->empl_id;

        $sem_data = Ipcr_Semestral::with([
            'monthly_accomplishment',
            'monthly_accomplishment.returnRemarks'
        ])
            ->where('employee_code', $emp_code)
            ->where('status', '2')
            ->where('year', '>', '2024')
            ->orderBy('year', 'asc')
            ->orderBy('sem', 'asc')
            ->get();

        $source = "direct";

        $div = "";
        if ($emp->Division) {
            $div = $emp->Division->division_name1;
        }
        foreach ($sem_data as $sem) {
            $this->ensureSixMonths($sem);
        }
        return inertia('IPCR/AccomplishmentRevised/Index', [
            "id" => $id,
            "sem_data" => $sem_data,
            "division" => $div,
            "emp" => $emp,
            "source" => $source,
        ]);
    }
    public function ensureSixMonths($ipcrSemestral)
    {
        $year = $ipcrSemestral->year;

        // Define expected months based on semester
        $expectedMonths = ($ipcrSemestral->sem == 1)
            ? ['1', '2', '3', '4', '5', '6']
            : ['7', '8', '9', '10', '11', '12'];

        // Get existing months for this semestral
        $existingMonths = $ipcrSemestral->monthly_accomplishment
            ->pluck('month')
            ->map(fn($m) => (string)$m)
            ->toArray();

        // Find which months are missing
        $missingMonths = array_diff($expectedMonths, $existingMonths);

        // If all 6 exist, do nothing
        if (count($missingMonths) === 0) {
            return;
        }

        // Create only the missing months
        foreach ($missingMonths as $month) {
            MonthlyAccomplishment::create([
                'ipcr_semestral_id' => $ipcrSemestral->id,
                'month'             => $month,
                'year'              => $year,
                'status'            => '-1',
            ]);
        }
    }
    public function getMonthlyRating(Request $request, $emp_code, $sem_id, $month, $year)
    {
        $is_div_head = employee_division_head($emp_code);
        // $user_employees = UserEmployees::where('empl_id', $emp_code)->first();
        // dd($emp_code);
        // dd($is_div_head);
        //GET IPCR TARGETS GIVEN THE SEM ID
        $ipcr_sem = Ipcr_Semestral::where('id', $sem_id)->first();
        // dd($ipcr_sem);
        if (!$ipcr_sem) {
            $div_head = $ipcr_sem->pcr_type;
            if ($div_head != NULL || $div_head != "") {
                $is_div_head = $div_head;
            }
        }
        // dd($is_div_head);
        return $is_div_head == "emp" ? $this->getIPCRForViewing($emp_code, $sem_id, $month, $year) : ($is_div_head == "div" ? $this->getDPCRForViewing($emp_code, $sem_id, $month, $year) :
            $this->getHPCRForViewing($emp_code, $sem_id, $month, $year, $is_div_head));
    }
    protected function getIPCRForViewing($emp_code, $sem_id, $month, $year)
    {
        if (intval($month) > 6) {
            $month = intval($month) - 6;
        }
        // dd($emp_code, $sem_id, $month, $year);
        // dd($month, $sem_id, $emp_code, $year);
        // $targ = IpcrTarget::with([
        //     'individualOutput',
        //     // 'monthlyTargets' => function ($query) use ($month, $year) {
        //     //     $query->where('month', $month)
        //     //         ->where('year', $year);
        //     // },
        //     // 'monthlyTargets.dailyAccomplishments'
        // ])->where('ipcr_semestral_id', $sem_id)
        //     ->where('employee_code', $emp_code)
        //     // ->whereHas('monthlyTargets', function ($query) use ($month, $year) {
        //     //     $query->where('month', $month)
        //     //         ->where('year', $year);
        //     // })
        //     ->get();
        // dd(IpcrTarget::where('ipcr_semestral_id', $sem_id)
        //     ->get(),$emp_code, $sem_id, $month, $year);
        // dd($targ,$emp_code, $sem_id, $month, $year);

        // dd(IpcrTarget::with([
        //         'individualOutput',
        //         'monthlyTargets'
        //         => function ($query) use ($month, $year) {
        //             $query->where('month', $month)
        //                 ->where('year', $year);
        //         },
        //         'monthlyTargets.dailyAccomplishments'
        //     ])
        //     ->where('ipcr_semestral_id', $sem_id)
        //     ->where('employee_code', $emp_code)
        //     ->whereHas('monthlyTargets', function ($query) use ($month, $year) {
        //         $query->where('month', $month)
        //             ->where('year', $year);
        //     })
        //     ->orderBy('ipcr_type', 'ASC')
        //     ->get()
        //     ->map(function ($item) use ($month, $year) {
        //         $daily = [];
        //         // dd($item->ipcr_semestral_id);
        //         $sem_id = $item->ipcr_semestral_id;
        //         $ifo = $item->individualOutput;
        //         if ($item->monthlyTargets) {
        //             $daily = $item->monthlyTargets->flatMap(function ($monthly_item) use ($ifo, $sem_id) {
        //                 // Ensure dailyAccomplishments is a collection before calling map()
        //                 // return $monthly_item->dailyAccomplishments ? $monthly_item->dailyAccomplishments->sortBy('date')->map(function ($daily_item) use ($ifo) {
        //                 //     return [
        //                 //         "individual_output" => $ifo->individual_output,
        //                 //         "description" => $daily_item->description,
        //                 //         "date" => $daily_item->date
        //                 //     ];
        //                 // }) : collect();
        //                 return $monthly_item->dailyAccomplishments
        //                     ? $monthly_item->dailyAccomplishments
        //                     ->where('sem_id', $sem_id) // filter by sem_id
        //                     ->sortBy('date')
        //                     ->map(function ($daily_item) use ($ifo) {
        //                         return [
        //                             "individual_output" => $ifo ? $ifo->individual_output : "",
        //                             "description" => $daily_item->description,
        //                             "date" => $daily_item->date
        //                         ];
        //                     })
        //                     : collect();
        //             });
        //         }
        //         $cnt = count($daily);
        //         // $mt = isset($item->monthlyTargets[0]) ? $item->monthlyTargets[0] : null;
        //         // if (!isset($item->monthlyTargets[0])) {
        //         //     dd($year, $month, $item);
        //         // }
        //         // dd(count($daily));
        //         return [
        //             "type" => $item->ipcr_type,
        //             "ipcr_type" => $item->ipcr_type,
        //             "sem_id" => $item->ipcr_semestral_id,
        //             "idifo" => $item->individual_final_output_id,
        //             "individual_output" => $item->individualOutput ? $item->individualOutput->individual_output : "",
        //             "output" => $item->individualOutput ? $item->individualOutput->individual_output : "",
        //             "performance_measure" => $item->individualOutput ? $item->individualOutput->performance_measure : "",
        //             "prescribed_period" => $item->individualOutput ? $item->individualOutput->prescribed_period : "",
        //             "quality1" => $item->individualOutput ? $item->individualOutput->quality1 : "",
        //             "quality2" => $item->individualOutput ? $item->individualOutput->quality2 : "",
        //             "quality3" => $item->individualOutput ? $item->individualOutput->quality3 : "",
        //             "efficiency1" => $item->individualOutput ? $item->individualOutput->efficiency1 : "",
        //             "efficiency2" => $item->individualOutput ? $item->individualOutput->efficiency2 : "",
        //             "efficiency3" => $item->individualOutput ? $item->individualOutput->efficiency3 : "",
        //             "timeliness" => $item->individualOutput ? $item->individualOutput->timeliness : "",
        //             // "monthly_rating_id" => $mt ? $mt->id : "",
        //             // "q1" => $mt && isset($mt->q1) ? floatval($mt->q1) : 0,
        //             // "q2" => $mt && isset($mt->q2) ? floatval($mt->q2) : 0,
        //             // "q3" => $mt && isset($mt->q3) ? floatval($mt->q3) : 0,
        //             // "e1" => $mt && isset($mt->e1) ? floatval($mt->e1) : 0,
        //             // "e2" => $mt && isset($mt->e2) ? floatval($mt->e2) : 0,
        //             // "e3" => $mt && isset($mt->e3) ? floatval($mt->e3) : 0,
        //             // "t1" => $mt && isset($mt->t1) ? floatval($mt->t1) : 0,
        //             // "time" => $mt && isset($mt->t1) ? floatval($mt->t1) : 0, // using t1 for "time"
        //             "monthly_rating_id" => $item->monthlyTargets ? $item->monthlyTargets[0]->id : "",
        //             "q1" => $item->monthlyTargets ? ($item->monthlyTargets[0]->q1 ? floatval($item->monthlyTargets[0]->q1) : 0) : "0",
        //             "q2" => $item->monthlyTargets ? ($item->monthlyTargets[0]->q2 ? floatval($item->monthlyTargets[0]->q2) : 0) : "0",
        //             "q3" => $item->monthlyTargets ? ($item->monthlyTargets[0]->q3 ? floatval($item->monthlyTargets[0]->q3) : 0) : "0",
        //             "e1" => $item->monthlyTargets ? ($item->monthlyTargets[0]->e1 ? floatval($item->monthlyTargets[0]->e1) : 0) : "0",
        //             "e2" => $item->monthlyTargets ? ($item->monthlyTargets[0]->e2 ? floatval($item->monthlyTargets[0]->e2) : 0) : "0",
        //             "e3" => $item->monthlyTargets ? ($item->monthlyTargets[0]->e3 ? floatval($item->monthlyTargets[0]->e3) : 0) : "0",
        //             "t1" => $item->monthlyTargets ? ($item->monthlyTargets[0]->t1 ? floatval($item->monthlyTargets[0]->t1) : 0) : "0",
        //             "time" => $item->monthlyTargets ? ($item->monthlyTargets[0]->t1 ? floatval($item->monthlyTargets[0]->t1) : 0) : "0",
        //             "visible" => intval($cnt) > 0 ? true : false,
        //             "daily" => $daily,
        //             "count_daily" => $cnt
        //         ];
        //     }),$emp_code, $sem_id, $month, $year);
        $this->generateIPCRMonthlyTarget($sem_id, $month, $year, $emp_code);
        return
            IpcrTarget::with([
                'individualOutput',
                'monthlyTargets'
                => function ($query) use ($month, $year) {
                    $query->where('month', $month)
                        ->where('year', $year);
                },
                'monthlyTargets.dailyAccomplishments'
            ])
            ->where('ipcr_semestral_id', $sem_id)
            ->where('employee_code', $emp_code)
            ->whereHas('monthlyTargets', function ($query) use ($month, $year) {
                $query->where('month', $month)
                    ->where('year', $year);
            })
            ->orderBy('ipcr_type', 'ASC')
            ->get()
            ->map(function ($item) use ($month, $year) {
                $daily = [];
                // dd($item->ipcr_semestral_id);
                $sem_id = $item->ipcr_semestral_id;
                $ifo = $item->individualOutput;
                if ($item->monthlyTargets) {
                    $daily = $item->monthlyTargets->flatMap(function ($monthly_item) use ($ifo, $sem_id) {
                        // Ensure dailyAccomplishments is a collection before calling map()
                        // return $monthly_item->dailyAccomplishments ? $monthly_item->dailyAccomplishments->sortBy('date')->map(function ($daily_item) use ($ifo) {
                        //     return [
                        //         "individual_output" => $ifo->individual_output,
                        //         "description" => $daily_item->description,
                        //         "date" => $daily_item->date
                        //     ];
                        // }) : collect();
                        return $monthly_item->dailyAccomplishments
                            ? $monthly_item->dailyAccomplishments
                            ->where('sem_id', $sem_id) // filter by sem_id
                            ->sortBy('date')
                            ->map(function ($daily_item) use ($ifo) {
                                return [
                                    "individual_output" => $ifo ? $ifo->individual_output : "",
                                    "description" => $daily_item->description,
                                    "date" => $daily_item->date
                                ];
                            })
                            : collect();
                    });
                }
                $cnt = count($daily);
                // $mt = isset($item->monthlyTargets[0]) ? $item->monthlyTargets[0] : null;
                // if (!isset($item->monthlyTargets[0])) {
                //     dd($year, $month, $item);
                // }
                // dd(count($daily));
                return [
                    "type" => $item->ipcr_type,
                    "ipcr_type" => $item->ipcr_type,
                    "sem_id" => $item->ipcr_semestral_id,
                    "idifo" => $item->individual_final_output_id,
                    "individual_output" => $item->individualOutput ? $item->individualOutput->individual_output : "",
                    "output" => $item->individualOutput ? $item->individualOutput->individual_output : "",
                    "performance_measure" => $item->individualOutput ? $item->individualOutput->performance_measure : "",
                    "prescribed_period" => $item->individualOutput ? $item->individualOutput->prescribed_period : "",
                    "quality1" => $item->individualOutput ? $item->individualOutput->quality1 : "",
                    "quality2" => $item->individualOutput ? $item->individualOutput->quality2 : "",
                    "quality3" => $item->individualOutput ? $item->individualOutput->quality3 : "",
                    "efficiency1" => $item->individualOutput ? $item->individualOutput->efficiency1 : "",
                    "efficiency2" => $item->individualOutput ? $item->individualOutput->efficiency2 : "",
                    "efficiency3" => $item->individualOutput ? $item->individualOutput->efficiency3 : "",
                    "timeliness" => $item->individualOutput ? $item->individualOutput->timeliness : "",
                    // "monthly_rating_id" => $mt ? $mt->id : "",
                    // "q1" => $mt && isset($mt->q1) ? floatval($mt->q1) : 0,
                    // "q2" => $mt && isset($mt->q2) ? floatval($mt->q2) : 0,
                    // "q3" => $mt && isset($mt->q3) ? floatval($mt->q3) : 0,
                    // "e1" => $mt && isset($mt->e1) ? floatval($mt->e1) : 0,
                    // "e2" => $mt && isset($mt->e2) ? floatval($mt->e2) : 0,
                    // "e3" => $mt && isset($mt->e3) ? floatval($mt->e3) : 0,
                    // "t1" => $mt && isset($mt->t1) ? floatval($mt->t1) : 0,
                    // "time" => $mt && isset($mt->t1) ? floatval($mt->t1) : 0, // using t1 for "time"
                    "monthly_rating_id" => $item->monthlyTargets ? $item->monthlyTargets[0]->id : "",
                    "q1" => $item->monthlyTargets ? ($item->monthlyTargets[0]->q1 ? floatval($item->monthlyTargets[0]->q1) : 0) : "0",
                    "q2" => $item->monthlyTargets ? ($item->monthlyTargets[0]->q2 ? floatval($item->monthlyTargets[0]->q2) : 0) : "0",
                    "q3" => $item->monthlyTargets ? ($item->monthlyTargets[0]->q3 ? floatval($item->monthlyTargets[0]->q3) : 0) : "0",
                    "e1" => $item->monthlyTargets ? ($item->monthlyTargets[0]->e1 ? floatval($item->monthlyTargets[0]->e1) : 0) : "0",
                    "e2" => $item->monthlyTargets ? ($item->monthlyTargets[0]->e2 ? floatval($item->monthlyTargets[0]->e2) : 0) : "0",
                    "e3" => $item->monthlyTargets ? ($item->monthlyTargets[0]->e3 ? floatval($item->monthlyTargets[0]->e3) : 0) : "0",
                    "t1" => $item->monthlyTargets ? ($item->monthlyTargets[0]->t1 ? floatval($item->monthlyTargets[0]->t1) : 0) : "0",
                    "time" => $item->monthlyTargets ? ($item->monthlyTargets[0]->t1 ? floatval($item->monthlyTargets[0]->t1) : 0) : "0",
                    "visible" => intval($cnt) > 0 ? true : false,
                    "daily" => $daily,
                    "count_daily" => $cnt
                ];
            });
    }
    protected function generateIPCRMonthlyTarget($sem_id, $month, $year, $emp_code){
        // dd("targets");
        $ipcr_targets = IpcrTarget::where('ipcr_semestral_id', $sem_id)
            ->where('employee_code', $emp_code)
            ->get();
        foreach ($ipcr_targets as $ipcr_target) {
            // Generate a unique slug
            do {
                $slug = $month . '-' . $ipcr_target->year . '-' . Str::random(6);
            } while (MonthlyTarget::where('slug', $slug)->exists());

            // Create the monthly target
            MonthlyTarget::create([
                'month'             => $month,
                'year'              => $ipcr_target->year,
                'ipcr_target_id'    => $ipcr_target->id,
                'dpcr_target_id'    => $ipcr_target->idDPCR ?? null,
                'hospital_target_id'=> null,
                'idHIPCR'           => null,
                'idHSPCR'           => null,
                'idHDPCR'           => null,
                'idHPCR'            => null,
                'is_hospital'       => 0,
                'sem_id'            => $ipcr_target->ipcr_semestral_id,
                'slug'              => $slug,
                'type'              => -1,
                'status'            => $ipcr_target->status ?? 1,
                'created_at'        => now(),
                'updated_at'        => now(),
            ]);
        }
        // return  $ipr_target;
    }
    protected function getDPCRForViewing($emp_code, $sem_id, $month, $year)
    {
        if (intval($month) > 6) {
            $month = intval($month) - 6;
        }
        return
            DpcrTarget::with([
                'divisionOutput',
                'monthlyTargets' => function ($query) use ($month, $year) {
                    $query->where('month', $month)
                        ->where('year', $year);
                },
                'monthlyTargets.dailyAccomplishments'
            ])
            ->where('ipcr_semestral_id', $sem_id)
            ->where('employee_code', $emp_code)
            ->whereHas('monthlyTargets', function ($query) use ($month, $year) {
                $query->where('month', $month)
                    ->where('year', $year);
            })
            ->orderBy('dpcr_type', 'ASC')
            ->get()
            ->map(function ($item) {
                $daily = [];
                // dd($item);
                $ifo = $item->divisionOutput;
                if ($item->monthlyTargets) {
                    $daily = $item->monthlyTargets->flatMap(function ($monthly_item) use ($ifo) {
                        // Ensure dailyAccomplishments is a collection before calling map()
                        return $monthly_item->dailyAccomplishments ? $monthly_item->dailyAccomplishments->sortBy('date')->map(function ($daily_item) use ($ifo) {
                            return [
                                "individual_output" => optional($ifo)->output,
                                "description" => $daily_item->description,
                                "date" => $daily_item->date
                            ];
                        }) : collect();
                    });
                }
                $cnt = count($daily);
                // dd(count($daily));
                return [
                    "type" => $item->dpcr_type,
                    "ipcr_type" => $item->ipcr_type,
                    "sem_id" => $item->ipcr_semestral_id,
                    "idifo" => $item->idDPCR,
                    "individual_output" => $item->divisionOutput ? $item->divisionOutput->output : "",
                    "output" => $item->divisionOutput ? $item->divisionOutput->output : "",
                    "performance_measure" => $item->divisionOutput ? $item->divisionOutput->performance_measure : "",
                    "prescribed_period " => $item->divisionOutput ? $item->divisionOutput->prescribed_period : " ",
                    "quality1" => $item->divisionOutput ? $item->divisionOutput->quality1 : "",
                    "quality2" => $item->divisionOutput ? $item->divisionOutput->quality2 : "",
                    "quality3" => $item->divisionOutput ? $item->divisionOutput->quality3 : "",
                    "efficiency1" => $item->divisionOutput ? $item->divisionOutput->efficiency1 : "",
                    "efficiency2" => $item->divisionOutput ? $item->divisionOutput->efficiency2 : "",
                    "efficiency3" => $item->divisionOutput ? $item->divisionOutput->efficiency3 : "",
                    "timeliness" => $item->divisionOutput ? $item->divisionOutput->timeliness : "",
                    "monthly_rating_id" => $item->monthlyTargets ? $item->monthlyTargets[0]->id : "",
                    "q1" => $item->monthlyTargets ? ($item->monthlyTargets[0]->q1 ? floatval($item->monthlyTargets[0]->q1) : 0) : "0",
                    "q2" => $item->monthlyTargets ? ($item->monthlyTargets[0]->q2 ? floatval($item->monthlyTargets[0]->q2) : 0) : "0",
                    "q3" => $item->monthlyTargets ? ($item->monthlyTargets[0]->q3 ? floatval($item->monthlyTargets[0]->q3) : 0) : "0",
                    "e1" => $item->monthlyTargets ? ($item->monthlyTargets[0]->e1 ? floatval($item->monthlyTargets[0]->e1) : 0) : "0",
                    "e2" => $item->monthlyTargets ? ($item->monthlyTargets[0]->e2 ? floatval($item->monthlyTargets[0]->e2) : 0) : "0",
                    "e3" => $item->monthlyTargets ? ($item->monthlyTargets[0]->e3 ? floatval($item->monthlyTargets[0]->e3) : 0) : "0",
                    "t1" => $item->monthlyTargets ? ($item->monthlyTargets[0]->t1 ? floatval($item->monthlyTargets[0]->t1) : 0) : "0",
                    "time" => $item->monthlyTargets ? ($item->monthlyTargets[0]->t1 ? floatval($item->monthlyTargets[0]->t1) : 0) : "0",
                    "visible" => intval($cnt) > 0 ? true : false,
                    "daily" => $daily,
                    "count_daily" => $cnt
                ];
            });
    }
    protected function getHPCRForViewing($emp_code, $sem_id, $month, $year, $emp_type)
    {
        if (intval($month) > 6) {
            $month = intval($month) - 6;
        }
        if ($emp_type == "hos") {
            return $this->getHospitalData($emp_code, $sem_id, $month, $year);
        } else if ($emp_type == "hdiv") {
            return $this->getHospitalDPCRData($emp_code, $sem_id, $month, $year);
        } else if ($emp_type == "hsec") {
            return $this->getHospitalSPCRData($emp_code, $sem_id, $month, $year);
        } else if ($emp_type == "hemp") {
            return $this->getHospitalIPCRData($emp_code, $sem_id, $month, $year);
        }
    }
    protected function getHospitalData($emp_code, $sem_id, $month, $year)
    {
        return
            HospitalTarget::with([
                'hpcr',
                'hpcr.programAndProject',
                'hpcr.programAndProject.MFO',
                'ipcr_Semestral',
                'monthlyTargets' => function ($query) use ($month, $year) {
                    $query->where('month', $month)
                        ->where('year', $year);
                },

                'monthlyTargets.dailyAccomplishments'
            ])
            ->where('ipcr_semestral_id', $sem_id)
            ->where('employee_code', $emp_code)
            ->whereHas('monthlyTargets', function ($query) use ($month, $year) {
                $query->where('month', $month)
                    ->where('year', $year);
            })
            ->orderBy('pcr_type', 'ASC')
            ->get()
            ->map(function ($item) {
                $daily = [];
                // dd($item);
                $ifo = $item->hpcr;
                if ($item->monthlyTargets) {
                    $daily = $item->monthlyTargets->flatMap(function ($monthly_item) use ($ifo) {
                        // Ensure dailyAccomplishments is a collection before calling map()
                        return $monthly_item->dailyAccomplishments ? $monthly_item->dailyAccomplishments->sortBy('date')->map(function ($daily_item) use ($ifo) {
                            return [
                                "individual_output" => $ifo->output,
                                "description" => $daily_item->description,
                                "date" => $daily_item->date
                            ];
                        }) : collect();
                    });
                }
                $cnt = count($daily);
                // dd(count($daily));
                return [
                    "type" => $item->type,
                    "ipcr_type" => $item->ipcr_type,
                    "sem_id" => $item->ipcr_semestral_id,
                    "idifo" => $item->idHPCR,
                    "individual_output" => $item->divisionOutput ? $item->divisionOutput->output : "",
                    "output" => $item->hpcr ? $item->hpcr->output : "",
                    "performance_measure" => $item->hpcr ? $item->hpcr->performance_measure : "",
                    "prescribed_period" => $item->hpcr ? $item->hpcr->prescribed_period : "",
                    "quality1" => $item->hpcr ? $item->hpcr->quality1 : "",
                    "quality2" => $item->hpcr ? $item->hpcr->quality2 : "",
                    "quality3" => $item->hpcr ? $item->hpcr->quality3 : "",
                    "efficiency1" => $item->hpcr ? $item->hpcr->efficiency1 : "",
                    "efficiency2" => $item->hpcr ? $item->hpcr->efficiency2 : "",
                    "efficiency3" => $item->hpcr ? $item->hpcr->efficiency3 : "",
                    "timeliness" => $item->hpcr ? $item->hpcr->timeliness : "",
                    "monthly_rating_id" => $item->monthlyTargets ? $item->monthlyTargets[0]->id : "",
                    "q1" => $item->monthlyTargets ? $item->monthlyTargets[0]->q1 : "",
                    "q2" => $item->monthlyTargets ? $item->monthlyTargets[0]->q2 : "",
                    "q3" => $item->monthlyTargets ? $item->monthlyTargets[0]->q3 : "",
                    "e1" => $item->monthlyTargets ? $item->monthlyTargets[0]->e1 : "",
                    "e2" => $item->monthlyTargets ? $item->monthlyTargets[0]->e2 : "",
                    "e3" => $item->monthlyTargets ? $item->monthlyTargets[0]->e3 : "",
                    "t1" => $item->monthlyTargets ? $item->monthlyTargets[0]->t1 : "",
                    "time" => $item->monthlyTargets ? $item->monthlyTargets[0]->t1 : "",
                    "visible" => intval($cnt) > 0 ? true : false,
                    "daily" => $daily,
                    "count_daily" => $cnt
                ];
            });
    }
    protected function getHospitalDPCRData($emp_code, $sem_id, $month, $year)
    {
        return
            HospitalTarget::with([
                'dpcr',
                'dpcr.programAndProject',
                'hDPCR',
                'hDPCR.hospitalOutput',
                'hDPCR.hospitalOutput.programAndProject',
                'hDPCR.hospitalOutput.programAndProject.MFO',
                'ipcr_Semestral',
                'monthlyTargets' => function ($query) use ($month, $year) {
                    $query->where('month', $month)
                        ->where('year', $year);
                },

                'monthlyTargets.dailyAccomplishments'
            ])
            ->where('ipcr_semestral_id', $sem_id)
            ->where('employee_code', $emp_code)
            ->whereHas('monthlyTargets', function ($query) use ($month, $year) {
                $query->where('month', $month)
                    ->where('year', $year);
            })
            ->orderBy('pcr_type', 'ASC')
            ->get()
            ->map(function ($item) {
                $daily = [];
                // dd($item);
                // dd($item);
                $output = "";
                $pm = "";

                $prescribed_period = "";
                $q1 = "";
                $q2 = "";
                $q3 = "";
                $e1 = "";
                $e2 = "";
                $e3 = "";
                $t1 = "";
                $idIFO = "";
                if ($item->pcr_type == "dpcr") {
                    $ifo = $item->dpcr;
                    // dd($ifo);
                    $idIFO = $item->idDPCR;
                    if ($ifo) {

                        $q1 = $ifo->quality1;
                        $q2 = $ifo->quality2;
                        $q3 = $ifo->quality3;
                        $e1 = $ifo->efficiency1;
                        $e2 = $ifo->efficiency2;
                        $e3 = $ifo->efficiency3;
                        $t1 = $ifo->timeliness;
                        $output = $ifo->output;

                        $pm = $ifo->performance_measure;
                        $prescribed_period = $ifo->prescribed_period;
                    }
                } else if ($item->pcr_type == "hdpcr") {
                    $ifo = $item->hDPCR;
                    $idIFO = $item->idHDPCR;
                    if ($ifo) {
                        $q1 = $ifo->quality1;
                        $q2 = $ifo->quality2;
                        $q3 = $ifo->quality3;
                        $e1 = $ifo->efficiency1;
                        $e2 = $ifo->efficiency2;
                        $e3 = $ifo->efficiency3;
                        $t1 = $ifo->timeliness;
                        $output = $ifo->output;

                        $pm = $ifo->performance_measure;
                        $prescribed_period = $ifo->prescribed_period;
                    }
                }
                // dd($ifo);
                // $ifo = $item->hpcr;
                if ($item->monthlyTargets) {
                    $daily = $item->monthlyTargets->flatMap(function ($monthly_item) use ($ifo) {
                        // Ensure dailyAccomplishments is a collection before calling map()
                        return $monthly_item->dailyAccomplishments ? $monthly_item->dailyAccomplishments->sortBy('date')->map(function ($daily_item) use ($ifo) {
                            return [
                                "individual_output" => $ifo->output,
                                "description" => $daily_item->description,
                                "date" => $daily_item->date
                            ];
                        }) : collect();
                    });
                }
                $cnt = count($daily);
                // dd(count($daily));
                // dd($item->pcr_type);
                return [
                    "type" => $item->type,
                    "ipcr_type" => $item->pcr_type,
                    "sem_id" => $item->ipcr_semestral_id,
                    "idifo" => $idIFO,
                    "output" => $output,
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
                    "monthly_rating_id" => $item->monthlyTargets ? $item->monthlyTargets[0]->id : "",
                    "q1" => $item->monthlyTargets ? ($item->monthlyTargets[0]->q1 ? floatval($item->monthlyTargets[0]->q1) : 0) : "0",
                    "q2" => $item->monthlyTargets ? ($item->monthlyTargets[0]->q2 ? floatval($item->monthlyTargets[0]->q2) : 0) : "0",
                    "q3" => $item->monthlyTargets ? ($item->monthlyTargets[0]->q3 ? floatval($item->monthlyTargets[0]->q3) : 0) : "0",
                    "e1" => $item->monthlyTargets ? ($item->monthlyTargets[0]->e1 ? floatval($item->monthlyTargets[0]->e1) : 0) : "0",
                    "e2" => $item->monthlyTargets ? ($item->monthlyTargets[0]->e2 ? floatval($item->monthlyTargets[0]->e2) : 0) : "0",
                    "e3" => $item->monthlyTargets ? ($item->monthlyTargets[0]->e3 ? floatval($item->monthlyTargets[0]->e3) : 0) : "0",
                    "t1" => $item->monthlyTargets ? ($item->monthlyTargets[0]->t1 ? floatval($item->monthlyTargets[0]->t1) : 0) : "0",
                    "time" => $item->monthlyTargets ? ($item->monthlyTargets[0]->t1 ? floatval($item->monthlyTargets[0]->t1) : 0) : "0",
                    "visible" => intval($cnt) > 0 ? true : false,
                    "daily" => $daily,
                    "count_daily" => $cnt
                ];
            });
    }
    protected function getHospitalSPCRData($emp_code, $sem_id, $month, $year)
    {
        return
            HospitalTarget::with([
                'hSPCR',
                'hSPCR.hospitalDivisionOutput',
                'hSPCR.hospitalDivisionOutput.hospitalOutput',
                'hSPCR.hospitalDivisionOutput.hospitalOutput.programAndProject',
                'hSPCR.hospitalDivisionOutput.hospitalOutput.programAndProject.MFO',
                'ipcr_Semestral',
                'monthlyTargets' => function ($query) use ($month, $year) {
                    $query->where('month', $month)
                        ->where('year', $year);
                },

                'monthlyTargets.dailyAccomplishments'
            ])
            ->where('ipcr_semestral_id', $sem_id)
            ->where('employee_code', $emp_code)
            ->whereHas('monthlyTargets', function ($query) use ($month, $year) {
                $query->where('month', $month)
                    ->where('year', $year);
            })
            ->orderBy('pcr_type', 'ASC')
            ->get()
            ->map(function ($item) {
                $daily = [];
                // dd($item);
                $ifo = $item->hSPCR;
                if ($item->monthlyTargets) {
                    $daily = $item->monthlyTargets->flatMap(function ($monthly_item) use ($ifo) {
                        // Ensure dailyAccomplishments is a collection before calling map()
                        return $monthly_item->dailyAccomplishments ? $monthly_item->dailyAccomplishments->sortBy('date')->map(function ($daily_item) use ($ifo) {
                            return [
                                "individual_output" => $ifo->output,
                                "description" => $daily_item->description,
                                "date" => $daily_item->date
                            ];
                        }) : collect();
                    });
                }
                $cnt = count($daily);
                // dd(count($daily));
                return [
                    "type" => $item->type,
                    "ipcr_type" => $item->ipcr_type,
                    "sem_id" => $item->ipcr_semestral_id,
                    "idifo" => $item->idHSPCR,
                    "output" => $item->hSPCR ? $item->hSPCR->output : "",
                    "individual_output" => $item->hSPCR ? $item->hSPCR->output : "",

                    // $pm = $ifo->performance_measure;
                    "performance_measure" => $item->hSPCR ? $item->hSPCR->performance_measure : "",
                    "prescribed_period" => $item->hSPCR ? $item->hSPCR->prescribed_period : "",
                    "quality1" => $item->hSPCR ? $item->hSPCR->quality1 : "",
                    "quality2" => $item->hSPCR ? $item->hSPCR->quality2 : "",
                    "quality3" => $item->hSPCR ? $item->hSPCR->quality3 : "",
                    "efficiency1" => $item->hSPCR ? $item->hSPCR->efficiency1 : "",
                    "efficiency2" => $item->hSPCR ? $item->hSPCR->efficiency2 : "",
                    "efficiency3" => $item->hSPCR ? $item->hSPCR->efficiency3 : "",
                    "timeliness" => $item->hSPCR ? $item->hSPCR->timeliness : "",
                    "monthly_rating_id" => $item->monthlyTargets ? $item->monthlyTargets[0]->id : "",
                    "q1" => $item->monthlyTargets ? ($item->monthlyTargets[0]->q1 ? floatval($item->monthlyTargets[0]->q1) : 0) : "0",
                    "q2" => $item->monthlyTargets ? ($item->monthlyTargets[0]->q2 ? floatval($item->monthlyTargets[0]->q2) : 0) : "0",
                    "q3" => $item->monthlyTargets ? ($item->monthlyTargets[0]->q3 ? floatval($item->monthlyTargets[0]->q3) : 0) : "0",
                    "e1" => $item->monthlyTargets ? ($item->monthlyTargets[0]->e1 ? floatval($item->monthlyTargets[0]->e1) : 0) : "0",
                    "e2" => $item->monthlyTargets ? ($item->monthlyTargets[0]->e2 ? floatval($item->monthlyTargets[0]->e2) : 0) : "0",
                    "e3" => $item->monthlyTargets ? ($item->monthlyTargets[0]->e3 ? floatval($item->monthlyTargets[0]->e3) : 0) : "0",
                    "t1" => $item->monthlyTargets ? ($item->monthlyTargets[0]->t1 ? floatval($item->monthlyTargets[0]->t1) : 0) : "0",
                    "time" => $item->monthlyTargets ? ($item->monthlyTargets[0]->t1 ? floatval($item->monthlyTargets[0]->t1) : 0) : "0",
                    "visible" => intval($cnt) > 0 ? true : false,
                    "daily" => $daily,
                    "count_daily" => $cnt
                ];
            });
    }
    protected function getHospitalIPCRData($emp_code, $sem_id, $month, $year)
    {
        return
            HospitalTarget::with([
                'ipcr',
                'ipcr.divisionOutput',
                'ipcr.divisionOutput.programAndProject',
                'ipcr.divisionOutput.programAndProject.MFO',
                'hIPCR',
                'hIPCR.hospitalSectionOutput',
                'hIPCR.hospitalSectionOutput.hospitalDivisionOutput',
                'hIPCR.hospitalSectionOutput.hospitalDivisionOutput.hospitalOutput',
                'hIPCR.hospitalSectionOutput.hospitalDivisionOutput.hospitalOutput.programAndProject',
                'hIPCR.hospitalSectionOutput.hospitalDivisionOutput.hospitalOutput.programAndProject.MFO',
                'ipcr_Semestral',
                'monthlyTargets' => function ($query) use ($month, $year) {
                    $query->where('month', $month)
                        ->where('year', $year);
                },

                'monthlyTargets.dailyAccomplishments'
            ])
            ->where('ipcr_semestral_id', $sem_id)
            ->where('employee_code', $emp_code)
            ->whereHas('monthlyTargets', function ($query) use ($month, $year) {
                $query->where('month', $month)
                    ->where('year', $year);
            })
            ->orderBy('pcr_type', 'ASC')
            ->get()
            ->map(function ($item) {
                $daily = [];
                // dd($item);
                // dd($item);
                $output = "";
                $pm = "";
                $prescribed_period = "";
                $q1 = "";
                $q2 = "";
                $q3 = "";
                $e1 = "";
                $e2 = "";
                $e3 = "";
                $t1 = "";
                $idIFO = "";
                if ($item->pcr_type == "ipcr") {
                    $ifo = $item->ipcr;
                    // dd($item);
                    $idIFO = $item->idIPCR;
                    if ($ifo) {
                        $pm = $ifo->performance_measure;
                        $prescribed_period = $ifo->prescribed_period;
                        $q1 = $ifo->quality1;
                        $q2 = $ifo->quality2;
                        $q3 = $ifo->quality3;
                        $e1 = $ifo->efficiency1;
                        $e2 = $ifo->efficiency2;
                        $e3 = $ifo->efficiency3;
                        $t1 = $ifo->timeliness;
                        $output = $ifo->individual_output;
                    }
                } else if ($item->pcr_type == "hipcr") {
                    $ifo = $item->hIPCR;
                    $idIFO = $item->idHIPCR;
                    if ($ifo) {
                        $q1 = $ifo->quality1;
                        $q2 = $ifo->quality2;
                        $q3 = $ifo->quality3;
                        $e1 = $ifo->efficiency1;
                        $e2 = $ifo->efficiency2;
                        $e3 = $ifo->efficiency3;
                        $t1 = $ifo->timeliness;
                        $output = $ifo->output;
                        $pm = $ifo->performance_measure;
                        $prescribed_period = $ifo->prescribed_period;
                    }
                } else {
                    // dd($item->pcr_type);
                }
                // dd($ifo);
                // $ifo = $item->hpcr;
                if ($item->monthlyTargets) {
                    $daily = $item->monthlyTargets->flatMap(function ($monthly_item) use ($ifo) {
                        // Ensure dailyAccomplishments is a collection before calling map()
                        return $monthly_item->dailyAccomplishments ? $monthly_item->dailyAccomplishments->sortBy('date')->map(function ($daily_item) use ($ifo) {
                            return [
                                "individual_output" => $ifo->output,
                                "description" => $daily_item->description,
                                "date" => $daily_item->date
                            ];
                        }) : collect();
                    });
                }
                $cnt = count($daily);
                // dd(count($daily));
                return [
                    "type" => $item->type,
                    "ipcr_type" => $item->ipcr_type,
                    "sem_id" => $item->ipcr_semestral_id,
                    "idifo" => $idIFO,
                    "output" => $output,
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
                    "monthly_rating_id" => $item->monthlyTargets ? $item->monthlyTargets[0]->id : "",
                    "q1" => $item->monthlyTargets ? ($item->monthlyTargets[0]->q1 ? floatval($item->monthlyTargets[0]->q1) : 0) : "0",
                    "q2" => $item->monthlyTargets ? ($item->monthlyTargets[0]->q2 ? floatval($item->monthlyTargets[0]->q2) : 0) : "0",
                    "q3" => $item->monthlyTargets ? ($item->monthlyTargets[0]->q3 ? floatval($item->monthlyTargets[0]->q3) : 0) : "0",
                    "e1" => $item->monthlyTargets ? ($item->monthlyTargets[0]->e1 ? floatval($item->monthlyTargets[0]->e1) : 0) : "0",
                    "e2" => $item->monthlyTargets ? ($item->monthlyTargets[0]->e2 ? floatval($item->monthlyTargets[0]->e2) : 0) : "0",
                    "e3" => $item->monthlyTargets ? ($item->monthlyTargets[0]->e3 ? floatval($item->monthlyTargets[0]->e3) : 0) : "0",
                    "t1" => $item->monthlyTargets ? ($item->monthlyTargets[0]->t1 ? floatval($item->monthlyTargets[0]->t1) : 0) : "0",
                    "time" => $item->monthlyTargets ? ($item->monthlyTargets[0]->t1 ? floatval($item->monthlyTargets[0]->t1) : 0) : "0",
                    "visible" => intval($cnt) > 0 ? true : false,
                    "daily" => $daily,
                    "count_daily" => $cnt
                ];
            });
    }
}
