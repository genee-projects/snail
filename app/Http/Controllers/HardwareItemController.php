<?php

namespace App\Http\Controllers;

use App\Hardware;
use App\HardwareItem;
use App\Project;
use App\HardwareField;
use Illuminate\Http\Request;
use App\Clog;

class HardwareItemController extends Controller
{
    public function add(Request $request)
    {
        $user = \Session::get('user');

        if (!$user->can('项目硬件部署管理')) {
            abort(401);
        }

        $item = new HardwareItem();

        $project = Project::find($request->input('project_id'));
        $hardware = Hardware::find($request->input('hardware_id'));

        $item->hardware()->associate($hardware);
        $item->project()->associate($project);

        $item->status = $request->input('status');
        $item->extra = $request->input('fields', []);

        $time = $request->input('time');

        if (!$time) {
            $time = null;
        } else {
            $time = \Carbon\Carbon::createFromFormat('Y/m/d', $time)->format('Y-m-d H:i:s');
        }

        $item->time = $time;

        $item->save();

        Clog::add($project, '硬件明细添加', [
            strtr( '添加硬件 (%hardware_name) 下新的硬件明细 [%item_id]', [
                '%hardware_name'=> $hardware->name,
                '%item_id'=> $item->id
            ])
        ], Clog::LEVEL_NOTICE);

        \Log::notice(strtr('项目硬件明细增加: 用户(%name[%id]) 添加了项目(%project_name[%project_id]) 硬件 (%hardware_name[%hardware_id]) 的 明细信息: %hardware_item_id', [
           '%name' => $user->name,
           '%id' => $user->id,
           '%project_name' => $project->name,
           '%project_id' => $project->id,
           '%hardware_name' => $hardware->name,
           '%hardware_id' => $hardware->id,
           '%hardware_item_id' => $item->id,
       ]));

        return redirect()->to(route('project.profile', ['id' => $project->id]))
            ->with('message_type', 'info')
            ->with('message_content', '添加部署硬件成功!')
            ->with('tab', 'hardwares');
    }

    public function form(Request $request)
    {
        $item = HardwareItem::find($request->input('id'));

        return view('hardwares/form', ['item' => $item]);
    }

    public function edit(Request $request)
    {
        $user = \Session::get('user');

        if (!$user->can('项目硬件部署管理')) {
            abort(401);
        }

        $item = HardwareItem::find($request->input('id'));

        $project = $item->project;
        $hardware = $item->hardware;

        $old_attributes = $item->attributesToArray();

        $item->status = $request->input('status');

        $item->extra = $request->input('fields', []);

        $time = $request->input('time');

        if (!$time) {
            $time = null;
        } else {
            $time = \Carbon\Carbon::createFromFormat('Y/m/d', $time)->format('Y-m-d H:i:s');
        }

        $item->time = $time;

        $item->save();

        $new_attributes = $item->attributesToArray();

        $old_extra = $old_attributes['extra'];
        $new_extra = $new_attributes['extra'];


        $change = [];

        foreach(array_diff_assoc($old_extra, $new_extra) as $key => $value) {

            if (isset($old_extra[$key])) {
                $old_extra_value = $old_extra[$key];
            } else {
                $old_extra_value = null;
            }

            if (isset($new_extra[$key])) {
                $new_extra_value = $new_extra[$key];
            } else {
                $new_extra_value = null;
            }

            $title = HardwareField::find($key)->name;

            \Log::notice(strtr('项目硬件明细修改: 用户(%name[%id]) 修改了项目(%project_name[%project_id]) 硬件 (%hardware_name[%hardware_id]) 的 自定义明细信息: %title[%key] : %old -> %new', [
                '%name' => $user->name,
                '%id' => $user->id,
                '%project_name' => $project->name,
                '%project_id' => $project->id,
                '%hardware_name' => $hardware->name,
                '%hardware_id' => $hardware->id,
                '%hardware_item_id' => $item->id,
                '%key' => $key,
                '%title' => $title,
                '%old' => $old_extra_value,
                '%new' => $new_extra_value,
            ]));

            $change[] = [
                'title'=> $title,
                'old'=> $old_extra_value,
                'new'=> $new_extra_value,
            ];
        }

        if (count($change)) {
            array_unshift($change, [
                'title' => strtr('硬件 (%hardware_name) 下新的硬件明细 %item_id', ['%hardware_name'=> $hardware->name, '%item_id'=> $item->id]),
            ]);

            Clog::add($project, '项目硬件明细修改', $change, Clog::LEVEL_INFO);
        }

        $helper = [
            'time' => '操作时间',
            'status' => '状态',
        ];

        $change = [];

        unset($old_attributes['extra']);
        unset($new_attributes['extra']);

        foreach (array_diff_assoc($old_attributes, $new_attributes) as $key => $value) {

            $old_value = $old_attributes[$key];
            $new_value = $new_attributes[$key];

            switch ($key) {
                case 'status':

                    $new_value = \App\HardwareItem::$status[$new_value];
                    $old_value = \App\HardwareItem::$status[$old_value];

                    break;
                case 'time' :

                    if ($new_value) {
                        $new_value = $new_value->format('Y/m/d');
                    }
                    if ($old_value) {
                        $old_value = $old_value->format('Y/m/d');
                    }

                    //时间需要特殊处理
                    if ($old_value == $new_value) {
                        continue 2;
                    }

                    break;
            }

            $change[$key] = [
                'old' => $old_value,
                'new' => $new_value,
                'title' => $helper[$key],
            ];
        }

        if (count($change)) {

            foreach($change as $c) {

                \Log::notice(strtr('项目硬件明细修改: 用户(%name[%id]) 修改了项目(%project_name[%project_id]) 硬件 (%hardware_name[%hardware_id]) 的 明细信息: %hardware_item_id, %title : %old -> %new', [
                    '%name' => $user->name,
                    '%id' => $user->id,
                    '%project_name' => $project->name,
                    '%project_id' => $project->id,
                    '%hardware_name' => $hardware->name,
                    '%hardware_id' => $hardware->id,
                    '%hardware_item_id' => $item->id,
                    '%title' => $c['title'],
                    '%old' => $c['old'],
                    '%new' => $c['new'],
                ]));
            }

            array_unshift($change, [
                'title' => strtr('硬件 (%hardware_name) 下新的硬件明细 %item_id', ['%hardware_name'=> $hardware->name, '%item_id'=> $item->id]),
            ]);

            Clog::add($project, '项目硬件明细修改', $change, Clog::LEVEL_INFO);
        }

        return redirect()->to(route('project.profile', ['id' => $item->project->id]))
            ->with('message_type', 'info')
            ->with('message_content', '修改部署硬件成功!')
            ->with('tab', 'hardwares');
    }

    public function profile($id)
    {
        $item = HardwareItem::find($id);

        return view('hardwares/item', ['item' => $item]);
    }
}
