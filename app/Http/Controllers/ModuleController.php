<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Module;


class ModuleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        //
        $module = Module::find($id);

        if ($module->delete()) {
            return redirect()->to(route('modules'));
        }
    }

    public function add(Request $request) {

        $module = new Module();
        $module->name = $request->input('name');
        $module->description = $request->input('description');

        $module->save();

        foreach($request->input('modules', []) as $dep_module_id) {

            $dep_module = Module::find($dep_module_id);
            $module->dep_modules()->save($dep_module);
        }

        return redirect()->route('modules');
    }

    public function edit($id, Request $request) {

        $module = Module::find($id);

        $module->name = $request->input('name');
        $module->description = $request->input('description');

        $data = [];
        foreach($module->dep_modules as $m) {
            $data[] = $m->id;
        }

        $module->dep_modules()->detach($data);

        //重新对选定的 module 进行 link, 类型为 type
        foreach($request->input('modules') as $module_id) {



            $dep_module = Module::find($module_id);

            $module->dep_modules()->save($dep_module);
        }

        return redirect()->back();
    }

    public function modules() {
        return view('modules/index', ['modules'=> Module::all()]);
    }

    public function profile($id) {

        $module = Module::find($id);

        return view('modules/profile', ['module'=> $module]);
    }
}