<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Facades\Tests\Setup\AppointmentTestFactory;
use Facades\Tests\Setup\UserTestFactory;
use Tests\TestCase;
use Throwable;

Class AppointmentsTest extends TestCase {

    use WithFaker, RefreshDatabase;

    /** @test */
    public function a_appointment_can_be_viewed_by_anyone()
    {
        $appointment = AppointmentTestFactory::create();
        $this->get($appointment->path())
            ->assertSee($appointment->description)
            ->assertSee($appointment->name);
    }

    /** @test **/
    public function a_appointment_can_be_updated_only_by_the_owner()
    {
        $owner = UserTestFactory::create();
        $notOwner = UserTestFactory::create();
        $appointment = AppointmentTestFactory::create(['user_id' => $owner->id]);
        $newData = AppointmentTestFactory::raw(['user_id' => null]);

        // Update request by the owner
        $this->actingAs($owner)
            ->followingRedirects()
            ->patch($appointment->path(), $newData)
            ->assertSee($newData['description'])
            ->assertSee($newData['name']);

        // Update request by unauthorized user
        $this->actingAs($notOwner)
            ->followingRedirects()
            ->patch($appointment->path(), $newData)
            ->assertStatus(403);
    }


    /** @test */
    public function a_user_can_create_a_appointment()
    {
        $this->withoutExceptionHandling();
        $this->actingAs($user = UserTestFactory::create())
            ->post(route('appointments.store'), AppointmentTestFactory::raw(['user_id' => null]))
            ->assertRedirect();
    }

    /** @test **/
    public function a_guest_cannot_create_a_appointment()
    {
        $this->post(route('appointments.store'), AppointmentTestFactory::raw(['user_id' => null]))
        ->assertStatus(403);
    }
}
