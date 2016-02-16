<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParams extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        //
        Schema::create('params', function (Blueprint $table) {

            $table->increments('id');

            $table->string('name')->nullable();         //参数名称 (人数限制)
            $table->string('description')->nullable();  //参数描述
            $table->string('code');                     //参数代码
            $table->string('value')->nullable();        //参数值
            $table->integer('product_id');              // 所属 product
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        //
        Schema::drop('params');
    }
}
