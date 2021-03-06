<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReservingToolsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reserving_tools', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('equipment_id')->nullable();
            $table->integer('approved_by')->nullable();
            $table->enum('reserving_state',[0,1,2,3,4,5]);
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
        Schema::dropIfExists('reserving_tools');
    }
}
