<?php

namespace App\Http\Controllers;

use App\Models\Daily_Accomplishment;
use App\Models\DivisionOutput;
use App\Models\DpcrTarget;
use App\Models\HospitalTarget;
use App\Models\Ipcr_Semestral;
use App\Models\IpcrTarget;
use App\Models\MonthlyAccomplishment;
use App\Models\UserEmployees;
use App\Models\MonthlyTarget;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MonthlyTargetController extends Controller
{
    public function semestral_monthly(Request $request)
    {
        $id = auth()->user()->username;
        $emp = auth()->user()->userEmployee;
        $emp_code = $emp->empl_id;
        // dd($request);
        // dd("semestral monthly");
        $sem_data = Ipcr_Semestral::with([
            'monthly_accomplishment',
            'monthly_accomplishment.returnRemarks',
            'probationaryTemporaryEmployee'
        ])
            ->where('employee_code', $emp_code)
            ->where('status', '2')
            ->where('year', '>', '2024')
            ->orderBy('year', 'asc')
            ->orderBy('sem', 'asc')
            ->get();
        // dd($sem_data->pluck('probationaryTemporaryEmployee'), DB::connection()->getDatabaseName());
        $source = "direct";

        $div = "";
        if ($emp->Division) {
            $div = $emp->Division->division_name1;
        }
        // dd($sem_data);
        foreach ($sem_data as $sem) {
            if($sem->prob_type=='s'){
                $this->ensureSixMonths($sem);
            }

        }
        // dd($sem_data);
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

        // dd($missingMonths);
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
        $ipcr_sem = Ipcr_Semestral::with(['probationaryTemporaryEmployee'])
            ->where('id', $sem_id)
            ->first();

        // dd($ipcr_sem);
        $month_index = $month;
        if (!$ipcr_sem) {
            $div_head = optional($ipcr_sem)->pcr_type;
            if ($div_head != NULL || $div_head != "") {
                $is_div_head = $div_head;
            }
        }else{
            // dd("diri");
            // dd($ipcr_sem);
            if($ipcr_sem->prob_type!="s"){
                $prob_tempo_emp = $ipcr_sem->probationaryTemporaryEmployee;
                if($prob_tempo_emp){
                    $date_from_prob = $prob_tempo_emp->date_from;
                    if(is_string($date_from_prob)){
                        $date_from_prob = json_decode($date_from_prob, true);

                            $month=Carbon::parse($date_from_prob[intval($month)-1])->month;

                        // dd($month);
                    }
                    // dd($date_from_prob, $prob_tempo_emp);
                }
            }
        }
        // dd($month);
        // dd($is_div_head);
        // dd($ipcr_sem);
        // dd($this->getIPCRForViewing($emp_code, $sem_id, $month, $year, $ipcr_sem));
        // dd("ipcr_sem: ".$ipcr_sem);
        return $is_div_head == "emp" ? $this->getIPCRForViewing($emp_code, $sem_id, $month, $year, $ipcr_sem, $month_index) :
            ($is_div_head == "div" ?
            $this->getDPCRForViewing($emp_code, $sem_id, $month, $year, $ipcr_sem) :
            $this->getHPCRForViewing($emp_code, $sem_id, $month, $year, $is_div_head, $ipcr_sem));
    }
    protected function getIPCRForViewing($emp_code, $sem_id, $month, $year, $ipcr_sem, $month_index)
    {
        $month_as_is=$month;
        // dd($month_as_is);
        // dd($ipcr_sem);
        if (intval($month) > 6) {
            $month = intval($month) - 6;
        }
        if($ipcr_sem){
            if($ipcr_sem->probtype!="s"){
                $month_search=$month_as_is;
            }else{
                $month_search=$month;
            }
        }
        // if(!$this->checkIfMonthlyTargetExists($sem_id, $month, $year, $emp_code)){
        $this->generateIPCRMonthlyTarget($sem_id, $month_as_is, $year, $emp_code);
        // }


        //         dd([
        //     'connection' => config('database.default'),
        //     'driver'     => config('database.connections.' . config('database.default') . '.driver'),
        //     'host_ip'    => config('database.connections.' . config('database.default') . '.host'),
        //     'port'       => config('database.connections.' . config('database.default') . '.port'),
        //     'database'   => config('database.connections.' . config('database.default') . '.database'),
        //     'username'   => config('database.connections.' . config('database.default') . '.username'),
        // ]);


        // dd($month,"Year: ", $year, $sem_id, $emp_code);
        // dd($month_search, $month_as_is, $month, $ipcr_sem);
        $ipcr_data=
            IpcrTarget::with([
                'individualOutput',
                'monthlyTargets'
                => function ($query) use ($month_search, $year, $sem_id) {
                    // dd($month_search, $year, $sem_id);
                    $query->where('month', $month_search)
                        ->where('year', $year)
                        ->where('sem_id', $sem_id);
                },
                'monthlyTargets.dailyAccomplishments',
                'ipcr_Semestral',
                'ipcr_Semestral.probationaryTemporaryEmployee',
                'ipcr_Semestral.siblingSemestrals'
            ])
            ->where('ipcr_semestral_id', $sem_id)
            ->where('employee_code', $emp_code)
            ->whereHas('monthlyTargets', function ($query) use ($month_search, $year, $sem_id) {
                $query->where('month', $month_search)
                    ->where('year', $year)
                    ->where('sem_id', $sem_id);
            })
            ->orderBy('ipcr_type', 'ASC')
            ->get()
            ->map(function ($item) use ($month_as_is,$month, $year, $emp_code, $month_index) {
                $daily = [];
                // dd($item);
                // dd($item->ipcr_semestral_id);
                $ipcr_semestral = $item->ipcr_Semestral;
                $sem_id = $item->ipcr_semestral_id;
                $ipcr_semestral = $item->ipcr_Semestral;
                $prob_tempo = optional($ipcr_semestral)->probationaryTemporaryEmployee;
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

                if($cnt<1){
                    // dd($item->ipcr_Semestral);
                    // dd($prob_tempo, $sem_id);


                    // dd($date_from_array, $date_to_array);
                    if(optional($ipcr_semestral)->prob_type=='s'){
                        $daily = Daily_Accomplishment::where('sem_id', $item->ipcr_semestral_id)
                                ->whereMonth('date', $month_as_is)
                                ->whereYear('date', $year)
                                ->where('emp_code', $emp_code)
                                ->where('individual_final_output_id', $ifo->id)
                                ->get()
                                ->map(function($item)use ($ifo) {
                                    return [
                                        "individual_output" => optional($ifo)->individual_output,
                                        "description" => $item->description,
                                        "date" => $item->date
                                    ];
                                });
                    }else{
                        $date_from_array = json_decode($prob_tempo->date_from, true) ?? [];
                        $date_to_array   = json_decode($prob_tempo->date_to, true) ?? [];
                        // dd($month_as_is, $month);
                        $month_index = $month_index-1;
                        // dd($month_index);
                        $date_from = $date_from_array[intval($month_index)];
                        $date_to = $date_to_array[intval($month_index)];
                        $sems=$ipcr_semestral->siblingSemestrals;
                        // dd($sems);
                        // dd($sems->pluck('id'));
                        $daily = Daily_Accomplishment::whereIn('sem_id', $sems->pluck('id'))
                            ->whereBetween('date', [$date_from, $date_to])
                            ->where('emp_code', $emp_code)
                            ->where('individual_final_output_id', $ifo->id)
                            ->get()
                            ->map(function ($item) use ($ifo) {
                                return [
                                    "individual_output" => optional($ifo)->individual_output,
                                    "description" => $item->description,
                                    "date" => $item->date
                                ];
                            });
                    }

                }
                // $mt = isset($item->monthlyTargets[0]) ? $item->monthlyTargets[0] : null;
                // if (!isset($item->monthlyTargets[0])) {
                //     dd($year, $month, $item);
                // }
                // dd(count($daily));
                $cnt = count($daily);
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
         return $ipcr_data;
        // $dpcr_data = $this->getDPCRHere($emp_code, $sem_id, $month, $year);
        // return $ipcr_data;
        // if(count($dpcr_data)<=0){
        //     return $ipcr_data;
        // }
        // return $ipcr_data->concat($dpcr_data);
        // ->concat($dpcr_data);
    }
    // protected function getIPCRForVIewingComments(){
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
    // }
    protected function generateIPCRMonthlyTarget($sem_id, $month, $year, $emp_code)
    {
        // dd("targets");
        // 🔎 Check if monthly target already exists
        // dd($month);
        $ipcr_targets = IpcrTarget::where('ipcr_semestral_id', $sem_id)
            ->where('employee_code', $emp_code)
            ->get();
            // dd($ipcr_targets);
        foreach ($ipcr_targets as $ipcr_target) {

            $exists = MonthlyTarget::where('month', $month)
                        ->where('year', $ipcr_target->year)
                        ->where('ipcr_target_id', $ipcr_target->id)
                        // ->where('dpcr_target_id', $ipcr_target->idDPCR ?? null)
                        // ->where('employee_code', $emp_code)
                        ->exists();
            // dd($exists, $month, $ipcr_target->year, $ipcr_target->id, $ipcr_target->idDPCR ?? null);
            // ⛔ Skip if already exists
            if ($exists) {
                continue;
            }
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
                'hospital_target_id' => null,
                'idHIPCR'           => null,
                'idHSPCR'           => null,
                'idHDPCR'           => null,
                'idHPCR'            => null,
                'is_hospital'       => 0,
                'sem_id'            => $ipcr_target->ipcr_semestral_id,
                'slug'              => $slug,
                'type'              => 'ipcr',
                'status'            => $ipcr_target->status ?? 1,
                'created_at'        => now(),
                'updated_at'        => now(),
            ]);
        }
        // return  $ipr_target;
    }
    protected function getDPCRForViewing($emp_code, $sem_id, $month, $year, $ipcr_sem)
    {
        // dd($month);
        // $month_as_is=$month;
        // if (intval($month) > 6) {
        //     $month = intval($month) - 6;
        // }
        $is_hybrid = $ipcr_sem->is_hybrid?$ipcr_sem->is_hybrid:"0";
        $monthCopy = (int) $month;
        // dd($month,"1");
        $dpcr=$this->getDPCRHere($emp_code, $sem_id, $monthCopy , $year);
        // dd($ipcr_sem);
        // dd($is_hybrid);
        // dd($ipcr_sem);
        if($is_hybrid=="1"){
            $ipcr=$this->getIPCRForViewing($emp_code, $sem_id, $monthCopy , $year, $ipcr_sem);
            $hdpcr = $this->getHospitalDPCRData($emp_code, $sem_id, $monthCopy , $year);
            // dd($ipcr);
            return $dpcr->concat($hdpcr)->concat($ipcr );
        }else{
            // dd($ipcr_sem);
            return $dpcr;
        }

    }
    protected function getDPCRHere($emp_code, $sem_id, $month_3, $year)
    {
        $month=$month_3;
        // dd($month);
        $month_as_is=$month;
        // dd($month_as_is);
        if (intval($month) > 6) {
            $month = intval($month) - 6;
        }
        // dd($month_as_is);
        $sem = Ipcr_Semestral::where('id', $sem_id)->first();
        $sem1=$sem->sem;
        // dd($sem1);
        if($sem1>1){
            // dd("greater than 1");
            if($month_as_is<=6){
                $month_as_is=$month_as_is+6;
                // dd($month_as_is);
            }
        }
        // dd(DpcrTarget::with([
        //         'divisionOutput',
        //         'monthlyTargets'
        //         => function ($query) use ($month, $year) {
        //             $query->where('month', $month)
        //                 ->where('year', $year);
        //         },
        //         'monthlyTargets.dailyAccomplishments'
        //         => function($query)use($month_as_is, $year){
        //             $query->whereMonth('date', $month_as_is)
        //                 ->whereYear('date', $year);
        //         }
        //     ])
        //     ->where('ipcr_semestral_id', $sem_id)
        //     ->where('employee_code', $emp_code)
        //     ->whereHas('monthlyTargets', function ($query) use ($month, $year) {
        //         $query->where('month', $month)
        //             ->where('year', $year);
        //     })
        //     ->orderBy('dpcr_type', 'ASC')
        //     ->get(), $month_as_is, $year, $month, $sem_id);
        // dd()
        // dd($month);
        return
            DpcrTarget::with([
                'divisionOutput'=> function ($query) {
                    $query->withTrashed(); // include deleted + non-deleted
                },
                'monthlyTargets' => function ($query) use ($month, $year, $sem_id) {
                    $query->where('month', $month)
                        ->where('year', $year)
                        ->where('sem_id', $sem_id);
                },
                'monthlyTargets.dailyAccomplishments' => function($query)use($month_as_is, $year){
                    $query->whereMonth('date', $month_as_is)
                        ->whereYear('date', $year);
                },
                'ipcr_Semestral',
                'ipcr_Semestral.probationaryTemporaryEmployee',
                'ipcr_Semestral.siblingSemestrals'
            ])
            ->where('ipcr_semestral_id', $sem_id)
            ->where('employee_code', $emp_code)
            ->whereHas('monthlyTargets', function ($query) use ($month, $year, $sem_id) {
                $query->where('month', $month)
                    ->where('year', $year)
                    ->where('sem_id', $sem_id);
            })
            ->orderBy('dpcr_type', 'ASC')
            ->get()
            ->map(function ($item) use($month, $year, $month_as_is, $emp_code) {
                $daily = [];
                // dd($item);
                $ipcr_semestral = $item->ipcr_Semestral;
                $ifo = $item->divisionOutput;
                // dd($ifo);
                // if($item->idDPCR=='2027'){
                //     dd($item, DivisionOutput::where('id', $item->idDPCR)->first(), $ifo);
                // }
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
                $prob_tempo = optional($ipcr_semestral)->probationaryTemporaryEmployee;
                // dd($cnt);
                if($cnt<1){



                    if(optional($ipcr_semestral)->prob_type=='s'){

                        $daily = Daily_Accomplishment::where('sem_id', $item->ipcr_semestral_id)
                            ->whereMonth('date', $month_as_is)
                            ->whereYear('date', $year)
                            ->where('emp_code', $emp_code)
                            ->where('idDPCR', $item->idDPCR)
                            // ->when(optional($ifo)->id, function($query) use ($ifo){
                            //     $query->where('idDPCR', $ifo->id);
                            // })
                            // ->where('idDPCR', $ifo->id)
                            ->get()
                            ->map(function($item)use ($ifo) {
                                return [
                                    "individual_output" => optional($ifo)->output,
                                    "description" => $item->description,
                                    "date" => $item->date
                                ];
                            });
                    }else{
                        // dd($month_as_is);
                        $date_from_array = json_decode($prob_tempo->date_from, true) ?? [];
                        $date_to_array   = json_decode($prob_tempo->date_to, true) ?? [];
                        $month_index = $month_as_is-1;
                        // dd($month_index);
                        $date_from = $date_from_array[$month_index];
                        $date_to = $date_to_array[$month_index];
                        $sems=$ipcr_semestral->siblingSemestrals;
                        // dd($sems->pluck('id'));
                        $daily = Daily_Accomplishment::whereIn('sem_id', $sems->pluck('id'))
                            ->whereBetween('date', [$date_from, $date_to])
                            ->where('emp_code', $emp_code)
                            ->where('idDPCR', $item->idDPCR)
                            // ->when(optional($ifo)->id, function($query) use ($ifo){
                            //     $query->where('idDPCR', $ifo->id);
                            // })
                            // ->where('idDPCR', $ifo->id)
                            ->get()
                            ->map(function($item)use ($ifo) {
                                return [
                                    "individual_output" => optional($ifo)->output,
                                    "description" => $item->description,
                                    "date" => $item->date
                                ];
                            });
                    }

                    // dd($daily, $ifo->id, $item->ipcr_semestral_id, $month_as_is, $year, $emp_code);
                    // if(intval($item->id)==2109){
                    //     dd($daily, $month_as_is, $item, $ifo);
                    // }
                }
                // dd(count($daily));
                $cnt = count($daily);
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
    protected function getHPCRForViewing($emp_code, $sem_id, $month, $year, $emp_type, $ipcr_sem)
    {
        if (intval($month) > 6) {
            $month = intval($month) - 6;
        }
        // dd($month);
        // dd($emp_type, "diri");
        // dd("getHPCRForViewing: ".$sem_id);
        if ($emp_type == "hos") {
            return $this->getHospitalData($emp_code, $sem_id, $month, $year);
        } else if ($emp_type == "hdiv") {
            $hos=$this->getHospitalData($emp_code, $sem_id, $month, $year);
            $hdiv= $this->getHospitalDPCRData($emp_code, $sem_id, $month, $year);
            // dd($hos, $hdiv);
            return $hdiv->concat($hos);
        } else if ($emp_type == "hsec") {
            return $this->getHospitalSPCRData($emp_code, $sem_id, $month, $year);
        } else if ($emp_type == "hemp") {
            $ipcr = $this->getIPCRForViewing($emp_code, $sem_id, $month, $year, $ipcr_sem);
            $hipcr= $this->getHospitalIPCRData($emp_code, $sem_id, $month, $year);
            // dd($hipcr->pluck('daily'), $ipcr);
            // dd($hipcr, $ipcr);
            return $ipcr->concat($hipcr);
            // return $hipcr;
        }
    }
    protected function getHospitalData($emp_code, $sem_id, $month, $year)
    {
        $month_1=$month;
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

                'monthlyTargets.dailyAccomplishments',
                'ipcr_Semestral',
                'ipcr_Semestral.probationaryTemporaryEmployee',
                'ipcr_Semestral.siblingSemestrals'
            ])
            ->where('ipcr_semestral_id', $sem_id)
            ->where('employee_code', $emp_code)
            ->whereHas('hpcr')
            ->whereHas('monthlyTargets', function ($query) use ($month, $year) {
                $query->where('month', $month)
                    ->where('year', $year);
            })
            ->orderBy('pcr_type', 'ASC')
            ->get()
            ->map(function ($item)use($month_1, $emp_code, $year) {
                $daily = [];
                // dd($item);
                $ifo = $item->hpcr;
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
                $ipcr_semestral = $item->ipcr_Semestral;
                $prob_tempo = optional($ipcr_semestral)->probationaryTemporaryEmployee;


                if($cnt<1){
                    // dd($item->ipcr_Semestral);
                    // dd($prob_tempo, $sem_id);
                    $date_from_array = json_decode($prob_tempo->date_from, true) ?? [];
                    $date_to_array   = json_decode($prob_tempo->date_to, true) ?? [];

                    if(optional($ipcr_semestral)->prob_type=='s'){
                        $daily = Daily_Accomplishment::where('sem_id', $item->ipcr_semestral_id)
                                ->whereMonth('date', $month_1)
                                ->whereYear('date', $year)
                                ->where('emp_code', $emp_code)
                                ->where('individual_final_output_id', $ifo->id)
                                ->get()
                                ->map(function($item)use ($ifo) {
                                    return [
                                        "individual_output" => optional($ifo)->output,
                                        "description" => $item->description,
                                        "date" => $item->date
                                    ];
                                });
                    }else{
                        // dd($month_as_is);
                        $month_index = $month_1-1;
                        // dd($month_index);
                        $date_from = $date_from_array[$month_index];
                        $date_to = $date_to_array[$month_index];
                        $sems=$ipcr_semestral->siblingSemestrals;

                        // dd($date_from, $date_to, $sems->pluck('id'), $emp_code, $ifo);
                        // dd($sems);
                        // dd($sems->pluck('id'));
                        $daily = Daily_Accomplishment::whereIn('sem_id', $sems->pluck('id'))
                            ->whereBetween('date', [$date_from, $date_to])
                            ->where('emp_code', $emp_code)
                            ->where(function($query)use($ifo){
                                $query->where('individual_final_output_id', $ifo->id)
                                ->OrWHere('idHPCR', $ifo->id);
                            })

                            ->get()
                            ->map(function ($item) use ($ifo) {
                                return [
                                    "individual_output" => optional($ifo)->output,
                                    "description" => $item->description,
                                    "date" => $item->date
                                ];
                            });
                    }

                }
                $cnt = count($daily);
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
        $month_1=$month;
        // dd($month_1);
        return
            HospitalTarget::with([
                'dpcr',
                'dpcr.programAndProject',
                'hDPCR',
                'hDPCR.hospitalOutput',
                'hDPCR.hospitalOutput.programAndProject',
                'hDPCR.hospitalOutput.programAndProject.MFO',
                'ipcr_Semestral',
                'monthlyTargets' => function ($query) use ($month, $year, $sem_id) {
                    $query->where('month', $month)
                        ->where('year', $year)
                        ->where('sem_id', $sem_id);
                },

                'monthlyTargets.dailyAccomplishments',
                'ipcr_Semestral',
                'ipcr_Semestral.probationaryTemporaryEmployee',
                'ipcr_Semestral.siblingSemestrals'
            ])
            ->where('ipcr_semestral_id', $sem_id)
            ->where('employee_code', $emp_code)
            ->whereHas('monthlyTargets', function ($query) use ($month, $year) {
                $query->where('month', $month)
                    ->where('year', $year);
            })
            ->orderBy('pcr_type', 'ASC')
            ->get()
            ->map(function ($item) use($month_1, $emp_code, $year){
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
                $ipcr_semestral = $item->ipcr_Semestral;
                $prob_tempo = optional($ipcr_semestral)->probationaryTemporaryEmployee;


                if($cnt<1){
                    // dd($item->ipcr_Semestral);
                    // dd($prob_tempo, $sem_id);


                    if(optional($ipcr_semestral)->prob_type=='s'){
                        $daily = Daily_Accomplishment::where('sem_id', $item->ipcr_semestral_id)
                                ->whereMonth('date', $month_1)
                                ->whereYear('date', $year)
                                ->where('emp_code', $emp_code)
                                ->where('individual_final_output_id', $ifo->id)
                                ->get()
                                ->map(function($item)use ($ifo) {
                                    return [
                                        "individual_output" => optional($ifo)->output,
                                        "description" => $item->description,
                                        "date" => $item->date
                                    ];
                                });
                    }else{
                        // dd($month_as_is);
                        $date_from_array = json_decode($prob_tempo->date_from, true) ?? [];
                        $date_to_array   = json_decode($prob_tempo->date_to, true) ?? [];
                        $month_index = $month_1-1;
                        // dd($month_index);
                        $date_from = $date_from_array[$month_index];
                        $date_to = $date_to_array[$month_index];
                        $sems=$ipcr_semestral->siblingSemestrals;

                        // dd($date_from, $date_to, $sems->pluck('id'), $emp_code, $ifo);
                        // dd($sems);
                        // dd($sems->pluck('id'));
                        $daily = Daily_Accomplishment::whereIn('sem_id', $sems->pluck('id'))
                            ->whereBetween('date', [$date_from, $date_to])
                            ->where('emp_code', $emp_code)
                            ->where(function($query)use($ifo){
                                $query->where('individual_final_output_id', $ifo->id)
                                ->OrWHere('idHDPCR', $ifo->id);
                            })

                            ->get()
                            ->map(function ($item) use ($ifo) {
                                return [
                                    "individual_output" => optional($ifo)->output,
                                    "description" => $item->description,
                                    "date" => $item->date
                                ];
                            });
                    }

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
        $month_1=$month;
        if (intval($month) > 6) {
            $month_1 = intval($month) - 6;
        }
        // dd("hsec",$month);
        // dd($month_1, $sem_id, $emp_code, $year);
        $data=
            HospitalTarget::with([
                'hSPCR',
                'hSPCR.hospitalDivisionOutput',
                'hSPCR.hospitalDivisionOutput.hospitalOutput',
                'hSPCR.hospitalDivisionOutput.hospitalOutput.programAndProject',
                'hSPCR.hospitalDivisionOutput.hospitalOutput.programAndProject.MFO',
                'hIPCR',
                'ipcr_Semestral',
                'monthlyTargets'
                => function ($query) use ($month, $year) {
                    $query->where('month', $month)
                        ->where('year', $year);
                },

                'monthlyTargets.dailyAccomplishments',
                'ipcr_Semestral',
                'ipcr_Semestral.probationaryTemporaryEmployee',
                'ipcr_Semestral.siblingSemestrals'
            ])
            ->where('ipcr_semestral_id', $sem_id)
            ->where('employee_code', $emp_code)
            ->whereHas('monthlyTargets', function ($query) use ($month_1, $year) {
                $query->where('month', $month_1)
                    ->where('year', $year);
            })
            ->orderBy('pcr_type', 'ASC')
            ->get()
            ->map(function ($item) use($month_1, $emp_code, $year) {
                // dd($month_1, $emp_code, $year);
                // dd($item->monthlyTargets);
                $daily = [];
                // dd($item);
                $ifo = $item->hSPCR;
                if ($item->monthlyTargets) {
                    $daily = $item->monthlyTargets->flatMap(function ($monthly_item) use ($ifo) {
                        // Ensure dailyAccomplishments is a collection before calling map()
                        return $monthly_item->dailyAccomplishments ? $monthly_item->dailyAccomplishments->sortBy('date')->map(function ($daily_item) use ($ifo) {
                            return [
                                "individual_output" => optional($ifo)->output,
                                "description" => optional($daily_item)->description,
                                "date" => optional($daily_item)->date
                            ];
                        }) : collect();
                    });
                }
                $cnt = count($daily);
                $ipcr_semestral = $item->ipcr_Semestral;
                $prob_tempo = optional($ipcr_semestral)->probationaryTemporaryEmployee;


                if($cnt<1){
                    // dd($item->ipcr_Semestral);
                    // dd($prob_tempo, $sem_id);


                    if(optional($ipcr_semestral)->prob_type=='s'){
                        $daily = Daily_Accomplishment::where('sem_id', $item->ipcr_semestral_id)
                                ->whereMonth('date', $month_1)
                                ->whereYear('date', $year)
                                ->where('emp_code', $emp_code)
                                ->where('individual_final_output_id', optional($ifo)->id)
                                ->get()
                                ->map(function($item)use ($ifo) {
                                    return [
                                        "individual_output" => optional($ifo)->output,
                                        "description" => $item->description,
                                        "date" => $item->date
                                    ];
                                });
                    }else{
                        // dd($month_as_is);
                        $date_from_array = json_decode($prob_tempo->date_from, true) ?? [];
                        $date_to_array   = json_decode($prob_tempo->date_to, true) ?? [];
                        $month_index = $month_1-1;
                        // dd($month_index);
                        $date_from = $date_from_array[$month_index];
                        $date_to = $date_to_array[$month_index];
                        $sems=$ipcr_semestral->siblingSemestrals;

                        // dd($date_from, $date_to, $sems->pluck('id'), $emp_code, $ifo);
                        // dd($sems);
                        // dd($sems->pluck('id'));
                        $daily = Daily_Accomplishment::whereIn('sem_id', $sems->pluck('id'))
                            ->whereBetween('date', [$date_from, $date_to])
                            ->where('emp_code', $emp_code)
                            ->where(function($query)use($ifo){
                                $query->where('individual_final_output_id', $ifo->id)
                                ->OrWHere('idHSPCR', $ifo->id);
                            })

                            ->get()
                            ->map(function ($item) use ($ifo) {
                                return [
                                    "individual_output" => optional($ifo)->output,
                                    "description" => $item->description,
                                    "date" => $item->date
                                ];
                            });
                    }

                }
                $cnt = count($daily);
                if($item->pcr_type=='hspcr'){
                    $output = $item->hSPCR ? $item->hSPCR->output : "";
                    $pm = $item->hSPCR ? $item->hSPCR->performance_measure : "";
                    $prescribed_period = $item->hSPCR ? $item->hSPCR->prescribed_period : "";
                    $quality1 = $item->hSPCR ? $item->hSPCR->quality1 : "";
                    $quality2 = $item->hSPCR ? $item->hSPCR->quality2 : "";
                    $quality3 = $item->hSPCR ? $item->hSPCR->quality3 : "";
                    $efficiency1 = $item->hSPCR ? $item->hSPCR->efficiency1 : "";
                    $efficiency2 = $item->hSPCR ? $item->hSPCR->efficiency2 : "";
                    $efficiency3 = $item->hSPCR ? $item->hSPCR->efficiency3 : "";
                    $timeliness = $item->hSPCR ? $item->hSPCR->timeliness : "";
                }else if($item->pcr_type=='hipcr'){
                    $output = $item->hIPCR ? $item->hIPCR->output : "";
                    $pm = $item->hIPCR ? $item->hIPCR->performance_measure : "";
                    $prescribed_period = $item->hIPCR ? $item->hIPCR->prescribed_period : "";
                    $quality1 = $item->hIPCR ? $item->hIPCR->quality1 : "";
                    $quality2 = $item->hIPCR ? $item->hIPCR->quality2 : "";
                    $quality3 = $item->hIPCR ? $item->hIPCR->quality3 : "";
                    $efficiency1 = $item->hIPCR ? $item->hIPCR->efficiency1 : "";
                    $efficiency2 = $item->hIPCR ? $item->hIPCR->efficiency2 : "";
                    $efficiency3 = $item->hIPCR ? $item->hIPCR->efficiency3 : "";
                    $timeliness = $item->hIPCR ? $item->hIPCR->timeliness : "";
                }
                // dd(count($daily));
                // dd($item);
                // if($item->pcr_type)
                return [
                    "type" => $item->type,
                    "ipcr_type" => $item->pcr_type,
                    "sem_id" => $item->ipcr_semestral_id,
                    "idifo" => $item->idHSPCR,
                    "output" => $output,
                    "individual_output" => $output,

                    // $pm = $ifo->performance_measure;
                    "performance_measure" => $pm,
                    "prescribed_period" => $prescribed_period,
                    "quality1" => $quality1,
                    "quality2" => $quality2,
                    "quality3" => $quality3,
                    "efficiency1" => $efficiency1,
                    "efficiency2" => $efficiency2,
                    "efficiency3" => $efficiency3,
                    "timeliness" => $timeliness,
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
        // dd($data, $month_1, $sem_id, $emp_code, $year);
        return $data;
    }
    protected function getHospitalIPCRData($emp_code, $sem_id, $month, $year)
    {
        // dd($month);
        // dd(" emp_code: ".$emp_code." sem_id: ".$sem_id." month: ".$month." year: ".$year);
        // dd(HospitalTarget::with('monthlyTargets')
        //     ->where('ipcr_semestral_id', $sem_id)
        //     // ->whereHas('monthlyTargets', function ($query) use ($month, $year) {
        //     //         $query->where('month', $month)
        //     //             ->where('year', $year);
        //     //     })
        //     ->where('employee_code', $emp_code)->get());
        $month_1=$month;
        if (intval($month) > 6) {
            $month_1 = intval($month) - 6;
        }
        // $dt111=HospitalTarget::with('monthlyTargets')
        //     ->where('ipcr_semestral_id', $sem_id)
        //     // ->whereHas('monthlyTargets', function ($query) use ($month_1, $year) {
        //     //         $query->where('month', $month_1)
        //     //             ->where('year', $year);
        //     //     })
        //     ->where('employee_code', $emp_code)->get();
        // dd($dt111);
        $data=HospitalTarget::with([
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
                    // 'ipcr_Semestral.monthlyAccomplishments',
                    'monthlyTargets' => function ($query) use ($month_1, $year, $sem_id) {
                        $query->where('month', $month_1)
                            ->where('sem_id', $sem_id);
                    },

                    'monthlyTargets.dailyAccomplishments',
                    'hSPCR',
                    'hSPCR.hospitalDivisionOutput',
                    'hSPCR.hospitalDivisionOutput.hospitalOutput',
                    'hSPCR.hospitalDivisionOutput.hospitalOutput.programAndProject',
                    'hSPCR.hospitalDivisionOutput.hospitalOutput.programAndProject.MFO',
                    'ipcr_Semestral',
                    'ipcr_Semestral.probationaryTemporaryEmployee',
                    'ipcr_Semestral.siblingSemestrals'

                ])
                ->where('ipcr_semestral_id', $sem_id)
                ->where('employee_code', $emp_code)
                ->whereHas('monthlyTargets', function ($query) use ($month_1, $year) {
                    $query->where('month', $month_1);
                        // ->where('year', $year);
                })
                ->orderBy('pcr_type', 'ASC')
                ->get()
                ->map(function ($item) use($month_1, $year, $emp_code){
                    // dd($item);
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
                    $ipcr_semestral = $item->ipcr_Semestral;
                    $prob_tempo = optional($ipcr_semestral)->probationaryTemporaryEmployee;
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
                    } else if ($item->pcr_type == "hspcr") {
                        $ifo = $item->hSPCR;
                        // $ifo = $item->hIPCR;
                        $idIFO = $item->idHSPCR;
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
                    }else {
                        // dd($item->pcr_type);
                    }
                    // dd($ifo);
                    // $ifo = $item->hpcr;
                    if ($item->monthlyTargets ){
                        $daily = $item->monthlyTargets->flatMap(function ($monthly_item) use ($ifo, $month_1) {
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

                    if($cnt<1){
                    // dd($item->ipcr_Semestral);
                    // dd($prob_tempo, $sem_id);


                        if(optional($ipcr_semestral)->prob_type=='s'){
                            $daily = Daily_Accomplishment::where('sem_id', $item->ipcr_semestral_id)
                                    ->whereMonth('date', $month_1)
                                    ->whereYear('date', $year)
                                    ->where('emp_code', $emp_code)
                                    ->where('individual_final_output_id', $ifo->id)
                                    ->get()
                                    ->map(function($item)use ($ifo) {
                                        return [
                                            "individual_output" => optional($ifo)->output,
                                            "description" => $item->description,
                                            "date" => $item->date
                                        ];
                                    });
                        }else{
                            // dd($month_as_is);
                            $month_index = $month_1-1;
                            // dd($month_index);
                            // dd($item->ipcr_semestral)
                            $date_from_array = json_decode($prob_tempo->date_from, true) ?? [];
                            $date_to_array   = json_decode($prob_tempo->date_to, true) ?? [];
                            $month_index = collect($date_from_array)->search(function ($date) use ($month_1) {

                                    if (!$date) {
                                        return false;
                                    }

                                    return \Carbon\Carbon::parse($date)->month == $month_1;
                                });
                                // dd($month_index);
                            $date_from = $date_from_array[$month_index];
                            $date_to = $date_to_array[$month_index];

                            $sems=$ipcr_semestral->siblingSemestrals;

                            // dd($date_from, $date_to, $sems->pluck('id'), $emp_code, $ifo);
                            // dd($sems);
                            // dd($sems->pluck('id'));
                            $daily = Daily_Accomplishment::whereIn('sem_id', $sems->pluck('id'))
                                ->whereBetween('date', [$date_from, $date_to])
                                ->where('emp_code', $emp_code)
                                ->where(function($query)use($ifo){
                                    $query->where('individual_final_output_id', $ifo->id)
                                    ->OrWHere('idHIPCR', $ifo->id);
                                })

                                ->get()
                                ->map(function ($item) use ($ifo) {
                                    return [
                                        "individual_output" => optional($ifo)->output,
                                        "description" => $item->description,
                                        "date" => $item->date
                                    ];
                                });
                            // dd($month_1, $month_index, $date_from, $date_to, $daily);
                        }

                    }
                    $cnt = count($daily);
                    // dd(count($daily));
                    return [
                        "id"=>$item->id,
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
        // dd($data->pluck('id'));
        return $data;

    }

}
// HospitalTarget::with([
//     'ipcr',
//     'ipcr.divisionOutput',
//     'ipcr.divisionOutput.programAndProject',
//     'ipcr.divisionOutput.programAndProject.MFO',
//     'hIPCR',
//     'hIPCR.hospitalSectionOutput',
//     'hIPCR.hospitalSectionOutput.hospitalDivisionOutput',
//     'hIPCR.hospitalSectionOutput.hospitalDivisionOutput.hospitalOutput',
//     'hIPCR.hospitalSectionOutput.hospitalDivisionOutput.hospitalOutput.programAndProject',
//     'hIPCR.hospitalSectionOutput.hospitalDivisionOutput.hospitalOutput.programAndProject.MFO',
//     'ipcr_Semestral',
//     'monthlyTargets' => function ($query) use ($month, $year) {
//         $query->where('month', $month)
//             ->where('year', $year);
//     },

//     'monthlyTargets.dailyAccomplishments'
// ])
// ->where('ipcr_semestral_id', $sem_id)
// ->where('employee_code', $emp_code)
// ->whereHas('monthlyTargets', function ($query) use ($month, $year) {
//     $query->where('month', $month)
//         ->where('year', $year);
// })
// ->orderBy('pcr_type', 'ASC')
// ->get()
// ->map(function ($item) {
//     $daily = [];
//     // dd($item);
//     // dd($item);
//     $output = "";
//     $pm = "";
//     $prescribed_period = "";
//     $q1 = "";
//     $q2 = "";
//     $q3 = "";
//     $e1 = "";
//     $e2 = "";
//     $e3 = "";
//     $t1 = "";
//     $idIFO = "";
//     if ($item->pcr_type == "ipcr") {
//         $ifo = $item->ipcr;
//         // dd($item);
//         $idIFO = $item->idIPCR;
//         if ($ifo) {
//             $pm = $ifo->performance_measure;
//             $prescribed_period = $ifo->prescribed_period;
//             $q1 = $ifo->quality1;
//             $q2 = $ifo->quality2;
//             $q3 = $ifo->quality3;
//             $e1 = $ifo->efficiency1;
//             $e2 = $ifo->efficiency2;
//             $e3 = $ifo->efficiency3;
//             $t1 = $ifo->timeliness;
//             $output = $ifo->individual_output;
//         }
//     } else if ($item->pcr_type == "hipcr") {
//         $ifo = $item->hIPCR;
//         $idIFO = $item->idHIPCR;
//         if ($ifo) {
//             $q1 = $ifo->quality1;
//             $q2 = $ifo->quality2;
//             $q3 = $ifo->quality3;
//             $e1 = $ifo->efficiency1;
//             $e2 = $ifo->efficiency2;
//             $e3 = $ifo->efficiency3;
//             $t1 = $ifo->timeliness;
//             $output = $ifo->output;
//             $pm = $ifo->performance_measure;
//             $prescribed_period = $ifo->prescribed_period;
//         }
//     } else {
//         // dd($item->pcr_type);
//     }
//     // dd($ifo);
//     // $ifo = $item->hpcr;
//     if ($item->monthlyTargets) {
//         $daily = $item->monthlyTargets->flatMap(function ($monthly_item) use ($ifo) {
//             // Ensure dailyAccomplishments is a collection before calling map()
//             return $monthly_item->dailyAccomplishments ? $monthly_item->dailyAccomplishments->sortBy('date')->map(function ($daily_item) use ($ifo) {
//                 return [
//                     "individual_output" => $ifo->output,
//                     "description" => $daily_item->description,
//                     "date" => $daily_item->date
//                 ];
//             }) : collect();
//         });
//     }
//     $cnt = count($daily);
//     // dd(count($daily));
//     return [
//         "type" => $item->type,
//         "ipcr_type" => $item->ipcr_type,
//         "sem_id" => $item->ipcr_semestral_id,
//         "idifo" => $idIFO,
//         "output" => $output,
//         "individual_output" => $output,
//         "performance_measure" => $pm,
//         "prescribed_period" => $prescribed_period,
//         "quality1" => $q1,
//         "quality2" => $q2,
//         "quality3" => $q3,
//         "efficiency1" => $e1,
//         "efficiency2" => $e2,
//         "efficiency3" => $e3,
//         "timeliness" => $t1,
//         "monthly_rating_id" => $item->monthlyTargets ? $item->monthlyTargets[0]->id : "",
//         "q1" => $item->monthlyTargets ? ($item->monthlyTargets[0]->q1 ? floatval($item->monthlyTargets[0]->q1) : 0) : "0",
//         "q2" => $item->monthlyTargets ? ($item->monthlyTargets[0]->q2 ? floatval($item->monthlyTargets[0]->q2) : 0) : "0",
//         "q3" => $item->monthlyTargets ? ($item->monthlyTargets[0]->q3 ? floatval($item->monthlyTargets[0]->q3) : 0) : "0",
//         "e1" => $item->monthlyTargets ? ($item->monthlyTargets[0]->e1 ? floatval($item->monthlyTargets[0]->e1) : 0) : "0",
//         "e2" => $item->monthlyTargets ? ($item->monthlyTargets[0]->e2 ? floatval($item->monthlyTargets[0]->e2) : 0) : "0",
//         "e3" => $item->monthlyTargets ? ($item->monthlyTargets[0]->e3 ? floatval($item->monthlyTargets[0]->e3) : 0) : "0",
//         "t1" => $item->monthlyTargets ? ($item->monthlyTargets[0]->t1 ? floatval($item->monthlyTargets[0]->t1) : 0) : "0",
//         "time" => $item->monthlyTargets ? ($item->monthlyTargets[0]->t1 ? floatval($item->monthlyTargets[0]->t1) : 0) : "0",
//         "visible" => intval($cnt) > 0 ? true : false,
//         "daily" => $daily,
//         "count_daily" => $cnt
//     ];
// });
