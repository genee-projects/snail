<?php

namespace app\Console\Commands\Monitor;

use Illuminate\Console\Command;
use Mail;

class RefreshBackupTime extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'monitor:refresh-backup-time';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Refresh Backup Time';

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

				//先进行本地的备份数据的刷新
			    $client->refreshLatestBackupTime();
				$client->save();
		    }
	    }
    }
}
