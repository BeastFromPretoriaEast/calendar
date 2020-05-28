<?php

namespace App\Http\Controllers;

use App\Holiday;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use Illuminate\Support\Facades\View;

class HolidayController extends Controller
{
    /**
     * HolidayController constructor.
     */
    public function __construct()
    {
        $holidays = Holiday::sortHolidaysByMonth();
        $year = Carbon::now()->format('Y');

        View::share('holidays', $holidays);
        View::share('year', $year);
    }

    /**
     * The page that displays calendar
     */
    public function index()
    {
        $months = Holiday::generateCalendarData();

        return view('calendar', [
            'months' => $months,
        ]);
    }

    /**
     * The page that generates a pdf of the calendar
     */
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
