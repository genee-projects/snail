<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHardwareField extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        //
        Schema::create('hardware_fields', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('hardware_id');
            $table->string('name');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        //
        Schema::drop('hardware_fields');
    }
}
