<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model
{
    //
    use SoftDeletes;

    public $timestamps = false;

    protected $dates = ['from', 'to'];

    public function roles() {
        return $this->belongsToMany('App\Role',  'user_roles', 'user_id', 'role_id');
    }

    public function perms() {
        $perms = [];

        foreach($this->roles as $role) {
            foreach($role->perms as $perm) {
                $perms[] = $perm;
            }
        }

        //进行去重
        return array_unique($perms);
    }
}