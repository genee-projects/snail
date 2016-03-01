<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use App\Project;

class ChangeProjects extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        // 修改 projects 中 boolean 的 official 为 tinyint
        // 原 official 如果为 true, 对应的 tinyint 为 1
        // 原 official 如果为 false, 对应的 tinyint 为 0
        // 新 tinyint 2, 表示售前支持

        //更新说明
        //1. 创建一个 signed_status
        //2. 进行数据迁移
        //3. 删除 official

        //1.
        Schema::table('projects', function(Blueprint $table) {
            $table->tinyInteger('signed_status')->default(Project::SIGNED_STATUS_PROBATIONARY);
        });

        //2.

        foreach(Project::withTrashed()->get() as $project) {
            //正式客户
            if ($project->official) {
                $project->signed_status = Project::SIGNED_STATUS_OFFICIAL;
            } else {
                $project->signed_status = Project::SIGNED_STATUS_PROBATIONARY;
            }

            $project->save();
        }

        //3.
        Schema::table('projects', function(Blueprint $table) {
            $table->dropColumn('official');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //恢复步骤

        // 1. 创建 official
        // 2. 数据迁移
        // 3. 删除 signed_status

        //1. 创建 official
        Schema::table('projects', function(Blueprint $table) {
            $table->boolean('official')->default(true); //正式客户
        });

        //2. 数据迁移

        foreach(Project::withTrashed() as $project) {
            switch($project->signed_status) {
                // 正式客户
                case Project::SIGNED_STATUS_OFFICIAL:
                    $project->official = true;
                    $project->save();
                    break;
                //试用客户
                case Project::SIGNED_STATUS_PROBATIONARY:
                    $project->official = false;
                    $project->save();
                    break;
                default:
                    break;
            }
        }

        //3. 删除 signed_status
        Schema::table('projects', function(Blueprint $table) {
            $table->dropColumn('signed_status');
        });
    }
}
