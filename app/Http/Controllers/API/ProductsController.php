<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
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
     *     HTTP/1.1 200 OK
     * @apiErrorExample {json} Error-Response:
     *     HTTP/1/1 404 Not Found
     */
    public function destroy($id)
    {
        //
        if (Product::destroy($id)) {
            return response('OK', 200);
        }

        return response('Not Found', 404);
    }
}
