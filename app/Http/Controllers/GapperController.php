<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GapperController extends Controller
{
    private static $_RPC;
    private static function getRPC()
    {
        if (!self::$_RPC) {
            $config = (array) config('gapper.rpc');
            $api = $config['url'];
            $client_id = $config['client_id'];
            $client_secret = $config['client_secret'];
            self::$_RPC = $rpc = new \App\Gini\RPC($api);
            $token = $rpc->gapper->app->authorize($client_id, $client_secret);
            if (!$token) {
            }
        }

        return self::$_RPC;
    }

    public function go() {

        $paths = func_get_args();

        $config = config('gapper.rpc');
        $client_id = $config['client_id'];
        $url = config('gapper.url');

        if (empty($paths)) {
            $group_id = \App\Gini\Gapper\Client::getGroupID();
            if ($group_id) {
                $url .= '/dashboard/group/'.$group_id;
            }
        } else {
            $url .= '/'.implode('/', $paths);
        }

        $user = \App\Gini\Gapper\Client::getUserInfo();

        $token = null;
        if ($user['id']) {
            $token = self::getRPC()->gapper->user->getLoginToken((int) $user['id'], $client_id);
        }

        if ($token) {
            $url = url($url, '?gapper-token='.$token);
        }

        return redirect()->to($url);
    }

    public function login(Request $request) {

        $username = $request->input('username');
        $password = $request->input('password');


        try {

            $verify = self::getRPC()->gapper->user->verify($username, $password);

            if ($verify) {

                \App\Gini\Gapper\Client::loginByUserName($username);

                // 错误的client信息，用户无法登陆
                $config = config('gapper.rpc');
                $client_id = $config['client_id'];
                $app = self::getRPC()->gapper->app->getInfo($client_id);


                if (!isset($app['id'])) {
                   throw new \Exception('异常访问 !');
                }

                //crm 是一个 group 的 app, 判断用户是否有该 App 即可
                $groups = \App\Gini\Gapper\Client::getGroups();

                if (!$groups) {
                    throw new \Exception('用户无管理组!');
                } else {
                    foreach($groups as $group) {

                        $apps = \App\Gini\Gapper\Client::getApps($group['id']);

                        //安装了当前 App
                        //直接跳到 dashboard
                        if (array_key_exists($config['client_id'], $apps)) {
                            return redirect()->to(route('root'));
                        }
                    }
                }
            }

            throw new \Exception('登录失败! 请重试!');
        } catch(\Exception $e) {
            $message = $e->getMessage();
            return redirect()->back()
                ->with('message', $message);
        }
    }

    public function logout() {
        \App\Gini\Gapper\Client::logout();
        return redirect()->to(route('root'));
    }
}
