<?php

namespace App\Http\Controllers;

use App\Models\HospitalTarget;
use App\Models\Ipcr_Semestral;
use App\Models\MonthlyAccomplishment;
use App\Models\MonthlyTarget;
use App\Models\IpcrTarget;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RestorationController extends Controller
{
    public function handle()
    {
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '-1'); // optional: remove memory cap
    }
    //
    public function index(Request $request)
    {
        //
    }
    public function restore_ipcr_targets(Request $request)
    {
        $sourceDb='opcr_db_3';
        $prodDb='opcr';
        $semestralMapping = DB::table("{$sourceDb}.ipcr__semestrals as b")
                ->join("{$prodDb}.ipcr__semestrals as p", function($join) {
                    $join->on('b.employee_code', '=', 'p.employee_code')
                        ->on('b.sem', '=', 'p.sem')
                        ->on('b.year', '=', 'p.year');
                })
                ->select('b.id as old_id', 'p.id as new_id')
                ->pluck('new_id', 'old_id');

        $backupTargets = DB::table("{$sourceDb}.ipcr_targets")
            ->whereBetween('created_at', [
                '2025-11-03 00:00:00',
                '2025-11-07 15:15:00'
            ])
            ->get();
        // dd($backupTargets);
        $insertTargets = [];
        $inserted_targets =[];

        foreach ($backupTargets as $target) {
            // dd($target);
            // Skip if slug already exists
            $exists=false;
            if (DB::table("{$prodDb}.ipcr_targets")->where('slug', $target->slug)->exists()) {
                $exists = true;
            }
            // dd($exists, $target);
            $mappedSemId = $semestralMapping[$target->ipcr_semestral_id] ?? null;
            $exists = DB::table("{$prodDb}.ipcr_targets")
                ->where('individual_final_output_id', $target->individual_final_output_id)
                ->where('year', $target->year)
                ->where('ipcr_semestral_id', $mappedSemId)
                ->where('semester', $target->semester)
                ->exists();

            if ($exists) {$exists = true;};
            // dd($exists);
            if(!$exists){
                 $insertTargets[] = [
                    'ipcr_semestral_id' => $semestralMapping[$target->ipcr_semestral_id] ?? null,
                    'individual_final_output_id' => $target->individual_final_output_id,
                    'ipcr_type' => $target->ipcr_type,
                    'employee_code' => $target->employee_code,
                    'is_additional_target' => $target->is_additional_target,
                    'semester' => $target->semester,
                    'year' => $target->year,
                    'status' => $target->status,
                    'remarks' => $target->remarks,
                    'identifier' => $target->identifier,
                    'slug' => $target->slug,
                    'idDPCR' => $target->idDPCR,
                    'deleted_at' => $target->deleted_at,
                    'created_at' => $target->created_at,
                    'updated_at' => $target->updated_at,
                ];
                $inserted_targets[] = $target->slug;
                // try{
                //     DB::table("{$prodDb}.ipcr_targets")->insert($insertTargets);
                // } catch (\Exception $e) {
                //     dd('Error inserting target with slug: ' . $target->slug . '. Error: ' . $e->getMessage());
                // }
                // DB::table("{$prodDb}.ipcr_targets")->insert($insertTargets);
                array_push($inserted_targets, $insertTargets);
            }
            else{
                continue; // Skip to next iteration if exists
            }

        }
        if (!empty($insertTargets)) {
            try {
                DB::table("{$prodDb}.ipcr_targets")->insert($insertTargets);
            } catch (\Exception $e) {
                dd('Error inserting targets: ' . $e->getMessage());
            }
        }
        dd($inserted_targets);
    }
    public function restore_ipcr_semestral(Request $request)
    {
        $backupDb =  'ipcr_restored'; // backup database
        $prodDb   =  'opcr_testing';         // production database

        // Step 1: Get all ipcr__semestrals from backup created between Nov 3 → Nov 7 3:15PM
        $backupSemestrals = DB::table("{$backupDb}.ipcr__semestrals")
            ->whereBetween('created_at', [
                '2025-11-03 00:00:00',
                '2025-11-07 15:15:00'
            ])
            ->get();

        $insertableSemestrals = [];

        foreach ($backupSemestrals as $semestral) {
            // Step 2: Check if the same semestral exists in prod_db
            $exists = DB::table("{$prodDb}.ipcr__semestrals")
                ->where('employee_code', $semestral->employee_code)
                ->where('sem', $semestral->sem)
                ->where('year', $semestral->year)
                ->exists();

            // If it does NOT exist, add it to insert array
            if (!$exists) {
                $insertableSemestrals[] = [
                    'employee_code' => $semestral->employee_code,
                    'sem' => $semestral->sem,
                    'year' => $semestral->year,
                    'created_at' => $semestral->created_at,
                    'updated_at' => $semestral->updated_at,
                    // Add other columns if needed
                ];
            }
        }

        // Step 3: Insert into prod_db
        if (!empty($insertableSemestrals)) {
            DB::table("{$prodDb}.ipcr__semestrals")->insert($insertableSemestrals);
        }

        // Step 4: dd all backup semestrals
        dd($backupSemestrals);
    }

    // $backupDb =  'opcr_db_3'; // backup database
    //         $prodDb   =  'opcr';
    public function restore_ipcr_hospital_targets(Request $request)
    {
        // Database names
            $backupDb = env('BACKUP_DB', 'ipcr_restored'); // backup database
            $prodDb   = env('PROD_DB', 'prod_db');         // production database
            $backupDb =  'opcr_db_3'; // backup database
            $prodDb   =  'opcr';         // production database
            // Step 0: semestral mapping from backup to prod (same as for ipcr_targets)
            $semestralMapping = DB::table("{$backupDb}.ipcr__semestrals as b")
                ->join("{$prodDb}.ipcr__semestrals as p", function($join) {
                    $join->on('b.employee_code', '=', 'p.employee_code')
                        ->on('b.sem', '=', 'p.sem')
                        ->on('b.year', '=', 'p.year');
                })
                ->select('b.id as old_id', 'p.id as new_id')
                ->pluck('new_id', 'old_id');

            // Step 1: Get hospital_targets from backup between Nov 3 → Nov 7 3:15 PM
            $backupHospitalTargets = DB::table("{$backupDb}.hospital_targets")
                ->whereBetween('created_at', [
                    '2025-11-03 00:00:00',
                    '2025-11-07 15:15:00'
                ])
                ->get();

            $insertTargets = [];
            $inserted_targets = [];

            foreach ($backupHospitalTargets as $target) {

                // Map semestral ID to prod
                $mappedSemId = $semestralMapping[$target->ipcr_semestral_id] ?? null;
                if (!$mappedSemId) continue; // skip if mapping missing

                // Skip if slug already exists OR combination exists
                $exists = DB::table("{$prodDb}.hospital_targets")
                    ->where('slug', $target->slug)
                    ->orWhere(function($query) use ($target, $mappedSemId) {
                        $query->where('ipcr_semestral_id', $mappedSemId)
                            ->where('idIPCR', $target->idIPCR)
                            ->where('semester', $target->semester)
                            ->where('year', $target->year)
                            ->where('type', $target->type);
                    })
                    ->exists();

                if ($exists) continue;

                // Prepare row for bulk insert
                $insertTargets[] = [
                    'ipcr_semestral_id' => $mappedSemId,
                    'idIPCR' => $target->idIPCR,
                    'idDPCR' => $target->idDPCR,
                    'idHIPCR' => $target->idHIPCR,
                    'idHSPCR' => $target->idHSPCR,
                    'idHDPCR' => $target->idHDPCR,
                    'idHPCR' => $target->idHPCR,
                    'type' => $target->type,
                    'employee_code' => $target->employee_code,
                    'is_additional_target' => $target->is_additional_target,
                    'semester' => $target->semester,
                    'year' => $target->year,
                    'status' => $target->status,
                    'remarks' => $target->remarks,
                    'identifier' => $target->identifier,
                    'slug' => $target->slug,
                    'pcr_type' => $target->pcr_type,
                    'deleted_at' => $target->deleted_at,
                    'created_at' => $target->created_at,
                    'updated_at' => $target->updated_at,
                ];

                // Track inserted slugs for debugging
                $inserted_targets[] = $target->slug;
            }

            // Step 2: Bulk insert missing rows
            if (!empty($insertTargets)) {
                try {
                    DB::table("{$prodDb}.hospital_targets")->insert($insertTargets);
                } catch (\Exception $e) {
                    dd('Error inserting hospital_targets: ' . $e->getMessage());
                }
            }

            // Step 3: Debug inserted slugs
            dd($inserted_targets);

    }
    public function restore_dpcr_targets(Request $request)
    {
        //
    }
    public function restore_hospital_targets(Request $request)
    {
        //
    }


    // public function restore_monthly_targets_ipcr(Request $request)
    // {

    // }


    public function monthly_targets_restore1(Request $request)
    {
        $backupDb = 'ipcr_restored';
        $prodDb = 'opcr_testing';

        // Step 1: Get all backup monthly_targets updated within the specified time range
        $backupTargets = DB::table("{$backupDb}.monthly_targets")
            ->select('id', 'ipcr_target_id', 'sem_id', 'q1', 'q2', 'q3', 'e1', 'e2', 'e3', 't1', 'updated_at')
            ->whereBetween('updated_at', [
                '2025-11-03 00:00:00',
                '2025-11-07 15:15:00'
            ])
            ->where(function ($query) {
                $query->whereNotNull('q1')
                    ->orWhereNotNull('q2')
                    ->orWhereNotNull('q3')
                    ->orWhereNotNull('e1')
                    ->orWhereNotNull('e2')
                    ->orWhereNotNull('e3')
                    ->orWhereNotNull('t1');
            })
            ->get();
        // dd($backupTargets);

        // Step 2: Loop through and update corresponding rows in production DB
        $updatedCount = 0;

        foreach ($backupTargets as $target) {
            // Find the matching record in prod
            $prodTarget = DB::table("{$prodDb}.monthly_targets")
                ->where('ipcr_target_id', $target->ipcr_target_id)
                ->where('sem_id', $target->sem_id)
                ->first();

            if (!$prodTarget) continue; // Skip if no matching record

            // Skip if production record was updated after Nov 7, 2025 15:15
            if ($prodTarget->updated_at > '2025-11-07 15:15:00') {
                continue;
            }

            // Update the q/e/t columns based on backup values
            DB::table("{$prodDb}.monthly_targets")
                ->where('ipcr_target_id', $target->ipcr_target_id)
                ->where('sem_id', $target->sem_id)
                ->update([
                    'q1' => $target->q1,
                    'q2' => $target->q2,
                    'q3' => $target->q3,
                    'e1' => $target->e1,
                    'e2' => $target->e2,
                    'e3' => $target->e3,
                    't1' => $target->t1,
                    'updated_at' => now(), // optional: record sync time
                ]);

            $updatedCount++;
        }

        dd("Updated {$updatedCount} monthly_targets in {$prodDb}");
    }

    public function monthly_targets_restore(Request $request)
    {
        $backupDb = 'ipcr_restored';
        $prodDb = 'opcr_testing';
        $updatedCount = 0;
        DB::table("{$backupDb}.monthly_targets")
        ->select('ipcr_target_id', 'sem_id', 'q1', 'q2', 'q3', 'e1', 'e2', 'e3', 't1', 'updated_at')
        ->whereBetween('updated_at', [
            '2025-11-03 00:00:00',
            '2025-11-07 15:15:00'
        ])
        ->where(function ($query) {
            $query->whereNotNull('q1')
                ->orWhereNotNull('q2')
                ->orWhereNotNull('q3')
                ->orWhereNotNull('e1')
                ->orWhereNotNull('e2')
                ->orWhereNotNull('e3')
                ->orWhereNotNull('t1');
        })
        ->orderBy('id')
        ->chunk(200, function ($backupTargets) use (&$updatedCount, $prodDb) {
            foreach ($backupTargets as $target) {
                $prodTarget = DB::table("{$prodDb}.monthly_targets")
                    ->where('ipcr_target_id', $target->ipcr_target_id)
                    ->where('sem_id', $target->sem_id)
                    ->first();

                if (!$prodTarget) continue;

                // Skip if production record was updated after Nov 7, 2025 15:15
                if ($prodTarget->updated_at > '2025-11-07 15:15:00') {
                    continue;
                }

                DB::table("{$prodDb}.monthly_targets")
                    ->where('ipcr_target_id', $target->ipcr_target_id)
                    ->where('sem_id', $target->sem_id)
                    ->update([
                        'q1' => $target->q1,
                        'q2' => $target->q2,
                        'q3' => $target->q3,
                        'e1' => $target->e1,
                        'e2' => $target->e2,
                        'e3' => $target->e3,
                        't1' => $target->t1,
                        'updated_at' => now(),
                    ]);

                $updatedCount++;
            }
        });
    }

    public function restore_monthly_targets_ipcr($sem, $year, $sem_id, $ipcr_target_id){
        $id=$ipcr_target_id;
        $months = ['1', '2', '3', '4', '5', '6'];
        foreach ($months as $month) {
            $month_param = ($sem == 1) ? $month : $month + 6;
            $slug = $this->slugMonthly($month_param, $year);

            $existingRecord = MonthlyTarget::where('month', $month)
                ->where('ipcr_target_id', $id)
                ->first();

            if (!$existingRecord) {
                MonthlyTarget::create([
                    'month' => $month,
                    'year' => $year,
                    'sem_id' => $sem_id,
                    'status' => '-1',
                    'ipcr_target_id' => $id,
                    'type' => 'ipcr',
                    'slug' => $slug // Save the unique slug
                ]);
            }
        }
    }
    public function generateMonthlyTargetRatings($sem, $year, $sem_id, $request, $type, $data_id)
    {

        //used as index
        $mo = "not generated";
        $mo_track = 0;
        $months = ['1', '2', '3', '4', '5', '6'];
        foreach ($months as $month) {
            $month_param = ($sem == 1) ? $month : $month + 6;
            $slug = $this->slugMonthly($month_param, $year);

            $existingRecord = MonthlyTarget::where('month', $month)
                ->when($request->idHPCR, function ($query) use ($request) {
                    $query->where('idHPCR', $request->idHPCR);
                })
                // ->when($request->idIPCR, function ($query) use ($request) {
                //     $query->where('idIPCR', $request->idIPCR);
                // })
                // ->when($request->idDPCR, function ($query) use ($request) {
                //     $query->where('idDPCR', $request->idDPCR);
                // })
                ->when($request->idHIPCR, function ($query) use ($request) {
                    $query->where('idHIPCR', $request->idHIPCR);
                })
                ->when($request->idHSPCR, function ($query) use ($request) {
                    $query->where('idHSPCR', $request->idHSPCR);
                })
                ->when($request->idHDPCR, function ($query) use ($request) {
                    $query->where('idHDPCR', $request->idHDPCR);
                })
                ->where('hospital_target_id', $data_id)
                ->where('year', $year)
                ->where('sem_id', $sem_id)
                ->first();
            $is_hospital = '1';
            if ($request->ipcr_target_id || $request->dpcr_target_id) {
                $is_hospital = '0';
            }
            if (!$existingRecord) {
                MonthlyTarget::create([
                    'month' => $month,
                    'year' => $year,
                    'sem_id' => $sem_id,
                    'status' => '-1',
                    'dpcr_target_id' => $request->idDPCR,
                    "ipcr_target_id" => $request->idIPCR,
                    'idHPCR' => $request->idHPCR,
                    'idHSPCR' => $request->idHSPCR,
                    'idHDPCR' => $request->idHDPCR,
                    'idHIPCR' => $request->idHIPCR,
                    'hospital_target_id' => $data_id,
                    'is_hospital' => $is_hospital,
                    'slug' => $slug, // Save the unique slug
                    'type' => $type,
                ]);
            }

            $mo_track += 1;
        }
        if ($mo_track > 1) {
            $mo = "generated";
        }
        return $mo;
    }
    public function generateMonthlyAccomplishmentsStatus($sem, $year, $ipcr_m_id){
        $months = ($sem == 1) ? ['1', '2', '3', '4', '5', '6'] : ['7', '8', '9', '10', '11', '12'];
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
    }

    public function generateMissingMonthlyAccomplishments()
    {
        // dd(DB::connection()->getDatabaseName());
        // Get all semestrals that do not have all 6 monthly accomplishments
        $semestrals = Ipcr_Semestral::withCount('monthlyAccomplishments')
            ->having('monthly_accomplishments_count', '<', 6)
            ->where('deleted_at', null)
            ->get();

        $now = now();
        $insertData = [];

        foreach ($semestrals as $sem) {
            // Determine months based on semester
            $months = $sem->sem == 1 ? range(1, 6) : range(7, 12);

            // Get existing months for this semestral
            $existingMonths = $sem->monthly_accomplishment
                ->pluck('month')
                ->toArray();

            foreach ($months as $month) {
                // Only insert if this month does not exist
                if (!in_array($month, $existingMonths)) {
                    $insertData[] = [
                        'month' => $month,
                        'year' => $sem->year,
                        'ipcr_semestral_id' => $sem->id,
                        'status' => '-1',
                        'created_at' => $now,
                        'updated_at' => $now,
                    ];
                }
            }
        }

        if (!empty($insertData)) {
            // Bulk insert missing records
            MonthlyAccomplishment::insert($insertData);
        }

        return response()->json([
            'message' => 'Monthly accomplishments generated successfully.',
            'count' => count($insertData),
        ]);
    }

    public function checkOrRestoreHospitalMonthlyTargets(Request $request)
    {
        //
        // dd(DB::connection()->getDatabaseName());
        // HospitalTarget::get();
        // MonthlyTarget::get();

        // $incomplete = HospitalTarget::with('monthlyTargets')
        //     ->where('year', 2025)
        //     ->where('semester', 1) // or 2 for second semester
        //     ->whereHas('monthlyTargets', function ($query) {
        //         $query->whereNull('id'); // This condition will never be true, effectively filtering for those without monthly targets
        //     })
        //     ->get()
        //     ->map(function($item){
        //         return [
        //             'hospital_targets'=>$item,
        //             'monthly_targets'=>$item->monthlyTargets,
        //             'monthly_target_count'=> $item->monthlyTargets->count(),
        //         ];
        //     });
        $incomplete =HospitalTarget::with('monthlyTargets')
            ->where('year', 2025)
            ->where('semester', 2) // or 2 for second semester
            ->get()
                ->map(function($item){
                    return [
                        'hospital_targets'=>$item,
                        'monthly_targets'=>$item->monthlyTargets,
                        'id'=>$item->id,
                        'ipcr_semestral_id'=>$item->ipcr_semestral_id,
                        'monthly_target_count'=> $item->monthlyTargets->count(),
                    ];
            })
            ->filter(function ($item) {
                    return $item['monthly_target_count'] < 6;
                })
                ->values();


        // foreach ($incomplete as $item) {

        //     $hospital = $item['hospital_targets'];       // parent HospitalTarget model
        //     $existingMonths = $item['monthly_targets']   // child MonthlyTarget models
        //                         ->pluck('month')
        //                         ->toArray();

        //     // Generate missing months 1–6
        //     for ($month = 1; $month <= 6; $month++) {

        //         // If this month already exists for this hospital_target_id — skip
        //         if (in_array($month, $existingMonths)) {
        //             continue;
        //         }

        //         // Insert the monthly target
        //         MonthlyTarget::create([
        //             'month'              => $month,
        //             'year'               => $hospital->year,                // inherit
        //             'hospital_target_id' => $hospital->id,                  // inherit
        //             'sem_id'             => $hospital->ipcr_semestral_id,  // inherit

        //             // OPTIONAL inherited fields — use if needed
        //             'ipcr_target_id'     => $hospital->idIPCR,
        //             'dpcr_target_id'     => $hospital->idDPCR,
        //             'idHIPCR'            => $hospital->idHIPCR,
        //             'idHSPCR'            => $hospital->idHSPCR,
        //             'idHDPCR'            => $hospital->idHDPCR,
        //             'idHPCR'             => $hospital->idHPCR,

        //             'is_hospital'        => 1,
        //             'type'               => $hospital->type,
        //             'status'             => -1,
        //             'slug'               => uniqid('mtrg_'),
        //         ]);
        //     }
        // }
        $formatted = '(' . $incomplete->pluck('id')->implode(', ') . ')';
        dd($formatted,DB::connection()->getDatabaseName(), $incomplete->pluck('deleted_at'),$incomplete,$incomplete->pluck('ipcr_semestral_id')->unique()->values(), $incomplete->pluck('monthly_target_count'));
    }

    public function generateMonthlyTargets(){
        // dd("generate monthylsdfdsfsaaaaaaaaaaaaaaadf");
        $ids=[46911, 45227, 48748, 48074, 47984, 45095, 48820, 47667, 47445, 45264, 48117, 47690, 48747, 46740, 47509, 45200, 45994, 47536, 47750, 47549, 45142, 46428, 43844, 47965, 47656, 46044, 47534, 46016, 47464, 47159, 46058, 46518, 47948, 48715, 47543, 48846, 39960, 47556, 47739, 49743, 45718, 48929, 47649, 47675, 47553, 48279, 47078, 46774, 47700, 47375, 48619, 48803, 48549, 47492, 47517, 46135, 46066, 49455, 47376, 47642, 47919, 49098, 48579, 45232, 47747, 47594, 45874, 47545, 45841, 48776, 48545, 48819, 47725, 46834, 47498, 48559, 45954, 47418, 45245, 46421, 49447, 47707, 45944, 48845, 47564, 48558, 46986, 47982, 47693, 47610, 47601, 47428, 47661, 47757, 46161, 46899, 47686, 48040, 46657, 47721, 47743, 47726, 47963, 47533, 46061, 47586, 48900, 49755, 47671, 45102, 47539, 47550, 46517, 46641, 48687, 49451, 47477, 47527, 47588, 47722, 45279, 49655, 45388, 46018, 46425, 49441, 46746, 44989, 48746, 45815, 46015, 47425, 47081, 47602, 48562, 47441, 47758, 47616, 47220, 47738, 48018, 48751, 47613, 47901, 39030, 47639, 47448, 48727, 47622, 47786, 36804, 48048, 48756, 47415, 47916, 47571, 47663, 47631, 48551, 48542, 46085, 45282, 49434, 46396, 47623, 49313, 47353, 47424, 48940, 48120, 49002, 47694, 48087, 47727, 47652, 47573, 47578, 47741, 47643, 48081, 45334, 48183, 45504, 48817, 47472, 46451, 47640, 45193, 46001, 47115, 47713, 45995, 45149, 49505, 47466, 48548, 46397, 27539, 47516, 48063, 46773, 48556, 48710, 47712, 46778, 48085, 2546, 48721, 47511, 47515, 48935, 47650, 47641, 45316, 49279, 47540, 48714, 48712, 47331, 47584, 47968, 48829, 47462, 46776, 47479, 4, 47697, 47634, 46320, 48001, 47966, 46294, 47471, 47489, 47580, 47381, 49548, 47657, 47351, 48067, 43843, 47405, 47762, 47500, 48852, 46056, 47632, 47755, 47946, 47692, 49317, 48936, 47513, 43853, 47969, 47373, 47658, 48168, 47217, 31227, 46074, 47729, 48750, 47677, 48743, 49061, 48822, 9, 46273, 47449, 39048, 46853, 47510, 47468, 45976, 47620, 47744, 49316, 48084, 47453, 47689, 47618, 46445, 48911, 45387, 47599, 48864, 47577, 47887, 32192, 48113, 47967, 46655, 46111, 47499, 48034, 45991, 47490, 46403, 47896, 47635, 47524, 45190, 45634, 48174, 47706, 47560, 47118, 47079, 46019, 45273, 47447, 47398, 47597, 47437, 48998, 35157, 47665, 47705, 47218, 47306, 46000, 47699, 36795, 42790, 48110, 46225, 48716, 47797, 49453, 47485, 46232, 49205, 49732, 47475, 47972, 47417, 47926, 48017, 47781, 48122, 48767, 47660, 47605, 46121, 48624, 45846, 47629, 48996, 48550, 47374, 47593, 48713, 45989, 47970, 45445, 48847, 48022, 47422, 49508, 47456, 47470, 47222, 49442, 48744, 45560, 47403, 47478, 47523, 48457, 46874, 48083, 47709, 47695, 47458, 46227, 46967, 47473, 45097, 45179, 47708, 47682, 47873, 47753, 47745, 46617, 48114, 45101, 47674, 47488, 46908, 46877, 47960, 2543, 6, 46869, 45259, 45993, 47460, 47603, 31229, 47718, 48844, 47647, 45951, 47429, 46055, 8, 48730, 45185, 49808, 46422, 45218, 45987, 47719, 46012, 47685, 47862, 47956, 47879, 47646, 48033, 48837, 48039, 47679, 48981, 47538, 45893, 48724, 47433, 47421, 47566, 47542, 47698, 47670, 47737, 47751, 47467, 47400, 47495, 46131, 47927, 47446, 46060, 49294, 46537, 2545, 47754, 47591, 47749, 47565, 46221, 49354, 47568, 47463, 46777, 47651, 42524, 47592, 46095, 47442, 47668, 47724, 47450, 49314, 45645, 48726, 46086, 48897, 48717, 45441, 47502, 47666, 43856, 46116, 48170, 47717, 47676, 47606, 45816, 47796, 48246, 5, 47664, 47687, 49122, 47645, 46665, 45860, 45767, 46541, 47654, 48568, 47435, 10, 48546, 47703, 45297, 48863, 47626, 46661, 47423, 48728, 47451, 46013, 47710, 47440, 45939, 47555, 47434, 47736, 47465, 47525, 45261, 48856, 47480, 47406, 47659, 48768, 47361, 47633, 47508, 47520, 47624, 47567, 36798, 47734, 45449, 47793, 47691, 47493, 47552, 48557, 43846, 49444, 45249, 47487, 47436, 47531, 47535, 47746, 48752, 46003, 46144, 47702, 47522, 49172, 47600, 45187, 48003, 48955, 48753, 41516, 47756, 47688, 47404, 45246, 46073, 48732, 47711, 44763, 48923, 47420, 35139, 48749, 47964, 48082, 49688, 47368, 46678, 48070, 46412, 45247, 45877, 46838, 47890, 47619, 47414, 49014, 46355, 47672, 49195, 47684, 45390, 47918, 47574, 49562, 47111, 47582, 47983, 47426, 47452, 47761, 45338, 48755, 47402, 45391, 45990, 46092, 49564, 47372, 49506, 47587, 49315, 47662, 47544, 47377, 45584, 49439, 47113, 48711, 48112, 48831, 47590, 49445, 47399, 47554, 47563, 46382, 46020, 47637, 47431, 47416, 45354, 45285, 47496, 47733, 46053, 47174, 46429, 47432, 45442, 46222, 48540, 49010, 45876, 46879, 47723, 47899, 46735, 48004, 46912, 47636, 45229, 47546, 47551, 47572, 45845, 46420, 46424, 47604, 47607, 47223, 47455, 47760, 46011, 46675, 47371, 48121, 47530, 48723, 47430, 47912, 45556, 47891, 47701, 46430, 27416, 47589, 47454, 47558, 48191, 47311, 49114, 47547, 48854, 47735, 47579, 48919, 45806, 47638, 47491, 47575, 46374, 47106, 46036, 48840, 47562, 46427, 47459, 43842, 47561, 47759, 46984, 31239, 46177, 48719, 48823, 45875, 48118, 47696, 36796, 45389, 46054, 45988, 47585, 48552, 47614, 45105, 48812, 48090, 47716, 47364, 48742, 47401, 47576, 47953, 49640, 46033, 47615, 49628, 45977, 47669, 46023, 47630, 48722, 47457, 45992, 47598, 45963, 47975, 47497, 48824, 47532, 47439, 47673, 46536, 47529, 48934, 41519, 47512, 47514, 47537, 46686, 47731, 47730, 47443, 48860, 45284, 32186, 47482, 47476, 49297, 47732, 44980, 47648, 45248, 46004, 47976, 47427, 49754, 47569, 47444, 46426, 48789, 47740, 47653, 47611, 47683, 46279, 48020, 47559, 49635, 47742, 47627, 45230, 48718, 47608, 47521, 47519, 45833, 47748, 48745, 45395, 48212, 47469, 49319, 45308, 47438, 47518, 45986, 47596, 48124, 46089, 47221, 47628, 48725, 45328, 45567, 47349, 47526, 44761, 48729, 47728, 47681, 46775, 45265, 46117, 47704, 47955, 47494, 46354, 47595, 49741, 47541, 47187, 46087, 48019, 49036, 47625, 47080, 47715, 44992, 47973, 49233, 47484, 47528, 46090, 47570, 47644, 47419, 46562, 46565, 47655, 46129, 47483, 47413, 47481, 48896, 46014, 47219, 45947, 46612, 47461, 7, 47557, 46423, 47621, 47720, 47617, 47583, 47486, 47752, 49560, 47680, 47612, 48547, 42450, 49361, 47714, 47609, 44762, 47548, 46088, 48008, 30544, 47474, 47104, 47581, 45258, 47678
        ];
        $targets = IpcrTarget::whereIn('id', $ids)->get();
        foreach ($targets as $target) {
            for ($month = 1; $month <= 6; $month++) {

                // Generate a slug: month-year-randomSixLetters
                do {
                    $slug = $month . '-' . $target->year . '-' . Str::random(6);
                } while (MonthlyTarget::where('slug', $slug)->exists());

                MonthlyTarget::create([
                    'month'            => $month,
                    'year'             => $target->year,
                    'ipcr_target_id'   => $target->id,
                    'dpcr_target_id'   => $target->idDPCR ?? null,
                    'hospital_target_id'=> null, // if applicable
                    'idHIPCR'          => null,  // if applicable
                    'idHSPCR'          => null,
                    'idHDPCR'          => null,
                    'idHPCR'           => null,
                    'is_hospital'      => 0,     // default
                    'sem_id'           => $target->ipcr_semestral_id,
                    'slug'             => $slug,
                    'type'             => -1,
                    'status'           => $target->status ?? 1,
                    'created_at'       => now(),
                    'updated_at'       => now(),
                ]);
            }
        }
        return $targets;
    }
}
