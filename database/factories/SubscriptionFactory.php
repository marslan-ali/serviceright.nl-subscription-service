<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Domain\Models\Subscription;
use App\Domain\Models\Plan;
use Faker\Generator as Faker;

$factory->define(Subscription::class,
        function (Faker $faker) {
    return [
        'department' => Subscription::DEPARTMENT_VEHICLE,
        'model_type' => Subscription::DEPARTMENT_VEHICLE,
        'model_id'   => $faker->uuid,
        'plan_id'    => function () {
            return factory(Plan::class)->state(Subscription::DEPARTMENT_VEHICLE)
                ->create(['department' => Subscription::DEPARTMENT_VEHICLE]);
        },
        'period_start' => date('Y-m-d H:i:s'),
        'period_end'   => date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s').' +1 day')),
        'discount'     => $faker->numberBetween(0, 2)
    ];
});
