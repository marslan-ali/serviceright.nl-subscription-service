<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Domain\Models\Plan;
use App\Domain\Models\Subscription;
use Faker\Generator as Faker;

$factory->define(Plan::class, function (Faker $faker) {
    return [
        'description'=>$faker->text,
    ];
});

$factory->state(Plan::class, Subscription::DEPARTMENT_VEHICLE , function () {
    return [
        'name' => "Yearly subscription vehicle",
        'department' => Subscription::DEPARTMENT_VEHICLE,
    ];
});

$factory->state(Plan::class, Subscription::DEPARTMENT_COURIER, function () {
    return [
        'name' => "Yearly subscription courier",
        'department' => Subscription::DEPARTMENT_COURIER,
    ];
});
