<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrackingGoodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tracking_goods', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('order_detail_id')->nullable();
            $table->foreign('order_detail_id')
                ->references('id')->on('order_details')
                ->onDelete('cascade');
            $table->unsignedBigInteger('goods_receipt_detail_id')->nullable();
            $table->foreign('goods_receipt_detail_id')
                ->references('id')->on('goods_receipt_details')
                ->onDelete('cascade');
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
        Schema::dropIfExists('tracking_goods');
    }
}
