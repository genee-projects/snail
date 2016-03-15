<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class HardwareItemAddRefNo extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        //
        Schema::table('hardware_items', function (Blueprint $table) {
            $table->string('ref_no'); # 增加硬件序列号
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        //
        Schame::table('hardware_items', function (Blueprint $table) {
            $table->removeColumn('ref_no'); #增加硬件序列号
        });
    }
}
