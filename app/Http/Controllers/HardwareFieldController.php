<?php

namespace App\Http\Controllers;

use App\HardwareField;
use App\Hardware;
use Illuminate\Http\Request;

class HardwareFieldController extends Controller
{
    public function add(Request $request)
    {
        $field = new HardwareField();
        $field->name = $request->input('name');

        $hardware = Hardware::find($request->input('hardware_id'));

        $field->hardware()->associate($hardware);

        $field->save();

        return redirect()
            ->to(route('hardware.profile', ['id' => $hardware->id]))
            ->with('message_content', '添加成功!')
            ->with('message_type', 'info');
    }

    public function edit(Request $request)
    {
        $field = HardwareField::find($request->input('id'));

        $field->name = $request->input('name');

        $field->save();

        return redirect()
            ->to(route('hardware.profile', ['id' => $field->hardware->id]))
            ->with('message_content', '修改成功!')
            ->with('message_type', 'info');
    }

    public function delete($id)
    {
        $field = HardwareField::find($id);

        $hardware_id = $field->hardware->id;

        $field->delete();

        return redirect()
            ->to(route('hardware.profile', ['id' => $hardware_id]))
            ->with('message_content', '删除成功 !')
            ->with('message_type', 'info');
    }
}
