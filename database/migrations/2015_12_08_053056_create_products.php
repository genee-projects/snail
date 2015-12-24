<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //products, 产品结构
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');       // 自增 ID
            $table->string('name');         // 产品名称
            $table->string('description')->nullable();  // 产品备注
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
        Schema::drop('products');
    }
}
