<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecords extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // records 为外出记录
        Schema::create('records', function(Blueprint $table) {
            $table->increments('id');                   // 自增 ID
            $table->integer('user_id');                 // 工程师 ID
            $table->integer('project_id');              // 项目 ID
            $table->dateTime('time')->nullable();       // 外出时间
            $table->string('content')->nullable();      // 外出事项
            $table->string('contact')->nullable();      // 联系人
            $table->string('phone')->nullable();        // 联系方式
            $table->integer('software_count')->nullable();  //软件数量
            $table->string('hardware_name')->nullable();   // 硬件名称
            $table->integer('hardware_count')->nullable();  //硬件数量
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
        Schema::drop('records');
    }
}
