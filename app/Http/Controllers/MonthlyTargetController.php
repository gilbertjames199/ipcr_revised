<?php

namespace App\Http\Controllers;

use App\Models\Ipcr_Semestral;
use App\Models\IpcrTarget;
use Illuminate\Http\Request;

class MonthlyTargetController extends Controller
{
    public function semestral_monthly(Request $request)
    {
        $id = auth()->user()->username;
        $emp = auth()->user()->userEmployee;
        $emp_code = $emp->empl_id;
        // $sem_data = Ipcr_Semestral::with([
        //     'monthly_target',
        //     'monthly_target.returnRemarks'
        // ])
        //     ->where('employee_code', $emp_code)
        //     ->where('status', '2')
        //     ->orderBy('year', 'asc')
        //     ->orderBy('sem', 'asc')
        //     ->get();
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
        // dd($sem_data);
        $source = "direct";

        $div = "";
        if ($emp->Division) {
            $div = $emp->Division->division_name1;
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
    public function getMonthlyRating(Request $request, $emp_code, $sem_id, $month, $year)
    {
        //GET IPCR TARGETS GIVEN THE SEM ID
        return IpcrTarget::with([
            'individualOutput',
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
            ->orderBy('ipcr_type', 'ASC')
            ->get()
            ->map(function ($item) {
                $daily = [];
                // dd($item);
                $ifo = $item->individualOutput;
                if ($item->monthlyTargets) {
                    $daily = $item->monthlyTargets->flatMap(function ($monthly_item) use ($ifo) {
                        // Ensure dailyAccomplishments is a collection before calling map()
                        return $monthly_item->dailyAccomplishments ? $monthly_item->dailyAccomplishments->sortBy('date')->map(function ($daily_item) use ($ifo) {
                            return [
                                "individual_output" => $ifo->individual_output,
                                "description" => $daily_item->description,
                                "date" => $daily_item->date
                            ];
                        }) : collect();
                    });
                }
                $cnt = count($daily);
                // dd(count($daily));
                return [
                    "type" => $item->ipcr_type,
                    "sem_id" => $item->ipcr_semestral_id,
                    "idifo" => $item->individual_final_output_id,
                    "output" => $item->individualOutput ? $item->individualOutput->individual_output : "",
                    "quality1" => $item->individualOutput ? $item->individualOutput->quality1 : "",
                    "quality2" => $item->individualOutput ? $item->individualOutput->quality2 : "",
                    "quality3" => $item->individualOutput ? $item->individualOutput->quality3 : "",
                    "efficiency1" => $item->individualOutput ? $item->individualOutput->efficiency1 : "",
                    "efficiency2" => $item->individualOutput ? $item->individualOutput->efficiency2 : "",
                    "efficiency3" => $item->individualOutput ? $item->individualOutput->efficiency3 : "",
                    "timeliness" => $item->individualOutput ? $item->individualOutput->timeliness : "",
                    "monthly_rating_id" => $item->monthlyTargets ? $item->monthlyTargets[0]->id : "",
                    "q1" => $item->monthlyTargets ? $item->monthlyTargets[0]->q1 : "",
                    "q2" => $item->monthlyTargets ? $item->monthlyTargets[0]->q2 : "",
                    "q3" => $item->monthlyTargets ? $item->monthlyTargets[0]->q3 : "",
                    "e1" => $item->monthlyTargets ? $item->monthlyTargets[0]->e1 : "",
                    "e2" => $item->monthlyTargets ? $item->monthlyTargets[0]->e2 : "",
                    "e3" => $item->monthlyTargets ? $item->monthlyTargets[0]->e3 : "",
                    "t1" => $item->monthlyTargets ? $item->monthlyTargets[0]->t1 : "",
                    "visible" => intval($cnt) > 0 ? true : false,
                    "daily" => $daily,
                    "count_daily" => $cnt
                ];
            });
    }
}
