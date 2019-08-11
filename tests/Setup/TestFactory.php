<?php
namespace Tests\Setup;


use Illuminate\Foundation\Testing\WithFaker;

abstract class TestFactory implements TestFactoryInterface
{
    use WithFaker;

    public function __construct()
    {
        $this->factory = factory($this->model);
    }
    
    public function create($attributes = [])
    {
        $attributes = $attributes ?? [];
        return $this->factory->create($attributes);
    }
}