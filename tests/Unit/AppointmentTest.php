<?php

namespace Tests\Unit;

use App\Appointment;
use App\User;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Facades\Tests\Setup\AppointmentTestFactory;

class AppointmentTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_be_saved()
    {
        $appointment = AppointmentTestFactory::create();
        $this->assertDatabaseHas('appointments',
            [
                'date_starts' => $appointment->date_starts,
                'date_ends' => $appointment->date_ends,
                'product_id' => $appointment->product_id,
                'user_id' => $appointment->user_id,
            ]
        );
    }

    /** @test **/
    public function it_belongs_to_an_owner()
    {
        $this->assertInstanceOf(User::class, AppointmentTestFactory::create()->user);
    }

    /** @test **/
    public function it_has_a_day_method()
    {
        $appointment = AppointmentTestFactory::create();
        $this->assertNotEmpty($appointment->day());
    }

    /** @test **/
    public function it_has_a_time_method()
    {
        $appointment = AppointmentTestFactory::create();
        $this->assertNotEmpty($appointment->time());
    }

    /** @test **/
    public function it_has_an_upcoming_scope()
    {
        AppointmentTestFactory::create(
            [
                'date_starts' => (new Carbon())
                    ->sub(
                        (new CarbonInterval(0, 0, 0, -1))
                    )
            ]
        );
        $this->assertEmpty(Appointment::upcoming()->get());

        AppointmentTestFactory::create();
        $this->assertCount(1, Appointment::upcoming()->get());
    }
    /** @test */
    public function it_can_be_updated()
    {
        $appointment = AppointmentTestFactory::create();
        $newData = AppointmentTestFactory::raw();
        $appointment->date_starts = $newData['date_starts'];
        $appointment->date_ends = $newData['date_ends'];
        $appointment->product_id = $newData['product_id'];
        $appointment->save();
        $this->assertDatabaseHas('appointments', [
            'date_starts' => $newData['date_starts'],
            'date_ends' => $newData['date_ends'],
            'product_id' => $newData['product_id']
        ]);
    }

}
