<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuthHanabishisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auth_hanabishis', function (Blueprint $table) {
            $table->increments('id');
            $table->string('user_name');
            $table->string('password');
            $table->string('sub_1');
            $table->integer('flg_int');
            $table->boolean('flg_boo');

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
        Schema::dropIfExists('auth_hanabishis');
    }
}
