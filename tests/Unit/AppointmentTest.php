<?php

namespace Tests\Unit;

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

    /** @test */
    public function it_can_be_updated()
    {
        $appointment = AppointmentTestFactory::create();
        $newData = AppointmentTestFactory::raw();
        $appointment->date_starts = $newData['date_starts'];
        $appointment->date_ends = $newData['date_ends'];
        $appointment->product_id = $newData['product_id'];
        $appointment->save();
        $this->assertDatabaseHas('products', [
            'date_starts' => $newData['name'],
            'date_ends' => $newData['date_ends'],
            'product_id' => $newData['product_id']
        ]);
    }

    public function it_belongs_to_a_user()
    {
        $appointment = AppointmentTestFactory::create();
        $this->assertInstanceOf(User::class, $appointment->user);
    }
}
