<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConditionTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('condition_types', function (Blueprint $table) {
            $table->id();
            $table->integer('type');
            $table->integer('kubun');
            $table->integer('numero');
            $table->string('color');
            $table->integer('sub1');
            $table->integer('sub2');
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
        Schema::dropIfExists('condition_types');
    }
}
