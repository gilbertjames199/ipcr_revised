<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class TimeHelper
{
    public static function getCurrentTime()
    {
        $currentDate = now()->format('Y-m-d H:i:s');
        // $type = ' local';
        try {
            // Fetch internet time
            $response = Http::get('http://worldtimeapi.org/api/timezone/Etc/UTC');
            $internetTime = $response->json()['utc_datetime'];
            // $type = ' global';
            // Convert to your preferred timezone if needed
            $currentDate = Carbon::parse($internetTime)->setTimezone('Asia/Manila')->format('Y-m-d H:i:s');
        } catch (\Exception $e) {
            // If the internet is not accessible, fallback to server time
        }

        return $currentDate;
    }
}
