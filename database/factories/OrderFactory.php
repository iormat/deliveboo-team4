<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Order;
use Faker\Generator as Faker;

$factory->define(Order::class, function (Faker $faker) {

    $dates = ['2022-01-5','2022-02-5','2022-03-5','2022-04-5','2022-05-5','2022-06-5','2022-07-5','2022-08-5','2022-09-5','2022-010-5','2022-11-5','2022-12-5',];

    return [
        "date" => $dates[rand(0, count($dates)-1)],
        "total_price" => $faker -> randomFloat(2, 1, 50),
        "confirmed" => $faker -> boolean(),
        "payment_confirmation" => $faker -> boolean(),
        "confirmation_date" => $faker -> date(),
    ];
});
