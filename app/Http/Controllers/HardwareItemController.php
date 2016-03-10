<?php

namespace App\Http\Controllers;

use App\Hardware;
use App\HardwareItem;
use App\Project;
use Illuminate\Http\Request;

class HardwareItemController extends Controller
{
    public function add(Request $request)
    {
        $item = new HardwareItem();

        $project = Project::find($request->input('project_id'));
        $hardware = Hardware::find($request->input('hardware_id'));

        $item->equipment_name = $request->input('equipment_name');
        $item->equipment_id = $request->input('equipment_id');
        $item->hardware()->associate($hardware);
        $item->project()->associate($project);

        $item->status = $request->input('status');
        $item->extra = $request->input('fields', []);

        $item->save();

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
        $item = HardwareItem::find($request->input('id'));

        $item->status = $request->input('status');
        $item->extra = $request->input('fields');

        $item->equipment_name = $request->input('equipment_name');
        $item->equipment_id = $request->input('equipment_id');

        $item->extra = $request->input('fields', []);

        $item->save();

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
