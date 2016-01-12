<?php

/**
 * @file Client.php
 * @brief APP <--> Gapper Client <--> Gapper Server
 *
 * @author Hongjie Zhu
 *
 * @version 0.1.0
 * @date 2014-06-18
 */

/**
 * $client = \Gini\IoC::construct('\Gini\Gapper\Client', true); (default)
 * $client = \Gini\IoC::construct('\Gini\Gapper\Client', false);
 * $username = $client->getCurrentUserName();
 * $userdata = $client->getUserInfo();
 * $groupdata = $client->getGroupInfo();.
 */
namespace App\Gini\Gapper;

use Symfony\Component\HttpFoundation\Request;

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

    const STEP_LOGIN = 0;
    const STEP_GROUP = 1;
    const STEP_DONE = 2;
    const STEP_USER_401 = 3;
    const STEP_GROUP_401 = 4;

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
        $gapperToken = \Request::get('gapper-token');
        if ($gapperToken) {
            \App\Gini\Gapper\Client::logout();
            \App\Gini\Gapper\Client::loginByToken($gapperToken);
        } else {
            // 提供第三方登录验证入口
            $third = (array) config('gapper.3rd');
            foreach ($third as $key => $value) {
                if (isset($value['condition']) && !$_GET[$value['condition']]) {
                    continue;
                }
                $className = $value['class'];
                if (!class_exists($className)) {
                    continue;
                }
                $handler = new $className($value['params']);
                $handler->run();
            }
        }

        $gapperGroup = \Request::get('gapper-group');
        if ($gapperGroup && \App\Gini\Gapper\Client::getLoginStep() === \App\Gini\Gapper\Client::STEP_GROUP) {
            \App\Gini\Gapper\Client::chooseGroup($gapperGroup);
        }
    }

    public static function getLoginStep()
    {
        // 错误的client信息，用户无法登陆
        $config = config('gapper.rpc');
        $client_id = $config['client_id'];
        if (!$client_id) {
            return self::STEP_LOGIN;
        }

        $app = self::getRPC()->gapper->app->getInfo($client_id);
        if (!isset($app['id'])) {
            return self::STEP_LOGIN;
        }

        $username = self::getUserName();
        if (!$username) {
            return self::STEP_LOGIN;
        }

        if ($app['type'] === 'group' && empty(self::getGroupInfo())) {
            $groups = self::getGroups();
            if (!empty($groups) && is_array($groups)) {
                return self::STEP_GROUP;
            } else {
                return self::STEP_GROUP_401;
            }
        } elseif ($app['type'] === 'user') {
            $apps = (array) self::getRPC()->gapper->user->getApps(self::getUserName());
            if (!in_array($client_id, $apps)) {
                return self::STEP_USER_401;
            }
        }

        return self::STEP_DONE;
    }

    public static function loginByUserName($username)
    {
        return self::setUserName($username);
    }

    public static function loginByToken($token)
    {
        $user = self::getRPC()->gapper->user->authorizeByToken($token);


        if ($user && $user['username']) {
            return self::loginByUserName($user['username']);
        }

        return false;
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

    public static function chooseGroup($groupID)
    {
        $config = (array) config('gapper.rpc');
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
        if (!is_array($groups) || !in_array($groupID, array_keys($groups))) {
            return false;
        }

        $apps = [];

        try {
            $apps = self::getRPC()->gapper->group->getApps((int) $groupID);
        } catch (\Exception $e) {
        }

        if (is_array($apps) && in_array($client_id, array_keys($apps))) {
            self::setSession(self::$keyGroupID, $groupID);

            return true;
        }

        return false;
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
}
