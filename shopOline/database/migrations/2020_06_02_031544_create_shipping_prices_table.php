<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShippingPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shipping_prices', function (Blueprint $table) {
            $table->increments('id_shipping_price');

            $table->integer('id_shipping_type')->unsigned();
            $table->foreign('id_shipping_type')->references('id_shipping_type')->on('shipping_types')->onDelete('cascade');

            $table->integer('id_local')->unsigned();
            $table->foreign('id_local')->references('id_local')->on('locals')->onDelete('cascade');
            $table->string('price_ship');

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
        Schema::dropIfExists('shipping_prices');
    }
}
