<?php

namespace App\Http\Controllers;

use App\Holiday;
use Carbon\Carbon;

class HolidayController extends Controller
{
    public function index()
    {
        $months = Holiday::generateCalendarData();
        $year = Carbon::now()->format('Y');

        return view('calendar', [
            'year' => $year,
            'months' => $months,
        ]);
    }
}
