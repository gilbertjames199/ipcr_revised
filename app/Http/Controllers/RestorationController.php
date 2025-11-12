<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RestorationController extends Controller
{
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
    public function restore_dpcr_targets(Request $request)
    {
        //
    }
    public function restore_hospital_targets(Request $request)
    {
        //
    }
}
