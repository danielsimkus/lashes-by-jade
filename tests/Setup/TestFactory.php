<?php
namespace Tests\Setup;


use Illuminate\Foundation\Testing\WithFaker;

abstract class TestFactory implements TestFactoryInterface
{
    use WithFaker;

    /**
     * The Model::class which the factory will use
     *
     * @var null
     */
    protected $model = null;

    public function __construct()
    {
        $this->factory = factory($this->model);
    }
    
    public function create($attributes = []): object
    {
        $attributes = $attributes ?? [];
        return $this->factory->create($attributes);
    }

    public function raw($attributes = []): array
    {
        $attributes = $attributes ?? [];

        return $this->factory->raw($attributes);
    }
}