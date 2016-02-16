<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjects extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        //client_product, 项目结构
        Schema::create('projects', function (Blueprint $table) {
            $table->increments('id');                       // 自增 ID
            $table->string('ref_no')->nullable();           //项目编号
            $table->integer('client_id');                   // 客户
            $table->string('name');                         // 项目的名称
            $table->integer('product_id');                  // 产品类型
            $table->string('contact_user')->nullable();     // 联系人
            $table->string('contact_phone')->nullable();    //联系电话
            $table->string('contact_email')->nullable();    //邮箱
            $table->string('engineer')->nullable();         // 工程师负责人
            $table->string('deploy_address')->nullable();   // 部署地址
            $table->string('seller')->nullable();           // 销售人员
            $table->string('description')->nullable();      // 备注
            $table->string('way')->nullable();              // 乘车线路
            $table->dateTime('signed_time')->nullable();    // 签约时间
            $table->dateTime('cancelled_time')->nullable(); // 服务停止时间

            $table->boolean('vip')->default(false); //重点客户
            $table->boolean('official')->default(true); //正式客户
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop('projects');
    }
}
