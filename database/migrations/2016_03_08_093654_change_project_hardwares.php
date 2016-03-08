<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeProjectHardwares extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        # project_hardwares 进行更新
        # deployed_count 删除(实际部署数量)
        # plan_count 重命名为 count
        Schema::table('project_hardwares', function(Blueprint $table) {

            $table->dropColumn('deployed_count');
            $table->renameColumn('plan_count', 'count');

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
        Schema::table('project_hardwares', function(Blueprint $table) {
            $table->renameColumn('count', 'plan_count');
            $table->integer('deployed_count')->nullable();   //安装数量
        });
    }
}
