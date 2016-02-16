<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ServerAddIps extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        //
        Schema::table('servers', function (Blueprint $table) {
            $table->string('inner_ip');     //内网 IP
            $table->string('outer_ip');     //外网 IP
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        //
        Schema::table('servers', function (Blueprint $table) {
            $table->dropColumn('inner_ip');
            $table->dropColumn('outer_ip');
        });
    }
}
