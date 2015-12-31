<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Service;
use App\Item;

class ItemController extends Controller
{

    public function add(Request $request)
    {
        //
        $item = new Item();

        $object_name = ucwords($request->input('object_type'));

        $object_id = $request->input('object_id');


        $object = $object_name::find($object_id);

        $item->object()->associate($object);
        $item->key = $request->input('key');
        $item->value = $request->input('value');
        $item->name = $request->input('name');

        $item->save();

        return redirect()->back()
            ->with('message_content', '添加成功!')
            ->with('message_type', 'info');
    }

    public function delete($id) {
        $item = Item::find($id);

        $item->delete();

        return redirect()->back()
            ->with('message_content', '删除成功!')
            ->with('message_type', 'info');
    }
}
