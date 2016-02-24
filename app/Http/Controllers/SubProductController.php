<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\SubProduct;
use App\Module;
use App\Project;

class SubProductController extends Controller
{
    public function profile($id)
    {
        if (!\Session::get('user')->can('产品查看')) {
            abort(401);
        }

        $sub = SubProduct::find($id);

        return view('subproducts/profile', ['subproduct' => $sub]);
    }

    public function add(Request $request)
    {
        if (!\Session::get('user')->can('产品类别管理')) {
            abort(401);
        }

        $product = Product::find($request->input('product_id'));

        $sub = new SubProduct();

        $sub->name = $request->input('name');
        $sub->description = $request->input('description');

        $sub->product()->associate($product);

        $sub->save();

        $user = \Session::get('user');

        \Log::notice(strtr('子产品增加: 用户(%name[%id]) 增加了子产品 (%sub_product[%sub_product_id])', [
            '%name' => $user->name,
            '%id' => $user->id,
            '%sub_product' => $sub->name,
            '%sub_product_id' => $sub->id,
        ]));

        return redirect()->back()
            ->with('message_content', '添加成功!')
            ->with('message_type', 'info');
    }

    public function delete($id)
    {
        if (!\Session::get('user')->can('产品类别管理')) {
            abort(401);
        }

        $sub = SubProduct::find($id);

        $sub_name = $sub->name;
        $sub_id = $sub->id;

        $sub->delete();

        $user = \Session::get('user');

        \Log::notice(strtr('子产品增加: 用户(%name[%id]) 删除了子产品 (%sub_product[%sub_product_id])', [
            '%name' => $user->name,
            '%id' => $user->id,
            '%sub_product' => $sub_name,
            '%sub_product_id' => $sub_id,
        ]));

        return redirect()->back()
            ->with('message_content', '删除成功!')
            ->with('message_type', 'info');
    }

    public function edit(Request $request)
    {
        if (!\Session::get('user')->can('产品类别管理')) {
            abort(401);
        }

        $sub = SubProduct::find($request->input('id'));

        $old_attributes = $sub->attributesToArray();

        $sub->name = $request->input('name');
        $sub->description = $request->input('description');

        $sub->save();

        $new_attributes = $sub->attributesToArray();

        $user = \Session::get('user');

        foreach (array_diff_assoc($old_attributes, $new_attributes) as $key => $value) {
            \Log::notice(strtr('产品修改: 用户(%name[%id]) 修改了子产品 (%sub_product[%sub_product_id]): [%key] %old --> %new', [
                '%name' => $user->name,
                '%id' => $user->id,
                '%sub_product' => $sub->name,
                '%sub_product_id' => $sub->id,
                '%key' => $key,
                '%old' => $old_attributes[$key],
                '%new' => $new_attributes[$key],
            ]));
        }

        return redirect()->back()
            ->with('message_content', '修改成功!')
            ->with('message_type', 'info');
    }

    public function modules($id, Request $request)
    {
        $user = \Session::get('user');
        if (!$user->can('产品模块管理')) {
            abort(401);
        }

        $sub = SubProduct::find($id);

        //先把所有的 type 的 module 进行 unlink

        $connected_modules = (array) $sub->modules()->lists('id')->all();

        $requested_modules = $request->input('modules', []);

        $inter = array_intersect($connected_modules, $requested_modules);

        $new_modules = array_diff($requested_modules, $inter);

        $deleted_modules = array_diff($connected_modules, $inter);

        //把所有关联了的都进行 detach
        if (count($connected_modules)) {
            $sub->modules()->detach($connected_modules);
        }

        //重新对选定的 module 进行 link
        //对需要关联的, 进行 save
        foreach ($requested_modules as $module_id) {
            $module = Module::find($module_id);

            $sub->modules()->save($module);
        }

        //对所有删除了的 modules, 进行 Log 记录
        if (count($deleted_modules)) {
            foreach ($deleted_modules as $did) {
                $module = Module::find($did);

                \Log::notice(strtr('子产品模块删除: 用户(%name[%id]) 删除了子产品(%product_name[%product_id]) 的模块 (%module_name[%module_id])', [
                    '%name' => $user->nusame,
                    '%id' => $user->id,
                    '%product_name' => $sub->name,
                    '%product_id' => $sub->id,
                    '%module_name' => $module->name,
                    '%module_id' => $module->id,
                ]));
            }
        }

        if (count($new_modules)) {
            foreach ($new_modules as $nid) {
                $module = Module::find($nid);

                \Log::notice(strtr('子产品模块添加: 用户(%name[%id]) 添加了子产品(%product_name[%product_id]) 的模块 (%module_name[%module_id])', [
                    '%name' => $user->nusame,
                    '%id' => $user->id,
                    '%product_name' => $sub->name,
                    '%product_id' => $sub->id,
                    '%module_name' => $module->name,
                    '%module_id' => $module->id,
                ]));
            }
        }

        //如果勾选了同步新模块到所有的 project 的 checkbox, 那么需要进行同步操作

        if ($request->input('sync_new_modules') == 'on') {

            //查到所有的 proejct, 进行 new_modules 的 connect
            foreach (Project::where('product_id', $id)->get() as $project) {
                foreach ($new_modules as $m) {
                    if (!$project->modules->contains($m)) {
                        $module = Module::find($m);
                        $project->modules()->save($module);

                        \Log::notice(strtr('项目模块增加: 用户(%name[%id] 添加了项目(%project_name[%product_id] 的模块 (%module_name[%module_id])', [
                            '%name' => $user->name,
                            '%id' => $user->id,
                            '%project_name' => $project->name,
                            '%project_id' => $project->id,
                            '%module_name' => $module->name,
                            '%module_id' => $module->id,
                        ]));
                    }
                }
            }
        }

        return redirect()->back()
            ->with('message_content', '模块设置成功!')
            ->with('message_type', 'info');
    }

    public function param_edit($id, Request $request)
    {
        $user = \Session::get('user');
        if (!$user->can('产品参数管理')) {
            abort(401);
        }

        $sub = SubProduct::find($id);

        $param_id = $request->input('param_id');
        $param = \App\Param::find($param_id);

        //获取子产品中该参数关联的 value
        $old_value = $sub->params()->where('param_id', $param->id)->first()->pivot->value;

        if ($request->input('reset') == 'on') {

            //获取到 product 中该参数的 value
            $value = $sub->product->params()->where('id', $param->id)->first()->value;

            $param->value = $value;

            $sub->params()->detach($param_id);

            $sub->params()->save($param, [
                'value' => $value,
            ]);

            \Log::notice(strtr('子产品参数修改: 用户 (%name[%id]) 修改了子产品 (%product_name[%product_id] 的参数(%param_name[%param_id]) : %old_value -> %new_value', [
                '%name' => $user->name,
                '%id' => $user->id,
                '%product_name' => $sub->name,
                '%product_id' => $sub->id,
                '%param_name' => $param->name,
                '%param_id' => $param->id,
                '%old_value' => $old_value,
                '%new_value' => $value,
            ]));
        } else {
            $value = $request->input('value');

            $sub->params()->updateExistingPivot($param_id, [
                'value' => $value,
                'manual' => true,
            ]);

            \Log::notice(strtr('子产品参数修改: 用户 (%name[%id]) 修改了子产品 (%product_name[%product_id] 的参数(%param_name[%param_id]) : %old_value -> %new_value', [
                '%name' => $user->name,
                '%id' => $user->id,
                '%product_name' => $sub->name,
                '%product_id' => $sub->id,
                '%param_name' => $param->name,
                '%param_id' => $param->id,
                '%old_value' => $old_value,
                '%new_value' => $value,
            ]));
        }

        foreach ($sub->projects as $project) {
            $project_param = $project->params()->where('param_id', $param->id)->first();
            $old_value = $project_param->pivot->value;

            //如果为默认 (不为手动), 则修改
            if (!$project_param->pivot->manual) {
                $project->params()->updateExistingPivot($param->id, [
                    'value' => $value,
                ]);

                \Log::notice(strtr('项目参数修改: 用户 (%name[%id]) 修改了项目 (%project_name[%project_id] 的参数(%param_name[%param_id]) : %old_value -> %new_value', [
                    '%name' => $user->name,
                    '%id' => $user->id,
                    '%project_name' => $project->name,
                    '%project_id' => $project->id,
                    '%param_name' => $param->name,
                    '%param_id' => $param->id,
                    '%old_value' => $old_value,
                    '%new_value' => $value,
                ]));
            }
        }

        return redirect()->back()
            ->with('message_content', '参数修改成功!')
            ->with('message_type', 'info');
    }
}
