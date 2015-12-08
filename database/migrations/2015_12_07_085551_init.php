<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Init extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        //clients, 客户结构
        Schema::create('clients', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('comment')->nullable();
        });

        //products, 产品结构
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');       // 自增 ID
            $table->string('name');         // 产品名称
            $table->string('description')->nullable();  // 产品备注
        });

        //client_product, 项目结构
        Schema::create('client_products', function(Blueprint $table) {
            $table->increments('id');       // 自增 ID
            $table->string('name');         // 项目的名称
            //$table->string('');           //
        });

        //server, 服务器结构
        Schema::create('servers', function(Blueprint $table) {
            $table->increments('id');               // 自增 ID
            $table->string('name');                 // 服务器名称
            $table->boolean('customer_provide')->nullable()->default(false);    // 客户自备服务器(如果为客户自备服务区, 那么为 true, 否则为 false
            $table->string('barcode')->nullable();              // 条形码
            $table->string('sn')->nullable();                   // 序列号
            $table->string('model')->nullable();                // 型号
            $table->string('cpu')->nullable();                  // cpu 核心
            $table->string('memory')->nullable();               // 内存
            $table->string('disk')->nullable();                 // 硬盘
            $table->string('os')->nullable();                   // 操作系统
            $table->string('database')->nullable();             // 数据库
            $table->string('fqdn')->nullable();                 // FQDN
            $table->string('vpn')->nullable();                  // VPN IP
            $table->string('description')->nullable();          //备注信息
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::drop('clients');
        Schema::drop('products');
        Schema::drop('client_products');
        SChema::drop('servers');
    }
}
