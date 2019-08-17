<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Facades\Tests\Setup\ProductTestFactory;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_be_saved()
    {
        $product = ProductTestFactory::create();
        $this->assertDatabaseHas('products',
            [
                'name' => $product->name,
                'description' => $product->description,
                'user_id' => $product->user_id,
            ]
        );
    }

    /** @test */
    public function it_can_be_updated()
    {
        $product = ProductTestFactory::create();
        $newData = ProductTestFactory::raw();
        $product->name = $newData['name'];
        $product->description = $newData['description'];
        $product->save();
        $this->assertDatabaseHas('products', [
            'name' => $newData['name'],
            'description' => $newData['description'],
        ]);
    }

    public function it_belongs_to_a_user()
    {
        $product = ProductTestFactory::create();
        $this->assertInstanceOf(User::class, $product->user);
    }
}
