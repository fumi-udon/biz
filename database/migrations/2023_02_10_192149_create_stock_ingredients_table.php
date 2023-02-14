<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockIngredientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_ingredients', function (Blueprint $table) {
            $table->id();
            $table->integer('udon_rest_15h');
            $table->integer('udon_rest_a')->nullable();
            $table->integer('article1_rest')->nullable();
            $table->integer('article2_rest')->nullable();
            $table->integer('pudding_mt')->nullable();
            $table->integer('pudding_sm')->nullable();
            $table->integer('oeuf')->nullable();
            $table->integer('article3_rest')->nullable();
            $table->integer('article4_rest')->nullable();
            $table->integer('article5_rest')->nullable();
            $table->integer('flg1')->nullable();
            $table->tinyInteger('boo1')->nullable();
            $table->date('registre_date');
            $table->dateTime('registre_datetime');
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
        Schema::dropIfExists('stock_ingredients');
    }
}
