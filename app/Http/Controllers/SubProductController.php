<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Product;
use App\SubProduct;
use App\Module;

class SubProductController extends Controller
{

    public function add(Request $request) {

        $product = Product::find($request->input('product_id'));

        $sub = new SubProduct;

        $sub->name = $request->input('name');
        $sub->description = $request->input('description');

        $sub->product()->associate($product);

        $sub->save();

        return redirect()->back();
    }

    public function delete($id) {

        $sub = SubProduct::find($id);

        $sub->delete();

        return redirect()->back();
    }

    public function edit(Request $request) {

        $sub = SubProduct::find($request->input('id'));

        $sub->name = $request->input('name');
        $sub->description = $request->input('description');

        $sub->save();

        return redirect()->back();
    }

    public function profile($id) {

        $sub = SubProduct::find($id);

        return view('subproducts/profile', ['subproduct'=> $sub]);

    }

    public function modules($id, Request $request) {

        $sub = SubProduct::find($id);

        $type = $request->input('type');

        //先把所有的 type 的 module 进行 unlink

        $data = [];

        foreach($sub->modules()->wherePivot('type', '=', $type)->get(['id']) as $module) {
            $data[] = $module->id;
        }

        if (count($data)) {
            $sub->modules()->detach($data);
        }

        //重新对选定的 module 进行 link, 类型为 type
        foreach($request->input('modules', []) as $module_id) {

            $module = Module::find($module_id);

            $sub->modules()->save($module, [
                'type'=> $type,
            ]);
        }

        return redirect()->back();
    }
}
