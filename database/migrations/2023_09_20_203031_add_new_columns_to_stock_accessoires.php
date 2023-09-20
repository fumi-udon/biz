<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewColumnsToStockAccessoires extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stock_accessoires', function (Blueprint $table) {
            $table->integer('sauce_poisson')->nullable();
            $table->integer('pate_miso_20kg')->nullable();
            $table->integer('mirin_20kg')->nullable();
            $table->integer('algue_nori')->nullable();
            $table->integer('algue_wakame')->nullable();
            $table->integer('gari_gingimbre')->nullable();
            $table->integer('poudre_dashi')->nullable();
            $table->integer('shichimi')->nullable();
            $table->integer('sauce_tomyum')->nullable();
            $table->integer('sauce_toubanjyun')->nullable();
            $table->integer('poudre_de_poulet')->nullable();
            $table->integer('burre')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('stock_accessoires', function (Blueprint $table) {
            $table->dropColumn([
                'sauce_poisson',
                'pate_miso_20kg',
                'mirin_20kg',
                'algue_nori',
                'algue_wakame',
                'gari_gingimbre',
                'poudre_dashi',
                'shichimi',
                'sauce_tomyum',
                'sauce_toubanjyun',
                'poudre_de_poulet',
                'burre',
            ]);
        });
    }
}
