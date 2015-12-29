<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectHardwares extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('project_hardwares', function(Blueprint $table) {
            $table->integer('project_id')->unsigned()->index();
            $table->foreign('project_id')->references('id')->on('projects');

            $table->integer('hardware_id')->unsigned()->index();
            $table->foreign('hardware_id')->references('id')->on('hardwares');

            $table->integer('deployed_count')->nullable();   //安装数量
            $table->integer('plan_count')->nullable();       // 计划安装数量
            $table->string('description')->nullable();      // 备注
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
        Schema::drop('project_hardwares');
    }
}
