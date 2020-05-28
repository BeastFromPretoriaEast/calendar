<?php

namespace App;

use Carbon\Carbon;
use DateTime;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\View;
use Symfony\Component\Console\Output\ConsoleOutput;

class Holiday extends Model
{
    public static $months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

    protected $fillable = [
        'date',
        'name',
    ];

    /**
     * Generates the html/data which will be used to populated the calendar view
     *
     * @param bool $printPdf
     * @return mixed
     */
    public static function generateCalendarData($printPdf = false)
    {
        $daysByMonthInYear = self::sortDaysByMonthInYear();
        $htmlMonths = self::createCalendarsViaTemplate($daysByMonthInYear, $printPdf);

        return $htmlMonths;
    }

    /**
     * Fetches all holiday data from the database then sorts the data by month
     *
     * @return mixed
     */
    public static function sortHolidaysByMonth()
    {
        $holidays = self::all();

        // Creates an associative array with days by months as keys, and the holiday name as the value.
        foreach ($holidays as $holiday):
            $month = date("F",strtotime($holiday['date']));
            $day = date("j",strtotime($holiday['date']));

            $holidaysByMonth[$month][$day] = $holiday['name'];
        endforeach;

        return $holidaysByMonth;
    }

    /**
     * Runs though all of the days in the year and assigns the holidays where necessary
     * Assigns data used in the calendar monthly template to generate html calendars
     *
     * @return mixed
     */
    public static function sortDaysByMonthInYear()
    {
        $year = Carbon::now()->format('Y');

        foreach (self::$months as $month):
            $date = '1 ' . $month . ' ' . $year;

            $firstWeekdayOfTheMonthName = date("l", strtotime($date));
            $firstWeekdayOfTheMonthNumber = date("N", strtotime($date));
            $amountOfDaysInMonth = date("t", strtotime($date));

            $data[$month]['firstWeekday']['name'] =  $firstWeekdayOfTheMonthName;
            $data[$month]['firstWeekday']['number'] =  $firstWeekdayOfTheMonthNumber;

            for ($d = 1; $d <= $amountOfDaysInMonth; $d++):
                $data[$month]['days'][$d] = null;
            endfor;
        endforeach;

        $holidays = self::sortHolidaysByMonth();

        foreach ($holidays as $month => $holiday):
            foreach ($holiday as $date => $name):
                $data[$month]['days'][$date] = $name;
            endforeach;
        endforeach;

        return $data;
    }

    /**
     * Generates each month's html calendar and places it in an associative array
     *
     * @param $daysByMonthInYear
     * @param bool $printPdf
     * @return mixed
     */
    public static function createCalendarsViaTemplate($daysByMonthInYear, $printPdf = false)
    {
        foreach ($daysByMonthInYear as $month => $monthData):

            $increment = 0;

            $months[$month] = View::make('includes.monthTemplate', [
                                    'month' => $month,
                                    'monthData' => $monthData,
                                    'increment' => $increment,
                                    'printPdf' => $printPdf
                                 ])->render();
        endforeach;

        return $months;
    }

    /**
     * This method makes an API call the external url which provides the system with the year's holidays
     * The retrieved data is then stored in the database
     *
     * @param null $year
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function getAndSaveHolidaysViaApi($year = null)
    {
        $out = new ConsoleOutput();

        try {

            $out->write('Requesting data from https://kayaposoft.com');

            $client = new Client();

            $params = [
                'query' => [
                    'action' => 'getHolidaysForYear',
                    'year' => $year ?? Carbon::now()->format('Y'),
                    'country' => 'zaf',
                    'holidayType' => 'public_holiday',
                ]
            ];

            $res = $client->request('GET', 'https://kayaposoft.com/enrico/json/v2.0/', $params);

            if($res->getStatusCode() == '200'):

                $out->writeln(' ...Success');

                $out->write('Processing data');

                // Fetch Json data if request is successful
                $json = $res->getBody();

                // Convert Json into associative array
                $arrayData = json_decode($json, true);

                if(array_key_exists('error', $arrayData)):
                    // Stop processing and display error message
                    print($arrayData['error']);
                    exit();
                else:
                    // Create a new collection instance from the array
                    $holidaysArr = collect($arrayData)->map(function ($item, $key) {

                        return [
                            'date' => Carbon::create($item['date']['year'], $item['date']['month'], $item['date']['day'])->format('Y-m-d'),
                            'name' => $item['name'][0]['text'],
                        ];

                    })->toArray();

                    $out->writeln(' ...Success');
                endif;

            endif;

        } catch (RequestException $e) {

            // Catch the instance of GuzzleHttp\Psr7\Response. Has its own 'Message' trait's methods.
            if ($e->hasResponse()):
                $response = $e->getResponse();
                var_dump($response->getStatusCode()); // HTTP status code;
                var_dump($response->getReasonPhrase()); // Response message;
                var_dump((string)$response->getBody()); // Body, normally it is JSON;
                var_dump(json_decode((string)$response->getBody())); // Body as the decoded JSON;
                var_dump($response->getHeaders()); // Headers array;
                var_dump($response->hasHeader('Content-Type')); // Is the header presented?
                var_dump($response->getHeader('Content-Type')[0]); // Concrete header value;
            endif;

        }

        // if response has values remove all current holiday data and add the new holiday data
        if(!empty($holidaysArr)):
            self::truncate();
            self::insert($holidaysArr);
            $holidaysCount = count($holidaysArr);
            $message = "Added " . $holidaysCount . " records to the database.";
        else:
            $message = "No holidays where listed in the response.";
        endif;

        $out->writeln($message);
        $out->writeln('Console job completed.');
    }
}
