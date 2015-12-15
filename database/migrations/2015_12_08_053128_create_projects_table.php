<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //client_product, 项目结构
        Schema::create('projects', function(Blueprint $table) {
            $table->increments('id');                   // 自增 ID
            $table->string('name');                     // 项目的名称
            $table->string('ref_no')->nullable();       //项目编号
            $table->string('seller')->nullable();       // 销售人员
            $table->integer('product_id');              // 产品类型
            $table->integer('client_id');               // 客户
            $table->string('contact')->nullable();      // 联系人
            $table->string('description')->nullable();  // 备注
            $table->dateTime('time');                   // 签约时间 //TODO, 可能有多个时间
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
        Schema::drop('projects');
    }
}
