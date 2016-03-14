<?php

use Illuminate\Database\Seeder;
use App\Role;

class InitRoles extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        //初始化系统默认 Role
        foreach (['销售', '售后', '产品', '硬件'] as $name) {
            $role = Role::where('name', $name)->first();

            if (!$role) {
                $role = new Role();
            }

            $role->name = $name;
            $role->system = true;
            $role->save();
        }

        //销售权限设定
        $role = Role::where('name', '销售')->first();

        $role->perms = [
            '产品查看',
            '服务器查看',
            '硬件查看',
            '客户查看',
            '硬件查看',
            '项目查看',
            '客户信息管理',
            '项目签约',
            '项目信息管理',
            '项目模块管理',
            '项目参数管理',
            '项目参数管理',
            '项目硬件管理',
            '项目服务器管理',
        ];

        $role->save();

        //售后权限设定
        $role = Role::where('name', '售后')->first();
        $role->perms = [
            '产品查看',
            '服务器查看',
            '硬件查看',
            '客户查看',
            '硬件查看',
            '项目查看',
            '项目信息管理',
            '项目模块管理',
            '项目参数管理',
            '项目硬件管理',
            '项目服务器管理',
            '服务器信息管理',
            '项目文件管理',
            '项目外出记录管理',
            '项目硬件部署管理',
        ];

        $role->save();

        //产品权限设定
        $role = Role::where('name', '产品')->first();
        $role->perms = [
            '产品查看',
            '服务器查看',
            '硬件查看',
            '客户查看',
            '硬件查看',
            '项目查看',
            '产品信息管理',
            '产品类别管理',
            '产品模块管理',
            '产品参数管理',
            '服务器信息管理',
        ];

        $role->save();

        //硬件权限设定
        $role = Role::where('name', '硬件')->first();
        $role->perms = [
            '产品查看',
            '服务器查看',
            '硬件查看',
            '客户查看',
            '硬件查看',
            '项目查看',
            '硬件管理',
        ];

        $role->save();
    }
}
