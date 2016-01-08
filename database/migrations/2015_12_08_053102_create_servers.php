<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Server;

class CreateServers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //server, 服务器结构
        Schema::create('servers', function(Blueprint $table) {
            $table->increments('id');               // 自增 ID
            $table->string('name');                 // 服务器名称
            $table->integer('provider')->nullable()->default(Server::PROVIDER_COMPANY);   //服务器提供方, 默认为公司提供
            $table->string('barcode')->nullable();              // 条形码
            $table->string('sn')->nullable();                   // 序列号
            $table->string('model')->nullable();                // 型号
            $table->string('cpu')->nullable();                  // cpu 核心
            $table->string('memory')->nullable();               // 内存
            $table->string('disk')->nullable();                 // 硬盘
            $table->string('os')->nullable();                   // 操作系统
            $table->string('fqdn')->nullable();                 // FQDN
            $table->string('vpn')->nullable();                  // VPN IP
            $table->string('description')->nullable();          // 备注信息
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        SChema::drop('servers');
    }
}
