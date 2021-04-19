<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Costo;
use Faker\Generator as Faker;

$factory->define(Costo::class, function (Faker $faker) {
    return [
        'descripcion' => $faker->text(100),
        'costo' => strval(number_format(rand(1, 100), 2, '.', '')),
        'fecha' => now(),
    ];
});
