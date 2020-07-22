<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use Faker\Generator as Faker;

/**
 * Factory for User model
 */
$factory->define(User::class, function (Faker $faker) {
    return [
        'badge_number' => $faker->numberBetween(1000, 999999),
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName
    ];
});
