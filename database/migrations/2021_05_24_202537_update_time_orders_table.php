<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTimeOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function($table)
        {
            $table->dateTime('request_date')->nullable()->default(null)->change();
            $table->dateTime('get_date')->nullable()->default(null)->change();
            $table->dateTime('ship_date')->nullable()->default(null)->change();
            $table->dateTime('completion_date')->nullable()->default(null)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
