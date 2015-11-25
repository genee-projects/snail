<?php

namespace app;

use Illuminate\Database\Eloquent\Model;
use Mail;

class Client extends Model
{
    protected $table = 'clients';

    public $timestamps = false;

    //设定 backup_sync 以 boolean 类型返回
    protected $casts = [
        'backup_sync' => 'boolean',
        'warning'=> 'boolean',
		'latest_backup_time'=> 'integer',
    ];

    //刷新备份时间
    public function refreshLatestBackupTime()
    {
        $dumpBackupDir = $this->dumpBackupDir();

        //目录不存在, 不更新
        if (!file_exists($dumpBackupDir)) {
            return;
        }

        $files = scandir($dumpBackupDir, SCANDIR_SORT_DESCENDING);
        $maxBackupFile = current($files);

        //为 2015-10-28T041832.tgz
        //修正为 2015-10-28 041832
        $latestBackupTime = str_replace([
            'T',
            '.tgz',
        ], [
            ' ',
            null,
        ], $maxBackupFile);

        $this->latest_backup_time = strtotime($latestBackupTime);
        $this->save();
    }

	public function dumpBackupDir() {
			// /data/backup/data/fqdn/mysqldump/%site/%lab/
			$backupRootDir = config('backup.dir');

			$backupDir = strtr('%root/%fqdn/mysqldump/%site/%lab/', [
					'%root'=> $backupRootDir,
					'%fqdn'=> $this->fqdn,
					'%site'=> $this->site,
					'%lab'=> $this->lab,
			]);

			return $backupDir;
	}

    //当前 client 的备份目录
    public function backupDir()
    {

        // data/backup/data/fqdn/
        $backupRootDir = config('backup.dir');

        $backupDir = strtr('%root/%fqdn', [
            '%root'=> $backupRootDir,
            '%fqdn'=> $this->fqdn,
        ]);

        return $backupDir;
    }

    // 报警
    public function warning()
    {
        $data = [
            'fqdn'=> $this->fqdn,
            'latest_backup_time'=> date('Y-m-d H:i:s', $this->latest_backup_time),
        ];

        Mail::send('mail/warning', $data, function ($message) {
            $message
                ->from('support@genee.cn')
                ->to(config('backup.warning_contact'))
                ->subject('Backup Alarm!');
        });
    }
}
