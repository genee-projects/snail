<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Gini\Gapper\Client;

class UserController extends Controller
{
    public function users()
    {
        if (!\Session::get('user')->is_admin()) {
            abort(401);
        }

        return view('users/index', ['users' => User::all()]);
    }

    public function refresh()
    {
        if (!\Session::get('user')->is_admin()) {
            abort(401);
        }

        $group_id = config('gapper.group_id');

        $members = Client::getMembers($group_id);

        if (count($members)) {
            $deleted_users = User::all()->lists('gapper_id', 'id')->toArray();

            foreach ($members as $member) {
                $id = $member['id'];
                $user = User::where('gapper_id', $id)->first();

                if (!$user) {
                    $user = new \App\User();

                    $user->gapper_id = $member['id'];
                    $user->name = $member['name'];
                    $user->icon = $member['icon'];
                } else {
                    $user->name = $member['name'];
                    $user->icon = $member['icon'];

                    //从 deleted_users 中删除当前 gapper_id 对应的用户
                    //最后剩下的, 就是 User 中不包含 gapper_id 的用户

                    if (array_key_exists($member['id'], $deleted_users)) {
                        unset($deleted_users[$id]);
                    }
                }

                $user->save();
            }

            //发现有需要删除的 User
            if (count($deleted_users)) {
                $to_deleted_users = User::whereIn('id', array_values($deleted_users))->delete();
            }
        }

        return redirect()->to('users')
            ->with('message_content', '同步成功!')
            ->with('message_type', 'info');
    }

    public function users_json()
    {
        return response()->json(User::all());
    }

    public function view(Request $request)
    {
        if (!\Session::get('user')->is_admin()) {
            abort(401);
        }

        $id = $request->input('id');
        $user = User::find($id);

        return response()->json([
            'id' => $user->id,
            'view' => (string) view('users/view', ['user' => $user]),
        ]);
    }
}
