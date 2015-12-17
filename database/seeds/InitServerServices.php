<?php

use Illuminate\Database\Seeder;
use App\Server;
use App\Service;
use App\Item;


class InitServerServices extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $root = Server::root();

        $services = [
            [
                'name'=> '数据库',
                'code'=> 'database',
                'items'=> [
                    'host'=> '172.17.42.1',
                ]
            ],
            [
                'name'=> '缓存',
                'code'=> 'redis',
                'items'=> [
                    'host'=> '172.17.42.1',
                    'port'=> '6379',
                ],
            ],
            [
                'name'=> '全文索引',
                'code'=> 'sphinxsearch',
                'items'=> [
                    'host'=> '172.17.42.1',
                    'port'=> '6379',
                ],
            ],
            [
                'name'=> '队列服务',
                'code'=> 'beanstalkd',
                'items'=> [
                    'host'=> '172.17.42.1',
                    'port'=> '11300',
                ],
            ],
            [
                'name'=> 'Node-Lims2',
                'code'=> 'node_lims2',
                'items'=> [
                    'beanstalkd'=> '172.17.42.1:11300',
                    'host'=> '172.17.42.1',
                    'port'=> '8041',
                    'salt'=> NULL,
                    'rpc_token'=> NULL,
                ],
            ],
            [   'name'=> 'Genee Updater',
                'code'=> 'genee_updater',
                'items'=> [
                    'port'=> '3000',
                    'site_url'=> NULL,
                ],
            ],
        ];

        foreach($services as $service) {

            $_s = new Service;
            $_s->name = $service['name'];
            $_s->code = $service['code'];

            $_s->object()->associate($root);
            $_s->save();

            foreach($service['items'] as $k => $v) {
                $_t = new Item;


                $_t->object()->associate($_s);
                $_t->key = $k;
                $_t->value = $v;

                $_t->save();
            }
        }
    }
}
