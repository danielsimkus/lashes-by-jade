<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Facades\Tests\Setup\ProductTestFactory;
use Facades\Tests\Setup\UserTestFactory;
use Tests\TestCase;
use Throwable;

Class ProductsTest extends TestCase {

    use WithFaker, RefreshDatabase;

    /** @test */
    public function a_product_can_be_viewed_by_anyone()
    {
        $product = ProductTestFactory::create();
        $this->get($product->path())
            ->assertSee($product->description)
            ->assertSee($product->name);
    }

    /** @test **/
    public function a_product_can_be_updated_only_by_the_owner()
    {
        $owner = UserTestFactory::create();
        $notOwner = UserTestFactory::create();
        $product = ProductTestFactory::create(['user_id' => $owner->id]);
        $newData = ProductTestFactory::raw(['user_id' => null]);

        // Update request by the owner
        $this->actingAs($owner)
            ->followingRedirects()
            ->patch($product->path(), $newData)
            ->assertSee($newData['description'])
            ->assertSee($newData['name']);

        // Update request by unauthorized user
        $this->actingAs($notOwner)
            ->followingRedirects()
            ->patch($product->path(), $newData)
            ->assertStatus(403);
    }


    /** @test */
    public function a_user_can_create_a_product()
    {
        $this->withoutExceptionHandling();
        $this->actingAs($user = UserTestFactory::create())
            ->post(route('products.store'), ProductTestFactory::raw(['user_id' => null]))
            ->assertRedirect();
    }

    /** @test **/
    public function a_guest_cannot_create_a_product()
    {
        $this->post(route('products.store'), ProductTestFactory::raw(['user_id' => null]))
        ->assertStatus(403);
    }
}
