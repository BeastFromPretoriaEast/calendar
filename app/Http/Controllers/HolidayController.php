<?php

namespace App\Http\Controllers;

use App\Holiday;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use Illuminate\Support\Facades\View;

class HolidayController extends Controller
{
    public function __construct()
    {
        $holidays = Holiday::sortHolidaysByMonth();
        $year = Carbon::now()->format('Y');

        View::share('holidays', $holidays);
        View::share('year', $year);
    }

    public function index()
    {
        $months = Holiday::generateCalendarData();

        return view('calendar', [
            'months' => $months,
        ]);
    }

    public function downloadPDF()
    {
        $printPdf = true;
        $months = Holiday::generateCalendarData($printPdf);

        $pdf = PDF::loadView('pdf.calendar', [
            'months' => $months,
            'printPDF' => true
        ]);
        return $pdf->stream('holidays-2020.pdf');
    }
}
