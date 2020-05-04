<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('department')->index();
            $table->string('model_type');
            $table->string('model_id');
            $table->unsignedBigInteger('plan_id')->index();
            $table->timestamp('period_start');
            $table->timestamp('period_end');
            $table->integer('discount');

            $table->foreign('plan_id')->references('id')->on('plans');
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
        Schema::dropIfExists('subscriptions');
    }
}
