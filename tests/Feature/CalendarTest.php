<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CalendarTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
    }

    /**
     * Tests if the first month displays
     *
     * @return void
     */
    public function testDoesFirstMonthDisplay()
    {
        $response = $this->get('/');
        $response->assertSeeText("January", true);
    }

    /**
     * Tests if the last month displays
     *
     * @return void
     */
    public function testDoesLastMonthDisplay()
    {
        $response = $this->get('/');
        $response->assertSeeText("December", true);
    }

    /**
     * Tests if the console command that fetches the dates works correctly
     *
     * @return void
     */
    public function testDoesConsoleGetDatesViaApiWork()
    {
        $this->artisan('holidays:fetch')
            ->assertExitCode(0);
    }
}
