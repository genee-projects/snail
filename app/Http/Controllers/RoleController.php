<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Role;
use App\User;

class RoleController extends Controller
{
    public function roles() {
        return view('roles/index', ['roles'=> Role::all()]);
    }

    public function profile($id) {
        $role = Role::find($id);

        return view('roles/profile', ['role'=> $role]);
    }

    /* 目前 Role 不提供自定义添加\修改\删除功能
    public function add(Request $request) {
        $role = new Role;

        $role->name = $request->input('name');

        $role->save();

        return redirect()->back()
            ->with('message_content', '添加成功!')
            ->with('message_type', 'info');
    }

    public function delete($id) {
        $role = Role::find($id);

        $role->delete();

        return redirect()->back()
            ->with('message_content', '删除成功!')
            ->with('message_type', 'info');
    }

    public function edit(Request $request) {

        $role = Role::find($request->input('role_id'));

        $role->name = $request->input('name');

        $role->perms = $request->input('perms');

        $role->save();

        return redirect()->back()
            ->with('message_content', '修改成功!')
            ->with('message_type', 'info');
    }
    */

    public function user_connect($role_id, $user_id) {

        $role = Role::find($role_id);
        $user = User::find($user_id);

        if (!$user->roles->contains($role->id)) {
            $user->roles()->save($role);

            return response()->json(true);
        }

        return response()->json(false);
    }

    public function user_disconnect($role_id, $user_id) {
        $role = Role::find($role_id);
        $user = User::find($user_id);

        if ($user->roles->contains($role->id)) {
            $user->roles()->detach([$role->id]);
            return response()->json(true);
        }

        return response()->json(false);
    }

    public function user_connect_all($role_id) {

        $role = Role::find($role_id);

        $connected_users = $role->users()->lists('id')->all();

        if (count($connected_users)) {
            $role->users()->detach($connected_users);
        }

        $users = User::all();

        $role->users()->saveMany($users->all());

        return redirect()->back()
            ->with('message_content', '设置成功!')
            ->with('message_type', 'info');
    }
}
