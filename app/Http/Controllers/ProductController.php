<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Product;
use App\Module;
use App\Service;

class ProductController extends Controller
{


    public function products() {
        return view('products/index', ['products' => Product::all()]);
    }

    public function profile($id) {

        $product = Product::find($id);
        
        return view('products/profile', ['product'=> $product]);
    }

    public function add(Request $request) {
        $product = new Product();

        $product->name = $request->input('name');
        $product->description = $request->input('description');

        if ($product->save()) {
            return response()->back();
        }
    }

    public function edit(Request $request) {
        $product = Product::find($request->input('product_id'));
        $product->name = $request->input('name');
        $product->description = $request->input('description');

        if ($product->save()) {
            return redirect()->back();
        }
     }

    public function delete(Request $request) {

        $product = Product::find($request->input('id'));

        if ($product->delete()) {
            return response()->json(true);
        }
    }

    public function modules($id, Request $request) {

        $product = Product::find($id);

        $type = $request->input('type');

        //先把所有的 type 的 module 进行 unlink

        $data = [];
        foreach($product->modules()->wherePivot('type', '=', $type)->get(['id']) as $module) {
            $data[] = $module->id;
        }

        $product->modules()->detach($data);

        //重新对选定的 module 进行 link, 类型为 type
        foreach($request->input('modules') as $module_id) {

            $module = Module::find($module_id);

            $product->modules()->save($module, [
               'type'=> $type,
            ]);
        }

        return redirect()->back();
    }
}