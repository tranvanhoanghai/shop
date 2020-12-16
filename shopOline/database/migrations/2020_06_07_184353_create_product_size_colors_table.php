<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductSizeColorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_size_colors', function (Blueprint $table) {
            $table->integer('id_product')->unsigned();
            $table->foreign('id_product')->references('id_product')->on('products')->onDelete('cascade');

            $table->integer('id_size')->unsigned()->nullable();
            $table->foreign('id_size')->references('id_size')->on('sizes')->onDelete('cascade');

            $table->integer('id_color')->unsigned()->nullable();
            $table->foreign('id_color')->references('id_color')->on('colors')->onDelete('cascade');

            $table->unique(['id_product','id_size', 'id_color']);

            $table->integer('quantity')->nullable();


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
        Schema::dropIfExists('product_size_colors');
    }
}
