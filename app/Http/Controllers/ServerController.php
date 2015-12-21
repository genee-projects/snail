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
            //'root'=> Server::root(),
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
        $server->customer_provide = (bool) $request->input('customer-provide');
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

        /* services 暂时先删除
        foreach(Server::root()->services as $service) {

            $_s = $service->replicate();
            $_s->push();
            $server->services()->save($_s);

            foreach($service->items as $item) {
                $_t = $item->replicate();
                $_t->push();
                $_s->items()->save($_t);
            }
        }
        */

        return redirect('/servers')
            ->with('message_content', '添加成功!')
            ->with('message_type', 'info');
    }

    public function edit(Request $request) {

        $server = Server::find($request->input('id'));

        $server->name = $request->input('name');
        $server->customer_provide = (bool) $request->input('customer-provide');
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
            return redirect(sprintf('/servers/profile/%d', $server->id))
                ->with('message_content', '修改成功!')
                ->with('message_type', 'info');
        }
    }

    public function delete($id) {
        $server = Server::find($id);

        if ($server->delete()) {
            return redirect('/servers')
                ->with('message_content', '删除成功!')
                ->with('message_type', 'info');
        }
    }
}