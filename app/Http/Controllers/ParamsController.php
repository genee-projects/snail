<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Param;
use App\Product;


class ParamsController extends Controller
{

    public function add(Request $request) {

        $param = new Param();
        $param->name = $request->input('name');
        $param->description = $request->input('description');
        $param->code = $request->input('code');
        $param->value = $request->input('value');

        $product = Product::find($request->input('product_id'));

        $param->product()->associate($product);

        $param->save();

        return redirect()->back();
    }

    public function delete($id)
    {
        //
        $param = Param::find($id);

        $param->delete();

        return redirect()->back();
    }


    public function edit(Request $request) {

        $param = Param::find($request->input('id'));

        $param->name = $request->input('name');
        $param->description = $request->input('description');
        $param->code = $request->input('code');
        $param->value = $request->input('value');

        $param->save();

        return redirect()->back();
    }
}
