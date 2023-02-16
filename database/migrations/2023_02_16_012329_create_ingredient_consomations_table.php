<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIngredientConsomationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ingredient_consomations', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->integer('ingredient_id');
            $table->string('ingredient_name');
            $table->string('ingredient_category');
            $table->integer('ingredient_sub_id')->nullable();
            $table->string('ingredient_sub_name')->nullable();
            $table->string('ingredient_sub_category')->nullable();
            $table->integer('product_id');
            $table->string('product_name');
            $table->string('product_type');
            $table->string('category');
            $table->string('sub_category')->nullable();
            $table->integer('sup_id')->nullable();
            $table->string('sup_name')->nullable();
            $table->integer('sup2_id')->nullable();
            $table->string('sup2_name')->nullable();
            $table->double('consommation,6,2');
            $table->string('consommation_sub')->nullable();
            $table->string('unit_name');
            $table->string('unit_sub_name')->nullable();
            $table->smallInteger('dispo_flg')->default(1);
            $table->smallInteger('display_flg')->default(1);
            $table->smallInteger('saison_id')->default(1);
            $table->string('add_info')->nullable();
            $table->text('add_txt')->nullable();
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
        Schema::dropIfExists('ingredient_consomations');
    }
}
