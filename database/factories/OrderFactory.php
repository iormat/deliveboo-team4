<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Order;
use Faker\Generator as Faker;

$factory->define(Order::class, function (Faker $faker) {
    return [
        "date" => $faker -> date(),
        "total_price" => $faker -> randomFloat(2, 1, 999),
        "confirmed" => $faker -> boolean(),
        "payment_confirmation" => $faker -> boolean(),
        "confirmation_date" => $faker -> date(),
    ];
});
