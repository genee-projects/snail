<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProjectAddLoginUrl extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        //
        Schema::table('projects', function (Blueprint $table) {
            $table->string('login_url');    //登录 URL
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        //
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn('login_url');
        });
    }
}
