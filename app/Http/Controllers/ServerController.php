<?php

namespace app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Server;

class ServerController extends Controller
{

    public function servers() {

        if (!\Session::get('user')->can('服务器查看')) abort(401);

        return view('servers/index', [
            'servers'=> Server::orderByRaw('INET_ATON(`vpn`)')->get(),
        ]);
    }

    public function servers_json() {
        return response()->json(Server::all());
    }

    public function profile($id) {

        if (!\Session::get('user')->can('服务器查看')) abort(401);

        return view('servers/profile', ['server'=> Server::find($id)]);
    }

    public function add(Request $request) {

        if (!\Session::get('user')->can('服务器信息管理')) abort(401);

        $server = new Server();

        $server->name = $request->input('name');
        $server->provider = $request->input('provider');
        $server->barcode = $request->input('barcode');
        $server->sn = $request->input('sn');
        $server->model = $request->input('model');
        $server->cpu = $request->input('cpu');
        $server->memory = $request->input('memory');
        $server->disk = $request->input('disk');
        $server->os = $request->input('os');
        $server->fqdn = $request->input('fqdn');
        $server->vpn = $request->input('vpn');
        $server->description = $request->input('description');

        $server->inner_ip = $request->input('inner_ip');
        $server->outer_ip = $request->input('outer_ip');

        $server->save();

        return redirect()->to(route('servers'))
            ->with('message_content', '添加成功!')
            ->with('message_type', 'info');
    }

    public function edit(Request $request) {

        if (!\Session::get('user')->can('服务器信息管理')) abort(401);

        $server = Server::find($request->input('id'));

        $server->name = $request->input('name');
        $server->provider = $request->input('provider');
        $server->barcode = $request->input('barcode');
        $server->sn = $request->input('sn');
        $server->model = $request->input('model');
        $server->cpu = $request->input('cpu');
        $server->memory = $request->input('memory');
        $server->disk = $request->input('disk');
        $server->os = $request->input('os');
        $server->fqdn = $request->input('fqdn');
        $server->vpn = $request->input('vpn');
        $server->description = $request->input('description');
        
        $server->inner_ip = $request->input('inner_ip');
        $server->outer_ip = $request->input('outer_ip');

        if ($server->save()) {
            return redirect()->to(route('server.profile', ['id'=> $server->id]))
                ->with('message_content', '修改成功!')
                ->with('message_type', 'info');
        }
    }

    public function delete($id) {

        if (!\Session::get('user')->can('服务器信息管理')) abort(401);


        $server = Server::find($id);

        $server->delete();

        return redirect()->to(route('servers'))
            ->with('message_content', '删除成功!')
            ->with('message_type', 'info');
    }
}