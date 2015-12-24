<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubProductParams extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('sub_product_params', function(Blueprint $table) {
            $table->integer('sub_product_id')->unsigned()->index();
            $table->foreign('sub_product_id')->references('id')->on('sub_products');

            $table->integer('param_id')->unsigned()->index();
            $table->foreign('param_id')->references('id')->on('params');

            $table->string('value');    //附加参数, params
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
        Schema::drop('sub_product_params');
    }
}
