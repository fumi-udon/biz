<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlanProductionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plan_productions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('portion_par_udon');
            $table->integer('rmn_mon');
            $table->integer('rmn_tue');
            $table->integer('rmn_wed');
            $table->integer('rmn_thu');
            $table->integer('rmn_fri');
            $table->integer('rmn_sat');
            $table->integer('rmn_sun');
            $table->integer('udon_base_mon');
            $table->integer('udon_base_tue');
            $table->integer('udon_base_wed');
            $table->integer('udon_base_thu');
            $table->integer('udon_base_fri');
            $table->integer('udon_base_sat');
            $table->integer('udon_base_sun');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plan_productions');
    }
}
