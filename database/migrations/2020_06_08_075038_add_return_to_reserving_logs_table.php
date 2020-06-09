<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddReturnToReservingLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('reserving_logs', function (Blueprint $table) {
            $table->dateTime('return_date')->nullable();
            $table->dateTime('return_reason')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('reserving_logs', function (Blueprint $table) {
            $table->dropColumn('return_reason');
            $table->dropColumn('return_date');
        });
    }
}
