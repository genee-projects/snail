<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropServerUsage extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        //
        Schema::table('project_servers', function (Blueprint $table) {
            $table->dropColumn('usage');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        //
        Schema::table('project_servers', function (Blueprint $table) {
            $table->string('usage');
        });
    }
}
