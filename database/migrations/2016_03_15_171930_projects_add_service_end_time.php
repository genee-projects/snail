<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use App\Project;

class ProjectsAddServiceEndTime extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('projects', function(Blueprint $table) {
            $table->dateTime('service_end_time')->nullable();
        });

        foreach(Project::all() as $project) {
            if ($project->check_time) {
                switch ($project->service_unit) {
                    case Project::SERVICE_UNIT_MONTH :
                        $end_time = $project->check_time->copy()->addMonths($project->service_value);
                        break;
                    case Project::SERVICE_UNIT_YEAR :
                        $end_time = $project->check_time->copy()->addYears($project->service_value);
                        break;
                    case Project::SERVICE_UNIT_DAY :
                        $end_time = $project->check_time->copy()->addDays($project->service_value);
                        break;
                }

                $project->service_end_time = $end_time;

                $project->save();
            }
        }
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
            $table->dropColumn('service_end_time');
        });
    }
}
