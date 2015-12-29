<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubProductHardwares extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('sub_product_hardwares', function(Blueprint $table) {
            $table->integer('sub_product_id')->unsigned()->index();
            $table->foreign('sub_product_id')->references('id')->on('sub_products');

            $table->integer('hardware_id')->unsigned()->index();
            $table->foreign('hardware_id')->references('id')->on('hardwares');

            $table->integer('count')->nullable();       //默认部署数量
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
        Schema::drop('sub_product_hardwares');
    }
}
