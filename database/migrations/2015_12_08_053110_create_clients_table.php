<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //clients, 客户结构
        Schema::create('clients', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');                     // 名称
            $table->string('address')->nullable();      // 地址
            $table->string('description')->nullable();  // 备注
            $table->string('url')->nullable();          // 网站/链接
            $table->string('seller_url')->nullable();   // 销售试用的纷享销客的 URL
            $table->string('type')->nullable();         //客户类型
            $table->string('region')->nullable();       //所在区域
            $table->integer('parent_id')->nullable()->default(0);   // 父级 client 的 id
            $table->index('parent_id');
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
        Schema::drop('clients');
    }
}
