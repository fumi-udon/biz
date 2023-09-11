<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFinancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('finances', function (Blueprint $table) {
            $table->id();
            $table->string('shop');
            $table->string('name')->nullable();
            $table->string('article')->nullable();
            $table->string('zone')->nullable();
            $table->string('adress')->nullable();
            $table->string('comman1')->nullable();
            $table->string('comman2')->nullable();
            $table->string('comman3')->nullable();
            $table->string('comman4')->nullable();

            $table->decimal('recettes_main')->nullable();
            $table->decimal('recettes_sub')->nullable();
            $table->decimal('recettes_sub2')->nullable();
            $table->decimal('montant_init')->nullable();
            $table->decimal('montant_1')->nullable();
            $table->decimal('montant_2')->nullable();
            
            $table->decimal('chips')->nullable();
            $table->decimal('chips_sub')->nullable();
            $table->decimal('caisse')->nullable();
            $table->decimal('caisse_sub')->nullable();
            $table->decimal('caisse_ozark')->nullable();
            $table->decimal('cash')->nullable();
            $table->decimal('cash_sub')->nullable();
            $table->decimal('cheque')->nullable();
            $table->decimal('cheque_sub')->nullable();
            $table->decimal('card')->nullable();
            $table->decimal('card_sub')->nullable();
            $table->decimal('mode_pay_1')->nullable();
            $table->decimal('mode_pay_2')->nullable();
            $table->decimal('mode_pay_3')->nullable();


            $table->integer('flg')->nullable();
            $table->integer('cat')->nullable();
            $table->integer('cat_1')->nullable();
            $table->integer('cat_2')->nullable();

            $table->tinyInteger('bravo')->nullable();
            $table->tinyInteger('boo')->nullable();
            $table->tinyInteger('dei')->nullable();

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
        Schema::dropIfExists('finances');
    }
}
