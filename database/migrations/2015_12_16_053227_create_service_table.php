<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('services', function(Blueprint $table) {
            $table->increments('id');       // 自增 ID
            $table->string('name');         // 名称
            $table->string('code');         // 代码
            $table->integer('object_id');   // 所属的对象 ID
            $table->string('object_type');  // 所属的对象类型
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
        Schema::drop('services');
    }
}
