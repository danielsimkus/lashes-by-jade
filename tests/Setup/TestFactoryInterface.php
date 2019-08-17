<?php

namespace Tests\Setup;

interface TestFactoryInterface {
    public function create($attributes = []);
    public function raw($attributes = []);
    public function __construct();
}