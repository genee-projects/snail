<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHardwareItem extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        //
        Schema::create('hardware_items', function (Blueprint $table) {
            $table->increments('id');       // 自增 ID
            $table->integer('hardware_id');     //硬件
            $table->integer('project_id');      //项目 ID
            $table->string('equipment_name')->nullable();   //仪器名称
            $table->integer('equipment_id')->nullable();    //仪器 CF-ID
            $table->json('extra');              //附加参数
            $table->tinyInteger('status')->default(\App\HardwareItem::STATUS_ON_THE_WAY);   //默认状态, 在途中
            $table->dateTime('time')->nullable(); // 部署时间
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        //
        Schema::drop('hardware_items');
    }
}
