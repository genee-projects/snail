<?php

namespace app\Console\Commands\Monitor;

use Illuminate\Console\Command;
use App\Client;
use Mail;

class DisableClientBackupSync extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'monitor:disable-client-backup-sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Disable Client Backup Sync';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

	$fqdn = $this->ask('请输入对应客户的 fqdn: ');
	
	$client = Client::where('fqdn', $fqdn)->first();

	if ($client !== NULL) {
		$comment = $this->ask('请输入该客户停止原因: ');

		$client->backup_sync = false;
		$client->warning = false;
		$client->latest_warning_time = 0;
		$client->comment = $comment;
		$client->save();
		$this->info('更新成功!');
		return;
	}

	$this->error('无该客户');
    }
}
