<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Product;

class ProductsController extends Controller
{
    /**
     * @api {get} /products/ 获取所有的 products
     * @apiGroup Products
     * @apiVersion 0.0.1
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200 OK
[
    {
    "deleted_at": null,
    "description": "LIMS-CF 是一款专门面向科研实验室公共仪器的智能化管理系统。本系统将公共仪器平台的各项必要工作流程整合在一起，显著提高仪器设备的管理和使用效率。",
    "id": "1",
    "name": "LIMS-CF"
    },
    {
        "deleted_at": null,
        "description": "LIMS 以实验室为中心，结合应用软件与互联网技术，根据科研人员的工作需要，将多个影响实验室运作的必要因素有机地结合起来，从而大幅度提高实验室管理效率和自动化水平，为您的实验室实现简易便捷的无纸化管理环境。",
        "id": "2",
        "name": "LIMS"
    },
    {
        "deleted_at": null,
        "description": "Billing 是基理科技设计的独立支付结算平台，能为拥有多个需要进行充值支付系统的用户提供更灵活的机构内充值分配结算的解决方案。",
        "id": "3",
        "name": "Billing"
    },
    {
        "deleted_at": null,
        "description": "Mall 是基理科技自主研发的在线科研采购管理系统，系统全面整合产品查找、选购、付款、收货、报销结算等各个环节，通过线上平台为科研工作者提供丰富的试剂、耗材等实验室用品信息，用户随时能够以透明实惠的价格买到最合适的产品，有效节省选购时间，缩短供货周期。",
        "id": "4",
        "name": "Mall"
    },
    {
        "deleted_at": null,
        "description": "Tender 是基理科技结合高校采购流程，通过优化再造所研发的一款电子采购平台。通过信息发布，商家报价，网上定标及结果公布等流程实现全透明监管，有效防止物品采购过程中的暗箱操作。",
        "id": "5",
        "name": "Tender"
    }
]
     */
    public function index()
    {
        //
        return response()->json(Product::all());
    }

    public function create()
    {
        //
    }

    /**
     * @api {POST} /products/ 创建新的 product
     * @apiGroup Products
     * @apiVersion 0.0.1
     * @apiSuccess {Number} id 产品 ID
     * @apiSuccess {String} name 产品名称
     * @apiSuccess {String} description 产品描述
     * @apiSuccess {String} deleted_at 删除时间
     *
     */
    public function store(Request $request)
    {
        //
        $product = Product::find(1);
        return response()->json($product);
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    /**
     * @api {PUT} /products/{id} 更新指定的 product
     * @apiVersion 0.0.1
     * @apiGroup Products
     * @apiParam {Number} id Product 的 ID
     * @apiParam {String} name Product 的新名称
     * @apiParam {String} description Product 的新描述
     * @apiSuccessExample {json} Success-Response:
     *      HTTP/1.1 200 OK
     */

    public function update(Request $request, $id)
    {
        //
    }

    /**
     * @api {delete} /Products/{id} 删除指定的 product
     * @apiGroup Products
     * @apiVersion 0.0.1
     * @apiParam {Number}  id Product 的 ID
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 204 No Content
     *
     */
    public function destroy($id)
    {
        //
    }
}
