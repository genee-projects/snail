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
            return redirect()->back();
        }
    }

    public function add(Request $request) {

        $module = new Module();
        $module->name = $request->input('name');
        $module->description = $request->input('description');

        $module->save();

        return redirect()->back();
    }

    public function edit($id, Request $request) {

        $module = Module::find($id);
        //TODO

    }

    public function modules() {

        return view('modules/index', ['modules'=> Module::all()]);

    }
}