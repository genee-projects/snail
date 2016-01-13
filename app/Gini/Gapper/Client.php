<?php

namespace App\Gini\Gapper;

class Client
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

    private static $sessionKey = 'gapper.client';
    private static function prepareSession()
    {
        \Session::set(self::$sessionKey, \Session::get(self::$sessionKey) ? : []);
    }
    private static function hasSession($key)
    {
        $data = \Session::get(self::$sessionKey);
        return isset($data[$key]) ? true : false;
    }

    private static function getSession($key)
    {
        $data = \Session::get(self::$sessionKey);

        return $data[$key];
    }

    private static function setSession($key, $value)
    {
        self::prepareSession();

        $data = \Session::get(self::$sessionKey);

        $data[$key] = $value;

        \Session::set(self::$sessionKey, $data);

        session(self::$sessionKey, $data);

    }
    private static function unsetSession($key)
    {
        self::prepareSession();

        $data = \Session::get(self::$sessionKey);

        unset($data[$key]);

        \Session::set(self::$sessionKey, $data);
    }

    public static function init()
    {

        $gapperGroup = \Request::get('gapper-group');

        //其他 Group 登录到当前 CRM
        if ($gapperGroup == config('gapper.group_id')) {
            $gapperToken = \Request::get('gapper-token');
            if ($gapperToken) {
                \App\Gini\Gapper\Client::logout();
                \App\Gini\Gapper\Client::loginByToken($gapperToken);
                \App\Gini\Gapper\Client::initUser();
            }
        }
    }

    public static function loginByUserName($username)
    {

        @list($name, $backend) = explode('|', $username, 2);
        $backend = $backend ? : 'gapper';

        return self::setUserName($name. '|'. $backend);
    }

    public static function loginByToken($token)
    {
        $user = self::getRPC()->gapper->user->authorizeByToken($token);


        if ($user && $user['username']) {
            return self::loginByUserName($user['username']);
        }

        return false;
    }

    public static function getMembers($groupId) {

        try {
            $members = self::getRPC()->gapper->group->getMembers($groupId);
        } catch(\App\Gini\RPC\Exception $e) {
        }

        return $members ? : [];
    }

    private static $keyUserName = 'username';

    private static function setUserName($username)
    {
        // 错误的client信息，用户无法登陆
        $config = config('gapper.rpc');
        $client_id = $config['client_id'];
        if (!$client_id) {
            return false;
        }

        $app = [];

        try {
            $app = self::getRPC()->gapper->app->getInfo($client_id);
        } catch (\Exception $e) {
        }

        if (!$app['id']) {
            return false;
        }

        self::setSession(self::$keyUserName, $username);

        return true;
    }

    public static function getUserName()
    {
        $username = null;

        if (self::hasSession(self::$keyUserName)) {
            $username = self::getSession(self::$keyUserName);
        }

        return $username;
    }

    public static function getUserInfo()
    {

        if (!self::getUserName()) {
            return false;
        }

        $data = self::getRPC()->gapper->user->getInfo([
            'username' => self::getUserName(),
        ]);

        return $data;
    }

    public static function getGroups()
    {
        $config = config('gapper.rpc');
        $client_id = $config['client_id'];
        if (!$client_id) {
            return false;
        }

        $app = self::getRPC()->gapper->app->getInfo($client_id);
        if (!$app['id']) {
            return false;
        }

        $username = self::getUserName();

        if (!$username) {
            return false;
        }

        $groups = self::getRPC()->gapper->user->getGroups($username);

        if (empty($groups)) {
            return false;
        }

        $result = [];
        foreach ($groups as $k => $g) {
            $apps = self::getRPC()->gapper->group->getApps((int) $g['id']);
            if (is_array($apps) && in_array($client_id, array_keys($apps))) {
                $result[$k] = $g;
            }
        }

        return $result;
    }

    private static $keyGroupID = 'groupid';

    public static function resetGroup()
    {
        return self::setSession(self::$keyGroupID, 0);
    }

    public static function getGroupInfo()
    {
        if (self::hasSession(self::$keyGroupID)) {
            $groupID = self::getSession(self::$keyGroupID);
            return self::getRPC()->gapper->group->getInfo((int) $groupID);
        }
    }

    public static function getGroupID()
    {
        if (self::hasSession(self::$keyGroupID)) {
            return self::getSession(self::$keyGroupID);
        }
    }

    public static function logout()
    {
        self::unsetSession(self::$keyGroupID);
        self::unsetSession(self::$keyUserName);

        return true;
    }

    public static function goLogin()
    {
        //$url = \Gini\URI::url('gapper/client/login', ['redirect' => $_SERVER['REQUEST_URI']]);
        //\Gini\CGI::redirect($url);
    }

    public static function getApps($groupID) {

        try {
            $apps = self::getRPC()->gapper->group->getApps((int) $groupID);
        } catch (\Exception $e) {
            $apps = [];
        }

        return $apps;
    }

    public static function initUser() {
        $userInfo = \App\Gini\Gapper\Client::getUserInfo();

        $user = \App\User::where('gapper_id', $userInfo['id'])->first();

        if (! $user) {
            $user = new \App\User;

            $user->gapper_id = $userInfo['id'];
            $user->name = $userInfo['name'];
            $user->icon = $userInfo['icon'];

            $user->save();
        }
        //设定当前用户
        \Session::set('user', $user);
    }
}
