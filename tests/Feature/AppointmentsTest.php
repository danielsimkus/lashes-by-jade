<?php

namespace Tests\Feature;

use App\User;
use Facades\Tests\Setup\ProductTestFactory;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Facades\Tests\Setup\AppointmentTestFactory;
use Facades\Tests\Setup\UserTestFactory;
use Tests\TestCase;
use Throwable;

Class AppointmentsTest extends TestCase {

    use WithFaker, RefreshDatabase;

    /** @test */
    public function an_appointment_can_only_be_viewed_by_an_authorized_user()
    {
        $owner = UserTestFactory::create();
        $notOwner = UserTestFactory::create();
        $appointment = AppointmentTestFactory::create(['user_id' => $owner->id]);

        // Guests should be asked to login
        $this->get($appointment->path())
            ->assertRedirect('/login');

        // Non-owners should be given a 403
        $this->actingAs($notOwner)
            ->get($appointment->path())
            ->assertSee(403);
        $this->withoutExceptionHandling();
        // The owner should receive a 200
        $this->actingAs($owner)
            ->get($appointment->path())
            ->assertStatus(200);
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
            ->assertSee($newData['date_starts']->format('H:i'));

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
        ->assertStatus(302)
        ->assertRedirect('/login');
    }

    /** @test **/
    public function a_user_can_see_their_appointment_index()
    {
        $user = UserTestFactory::create();
        $appointment1 = AppointmentTestFactory::create(['user_id' => $user]);
        $appointment2 = AppointmentTestFactory::create(['user_id' => $user]);
        $this
            ->actingAs($user)
            ->get(route('appointments.index'))
            ->assertSee($appointment1->time())
            ->assertSee($appointment2->time());

    }
}
