<?php

namespace App\Http\Controllers;

use App\Models\Ipcr_Semestral;
use App\Models\MonthlyAccomplishment;
use App\Models\MonthlyTarget;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
}
