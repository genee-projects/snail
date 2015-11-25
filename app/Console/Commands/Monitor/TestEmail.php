<?php

namespace app\Console\Commands\Monitor;

use Illuminate\Console\Command;
use Mail;

class TestEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'monitor:test-email';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test email send';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
    $to = $this->ask('收件人地址: ');

        Mail::send('mail/warning', [
        'fqdn'=> 'test.cn',
        'latest_backup_time'=> '2015-11-11 11:11:11',
    ], function ($message) use ($to) {
        $message
            ->from('support@genee.cn')
            ->to($to)
            ->subject('test-email');
    });
    }
}
