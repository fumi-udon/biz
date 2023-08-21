<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToStockIngredientTable extends Migration
{
    public function up()
    {
        Schema::table('stock_ingredients', function (Blueprint $table) {
            // 数値型カラムの追加
            $table->decimal('chashu')->nullable();
            $table->decimal('paiko')->nullable();
            $table->decimal('poulet_cru')->nullable();
            $table->decimal('riz')->nullable();
            $table->decimal('lait')->nullable();
        });
    }

    public function down()
    {
        Schema::table('stock_ingredients', function (Blueprint $table) {
            // カラムの削除（ロールバック時）
            $table->dropColumn(['chashu', 'paiko', 'poulet_cru', 'riz', 'lait']);
        });
    }
}
