<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bill_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_bill')->unsigned();
            $table->foreign('id_bill')->references('id_bill')->on('bills')->onDelete('cascade');

            $table->integer('id_product')->unsigned();
            $table->foreign('id_product')->references('id_product')->on('products')->onDelete('cascade');

            $table->integer('id_size');
            $table->integer('id_color');

            $table->integer('qty'); # tong so lượng
            $table->integer('unit_price'); # Don gia 
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
        Schema::dropIfExists('bill_details');
    }
}
