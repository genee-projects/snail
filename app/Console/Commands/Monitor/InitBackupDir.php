<?php

namespace app\Console\Commands\Monitor;

use Illuminate\Console\Command;
use Mail;

class InitBackupDir extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'monitor:init-backup-dir';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Init Backup Dir';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
	    // 进行遍历
	    foreach (\App\Client::all() as $client) {
		$client->backup_dir = $client->backupDir();
		$client->save();
	    }
    }
}
