<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Facades\Tests\Setup\ProductTestFactory;
use Tests\TestCase;

Class ProductsTest extends TestCase {

    use WithFaker, RefreshDatabase;

    /** @test */
    public function a_product_can_be_viewed()
    {
        $product = ProductTestFactory::create();
        $this->get('/products/' . $product->id)
            ->assertStatus(302);
    }


    /** @test */
    public function a_user_can_create_a_product()
    {
        $params = [
            'name' => $this->faker->sentence(3, true),
            'description' => $this->faker->paragraph(3)
        ];
        $this->post('/products', $params);
        $this->assertDatabaseHas('products', $params);
    }
}
