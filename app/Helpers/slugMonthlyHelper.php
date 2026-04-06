<?php

namespace App\Helpers;

use App\Models\MonthlyTarget;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use Illuminate\Support\Str;

class TimeHelper
{

    public static function slugMonthlyGlobal($month, $year)
    {
        // Convert month number to month name
        $monthName = date('F', mktime(0, 0, 0, $month, 1));

        // Base slug
        $baseSlug = Str::slug($monthName . '-' . $year);
        $random = Str::random(7 * 2);
        $append = substr(preg_replace('/[^a-z1-3]/', '', $random), 0, 7);
        $slug = $baseSlug . '-' . $append;
        // $counter = 1;
        // dd($slug);
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
