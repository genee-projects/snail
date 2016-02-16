<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Module;
use App\Product;

class ModuleController extends Controller
{
    public function add(Request $request)
    {
        $user = \Session::get('user');
        if (!$user->can('产品模块管理')) {
            abort(401);
        }

        $product = Product::find($request->input('product_id'));

        $module = new Module();
        $module->name = $request->input('name');
        $module->description = $request->input('description');
        $module->product()->associate($product);

        $module->save();

        $dep_modules = $request->input('modules', []);

        $dep_modules_name = [];

        foreach ($dep_modules as $dep_module_id) {
            $dep_module = Module::find($dep_module_id);
            $module->dep_modules()->save($dep_module);

            $dep_modules_name[] = strtr('%name[%id]', [
                '%name' => $dep_module->name,
                '%id' => $dep_module->id,
            ]);
        }

        \Log::notice(strtr('产品模块增加: 用户(%name[%id]) 增加了产品 (%product[%product_id]) 的模块: (%module[%module_id]), 依赖模块: %dep_modules', [
            '%name' => $user->name,
            '%id' => $user->id,
            '%product' => $product->name,
            '%product_id' => $product->id,
            '%module' => $module->name,
            '%module_id' => $module->id,
            '%dep_modules' => implode(',', $dep_modules_name),
        ]));

        return redirect()->back()
            ->with('message_content', '添加成功!')
            ->with('message_type', 'info');
    }

    public function delete($id)
    {
        $user = \Session::get('user');
        if (!$user->can('产品模块管理')) {
            abort(401);
        }

        $module = Module::find($id);

        \Log::notice(strtr('产品模块删除: 用户(%name[%id]) 删除了产品 (%product[%product_id]) 的模块: (%module[%module_id])', [
            '%name' => $user->name,
            '%id' => $user->id,
            '%product' => $module->product->name,
            '%product_id' => $module->product->id,
            '%module' => $module->name,
            '%module_id' => $module->id,
        ]));

        $module->delete();

        return redirect()->back()
            ->with('message_content', '删除成功!')
            ->with('message_type', 'info');
    }

    public function edit(Request $request)
    {
        $user = \Session::get('user');
        if (!$user->can('产品模块管理')) {
            abort(401);
        }

        $module = Module::find($request->input('module_id'));

        $old_attributes = $module->attributesToArray();

        $module->name = $request->input('name');
        $module->description = $request->input('description');

        $module->save();

        $new_attributes = $module->attributesToArray();

        $product = $module->product;

        foreach (array_diff_assoc($old_attributes, $new_attributes) as $key => $value) {
            \Log::notice(strtr('产品模块修改: 用户(%name[%id]) 修改了产品 (%product[%product_id]) 的模块 (%module[%module_id])基本信息: [%key] %old --> %new', [
                '%name' => $user->name,
                '%id' => $user->id,
                '%product' => $product->name,
                '%product_id' => $product->id,
                '%key' => $key,
                '%old' => $old_attributes[$key],
                '%new' => $new_attributes[$key],
            ]));
        }

        $old_deped_modules = $module->dep_modules->lists('id')->all();

        if (count($old_deped_modules)) {
            $module->dep_modules()->detach($old_deped_modules);
        }

        $new_deped_modules = $request->input('modules', []);

        $d1 = array_diff($new_deped_modules, $old_deped_modules);
        $d2 = array_diff($old_deped_modules, $new_deped_modules);

        if (count($d1)) {
            $dep_modules = [];

            foreach ($d1 as $id) {
                $m = Module::find($id);
                $dep_modules[] = strtr('(%name[%id])', [
                    '%name' => $m->name,
                    '%id' => $m->id,
                ]);
            }

            //新加的模块
            \Log::notice(strtr('产品模块修改: 用户(%name[%id]) 增加了产品 (%product[%product_id]) 的模块 (%module[%module_id]) 的依赖模块 %dep_modules', [
                '%name' => $user->name,
                '%id' => $user->id,
                '%product' => $product->name,
                '%product_id' => $product->id,
                '%module' => $module->name,
                '%module_id' => $module->id,
                '%dep_modules' => implode(',', $dep_modules),
            ]));
        }

        if (count($d2)) {
            $dep_modules = [];

            foreach ($d2 as $id) {
                $m = Module::find($id);
                $dep_modules[] = strtr('(%name[%id])', [
                    '%name' => $m->name,
                    '%id' => $m->id,
                ]);
            }

            //删除的模块
            \Log::notice(strtr('产品模块修改: 用户(%name[%id]) 删除了产品 (%product[%product_id]) 的模块 (%module[%module_id]) 的依赖模块 %dep_modules', [
                '%name' => $user->name,
                '%id' => $user->id,
                '%product' => $product->name,
                '%product_id' => $product->id,
                '%module' => $module->name,
                '%module_id' => $module->id,
                '%dep_modules' => implode(',', $dep_modules),
            ]));
        }

        foreach ($new_deped_modules as $module_id) {
            $dep_module = Module::find($module_id);

            $module->dep_modules()->save($dep_module);
        }

        return redirect()->back()
            ->with('message_content', '修改成功!')
            ->with('message_type', 'info');
    }
}
