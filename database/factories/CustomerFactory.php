<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Customer;
use Faker\Generator as Faker;

$factory->define(Customer::class, function (Faker $faker) {
    return [
        
        "name" => $faker -> firstName(),
        "surname" => $faker -> lastName(),
        "address" => $faker -> streetAddress(),
        "note" => $faker -> words(10, true),
        "cap" => $faker -> numerify("#####"),
        "telephone" => $faker -> e164PhoneNumber(),

    ];
});
