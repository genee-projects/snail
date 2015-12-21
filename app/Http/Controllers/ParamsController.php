<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Param;


class ParamsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        //
        $param = Param::find($id);

        if ($param->delete()) {
            return redirect()->to(route('params'));
        }
    }

    public function add(Request $request) {

        $param = new Param();
        $param->name = $request->input('name');
        $param->description = $request->input('description');
        $param->code = $request->input('code');
        $param->value = $request->input('value');

        $param->save();

        return redirect()->route('params');
    }

    public function edit($id, Request $request) {

        $param = Param::find($id);


        $param->name = $request->input('name');
        $param->description = $request->input('description');
        $param->code = $request->input('code');
        $param->value = $request->input('value');

        $param->save();

        return redirect()->back();
    }

    public function params() {
        return view('params/index', ['params'=> Param::all()]);
    }


    public function profile($id) {


        $param = Param::find($id);


        return view('params/profile', ['param'=> $param]);
    }

    public function params_json() {
        return response()->json(Param::all());
    }
}
