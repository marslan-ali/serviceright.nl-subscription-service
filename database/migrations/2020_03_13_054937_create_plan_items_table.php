<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreatePlanItemsTable.
 */
class CreatePlanItemsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plan_items', function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('plan_id')->index();
            $table->unsignedBigInteger('item_id')->index();
            $table->foreign('plan_id')->references('id')->on('plans');
            $table->foreign('item_id')->references('id')->on('items');
            $table->unique(['plan_id', 'item_id']);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('plan_items');
    }

}
