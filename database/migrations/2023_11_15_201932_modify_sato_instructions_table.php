<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifySatoInstructionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sato_instructions', function (Blueprint $table) {
            // 既存の定義を変更するために変更が必要ならここに記述

            // 例: VARCHAR から TEXT に変更
            $table->text('override_tx_1')->change();
            $table->text('override_tx_2')->change();
            $table->text('override_tx_3')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
