<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Product;
use App\Module;
use App\Param;

class ProductController extends Controller
{


    public function products() {

        if (! \Session::get('user')->can('产品查看')) abort(401);

        return view('products/index', ['products' => Product::all()]);
    }

    public function profile($id) {

        if (! \Session::get('user')->can('产品查看')) abort(401);

        $product = Product::find($id);
        
        return view('products/profile', ['product'=> $product]);
    }

    public function add(Request $request) {

        if (! \Session::get('user')->can('产品信息管理')) abort(401);

        $product = new Product();

        $product->name = $request->input('name');
        $product->description = $request->input('description');

        if ($product->save()) {
            return redirect()->back()
                ->with('message_content', '添加成功!')
                ->with('message_type', 'info');
        }
    }

    public function edit(Request $request) {

        if (! \Session::get('user')->can('产品信息管理')) abort(401);

        $product = Product::find($request->input('product_id'));
        $product->name = $request->input('name');
        $product->description = $request->input('description');

        if ($product->save()) {
            return redirect()->back()
                ->with('message_content', '修改成功!')
                ->with('message_type', 'info');
        }
     }

    public function delete($id) {

        if (!\Session::get('user')->can('产品信息管理')) abort(401);

        $product = Product::find($id);

        if ($product->delete()) {
            return redirect()->route('products')
                ->with('message_content', '删除成功!')
                ->with('message_type', 'info');
        }
    }
}