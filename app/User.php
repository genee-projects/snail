<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model
{
    //
    use SoftDeletes;

    public $timestamps = false;

    public function roles() {
        return $this->belongsToMany('App\Role',  'user_roles', 'user_id', 'role_id');
    }

    static private $perms = null;

    public function perms() {

        if (self::$perms !== null) return self::$perms;

        $perms = [];

        foreach(self::find($this->id)->roles as $role) {
            foreach($role->perms as $perm) {
                $perms[] = $perm;
            }
        }


        //进行去重
        return self::$perms = array_unique($perms);
    }

    public function can($permission, $requireAll = false) {

        if ($this->is_admin()) return true;

        //requireAll 为是否判断全部权限, 如果 requireAll 为 true, 则表示满足所有权限才为 true, 为 false 表示满足一个即可
        if (is_array($permission)) {

            foreach($permission as $p) {

                //如果需要全都遍历
                if ($requireAll) {

                    //如果发现 !can, 则 false
                    //如果没有在这个地方return, 最后会 return true
                    if (!$this->can($p)) return false;
                } else {
                    //如果发现 can, 则为 true
                    //如果没有在这个地方 return, 最后会return false
                    if ($this->can($p)) return true;
                }
            }
        }
        else {
            return in_array($permission, $this->perms());
        }

        if ($requireAll) return true;
        return false;
    }


    static private $is_admin = null;

    public function is_admin() {

        if (self::$is_admin != null) return self::$is_admin;

        return self::$is_admin = in_array($this->gapper_id, config('app.managers', []));
    }
}