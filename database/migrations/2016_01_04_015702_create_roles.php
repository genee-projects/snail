<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoles extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        //
        Schema::create('roles', function (Blueprint $table) {

            $table->increments('id');
            $table->string('name');
            $table->boolean('system')->default(false); //是否为系统默认角色

            $table->json('perms');   //权限

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        //
        Schema::drop('roles');
    }
}
