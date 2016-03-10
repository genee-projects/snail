<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Project;
use App\Record;

class RecordController extends Controller
{
    public function add(Request $request)
    {
        $record = new Record();
        $record->project()->associate(Project::find($request->input('project_id')));
        $record->user()->associate(\Session::get('user'));

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

        return redirect()->back()
            ->with('message_content', '外出记录添加成功!')
            ->with('message_type', 'info')
            ->with('tab', 'records');
    }

    public function delete($id)
    {
        $record = Record::find($id);

        $record->delete();

        return redirect()->back()
            ->with('message_content', '外出记录删除成功!')
            ->with('message_type', 'info')
            ->with('tab', 'records');
    }
}
