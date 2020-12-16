<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id_product');
            $table->string('name_product');
            $table->string('slug_product');

            $table->integer('id_product_type')->unsigned();
            $table->foreign('id_product_type')->references('id_product_type')->on('product_types'); # loại sản phẩm
            $table->string('img');

            $table->integer('price0')->nullable();  #giá vốn
            $table->integer('price1')->nullable();  #giá bán
            $table->string('sale')->nullable();
            $table->text('description')->nullable();
            $table->string('unit');
            $table->string('status');
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
        Schema::dropIfExists('products');
    }
}
