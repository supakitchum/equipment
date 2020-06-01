<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTaskCalEquipmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('task_cal_equipments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('task_name')->nullable();
            $table->integer('equipment_id');
            $table->integer('user_id');
            $table->timestamp('due_date')->nullable();
            $table->text('description')->nullable();
            $table->boolean('state')->nullable();
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
        Schema::dropIfExists('task_cal_equipments');
    }
}
