<?php

namespace app\Console\Commands\Monitor;

use Illuminate\Console\Command;
use Mail;

class UpdateBackupDir extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'monitor:update-backup-dir';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Backup Dir';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // 进行遍历
        foreach (\App\Client::all() as $client) {
            # 针对可进行备份同步的, 更新备份目录
            if ($client->backup_sync) {
                $client->backup_dir = $client->backupDir();
                $client->save();
            }
        }
    }
}
