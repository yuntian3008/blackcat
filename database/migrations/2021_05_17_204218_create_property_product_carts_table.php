<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropertyProductCartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('property_product_carts', function (Blueprint $table) {
        //     $table->unsignedBigInteger('property_product_id');
        //     $table->unsignedBigInteger('cart_item_id');
        //     $table->foreign('property_product_id')
        //         ->references('id')->on('property_products')
        //         ->onDelete('cascade');
        //     $table->foreign('cart_item_id')
        //         ->references('id')->on('cart_items')
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
        // Schema::dropIfExists('property_product_carts');
    }
}
