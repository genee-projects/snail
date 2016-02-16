<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Server;

class ServersController extends Controller
{
    /**
     * @api {get} /servers/ 获取所有的 servers
     * @apiGroup Servers
     * @apiVersion 0.0.1
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200 OK
     */
    public function index()
    {
        //
        return response()->json(Server::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * @api {POST} /servers/ 创建新的 server
     * @apiGroup Servers
     * @apiVersion 0.0.1
     * @apiSuccess {Number} id 服务器 ID
     * @apiSuccess {String} name 服务器名称
     * @apiSuccess {String} description 产品描述
     * @apiSuccess {Boolean} customer_provide 是否为客户提供的服务器
     * @apiSuccess {String} barcode 条形码
     * @apiSuccess {String} sn 序列号
     * @apiSuccess {String} model 型号
     * @apiSuccess {Number} cpu CPU核心数
     * @apiSuccess {Number} memory 内存大小(G)
     * @apiSuccess {Number} disk 硬盘容量大小(G)
     * @apiSuccess {String} database 数据库类型
     * @apiSuccess {String} fqdn FQDN
     * @apiSuccess {String} vpn VPN 地址
     * @apiSuccess {String} description 备注信息
     * @apiSuccess {String} deleted_at 删除时间
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * @api {PUT} /servers/{id} 更新指定的 server
     * @apiVersion 0.0.1
     * @apiGroup Servers
     * @apiParam {Number} id 服务器 ID
     * @apiParam {String} name 服务器名称
     * @apiParam {String} description 产品描述
     * @apiParam {Boolean} customer_provide 是否为客户提供的服务器
     * @apiParam {String} barcode 条形码
     * @apiParam {String} sn 序列号
     * @apiParam {String} model 型号
     * @apiParam {Number} cpu CPU核心数
     * @apiParam {Number} memory 内存大小(G)
     * @apiParam {Number} disk 硬盘容量大小(G)
     * @apiParam {String} database 数据库类型
     * @apiParam {String} fqdn FQDN
     * @apiParam {String} vpn VPN 地址
     * @apiParam {String} description 备注信息
     * @apiParam {String} deleted_at 删除时间
     * @apiParam {String} name 服务器 的新名称
     * @apiParam {String} description Product 的新描述
     * @apiSuccessExample {json} Success-Response:
     *      HTTP/1.1 200 OK
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * @api {delete} /Servers/{id} 删除指定的 server
     * @apiGroup Servers
     * @apiVersion 0.0.1
     * @apiParam {Number}  id Server 的 ID
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200 OK
     * @apiErrorExample {json} Error-Response:
     *     HTTP/1/1 404 Not Found
     */
    public function destroy($id)
    {
        //
        if (Server::destroy($id)) {
            return response('OK', 200);
        }

        return response('Not Found', 404);
    }
}
