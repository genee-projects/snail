<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHardwares extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('hardwares', function(Blueprint $table) {

            $table->increments('id');       // 自增 ID
            $table->string('name');         // 名称
            $table->string('description');  // 描述
            $table->string('model');        // 规格/型号
            $table->integer('product_id');  // 硬件属于 product
            $table->boolean('self_produce')->default(true);      //是否自产
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
        Schema::drop('hardwares');
    }
}
