<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Module;
use App\Product;


class ModuleController extends Controller
{


    public function add(Request $request) {

        $product = Product::find($request->input('product_id'));

        $module = new Module();
        $module->name = $request->input('name');
        $module->description = $request->input('description');
        $module->product()->associate($product);

        $module->save();

        foreach($request->input('modules', []) as $dep_module_id) {

            $dep_module = Module::find($dep_module_id);
            $module->dep_modules()->save($dep_module);
        }

        return redirect()->back()
            ->with('message_content', '添加成功!')
            ->with('message_type', 'info');
    }

    public function delete($id)
    {
        //
        $module = Module::find($id);

        $module->delete();

        return redirect()->back()
            ->with('message_content', '删除成功!')
            ->with('message_type', 'info');
    }

    public function edit(Request $request) {

        $module = Module::find($request->input('module_id'));


        $module->name = $request->input('name');
        $module->description = $request->input('description');

        $module->save();

        $deped_modules = $module->dep_modules->lists('id')->all();

        if (count($deped_modules)) $module->dep_modules()->detach($deped_modules);

        //重新对选定的 module 进行 link, 类型为 type
        foreach($request->input('modules', []) as $module_id) {

            $dep_module = Module::find($module_id);

            $module->dep_modules()->save($dep_module);
        }

        return redirect()->back()
            ->with('message_content', '修改成功!')
            ->with('message_type', 'info');
    }
}