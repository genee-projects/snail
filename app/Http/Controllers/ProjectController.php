<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Product;
use App\Project;
use App\Client;
use App\Server;

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
        $project->contact = $request->input('contact');
        $project->signed_time = $request->input('signed_time');
        $project->divorced_time = $request->input('divorced_time');
        $project->description = $request->input('description');

        if ($project->save()) {
            return redirect(sprintf('/projects/profile/%d', $project->id));
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
            $project->servers()->save($server, ['usage'=> $request->input('usage')]);

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
}
