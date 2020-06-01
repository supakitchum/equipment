<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReservingLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reserving_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('reserving_id');
            $table->timestamp('approve_date')->nullable();
            $table->timestamp('transfer_date')->nullable();
            $table->timestamp('reject_date')->nullable();
            $table->timestamp('request_date')->nullable();
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
        Schema::dropIfExists('reserving_logs');
    }
}
