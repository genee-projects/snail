<?php

namespace app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Product;

class ProductController extends Controller
{
    public function products() {
        return view('products/products', ['products' => Product::all()]);
    }

    public function profile() {
        return view('products/profile');
    }

    public function add(Request $request) {
        $product = new Product();

        $product->name = $request->input('name');
        $product->description = $request->input('description');

        if ($product->save()) {
            return response()->json(true);
        }
    }

    public function delete(Request $request) {
        $product = Product::find($request->input('id'));

        if ($product->delete()) {
            return response()->json(true);
        }
    }
}