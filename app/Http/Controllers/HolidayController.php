<?php

namespace App\Http\Controllers;

use App\Holiday;
use Carbon\Carbon;

class HolidayController extends Controller
{
    public function index()
    {
        $holidays = Holiday::sortHolidaysByMonth();
        $months = Holiday::generateCalendarData();
        $year = Carbon::now()->format('Y');

        return view('calendar', [
            'holidays' => $holidays,
            'months' => $months,
            'year' => $year,
        ]);
    }
}
