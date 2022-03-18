<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Type;
use Faker\Generator as Faker;

$factory->define(Type::class, function (Faker $faker) {
    $types = ['Cinese', 'Giapponese', 'Italiano', 'Gelato','Pizza',];

    return [
        "type_name" => $types[rand(0, count($types)-1)],
    ];
});
