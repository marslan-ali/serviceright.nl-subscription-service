<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Domain\Models\Item;
use App\Domain\Models\Subscription;
use Faker\Generator as Faker;

$factory->define(Item::class,
        function (Faker $faker) {
    return [
        'description'     => $faker->text,
        'amount'   => 2500 ,
        'tax_rate' => 21,
        'currency' => 'EUR',
    ];


});

$factory->state(Item::class, Subscription::DEPARTMENT_VEHICLE, function () {
    return [
        'name' => "vehicle yearly subscription ",
        'department' => Subscription::DEPARTMENT_VEHICLE,
    ];
});

$factory->state(Item::class, Subscription::DEPARTMENT_COURIER, function () {
    return [
        'name' => "courier yearly subscription ",
        'department' => Subscription::DEPARTMENT_COURIER,
    ];
});
