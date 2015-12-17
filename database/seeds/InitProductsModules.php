<?php

use Illuminate\Database\Seeder;
use App\Product;
use App\Module;

class InitProductsModules extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $data = [
            'LIMS-CF'=> [
                [
                    'name'=> '文件系统',
                    'code'=> 'nfs',
                ],
                [
                    'name'=> '权限管理',
                    'code'=> 'roles',
                ],
                [
                    'name'=> '人员管理',
                    'code'=> 'people',
                ],
                [
                    'name'=> '实验室管理',
                    'code'=> 'labs',
                ],
                [
                    'name'=> '仪器管理',
                    'code'=> 'equipments',
                ],
                [
                    'name'=> '消息中心',
                    'code'=> 'messages'
                ],
                [
                    'name'=> '财务中心',
                    'code'=> 'billing',
                ],
                [
                    'name'=> '仪器收费',
                    'code'=> 'eq_charge',
                ],
                [
                    'name'=> '仪器预约',
                    'code'=> 'eq_reserv',
                ],
                [
                    'name'=> '仪器送样',
                    'code'=> 'eq_sample',
                ],
                [
                    'name'=> '仪器黑名单',
                    'code'=> 'eq_ban',
                ],
                [
                    'name'=> '仪器监控',
                    'code'=> 'eq_mon',
                ],
                [
                    'name'=> '自定义字段',
                    'code'=> 'extra',
                ],
                [
                    'name'=> '微信',
                    'code'=> 'wechat',
                ],
                [
                    'name'=> '仪器控',
                    'code'=> 'yiqikong',
                ],
                [
                    'name'=> '更新记录',
                    'code'=> 'update',
                ],
                [
                    'name'=> '预约工作时间',
                    'code'=> 'eq_empower'
                ],
                [
                    'name'=> 'GMeter',
                    'code'=> 'eq_meter',
                ],
            ],
            'LIMS-CF-Lite'=> [
                [
                    'name'=> '文件系统',
                    'code'=> 'nfs',
                ],
                [
                    'name'=> '权限管理',
                    'code'=> 'roles',
                ],
                [
                    'name'=> '人员管理',
                    'code'=> 'people',
                ],
                [
                    'name'=> '实验室管理',
                    'code'=> 'labs',
                ],
                [
                    'name'=> '仪器管理',
                    'code'=> 'equipments',
                ],
                [
                    'name'=> '消息中心',
                    'code'=> 'messages'
                ],
                [
                    'name'=> '财务中心',
                    'code'=> 'billing',
                ],
                [
                    'name'=> '仪器收费',
                    'code'=> 'eq_charge',
                ],
                [
                    'name'=> '仪器预约',
                    'code'=> 'eq_reserv',
                ],
                [
                    'name'=> '仪器送样',
                    'code'=> 'eq_sample',
                ],
                [
                    'name'=> '仪器黑名单',
                    'code'=> 'eq_ban',
                ],
                [
                    'name'=> '仪器监控',
                    'code'=> 'eq_mon',
                ],
                [
                    'name'=> '自定义字段',
                    'code'=> 'extra',
                ],
                [
                    'name'=> '微信',
                    'code'=> 'wechat',
                ],
                [
                    'name'=> '仪器控',
                    'code'=> 'yiqikong',
                ],
                [
                    'name'=> '更新记录',
                    'code'=> 'update',
                ],
            ],
            'LIMS-CF-Mini'=> [
                [
                    'name'=> '文件系统',
                    'code'=> 'nfs',
                ],
                [
                    'name'=> '权限管理',
                    'code'=> 'roles',
                ],
                [
                    'name'=> '人员管理',
                    'code'=> 'people',
                ],
                [
                    'name'=> '实验室管理',
                    'code'=> 'labs',
                ],
                [
                    'name'=> '仪器管理',
                    'code'=> 'equipments',
                ],
                [
                    'name'=> '消息中心',
                    'code'=> 'messages'
                ],
                [
                    'name'=> '仪器收费',
                    'code'=> 'eq_charge',
                ],
                [
                    'name'=> '仪器预约',
                    'code'=> 'eq_reserv',
                ],
                [
                    'name'=> '仪器送样',
                    'code'=> 'eq_sample',
                ],
                [
                    'name'=> '仪器黑名单',
                    'code'=> 'eq_ban',
                ],
                [
                    'name'=> '自定义字段',
                    'code'=> 'extra',
                ],
                [
                    'name'=> '更新记录',
                    'code'=> 'update',
                ],
                [
                    'name'=> '预约工作时间',
                    'code'=> 'eq_empower',
                ],
            ],
            'LIMS'=> [
                [
                    'name'=> '文件系统',
                    'code'=> 'nfs',
                ],
                [
                    'name'=> '权限管理',
                    'code'=> 'roles',
                ],
                [
                    'name'=> '人员管理',
                    'code'=> 'people',
                ],
                [
                    'name'=> '仪器管理',
                    'code'=> 'equipments',
                ],
                [
                    'name'=> '消息中心',
                    'code'=> 'messages'
                ],
                [
                    'name'=> '仪器预约',
                    'code'=> 'eq_reserv',
                ],
                [
                    'name'=> '仪器监控',
                    'code'=> 'eq_mon',
                ],
                [
                    'name'=> '仪器黑名单',
                    'code'=> 'eq_ban',
                ],
                [
                    'name'=> '自定义字段',
                    'code'=> 'extra',
                ],
                [
                    'name'=> '更新记录',
                    'code'=> 'update',
                ],
                [
                    'name'=> '预约工作时间',
                    'code'=> 'eq_empower',
                ],
                [
                    'name'=> '财务管理',
                    'code'=> 'grants',
                ],
                [
                    'name'=> '存货管理',
                    'code'=> 'inventory',
                ],
                [
                    'name'=> '订单管理',
                    'code'=> 'orders',
                ],
                [
                    'name'=> '任务管理',
                    'code'=> 'treenote',
                ],
                [
                    'name'=> '供货商管理',
                    'code'=> 'vendor',
                ],
                [
                    'name'=> '日程管理',
                    'code'=> 'schedule',
                ]

            ],
            'Billing'=> [

            ],
            'Mall'=> [

            ],
            'Tender'=> [

            ],
        ];

        foreach($data as $product_name => $modules) {

            $product = Product::where('name', '=', $product_name)->first();

            foreach($modules as $module) {
                $_m = new Module();

                $_m->name = $module['name'];
                $_m->code = $module['code'];

                $_m->object()->associate($product);

                $_m->save();
            }
        }
    }
}
