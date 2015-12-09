<?php

namespace app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Client;

class ClientController extends Controller
{
    public function clients() {

        return view('clients/index', ['clients'=> Client::where('parent_id', 0)->get()]);
    }

    public function add(Request $request) {

        $client = new Client();

        if ($request->input('parent_id')) {
            $parent = Client::find($request->input('parent_id'));
            $client->parent()->associate($parent);
        }

        $client->name = $request->input('name');
        $client->description = $request->input('description');
        $client->address = $request->input('address');
        $client->url = $request->input('url');

        if ($client->save()) {
            return redirect('/clients')
                ->with('message_content', '添加成功!')
                ->with('message_type', 'info');
        }
    }

    public function edit(Request $request) {


        $client = Client::find($request->input('id'));

        $client->name = $request->input('name');
        $client->description = $request->input('description');
        $client->address = $request->input('address');
        $client->url = $request->input('url');

        if ($client->save()) {
            return redirect(sprintf('/clients/profile/%d', $client->id))
                ->with('message_content', '修改成功!')
                ->with('message_type', 'info');
        }

    }

    public function profile($id) {

        $client = Client::find($id);

        return view('clients/profile', ['client'=> $client]);
    }

    public function delete($id) {

        $client = Client::find($id);

        if ($client->delete()) {
            return redirect('/clients')
                ->with('message_content', '删除成功!')
                ->with('message_type', 'info');
        }
    }
}
