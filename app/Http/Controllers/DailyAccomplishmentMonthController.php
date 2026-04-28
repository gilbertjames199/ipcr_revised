<?php

namespace App\Http\Controllers;

use App\Models\DailyAccomplishmentMonth;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DailyAccomplishmentMonthController extends Controller
{
    protected $daily_accom_month;

    public function __construct(DailyAccomplishmentMonth $daily_accom_month)
    {
        $this->daily_accom_month = $daily_accom_month;
    }

    public function index(Request $request)
    {
        $data = DailyAccomplishmentMonth::get();

        return inertia('Daily_Accomplishment/Months/Index', [
            'data' => $data,
        ]);
    }

    public function generate(Request $request)
    {
        $request->validate([
            'year' => 'required|integer|min:2025|max:2027',
        ]);

        $year = (int) $request->input('year');

        // Iterate over all 12 months
        for ($month = 1; $month <= 12; $month++) {

            // Skip if a record already exists for this year + month
            $exists = DailyAccomplishmentMonth::where('year', $year)
                ->where('month', $month)
                ->exists();

            if ($exists) {
                continue;
            }

            // Deadline = 10th working day of the NEXT month
            $deadline = $this->getTenthWorkingDay($year, $month);

            DailyAccomplishmentMonth::create([
                'year'     => $year,
                'month'    => $month,
                'deadline' => $deadline,
            ]);
        }

        return redirect()->back();
    }

    /**
     * Returns the date of the 10th working day (Mon–Fri) of the month
     * that follows the given year + month.
     */
    private function getTenthWorkingDay(int $year, int $month): string
    {
        // Advance to the next month
        if ($month === 12) {
            $targetYear  = $year + 1;
            $targetMonth = 1;
        } else {
            $targetYear  = $year;
            $targetMonth = $month + 1;
        }

        $workingDayCount = 0;
        $cursor = Carbon::create($targetYear, $targetMonth, 1)->startOfDay();

        while (true) {
            // isWeekday() returns true for Monday–Friday
            if ($cursor->isWeekday()) {
                $workingDayCount++;

                if ($workingDayCount === 10) {
                    return $cursor->toDateString(); // e.g. "2025-02-14"
                }
            }

            $cursor->addDay();
        }
    }

    public function update(Request $request, $id)
    {
        $record = $this->daily_accom_month->findOrFail($id);

        $validated = $request->validate([
            'deadline' => 'required|date', // or 'date_format:Y-m-d' etc.
        ]);

        $record->update($validated);
        return redirect()->back()->with('message', 'Deadline Updated Successfully');
        // Return JSON response (if API) or redirect
        // return response()->json([
        //     'message' => 'Deadline updated successfully',
        //     'data' => $record
        // ]);
    }
}
