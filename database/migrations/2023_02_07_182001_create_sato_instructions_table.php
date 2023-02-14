<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSatoInstructionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sato_instructions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('override_tx_1');
            $table->string('override_tx_2');
            $table->string('override_tx_3');
            $table->integer('flg_int');
            $table->boolean('flg_boo');
            $table->date('aply_date');
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
        Schema::dropIfExists('sato_instructions');
    }
}
