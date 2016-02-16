<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Role;
use App\User;

class RoleController extends Controller
{
    public function roles() {

        if (!\Session::get('user')->is_admin()) abort(401);

        return view('roles/index', ['roles'=> Role::all()]);

    }

    public function user_connect($role_id, $user_id) {

        if (!\Session::get('user')->is_admin()) abort(401);

        $role = Role::find($role_id);
        $user = User::find($user_id);

        if (!$user->roles->contains($role->id)) {
            $user->roles()->save($role);
            \Log::warning(strtr('角色设定: 用户(%name[%id]) 设定为角色[%role]', [
                '%name'=> $user->name,
                '%id'=> $user->id,
                '%role'=>$role->name,
            ]));

            return response()->json(true);
        }

        return response()->json(false);
    }

    public function user_disconnect($role_id, $user_id) {

        if (!\Session::get('user')->is_admin()) abort(401);

        $role = Role::find($role_id);
        $user = User::find($user_id);

        if ($user->roles->contains($role->id)) {
            $user->roles()->detach([$role->id]);

            \Log::warning(strtr('角色设定: 用户(%name[%id]) 取消设定角色[%role]', [
                '%name'=> $user->name,
                '%id'=> $user->id,
                '%role'=>$role->name,
            ]));


            return response()->json(true);
        }

        return response()->json(false);
    }

    public function user_connect_many(Request $request) {

        if (!\Session::get('user')->is_admin()) abort(401);

        $users = (array) $request->input('users');
        $role = Role::find($request->input('id'));

        $connected_users = (array) $role->users()->lists('id')->all();

        $inter_users = (array) array_intersect($connected_users, $users);

        $new_users = array_diff($users, $inter_users);

        foreach($new_users as $uid) {
            $user = User::find($uid);

            if ($user) {
                $role->users()->save($user);

                \Log::warning(strtr('角色设定: 用户(%name[%id]) 设定为角色[%role]', [
                    '%name'=> $user->name,
                    '%id'=> $user->id,
                    '%role'=>$role->name,
                ]));
            }
        }

        return response()->json([
            'id'=> $role->id,
            'view'=> (string) view('roles/view', ['role'=> $role]),
        ]);
    }
}
