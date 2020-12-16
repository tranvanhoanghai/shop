<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bills', function (Blueprint $table) {
            $table->increments('id_bill');
            $table->string('name_bill');

            $table->integer('user_id')->unsigned(); #người nhận
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            
            $table->date('date');
            $table->integer('price_total');
            $table->string('sale')->nullable();
            $table->integer('type_bill');
            $table->integer('seller')->nullable(); #nguoi bán hang

            $table->integer('id_shipping_unit')->unsigned()->nullable();
            $table->foreign('id_shipping_unit')->references('id_shipping_unit')->on('shipping_units')->onDelete('cascade');

            $table->integer('id_shipping_price')->unsigned()->nullable();;
            $table->foreign('id_shipping_price')->references('id_shipping_price')->on('shipping_prices')->onDelete('cascade');

            $table->integer('id_local')->unsigned()->nullable();;
            $table->foreign('id_local')->references('id_local')->on('locals')->onDelete('cascade');

            $table->string('note')->nullable(); 
            $table->integer('price_ship')->nullable(); 
            $table->integer('status'); 

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
        Schema::dropIfExists('bills');
    }
}
