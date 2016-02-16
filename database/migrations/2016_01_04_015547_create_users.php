<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsers extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        //
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('gapper_id');   //gapper 的 id
            $table->string('name'); //名称
            $table->string('icon');

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        //
        Schema::drop('users');
    }
}
