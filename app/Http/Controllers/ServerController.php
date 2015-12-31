<?php

namespace app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Server;

class ServerController extends Controller
{
    public function servers() {

        return view('servers/index', [
            'servers'=> Server::all(),
        ]);
    }

    public function servers_json() {
        return response()->json(Server::all());
    }

    public function profile($id) {
        return view('servers/profile', ['server'=> Server::find($id)]);
    }

    public function add(Request $request) {

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

        $server->save();

        return redirect(route('servers'))
            ->with('message_content', '添加成功!')
            ->with('message_type', 'info');
    }

    public function edit(Request $request) {

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

        if ($server->save()) {
            return redirect(route('server.profile', ['id'=> $server->id]))
                ->with('message_content', '修改成功!')
                ->with('message_type', 'info');
        }
    }

    public function delete($id) {
        $server = Server::find($id);

        if ($server->delete()) {
            return redirect(route('servers'))
                ->with('message_content', '删除成功!')
                ->with('message_type', 'info');
        }
    }
}