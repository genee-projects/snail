<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Service;


class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        //
        $service = Service::find($id);

        if ($service->delete()) {
            return redirect()->back();
        }
    }

    public function add(Request $request) {

        $service = new Service();

        $service->name = $request->input('name');
        $service->code = $request->input('code');

        $object_name = ucwords($request->input('object_type'));
        $object_id = $request->input('object_id');

        $object = $object_name::where('id', '=', $object_id)->withTrashed()->first();

        $service->object()->associate($object);
        $service->save();

        return redirect()->back();
    }

    public function edit(Request $request) {

    }
}