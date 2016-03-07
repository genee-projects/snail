<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use App\Project;

class UpdateProjectTimes extends Migration
{
    /**
     * project 增加如下字段:
     * 1. check_time 为实际验收时间
     * 2. service_unit 维保单位, int
     * 3. service_value 维保值, int,
     * 维保时间为 check_time 到 check_time + service_unit 对应的值 * service_value
     */
    public function up()
    {
        //
        Schema::table('projects', function(Blueprint $table) {

            //cancelled_time 进行删除
            //会手动进行导出 cancelled_time 交付给相关人员
            $table->dropColumn('cancelled_time');

            //默认为 1 年
            $table->tinyInteger('service_unit')->nullable()->default(\App\Project::SERVICE_UNIT_YEAR);
            $table->tinyInteger('service_value')->nullable()->default(1);
            $table->dateTime('check_time')->nullable();
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
        Schema::table('projects', function(Blueprint $table) {
            $table->dropColumn('service_unit');
            $table->dropColumn('service_value');
            $table->dropColumn('check_time');

            $table->dateTime('cancelled_time')->nullable(); // 服务停止时间
        });
    }
}
