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
            $table->string('url')->nullable();          // 地址
            $table->integer('parent_id')->nullable()->default(0);   // 父级 client 的 id
            $table->index('parent_id');
            $table->index('progress')->nullable()->default(1);      // 客户进度, 1 表示初步沟通
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
