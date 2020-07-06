<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Agency;
use Faker\Generator as Faker;

$factory->define(Agency::class, function (Faker $faker) {
    return [
        'number' => $faker->randomNumber(4),
        'name' => $faker->name,
        'status' => Agency::STATUS_ACTIVE,
    ];
});
