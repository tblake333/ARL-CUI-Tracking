<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Item;
use App\User;
use Faker\Generator as Faker;

/**
 * Factory for item model
 */
$factory->define(Item::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence(2, false),
        'barcode' => 'CUI' . $faker->randomNumber(7),
        'owner_badge_number' => factory(User::class)->create()->badge_number,
        'type' => $faker->word(),
        'source' => $faker->word(),
        'source_date' => $faker->date(),
        'location' => $faker->sentence(2, false),
        'description' => $faker->sentence(),
        'keywords' => $faker->word() . ', ' . $faker->word() . ', ' . $faker->word
    ];
});
