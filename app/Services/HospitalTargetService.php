<?php

namespace App\Services;

use App\Models\HospitalTarget;
use App\Models\MonthlyTarget;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class HospitalTargetService
{
    public function store(
        $ipcr_semestral_id,
        $employee_code,
        $type,
        $pcr_type,
        $idHIPCR,
        $idHDPCR,
        $idHSPCR,
        $idHPCR,
        $idIPCR,
        $idDPCR,
        $is_additional_target,
        $id,
        $ifo_desc,
        $semester,
        $year,
        $status,
        $remarks,
        $identifier,
        $ipcr_target_id,
        $dpcr_target_id,
        $month_data,
        $prob_type
    ) {
        // dd(auth()->user()->id);
        // $user_type = employee_division_head($request->employee_code);

        $this->storeHPCR(
            $ipcr_semestral_id,
            $employee_code,
            $type,
            $pcr_type,
            $idHIPCR,
            $idHDPCR,
            $idHSPCR,
            $idHPCR,
            $idIPCR,
            $idDPCR,
            $is_additional_target,
            $id,
            $ifo_desc,
            $semester,
            $year,
            $status,
            $remarks,
            $identifier,
            $ipcr_target_id,
            $dpcr_target_id,
            $month_data,
            $prob_type
        );
        // if ($is_additional_target == 1) {
        //     return redirect('/ipcrsemestral/' . auth()->user()->id . '/direct')
        //         ->with('success', 'HPCR Additional Target created successfully');
        // }

        // return redirect('/hospital-targets/r/' . $request->slug_sem);
        // }
    }
    public function storeHPCR(
        $ipcr_semestral_id,
        $employee_code,
        $type,
        $pcr_type,
        $idHIPCR,
        $idHDPCR,
        $idHSPCR,
        $idHPCR,
        $idIPCR,
        $idDPCR,
        $is_additional_target,
        $id,
        $ifo_desc,
        $semester,
        $year,
        $status,
        $remarks,
        $identifier,
        $ipcr_target_id,
        $dpcr_target_id,
        $month_data,
        $prob_type
    ) {
        // dd($request);

        $slug = $this->generateSlugPCR($ifo_desc, $semester, $year);
        $data = new HospitalTarget();
        $data->ipcr_semestral_id = $ipcr_semestral_id;
        $data->idHPCR = $idHPCR;
        $data->type = $type;
        $data->employee_code = $employee_code;
        $data->is_additional_target = $is_additional_target;
        $data->semester = $semester;
        $data->year = $year;
        $data->status = $status;
        $data->remarks = $remarks;
        $data->slug = $slug;
        //INDIVIDUAL
        if ($pcr_type === 'hipcr') {
            $data->idHIPCR = $idHIPCR;
            $data->pcr_type = 'hipcr';
        }
        // HOSPITAL INDIVIDUAL
        if ($pcr_type === 'ipcr') {
            $data->idIPCR = $idIPCR;
            $data->pcr_type = 'ipcr';
        }
        //SECTION
        if ($pcr_type === 'hspcr') {
            $data->idHSPCR = $idHSPCR;
            $data->pcr_type = 'hspcr';
        }
        //HOSPITAL DIVISION
        if ($pcr_type === 'hdpcr') {
            $data->idHDPCR = $idHDPCR;
            $data->pcr_type = 'hdpcr';
        }
        //DIVISION
        if ($pcr_type === 'dpcr') {
            $data->idDPCR = $idDPCR;
            $data->pcr_type = 'dpcr';
        }
        //HOSPITAL
        if ($pcr_type === 'hpcr') {
            $data->idHPCR = $idHPCR;
            $data->pcr_type = 'hpcr';
        }

        $data->identifier = $identifier;
        $data->save();

        $mo_rat = $this->generateMonthlyTargetRatings(
            $semester,
            $year,
            $ipcr_semestral_id,
            $pcr_type,
            $data->id,
            $idHIPCR,
            $idHDPCR,
            $idHSPCR,
            $idHPCR,
            $idIPCR,
            $idDPCR,
            $ipcr_target_id,
            $dpcr_target_id,
            $month_data,
            $prob_type
        );
        // dd($mo_rat);
        // if (intval($request->is_additional_target) > 0) {
        //     return redirect('/ipcrsemestral/r/' . auth()->user()->id . '/direct')
        //         ->with('success', 'HPCR Additional Target created successfully');
        // }

    }
    // public function redirector
    public function generateSlugPCR($desc, $sem, $year)
    {
        //GENERATE SLUG
        $random = Str::random(14);
        $append = substr(preg_replace('/[^a-z1-3]/', '', $random), 0, 7);
        $desc = Str::limit($desc, 100, '');
        $slugBase = Str::slug($desc . '-' . $append . '-' . $sem . '-' . $year);
        $slug = $slugBase;

        $existingSlugs = DB::table('hospital_targets')
            ->where('slug', 'LIKE', $slugBase . '%')
            ->pluck('slug')
            ->toArray();

        if (in_array($slug, $existingSlugs)) {
            do {
                $random = Str::random(20);
                $append = substr(preg_replace('/[^a-z1-3]/', '', $random), 0, 10);
                $slug = $slugBase . '-' . $append;
            } while (in_array($slug, $existingSlugs));
        }

        return $slug;
    }

    public function generateMonthlyTargetRatings(
        $sem,
        $year,
        $sem_id,
        $type,
        $data_id,
        $idHIPCR,
        $idHDPCR,
        $idHSPCR,
        $idHPCR,
        $idIPCR,
        $idDPCR,
        $ipcr_target_id,
        $dpcr_target_id,
        $month_data,
        $prob_type
    ) {

        //used as index
        $mo = "not generated";
        $mo_track = 0;
        // $months = ['1', '2', '3', '4', '5', '6'];
        $months=[];
        if($prob_type=='s'){
            $months = ['1', '2', '3', '4', '5', '6'];
        }else{
            $months=$month_data;
        }
        foreach ($months as $month) {
            $month_param = ($sem == 1) ? $month : $month + 6;
            $slug = $this->slugMonthly($month_param, $year);

            $existingRecord = MonthlyTarget::where('month', $month)
                ->when($idHPCR, function ($query) use ($idHPCR) {
                    $query->where('idHPCR', $idHPCR);
                })
                // ->when($request->idIPCR, function ($query) use ($request) {
                //     $query->where('idIPCR', $request->idIPCR);
                // })
                // ->when($request->idDPCR, function ($query) use ($request) {
                //     $query->where('idDPCR', $request->idDPCR);
                // })
                ->when($idHIPCR, function ($query) use ($idHIPCR) {
                    $query->where('idHIPCR', $idHIPCR);
                })
                ->when($idHSPCR, function ($query) use ($idHSPCR) {
                    $query->where('idHSPCR', $idHSPCR);
                })
                ->when($idHDPCR, function ($query) use ($idHDPCR) {
                    $query->where('idHDPCR', $idHDPCR);
                })
                ->where('hospital_target_id', $data_id)
                ->where('year', $year)
                ->where('sem_id', $sem_id)
                ->first();
            $is_hospital = '1';
            // if ($ipcr_target_id || $dpcr_target_id) {
            //     $is_hospital = '0';
            // }
            if (!$existingRecord) {
                MonthlyTarget::create([
                    'month' => $month,
                    'year' => $year,
                    'sem_id' => $sem_id,
                    'status' => '-1',
                    'dpcr_target_id' => $type == 'dpcr' ? $idDPCR : null,
                    "ipcr_target_id" => $type == 'ipcr' ? $idIPCR : null,
                    'idHPCR' => $idHPCR,
                    'idHSPCR' => $idHSPCR,
                    'idHDPCR' => $type == 'hdpcr' ? $idHDPCR : null,
                    'idHIPCR' => $type == 'hipcr' ? $idHIPCR : null,
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
    public function slugMonthly($month, $year)
    {
        // Convert month number to month name
        $monthName = date('F', mktime(0, 0, 0, $month, 1));

        // Base slug
        $baseSlug = Str::slug($monthName . '-' . $year);
        $random = Str::random(7 * 2);
        $append = substr(preg_replace('/[^a-z1-3]/', '', $random), 0, 7);
        $slug = $baseSlug . '-' . $append;

        // Ensure slug is unique
        while (MonthlyTarget::where('slug', $slug)->exists()) {
            $random = Str::random(10 * 2);
            $append = substr(preg_replace('/[^a-z1-3]/', '', $random), 0, 10);
            // if ($count > 1) {
            $slug = $baseSlug . '-' . $append;
        }
        return $slug;
    }
}
