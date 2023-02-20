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
            $table->integer('table_number');
            $table->integer('serial_id');
            $table->string('product_name');
            $table->integer('product_id');
            $table->string('product_type');
            $table->string('product_toppings');
            $table->double('product_price');
            $table->integer('category_id');
            $table->string('category_name');
            $table->integer('order_quantity');
            $table->datetime('order_datetime');
            $table->integer('concurrent_connections');
            $table->integer('active_flag');
            $table->json('json_data');
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
