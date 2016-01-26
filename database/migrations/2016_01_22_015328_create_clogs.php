<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClogs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('clogs', function(Blueprint $table) {
            $table->increments('id');
            $table->dateTime('time');   //记录时间
            $table->integer('user_id'); //操作用户
            $table->string('action');   //操作内容
            $table->json('change');     //变动数据

            $table->integer('object_id');   //所属 Object
            $table->string('object_type');

            $table->integer('level');       //消息等级

            $table->softDeletes();
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
        Schema::drop('clogs');
    }
}
