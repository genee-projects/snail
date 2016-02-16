<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;

class ProductController extends Controller
{
    public function products()
    {
        if (!\Session::get('user')->can('产品查看')) {
            abort(401);
        }

        return view('products/index', ['products' => Product::all()]);
    }

    public function profile($id)
    {
        if (!\Session::get('user')->can('产品查看')) {
            abort(401);
        }

        $product = Product::find($id);

        return view('products/profile', ['product' => $product]);
    }

    public function add(Request $request)
    {
        if (!\Session::get('user')->can('产品信息管理')) {
            abort(401);
        }

        $product = new Product();

        $product->name = $request->input('name');
        $product->description = $request->input('description');

        if ($product->save()) {
            $user = \Session::get('user');

            \Log::notice(strtr('产品增加: 用户(%name[%id]) 增加产品 (%product[%product_id])', [
                '%name' => $user->name,
                '%id' => $user->id,
                '%product' => $product->name,
                '%product_id' => $product->id,
            ]));

            return redirect()->back()
                ->with('message_content', '添加成功!')
                ->with('message_type', 'info');
        }
    }

    public function edit(Request $request)
    {
        if (!\Session::get('user')->can('产品信息管理')) {
            abort(401);
        }

        $product = Product::find($request->input('product_id'));

        $old_attributes = $product->attributesToArray();

        $product->name = $request->input('name');
        $product->description = $request->input('description');

        $new_attributes = $product->attributesToArray();

        $user = \Session::get('user');

        foreach (array_diff_assoc($old_attributes, $new_attributes) as $key => $value) {
            \Log::notice(strtr('产品修改: 用户(%name[%id]) 修改了产品 (%product[%product_id]): [%key] %old --> %new', [
                '%name' => $user->name,
                '%id' => $user->id,
                '%product' => $product->name,
                '%product_id' => $product->id,
                '%key' => $key,
                '%old' => $old_attributes[$key],
                '%new' => $new_attributes[$key],
            ]));
        }

        if ($product->save()) {
            return redirect()->back()
                ->with('message_content', '修改成功!')
                ->with('message_type', 'info');
        }
    }

    public function delete($id)
    {
        if (!\Session::get('user')->can('产品信息管理')) {
            abort(401);
        }

        $product = Product::find($id);

        $product_name = $product->name;
        $product_id = $product->id;

        if ($product->delete()) {
            $user = \Session::get('user');

            \Log::notice(strtr('产品删除: 用户(%name[%id]) 删除产品 (%product[%product_id])', [
                '%name' => $user->name,
                '%id' => $user->id,
                '%product' => $product_name,
                '%product_id' => $product_id,
            ]));

            return redirect()->route('products')
                ->with('message_content', '删除成功!')
                ->with('message_type', 'info');
        }
    }
}
