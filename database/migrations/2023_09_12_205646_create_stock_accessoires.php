<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockAccessoires extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_accessoires', function (Blueprint $table) {
            $table->id();
            $table->integer('essuie_jmb')->nullable();
            $table->integer('papier_toilettes')->nullable();
            $table->integer('plastique_chaud_750ml')->nullable();
            $table->integer('plastique_froide_500ml')->nullable();
            $table->integer('plastique_froide_1000ml')->nullable();
            $table->integer('papier_serviette')->nullable();
            $table->integer('aluminium_901')->nullable();
            $table->integer('aluminium_701')->nullable();
            $table->integer('aluminium_401')->nullable();
            $table->integer('pot_de_sauce_30cc')->nullable();
            $table->integer('bol_carton_rond')->nullable();
            $table->integer('sac_transparant')->nullable();
            $table->integer('sac_petit')->nullable();
            $table->integer('sac_grand')->nullable();
            $table->integer('sac_poubelle')->nullable();
            $table->integer('bicarbonate')->nullable();
            $table->integer('tahina_pate_du_sesame')->nullable();
            $table->integer('viande_hachee_poulet_congele')->nullable();
            $table->integer('viande_hachee_boeuf_congele')->nullable();
            $table->integer('tantan_boeuf')->nullable();
            $table->integer('article1')->nullable();
            $table->integer('article2')->nullable();
            $table->integer('article3')->nullable();
            $table->integer('article4')->nullable();
            $table->integer('article5')->nullable();
            $table->integer('article6')->nullable();
            $table->integer('article7')->nullable();
            $table->integer('article8')->nullable();
            $table->integer('article9')->nullable();
            $table->integer('article10')->nullable();
            
            $table->string('sub1')->nullable();
            $table->string('sub2')->nullable();
            $table->string('sub3')->nullable();
            $table->string('color')->nullable();

            $table->integer('flg')->nullable();
            $table->integer('flg2')->nullable();
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
        Schema::dropIfExists('stock_accessoires');
    }
}
