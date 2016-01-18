<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Param;
use App\Product;


class ParamController extends Controller
{

    public function add(Request $request) {

        if (! \Session::get('user')->can('产品参数管理')) abort(401);

        $param = new Param();
        $param->name = $request->input('name');
        $param->description = $request->input('description');
        $param->code = $request->input('code');
        $param->value = $request->input('value');

        $product = Product::find($request->input('product_id'));

        $param->product()->associate($product);

        $param->save();

        return redirect()->back()
            ->with('message_content', '添加成功!')
            ->with('message_type', 'info');
    }

    public function delete($id) {

        if (! \Session::get('user')->can('产品参数管理')) abort(401);

        $param = Param::find($id);

        $param->delete();

        return redirect()->back()
            ->with('message_content', '删除成功!')
            ->with('message_type', 'info');
    }


    public function edit(Request $request) {

        if (! \Session::get('user')->can('产品参数管理')) abort(401);

        $param = Param::find($request->input('id'));

        $param->name = $request->input('name');
        $param->description = $request->input('description');
        $param->code = $request->input('code');
        $param->value = $request->input('value');

        $param->save();

        return redirect()->back()
            ->with('message_content', '修改成功!')
            ->with('message_type', 'info');
    }
}
