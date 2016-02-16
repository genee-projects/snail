<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Hardware;

class HardWareController extends Controller
{

    public function index() {

        if (!\Session::get('user')->can('硬件查看')) abort(401);

        return view('hardwares/index', ['hardwares'=> Hardware::all()]);

    }
    public function add(Request $request) {

        if (!\Session::get('user')->can('硬件管理')) abort(401);

        $hardware = new Hardware();
        $hardware->name = $request->input('name');
        $hardware->description = $request->input('description');
        $hardware->model = $request->input('model');
        $hardware->self_produce = (bool) ($request->input('self_produce') == 'on');

        $hardware->save();

        $user = \Session::get('user');

        \Log::notice(strtr('硬件增加: 用户(%name[%id]) 增加了硬件 (%hardware[%hardware_id])', [
            '%name'=> $user->name,
            '%id'=> $user->id,
            '%hardware'=> $hardware->name,
            '%hardware_id'=> $hardware->id,
        ]));

        return redirect()->back()
            ->with('message_content', '添加成功!')
            ->with('message_type', 'info');
    }

    public function delete($id)
    {
        if (!\Session::get('user')->can('硬件管理')) abort(401);

        $hardware = Hardware::find($id);

        $hardware_name = $hardware->name;
        $hardware_id = $hardware->id;

        $hardware->delete();

        $user = \Session::get('user');

        \Log::notice(strtr('硬件删除: 用户(%name[%id]) 删除了硬件 (%hardware[%hardware_id])', [
            '%name'=> $user->name,
            '%id'=> $user->id,
            '%hardware'=> $hardware_name,
            '%hardware_id'=> $hardware_id,
        ]));

        return redirect()->back()
            ->with('message_content', '删除成功!')
            ->with('message_type', 'info');
    }

    public function edit(Request $request) {

        if (!\Session::get('user')->can('硬件管理')) abort(401);

        $hardware = Hardware::find($request->input('id'));

        $old_attributes = $hardware->attributesToArray();

        $hardware->name = $request->input('name');
        $hardware->description = $request->input('description');
        $hardware->model = $request->input('model');
        $hardware->self_produce = (bool) ($request->input('self_produce') == 'on');

        $new_attributes = $hardware->attributesToArray();

        $user = \Session::get('user');

        foreach(array_diff_assoc($old_attributes, $new_attributes) as $key => $value) {
            $old = $old_attributes[$key];
            $new = $new_attributes[$key];

            if ($key == 'self_produce') {
                $old = ($old == 'true') ? '自产' : '外采';
                $new = ($new == 'true') ? '自产' : '外采';
            }

            \Log::notice(strtr('硬件修改: 用户(%name[%id]) 修改了硬件 (%hardware[%hardware_id]) 的基本信息: [%key] %old --> %new', [
                '%name'=> $user->name,
                '%id'=> $user->id,
                '%hardware'=> $hardware->name,
                '%hardware_id'=> $hardware->id,
                '%key'=> $key,
                '%old'=> $old,
                '%new'=> $new,
            ]));
        }

        $hardware->save();

        return redirect()->back()
            ->with('message_content', '修改成功!')
            ->with('message_type', 'info');
    }
}
