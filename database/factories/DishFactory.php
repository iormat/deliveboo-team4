<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Dish;
use Faker\Generator as Faker;



$factory->define(Dish::class, function (Faker $faker) {

    // $dishesName = ["Carbonara", "Matriciana", "Lasagne al forno", "Pizza Margherita", "Pizza 4 Stagioni", "Pizza "];
    // $description = ["Piatto tipico siciliano", "Piatto tipico romagnolo", "Piatto tipico sardo", "Piatto tipico campano", "Piatto tipico ligure"];
    return [
        
        // "name" => $dishesName[rand(0, count($dishesName)-1)],
        // "description" => $description[rand(0, count($description)-1)],
        "dish_name" => $faker -> word(),
        "description" => $faker -> text(),
        "dishes_img" => $faker->imageUrl(640, 480, 'animals', true),
        "available" => false,
        "ingredients" => $faker -> text(),
    ];
});
