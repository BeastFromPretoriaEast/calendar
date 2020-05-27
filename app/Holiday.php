<?php

namespace App;

use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Console\Output\ConsoleOutput;

class Holiday extends Model
{
    protected $fillable = [
        'date',
        'name',
    ];

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
                            'name' => $item['name'][0]['text']
                        ];

                    })->toArray();

                    $out->writeln(' ...Success');
                endif;

            endif;

        } catch (RequestException $e) {

            // Catch the instance of GuzzleHttp\Psr7\Response. Has its own 'Message' trait's methods.
            if ($e->hasResponse()) {
                $response = $e->getResponse();
                var_dump($response->getStatusCode()); // HTTP status code;
                var_dump($response->getReasonPhrase()); // Response message;
                var_dump((string)$response->getBody()); // Body, normally it is JSON;
                var_dump(json_decode((string)$response->getBody())); // Body as the decoded JSON;
                var_dump($response->getHeaders()); // Headers array;
                var_dump($response->hasHeader('Content-Type')); // Is the header presented?
                var_dump($response->getHeader('Content-Type')[0]); // Concrete header value;
            }

        }

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
