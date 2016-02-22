<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Project;

class NFSController extends Controller
{
    public function path($project_id, $path)
    {
        $project = Project::find($project_id);

        $path = ltrim($path, 'root');

        if (!$path) {
            $view = 'nfs/root';
        } else {
            $view = 'nfs/other';
        }

        if (!is_dir(\App\NFS::full_path($project, '/')))
        {
            $project->init_nfs();
        }

        return view($view, ['project' => $project, 'path' => $path]);
    }

    public function download($project_id, $file)
    {
        $user = \Session::get('user');

        $project = Project::find($project_id);

        $full_path = \App\NFS::full_path($project, $file);

        \Log::notice(strtr('文件下载: 用户(%name[%id]) 下载了文件 %file', [
            '%name' => $user->name,
            '%id' => $user->id,
            '%file' => $full_path,
        ]));

        return response()->download($full_path);
    }

    public function delete($project_id, $file)
    {
        $user = \Session::get('user');

        $project = Project::find($project_id);

        $full_path = \App\NFS::full_path($project, $file);

        \Log::notice(strtr('文件删除: 用户(%name[%id]) 删除了文件 %file', [
            '%name' => $user->name,
            '%id' => $user->id,
            '%file' => $full_path,
        ]));

        \App\NFS::delete($full_path);

        return redirect()->back()
            ->with('message_content', '删除成功!')
            ->with('message_type', 'info');
    }

    public function rename(Request $request)
    {
        $user = \Session::get('user');

        $project = Project::find($request->input('project_id'));

        $file = $request->input('file');

        $rename = \App\NFS::fix_name($request->input('rename'));

        $path = $request->input('path');

        $full_file = \App\NFS::full_path($project, $path.'/'.$rename);

        if (file_exists($full_file)) {
            $dirname = dirname($full_file).'/';

            $info = \App\NFS::pathinfo($full_file);
            $extension = $info['extension'] ? '.'.$info['extension'] : '';
            $name = substr($rename, 0, strrpos($rename, '.') ?: strlen($rename));

            $suffix_count = 2;

            do {
                $file_name = $name.'('.$suffix_count.')'.$extension;
                $full_file = $dirname.$file_name;
                ++$suffix_count;
            } while (file_exists($full_file));
        }

        $rename = substr($full_file, strrpos($full_file, '/') + 1);

        \App\NFS::rename(\App\NFS::full_path($project, $path), $file, $rename);

        \Log::notice(strtr('文件重命名: 用户(%name[%id]) 重命名了路径 %path 下的文件: %old -> %new', [
            '%name' => $user->name,
            '%id' => $user->id,
            '%path' => $path,
            '%old' => $file,
            '%new' => $rename,
        ]));

        return redirect()->back()
            ->with('message_content', '修改成功!')
            ->with('message_type', 'info');
    }

    public function upload($project_id, Request $request)
    {
        $user = \Session::get('user');

        $project = Project::find($project_id);

        if ($request->hasFile('file')) {
            $path = $request->input('path');

            $file = $request->file('file')->getClientOriginalName();

            $full_path = \App\NFS::full_path($project, $path);

            $full_file = \App\NFS::full_path($project, $path.'/'.$file);

            if (file_exists($full_file)) {
                $dirname = dirname($full_file).'/';

                $info = \App\NFS::pathinfo($full_file);
                $extension = $info['extension'] ? '.'.$info['extension'] : '';
                $name = substr($file, 0, strrpos($file, '.') ?: strlen($file));

                $suffix_count = 2;

                do {
                    $file_name = $name.'('.$suffix_count.')'.$extension;
                    $full_file = $dirname.$file_name;
                    ++$suffix_count;
                } while (file_exists($full_file));
            }

            $file = substr($full_file, strrpos($full_file, '/') + 1);

            \Log::notice(strtr('文件上传: 用户(%name[%id]) 在路径 %path 中上传了文件 %file', [
                '%name' => $user->name,
                '%id' => $user->id,
                '%path' => $full_path,
                '%file' => $file,
            ]));

            $request->file('file')->move($full_path, $file);

            return redirect()->back()
                ->with('message_content', '上传成功!')
                ->with('message_type', 'info');
        } else {
            return redirect()->back()
                ->with('message_content', '上传失败')
                ->with('message_type', 'danger');
        }
    }
}
