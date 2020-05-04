<?php

use Illuminate\Database\Seeder;
use App\Domain\Models\Item;
use App\Domain\Models\Plan;
use App\Domain\Models\PlanItem;
use App\Domain\Models\Subscription;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        factory(PlanItem::class)->create([
            'plan_id' => function () {
                return factory(Plan::class)->state(Subscription::DEPARTMENT_VEHICLE)->create();
            },
            'item_id' => function(){
                return factory(Item::class)->state(Subscription::DEPARTMENT_VEHICLE)->create();
            }
        ]);

        factory(PlanItem::class)->create([
            'plan_id' => function () {
                return factory(Plan::class)->state(Subscription::DEPARTMENT_COURIER)->create();
            },
            'item_id' => function(){
                return factory(Item::class)->state(Subscription::DEPARTMENT_COURIER)->create();
            }
        ]);

    }
}
