<?php

namespace app\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        \App\Console\Commands\Inspire::class,
        \App\Console\Commands\Monitor\Check::class,
        \App\Console\Commands\Monitor\TestEmail::class,
        \App\Console\Commands\Monitor\DisableClientBackupSync::class,
        \App\Console\Commands\Monitor\UpdateBackupDir::class,
        \App\Console\Commands\Monitor\RefreshBackupTime::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {

    	# 每小时进行一次更新
    	# 可通过页面强制更新
    	# 0 * * * * php artisan schedule:run 1>> /dev/null 2>&1
    }
}
