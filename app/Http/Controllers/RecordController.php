<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Project;
use App\Record;

class RecordController extends Controller
{
    public function add(Request $request)
    {
        $user = \Session::get('user');

        if (!$user->can('项目外出记录管理')) {
            abort(401);
        }

        $record = new Record();
        $project = Project::find($request->input('project_id'));

        $record->project()->associate($project);
        $record->user()->associate($user);

        $time = $request->input('time');

        if (!$time) {
            $time = null;
        } else {
            $time = \Carbon\Carbon::createFromFormat('Y/m/d', $time)->format('Y-m-d H:i:s');
        }

        $record->time = $time;

        $record->content = $request->input('content');
        $record->contact = $request->input('contact');
        $record->phone = $request->input('phone');
        $record->software_count = $request->input('software_count');

        $record->hardware_name = $request->input('hardware_name');
        $record->hardware_count = $request->input('hardware_count');

        $record->save();

        \Log::notice(strtr('外出记录添加: 用户(%name[%id]) 添加了项目 %project[%project_id] 的外出记录 %record_id', [
            '%name' => $user->name,
            '%id' => $user->id,
            '%project' => $project->name,
            '%project_id' => $project->id,
            '%record_id' => $record->id,
        ]));

        return redirect()->back()
            ->with('message_content', '外出记录添加成功!')
            ->with('message_type', 'info')
            ->with('tab', 'records');
    }

    public function delete($id)
    {
        $user = \Session::get('user');

        if (!$user->can('项目外出记录管理')) {
            abort(401);
        }

        $record = Record::find($id);
        $record_id = $record->id;
        $project = $record->project;

        $record->delete();

        \Log::notice(strtr('外出记录删除: 用户(%name[%id]) 删除了项目 %project[%project_id] 的外出记录 %record_id', [
            '%name' => $user->name,
            '%id' => $user->id,
            '%project' => $project->name,
            '%project_id' => $project->id,
            '%record_id' => $record_id,
        ]));

        return redirect()->back()
            ->with('message_content', '外出记录删除成功!')
            ->with('message_type', 'info')
            ->with('tab', 'records');
    }

    public function edit(Request $request)
    {
        $user = \Session::get('user');

        if (!$user->can('项目外出记录管理')) {
            abort(401);
        }

        $record = Record::find($request->input('id'));
        $project = $record->project;

        $old_attributes = $record->attributesToArray();

        $time = $request->input('time');

        if (!$time) {
            $time = null;
        } else {
            $time = \Carbon\Carbon::createFromFormat('Y/m/d', $time)->format('Y-m-d H:i:s');
        }

        $record->time = $time;

        $record->content = $request->input('content');
        $record->contact = $request->input('contact');
        $record->phone = $request->input('phone');
        $record->software_count = $request->input('software_count');

        $record->hardware_name = $request->input('hardware_name');
        $record->hardware_count = $request->input('hardware_count');

        $record->save();

        $new_attributes = $record->attributesToArray();

        foreach (array_diff_assoc($old_attributes, $new_attributes) as $key => $value) {
            $changed = false;
            $old_value = $old_attributes[$key];
            if ($old_value == null) {
                $old_value = '空';
            }

            $new_value = $new_attributes[$key];

            if ($new_value == null) {
                $new_value = '空';
            }

            switch ($key) {
                case 'time':
                    if ($old_value->format('Y/m/d') != $new_value->format('Y/m/d')) {
                        $changed = true;
                    }
                    break;
                default:
                    $changed = true;
            }

            if ($changed) {
                \Log::notice(strtr('外出记录修改: 用户(%name[%id]) 修改了项目 %project[%project_id] 的外出记录 %record_id: %key : %old --> %new', [
                    '%name' => $user->name,
                    '%id' => $user->id,
                    '%project' => $project->name,
                    '%project_id' => $project->id,
                    '%record_id' => $record->id,
                    '%key' => $key,
                    '%old' => $old_value,
                    '%new' => $new_value,
                ]));
            }
        }

        return redirect()->back()
            ->with('message_content', '外出记录修改成功!')
            ->with('message_type', 'info')
            ->with('tab', 'records');
    }
}
