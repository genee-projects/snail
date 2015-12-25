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
            return redirect()->back();
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

    public function delete($id) {

        $product = Product::find($request->input('id'));

        $product = Product::find($id);

        if ($product->delete()) {
            return redirect()->route('products');
        }
    }


    public function params_json($id) {

        $product = Product::find($id);

        return response()->json($product->params);

    }
}