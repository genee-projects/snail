<?php

namespace App\Http\Controllers;

use App\Hardware;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\SubProduct;
use App\Project;
use App\Client;
use App\Server;
use App\Module;
use App\Param;

class ProjectController extends Controller
{
    public function index()
    {
        return view('projects/index', [
            'projects'=> Project::all(),
        ]);
    }

    public function add(Request $request) {

        $sub = SubProduct::find($request->input('product_id'));
        $client = Client::find($request->input('client_id'));

        $project = new Project();
        $project->product()->associate($sub);
        $project->client()->associate($client);

        $project->vip = (bool) ($request->input('vip') == 'on');
        $project->official = (bool) ($request->input('official') == 'on');

        $project->ref_no = $request->input('ref_no');
        $project->name = $request->input('name');
        $project->seller = $request->input('seller');
        $project->contact_user = $request->input('contact_user');
        $project->signed_time = $request->input('signed_time');
        $project->cancelled_time = $request->input('cancelled_time');
        $project->description = $request->input('description');

        if ($project->save()) {

            foreach($sub->modules as $module) {
                $project->modules()->save($module);
            }

            foreach($sub->params as $param) {

                $project->params()->save($param, [
                    'value'=> $param->pivot->value,
                ]);
            }

            foreach($sub->hardwares as $hardware) {

                $project->hardwares()->save($hardware, [
                    'plan_count'=> $hardware->pivot->count,
                ]);
            }

            return redirect(route('project.profile', ['id'=> $project->id]))
                ->with('message_content', '签约成功!')
                ->with('message_type', 'info');
        }
    }

    public function edit(Request $request) {

        $project = Project::find($request->input('id'));
        $product = SubProduct::find($request->input('product_id'));

        $project->ref_no = $request->input('ref_no');               // 项目编号
        $project->name = $request->input('name');                   // 项目名称

        $project->vip = (bool) ($request->input('vip') == 'on');
        $project->official = (bool) ($request->input('official') == 'on');

        $project->product()->associate($product);                   // 产品类型
        $project->contact_user = $request->input('contact_user');   // 联系人
        $project->contact_phone = $request->input('contact_phone'); // 联系电话
        $project->contact_email = $request->input('contact_email'); // 联系邮箱

        $signed_time = $request->input('signed_time');

        if (!$signed_time) $signed_time = NULL;
        $project->signed_time = $signed_time;     // 签约时间

        $cancelled_time =  $request->input('cancelled_time');

        if (!$cancelled_time) $cancelled_time = NULL;

        $project->cancelled_time = $cancelled_time;   // 服务到期时间

        $project->seller = $request->input('seller');               // 销售人员
        $project->engineer = $request->input('engineer');           // 工程师
        $project->description = $request->input('description'); //
        $project->deploy_address = $request->input('deploy_address');
        $project->way = $request->input('way');

        if ($project->save()) {
            return redirect(route('project.profile', ['id'=> $project->id]))
                ->with('message_content', '修改成功!')
                ->with('message_type', 'info');
        }
    }

    public function profile($id) {

        $project = Project::find($id);

        return view('/projects/profile', [
            'project'=> $project,
        ]);
    }


    public function delete($id) {
        $project = Project::find($id);

        if ($project->delete()) {
            return redirect(route('projects'))
                ->with('message_content', '已解约该项目!')
                ->with('message_type', 'danger');
        }

        return redirect(route('projects.profile', ['id'=> $id]))
            ->with('message_content', '内部错误, 无法解约!')
            ->with('message_type', 'danger');
    }

    public function servers($id, Request $request) {
        $project = Project::find($id);

        $server = Server::find($request->input('server_id'));

        $deploy_time = $request->input('deploy_time');
        if (!$deploy_time) $deploy_time = NULL;

        if (! $project->servers()->find($request->input('server_id'))) {
            $project->servers()->save($server, [
                'usage'=> $request->input('usage'),
                'deploy_time'=> $deploy_time,
            ]);

            return redirect(route('project.profile', ['id'=> $project->id]))
                ->with('message_content', '关联成功!')
                ->with('message_type', 'info');
        }

        return redirect(route('project.profile', ['id'=> $project->id]))
            ->with('message_content', '已关联服务器, 无法再次关联')
            ->with('message_type', 'danger');
    }


    public function modules($id, Request $request) {

        $project = Project::find($id);

        $connected_modules = $project->product->product->modules()->lists('id')->all();

        if (count($connected_modules)) $project->modules()->detach($connected_modules);

        //重新对选定的 module 进行 link, 类型为 type
        foreach($request->input('modules', []) as $module_id) {

            $module = Module::find($module_id);

            $project->modules()->save($module);
        }

        return redirect()->back()
            ->with('message_content', '模块设置成功!')
            ->with('message_type', 'info');
    }

    public function params($id, Request $request) {

        $project = Project::find($id);

        $data = $project->params()->lists('id')->all();

        //$data 为已关联的

        $params = $request->input('params');

        //拆分算法如下

        //1. 获取 $data 和 $params 的交集
        //2. 获取 $data 和 1.中交集的差集
        //3. 对差集进行 detach 即可
        //4. 获取 $param 和 1.中交集的差集, 进行 save


        //1. 获取 $data 和 $params 的交集
        $intersect = array_intersect($data, (array) $params);


        //2. 获取 $data 和 1.中交集的差集

        $detach = array_diff($data, $intersect);


        //3. detach
        if (count($detach)) {
            $project->params()->detach($detach);
        }

        //4. 获取 $param 和 1.中交集的差集, 进行 save
        $save = array_diff((array) $params, $intersect);


        foreach($save as $param_id) {

            $param = Param::find($param_id);

            $project->params()->save($param, [
                'value'=> $param->value,
            ]);
        }

        return redirect()->back()
            ->with('message_content', '参数设置成功!')
            ->with('message_type', 'info');
    }

    public function hardwares($id, Request $request) {

        $project = Project::find($id);

        $data = $project->hardwares()->lists('id')->all();

        //$data 为已关联的

        $hardwares = $request->input('hardwares');

        //拆分算法如下

        //1. 获取 $data 和 $params 的交集
        //2. 获取 $data 和 1.中交集的差集
        //3. 对差集进行 detach 即可
        //4. 获取 $param 和 1.中交集的差集, 进行 save


        //1. 获取 $data 和 $params 的交集
        $intersect = array_intersect($data, (array) $hardwares);


        //2. 获取 $data 和 1.中交集的差集

        $detach = array_diff($data, $intersect);


        //3. detach
        if (count($detach)) {
            $project->hardwares()->detach($detach);
        }

        //4. 获取 $param 和 1.中交集的差集, 进行 save
        $save = array_diff((array) $hardwares, $intersect);


        foreach($save as $hardware_id) {

            $hardware = Hardware::find($hardware_id);

            $project->hardwares()->save($hardware);
        }

        return redirect()->back()
            ->with('message_content', '硬件设置成功!')
            ->with('message_type', 'info');
    }

    public function param_edit($id, Request $request) {

        $param_id = $request->input('param_id');

        $param = Param::find($param_id);

        $project = Project::find($id);
        $project->params()->detach($param_id);

        $project->params()->save($param, [
            'value' => $request->input('value'),
        ]);

        return redirect()->back()
            ->with('message_content', '参数修改成功!')
            ->with('message_type', 'info');
    }

    public function hardware_edit($id, Request $request) {

        $hardware_id = $request->input('hardware_id');

        $hardware = Hardware::find($hardware_id);

        $project = Project::find($id);

        $project->hardwares()->detach($hardware_id);

        $project->hardwares()->save($hardware, [
            'description'=> $request->input('description'),
            'deployed_count'=> $request->input('deployed_count'),
            'plan_count'=> $request->input('plan_count'),
        ]);

        return redirect()->back()
            ->with('message_content', '硬件修改成功!')
            ->with('message_type', 'info');
    }


    //profile 信息 startq
    public function profile_item($id, Request $request) {

        $project = Project::find($id);
        $type = $request->input('type');

        $method = strtr('_profile_{type}', ['{type}'=> $type]);

        if (method_exists($this, $method)) {
            return call_user_func([$this, $method], $project);
        }
    }

    private function _profile_comments($project) {
        return view('projects/profile/comments', ['project'=> $project]);
    }

    private function _profile_servers($project) {
        return view('projects/profile/servers', ['project'=> $project]);
    }

    private function _profile_hardwares($project) {
        return view('projects/profile/hardwares', ['project'=> $project]);
    }

    private function _profile_softwares($project) {
        return view('projects/profile/softwares', ['project'=> $project]);
    }

    private function _profile_informations($project) {
        return view('projects/profile/informations', ['project'=> $project]);
    }

    private function _profile_trello($project) {
        return view('projects/profile/trello', ['project'=> $project]);
    }
    //profile 信息 end

}