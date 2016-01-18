<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Product;
use App\SubProduct;
use App\Module;
use App\Param;
use App\Hardware;
use App\Project;

class SubProductController extends Controller
{

    public function profile($id) {

        if (!\Session::get('user')->can('产品查看')) abort(401);

        $sub = SubProduct::find($id);

        return view('subproducts/profile', ['subproduct'=> $sub]);
    }

    public function add(Request $request) {

        if (!\Session::get('user')->can('产品类别管理')) abort(401);

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

        if (!\Session::get('user')->can('产品类别管理')) abort(401);

        $sub = SubProduct::find($id);

        $sub->delete();

        return redirect()->back()
            ->with('message_content', '删除成功!')
            ->with('message_type', 'info');;
    }

    public function edit(Request $request) {

        if (!\Session::get('user')->can('产品类别管理')) abort(401);

        $sub = SubProduct::find($request->input('id'));

        $sub->name = $request->input('name');
        $sub->description = $request->input('description');

        $sub->save();

        return redirect()->back()
            ->with('message_content', '修改成功!')
            ->with('message_type', 'info');
    }


    public function modules($id, Request $request) {

        if (!\Session::get('user')->can('产品模块管理')) abort(401);

        $sub = SubProduct::find($id);

        //先把所有的 type 的 module 进行 unlink

        $connected_modules = (array) $sub->modules()->lists('id')->all();

        $requested_modules = $request->input('modules', []);

        $inter = array_intersect($connected_modules, $requested_modules);

        $new_modules = array_diff($requested_modules, $inter);

        if (count($connected_modules)) {
            $sub->modules()->detach($connected_modules);
        }

        //重新对选定的 module 进行 link
        foreach($requested_modules as $module_id) {
            $module = Module::find($module_id);

            $sub->modules()->save($module);
        }

        //如果勾选了同步新模块到所有的 project 的 checkbox, 那么需要进行同步操作

        if ($request->input('sync_new_modules') == 'on') {

            //查到所有的 proejct, 进行 new_modules 的 connect
            foreach(Project::where('product_id', $id)->get() as $project) {

                foreach($new_modules as $m) {
                    if (!$project->modules->contains($m)) {
                        $project->modules()->save(Module::find($m));
                    }
                }
            }
        }

        return redirect()->back()
            ->with('message_content', '模块设置成功!')
            ->with('message_type', 'info');
    }

    public function params($id, Request $request) {


        if (!\Session::get('user')->can('产品参数管理')) abort(401);

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

    public function param_edit($id, Request $request) {

        if (!\Session::get('user')->can('产品参数管理')) abort(401);

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

