<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropertyProductOrderDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('property_product_order_details', function (Blueprint $table) {
        //     $table->unsignedBigInteger('property_product_id');
        //     $table->unsignedBigInteger('order_detail_id');
        //     $table->foreign('property_product_id')
        //         ->references('id')->on('property_products')
        //         ->onDelete('cascade');
        //     $table->foreign('order_detail_id')
        //         ->references('id')->on('order_details')
        //         ->onDelete('cascade');
        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::dropIfExists('property_product_order_details');
    }
}
