<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Dish;
use Faker\Generator as Faker;

$factory->define(Dish::class, function (Faker $faker) {
    return [
        "name" => $faker -> name(),
        "description" => $faker -> text(),
        "price" => $faker -> randomFloat(2, 1, 999),
        "dishes_img" => $faker -> name(),
        "available" => false,
        "ingredients" => $faker -> text(),
    ];
});
