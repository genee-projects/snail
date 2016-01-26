<?php

namespace app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Client;

use App\Clog;

class ClientController extends Controller
{

    public function clients() {

        if (! \Session::get('user')->can('客户查看')) abort(401);

        return view('clients/index', [
            'clients'=> Client::where('parent_id', 0)->get(),
        ]);
    }

    public function profile($id) {

        $client = Client::find($id);

        return view('clients/profile', [
            'client'=> $client,
        ]);
    }

    public function add(Request $request) {

        if (! \Session::get('user')->can('客户信息管理')) abort(401);

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

        Clog::add($client, '添加客户');

        //如果有父元素
        if ($request->input('parent_id')) {
            Clog::add($client->parent, '添加子层级客户', [
                $client->name,
            ]);

            /*
             * 不确定需要告知 Root 么, 暂时隐藏
            if ($client->parent && $client->parent->id != $client->root()->id) {

                Clog::add($client->root(), '添加子层级客户', [
                    $client->name,
                ]);
            }
            */
        }

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

        if (! \Session::get('user')->can('客户信息管理')) abort(401);

        $client = Client::find($request->input('id'));

        $old_attributes = $client->attributesToArray();

        $client->name = $request->input('name');
        $client->description = $request->input('description');
        $client->address = $request->input('address');
        $client->url = $request->input('url');
        $client->seller_url = $request->input('seller_url');
        $client->type = $request->input('type');
        $client->region = $request->input('region');

        $client->save();

        $new_attributes = $client->attributesToArray();

        $change = [];

        $helper = [
            'name'=> '名称',
            'address'=> '地址',
            'description'=> '备注',
            'url'=> '网站/链接',
            'seller_url'=> '纷享销客链接',
            'type'=> '客户类型',
            'region'=> '客户区域',
        ];

        foreach(array_diff_assoc($old_attributes, $new_attributes) as $key => $value) {

            $old_value = $old_attributes[$key];
            if ($old_value == null) $old_value = '空';

            $new_value = $new_attributes[$key];

            if ($new_value == null) $new_value = '空';

            $change[$key] = [
                'old'=> $old_value,
                'new'=> $new_value,
                'title'=> $helper[$key],
            ];
        }

        if (count($change)) Clog::add($client, '修改基本信息', $change, Clog::LEVEL_NOTICE);

        return redirect()->to(route('client.profile', ['id'=> $client->id]))
            ->with('message_content', '修改成功!')
            ->with('message_type', 'info');
    }

    public function delete($id) {

        if (! \Session::get('user')->can('客户信息管理')) abort(401);

        $client = Client::find($id);

        Clog::add($client, '删除客户');

        $client->delete();
        return redirect()->to(route('clients'))
            ->with('message_content', '删除成功!')
            ->with('message_type', 'info');
    }
}
