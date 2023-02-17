<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesDataByProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_data_by_products', function (Blueprint $table) {
            $table->id();
            $table->string('product_name');
            $table->integer('product_id');
            $table->string('product_type');
            $table->integer('product_type_id');
            $table->string('extra');
            $table->smallInteger('extra_flg');
            $table->integer('category_id');
            $table->string('category_name');
            $table->string('sub_category_name');
            $table->integer('order_quantity');
            $table->string('unit_name');
            $table->double('price');
            $table->double('sub_price');
            $table->smallInteger('dispo_flg');
            $table->smallInteger('display_flg');
            $table->smallInteger('saison_id');
            $table->string('add_info');
            $table->text('add_txt');
            $table->datetime('order_datetime');
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
        Schema::dropIfExists('sales_data_by_products');
    }
}
