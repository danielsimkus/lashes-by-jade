<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use Carbon\CarbonInterval;
use Faker\Generator as Faker;
use App\Appointment;

$factory->define(Appointment::class, function (Faker $faker) {
    $start = $faker->dateTimeBetween('now','+1 week');
    $end = tap(clone $start)->add(new CarbonInterval(null, null, null, null, rand(1,2)));
    return [
        'date_starts' => $start,
        'date_ends' => $end,
        'product_id' => 1,
        'user_id' => factory(User::class)
    ];
});
