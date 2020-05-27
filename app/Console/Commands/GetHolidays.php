<?php

namespace App\Console\Commands;

use App\Holiday;
use Illuminate\Console\Command;

class GetHolidays extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'holidays:fetch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch holidays from via url request and store in database';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Holiday::getAndSaveHolidaysViaApi();
    }
}
