<?php

namespace app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Client;

class ClientController extends Controller
{
    public function clients() {

        return view('clients/index', [
            'clients'=> Client::where('parent_id', 0)->get(),
        ]);
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
        $client->seller_url = $request->input('seller_url');
        $client->type = $request->input('type');
        $client->region = $request->input('region');

        $client->save();

        //添加子项目, 跳转到子项目页面
        if ($request->input('parent_id')) {
            return redirect()->to(route('client.profile', ['id'=> $client->id]))
                ->with('message_content', '添加成功!')
                ->with('message_type', 'info');
        }

        //如果 clients 列表页面
        return redirect()->to(route('clients'))
            ->with('message_content', '添加成功!')
            ->with('message_type', 'info');
    }

    public function edit(Request $request) {

        $client = Client::find($request->input('id'));

        $client->name = $request->input('name');
        $client->description = $request->input('description');
        $client->address = $request->input('address');
        $client->url = $request->input('url');
        $client->seller_url = $request->input('seller_url');
        $client->type = $request->input('type');
        $client->region = $request->input('region');

        $client->save();

        return redirect()->to(route('client.profile', ['id'=> $client->id]))
            ->with('message_content', '修改成功!')
            ->with('message_type', 'info');
    }

    public function profile($id) {

        $client = Client::find($id);

        return view('clients/profile', [
            'client'=> $client,
        ]);
    }

    public function delete($id) {

        $client = Client::find($id);

        $client->delete();
        return redirect()->to(route('clients'))
            ->with('message_content', '删除成功!')
            ->with('message_type', 'info');
    }
}
