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

        //新增加的参数, 同步到所有的子产品中
        foreach($product->sub_products as $sub) {

            //同步到所有的子产品签约的项目中
            foreach($sub->projects as $project) {
                $project->params()->save($param, [
                    'value'=> $param->value,
                ]);
            }

            //同步到所有的子产品中
            $sub->params()->save($param, [
                'value'=> $param->value,
            ]);
        }

        return redirect()->back()
            ->with('message_content', '添加成功!')
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

        //修改的参数, 同步更新到所有的子产品中

        /*

        | 产品的值为 100 |
        | 子产品如下
            * 200 (手动)
                * 300 (手动)
            * 100 (默认)
                * 100 (默认)
            * 100 (默认)
                * 200 (手动)
            * 200 (手动)
                * 100 (手动)
            * 200 (手动)
                * 200 (默认)

        修改产品 100 到 101, 则, 100 默认的子产品需要修改,100 默认的项目需要修改, 但是 200 手动下 200 默认的不需要修改
         */

        foreach($param->product->sub_products as $sub) {

            $sub_param = $sub->params()->where('param_id', $param->id)->first();

            //如果为默认(不为手动), 则修改
            if (! $sub_param->pivot->manual) {
                $sub->params()->updateExistingPivot($param->id, [
                    'value'=> $param->value,
                ]);

                //同时修改该项目下所有的参数
                foreach($sub->projects as $project) {
                    $project_param = $project->params()->where('param_id', $param->id)->first();

                    //如果为默认 (不为手动), 则修改
                    if (! $project_param->pivot->manual) {
                        $project->params()->updateExistingPivot($param->id, [
                            'value'=> $param->value,
                        ]);
                    }
                }
            }
        }

        return redirect()->back()
            ->with('message_content', '修改成功!')
            ->with('message_type', 'info');
    }

    public function delete($id) {

        if (! \Session::get('user')->can('产品参数管理')) abort(401);

        $param = Param::find($id);

        //softDelete, 删除后会 hide, 不用在其他的地方进行修改
        $param->delete();

        return redirect()->back()
            ->with('message_content', '删除成功!')
            ->with('message_type', 'info');
    }

}
