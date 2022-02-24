<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Customer;
use Faker\Generator as Faker;

$factory->define(Customer::class, function (Faker $faker) {
    return [
        
        "name" => $faker -> name(),
        "surname" => $faker -> name(),
        "address" => $faker -> name(),
        "note" => $faker -> name(),
        "cap" => $faker -> numerify("#####"),
        "telephone" => $faker -> e164PhoneNumber(),

    ];
});
