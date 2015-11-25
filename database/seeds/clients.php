<?php

use Illuminate\Database\Seeder;
use App\Client;

class clients extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		//DB::unprepared(file_get_contents('database/seeds/clients.sql'));
		//使用 DB::unprepared 后续增加新的客户不是太好
		//使用 CSV 文件读取进行管理
		$csvHandler = fopen('database/seeds/clients.csv', 'r');
		//name,vpn,site,lab,fqdn,backup_sync,comment 
		//例如:
		//南开大学仪器管理系统,10.0.10.56,cf,nankai,1

		if (($handler = fopen('database/seeds/clients.csv', 'r')) !== false) {
				while(($data = fgetcsv($handler, 1000, ',')) !== false) {
						//
						$c = new Client;
						//批量赋值
						list($c->name, $c->vpn, $c->site, $c->lab, $c->fqdn, $c->backup_sync, $c->comment) = $data;

						$c->save();
				}
		}
    }
}
