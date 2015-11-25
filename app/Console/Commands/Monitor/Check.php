<?php

namespace app\Console\Commands\Monitor;

use Illuminate\Console\Command;
use Mail;

class Check extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'monitor:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check Backup Status';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
	    // 进行遍历
	    foreach (\App\Client::all() as $client) {
		    // 判断是否可进行 sync
		    //如果备份可悲 sync 到本地
		    if ($client->backup_sync) {

				//先清空报警
				$client->warning = false;
				$client->save();

				//先进行本地的备份数据的刷新
			    $client->refreshLatestBackupTime();

				//进行本地的备份时间的检测, 判断是否需要进行备份报警
			    if ($client->latest_backup_time && (time() - $client->latest_backup_time > config('backup.warning_duration'))) {
				    //报警
				    $client->warning();

				    $client->latest_warning_time = time();
				    $client->warning = true;
				    $client->save();
			    }
		    }
	    }
    }
}
