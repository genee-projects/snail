<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ParamsRelationalAddManual extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        //
        Schema::table('project_params', function (Blueprint $table) {
            $table->boolean('manual');
        });

        Schema::table('sub_product_params', function (Blueprint $table) {
            $table->boolean('manual');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        //

        Schema::table('project_params', function (Blueprint $table) {
            $table->dropColumn('manual');
        });

        Schema::table('sub_product_params', function (Blueprint $table) {
            $table->dropColumn('manual');
        });
    }
}
