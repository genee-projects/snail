<?php

use Illuminate\Database\Schema\Blueprinteger;
use Illuminate\Database\Migrations\Migration;

class init extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //

    Schema::create('clients', function ($table) {
        $table->increments('id');
        $table->string('name');
        $table->string('vpn');
        $table->string('site');
        $table->string('lab');
        $table->string('fqdn');

        $table->integer('latest_backup_time');
        $table->boolean('backup_sync')->default(true);

        $table->integer('latest_warning_time');
        $table->boolean('warning')->default(false);

        $table->string('backup_dir');

        $table->string('comment');
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
    Schema::drop('clients');
    }
}
