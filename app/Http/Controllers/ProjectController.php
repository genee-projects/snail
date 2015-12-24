<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Product;
use App\Project;
use App\Client;
use App\Server;
use App\Module;
use App\Param;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('projects/index', [
            'projects'=> Project::all(),
        ]);
    }

    public function add(Request $request) {

        $product = Product::find($request->input('product_id'));
        $client = Client::find($request->input('client_id'));

        $project = new Project();
        $project->product()->associate($product);
        $project->client()->associate($client);

        $project->ref_no = $request->input('ref_no');
        $project->name = $request->input('name');
        $project->seller = $request->input('seller');
        $project->contact_user = $request->input('contact_user');
        $project->signed_time = $request->input('signed_time');
        $project->cancelled_time = $request->input('cancelled_time');
        $project->description = $request->input('description');

        if ($project->save()) {

            foreach($product->modules()->wherePivot('type', '=', 'normal')->get() as $module) {
                $project->modules()->save($module, [
                    'type'=> 'normal',
                ]);
            }

            foreach($product->params as $param) {

                $project->params()->save($param, [
                    'value'=> $param->pivot->value,
                ]);
            }

            return redirect(route('project.profile', ['id'=> $project->id]));
        }
    }

    public function edit(Request $request) {

        $project = Project::find($request->input('id'));
        $product = Product::find($request->input('product_id'));


        $project->ref_no = $request->input('ref_no');               // 项目编号
        $project->name = $request->input('name');                   // 项目名称
        $project->product()->associate($product);                   // 产品类型
        $project->version = $request->input('version');             // 项目版本
        $project->contact_user = $request->input('contact_user');   // 联系人
        $project->contact_phone = $request->input('contact_phone'); // 联系电话
        $project->contact_email = $request->input('contact_email'); // 联系邮箱
        $project->signed_time = $request->input('signed_time');     // 签约时间
        $project->cancelled_time = $request->input('cancelled_time');   // 服务到期时间
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
            'products'=> Product::all(),
        ]);
    }

    public function server($id, Request $request) {
        $project = Project::find($id);

        $server = Server::find($request->input('server_id'));

        if (! $project->servers()->find($request->input('server_id'))) {
            $project->servers()->save($server, [
                'usage'=> $request->input('usage'),
                'deploy_time'=> $request->input('deploy_time'),
            ]);

            return redirect(route('project.profile', ['id'=> $project->id]))
                ->with('message_content', '关联成功!')
                ->with('message_type', 'info');

        }

        return redirect(route('project.profile', ['id'=> $project->id]))
            ->with('message_content', '已关联服务器, 无法再次关联')
            ->with('message_type', 'danger');
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

    public function module_add($id, Request $request) {

        $project = Project::find($id);

        $module = Module::find($request->input('module_id'));

        $project->modules()->save($module, [
            'type'=> 'extra',
        ]);

        return redirect()->back()
            ->with('message_content', '模块添加成功!')
            ->with('message_type', 'info');
    }

    public function module_delete($project_id, $module_id) {

        $project = Project::find($project_id);

        $project->modules()->detach($module_id);

        return redirect()->back()
            ->with('message_content', '模块删除成功!')
            ->with('message_type', 'info');
    }

    public function param_edit($project_id, Request $request) {

        $param_id = $request->input('param_id');

        $project = Project::find($project_id);

        $project->params()->detach($param_id);

        $param = Param::find($param_id);

        $project->params()->save($param, [
            'value' => $request->input('value'),
        ]);

        return redirect()->back();
    }

}
