<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\User;
use App\Role;

class UserController extends Controller
{
    public function users() {
        return view('users/index', ['users' => User::all()]);
    }

    public function profile($id) {
        $user = User::find($id);

        return view('users/profile', ['user'=> $user]);
    }

    public function add(Request $request) {
        $user = new User;
        $user->name = $request->input('name');
        $user->save();

        return redirect()->to(route('user.profile', ['id'=> $user->id]))
            ->with('message_content', '添加成功!')
            ->with('message_type', 'info');
    }

    public function delete($id) {
        $user = User::find($id);

        $user->delete();

        return redirect()->to(route('users'))
            ->with('message_content', '删除成功!')
            ->with('message_type', 'info');
    }

    public function edit(Request $request) {
        $user_id = $request->input('user_id');

        $user = User::find($user_id);

        /* 角色设定功能暂时隐藏, 考虑产品评审时再决定是否开放
        //角色设定

        $data = $user->roles()->lists('id')->all();

        if (count($data)) {
            $user->roles()->detach($data);
        }

        //重新对选定的 role 进行 link
        foreach($request->input('roles', []) as $role_id) {
            $role = Role::find($role_id);

            $user->roles()->save($role);
        }
        */

        $user->name = $request->input('name');

        $user->save();

        return redirect()->back()
            ->with('message_content', '修改成功!')
            ->with('message_type', 'info');
    }
}