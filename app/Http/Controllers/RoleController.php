<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Role;

class RoleController extends Controller
{
    public function roles() {
        return view('roles/index', ['roles'=> Role::all()]);
    }

    public function profile($id) {
        $role = Role::find($id);

        return view('roles/profile', ['role'=> $role]);
    }

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
}
