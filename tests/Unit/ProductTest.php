<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Facades\Tests\Setup\ProductTestFactory;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_be_saved()
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
}
