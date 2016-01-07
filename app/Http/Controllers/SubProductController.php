<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Product;
use App\SubProduct;
use App\Module;
use App\Param;
use App\Hardware;

class SubProductController extends Controller
{

    public function add(Request $request) {

        $product = Product::find($request->input('product_id'));

        $sub = new SubProduct;

        $sub->name = $request->input('name');
        $sub->description = $request->input('description');

        $sub->product()->associate($product);

        $sub->save();

        return redirect()->back()
            ->with('message_content', '添加成功!')
            ->with('message_type', 'info');
    }

    public function delete($id) {

        $sub = SubProduct::find($id);

        $sub->delete();

        return redirect()->back()
            ->with('message_content', '删除成功!')
            ->with('message_type', 'info');;
    }

    public function edit(Request $request) {

        $sub = SubProduct::find($request->input('id'));

        $sub->name = $request->input('name');
        $sub->description = $request->input('description');

        $sub->save();

        return redirect()->back()
            ->with('message_content', '修改成功!')
            ->with('message_type', 'info');
    }

    public function profile($id) {

        $sub = SubProduct::find($id);

        return view('subproducts/profile', ['subproduct'=> $sub]);

    }

    public function modules($id, Request $request) {

        $sub = SubProduct::find($id);

        //先把所有的 type 的 module 进行 unlink

        $connected_modules = $sub->modules()->lists('id')->all();

        if (count($connected_modules)) {
            $sub->modules()->detach($connected_modules);
        }

        //重新对选定的 module 进行 link, 类型为 type
        foreach($request->input('modules', []) as $module_id) {

            $module = Module::find($module_id);

            $sub->modules()->save($module);
        }

        return redirect()->back()
            ->with('message_content', '模块设置成功!')
            ->with('message_type', 'info');
    }

    public function params($id, Request $request) {

        $sub = SubProduct::find($id);

        $data = $sub->params()->lists('id')->all();

        //$data 为已关联的

        $params = $request->input('params');


        //拆分算法如下

        //1. 获取 $data 和 $params 的交集
        //2. 获取 $data 和 1.中交集的差集
        //3. 对差集进行 detach 即可
        //4. 获取 $param 和 1.中交集的差集, 进行 save


        //1. 获取 $data 和 $params 的交集
        $intersect = array_intersect($data, (array) $params);


        //2. 获取 $data 和 1.中交集的差集

        $detach = array_diff($data, $intersect);


        //3. detach
        if (count($detach)) {
            $sub->params()->detach($detach);
        }

        //4. 获取 $param 和 1.中交集的差集, 进行 save
        $save = array_diff((array) $params, $intersect);


        foreach($save as $param_id) {

            $param = Param::find($param_id);

            $sub->params()->save($param, [
                'value'=> $param->value,
            ]);
        }

        return redirect()->back()
            ->with('message_content', '参数设置成功!')
            ->with('message_type', 'info');
    }

    public function hardwares($id, Request $request) {

        $sub = SubProduct::find($id);

        $counts = $request->input('counts');

        $data = $sub->hardwares()->lists('id')->all();

        $hardwares = $request->input('hardwares');

        //$data 为已关联的 hardwares

        //拆分算法如下

        //1. 获取 $data 和 $hardware 的交集
        //2. 获取 $data 和 1.中交集的差集
        //3. 对差集进行 detach 即可
        //4. 获取 $hardwares 和 1.中交集的差集, 进行 save


        //1. 获取 $data 和 $params 的交集
        $intersect = array_intersect($data, (array) $hardwares);

        //2. 获取 $data 和 1.中交集的差集

        $detach = array_diff($data, $intersect);


        //3. detach
        if (count($detach)) {
            $sub->hardwares()->detach($detach);
        }

        //4. 获取 $param 和 1.中交集的差集, 进行 save
        $save = array_diff((array) $hardwares, $intersect);

        foreach($save as $hardware_id) {

            $hardware = Param::find($hardware_id);

            $sub->hardwares()->save($hardware, [
                'count'=> $counts[$hardware_id],
            ]);
        }

        return redirect()->back()
            ->with('message_content', '硬件设置成功!')
            ->with('message_type', 'info');

    }

    public function param_edit($id, Request $request) {

        $sub = SubProduct::find($id);

        $param_id = $request->input('param_id');

        $sub->params()->updateExistingPivot($param_id, [
            'value'=> $request->input('value'),
        ]);

        return redirect()->back()
            ->with('message_content', '参数修改成功!')
            ->with('message_type', 'info');
    }
}

