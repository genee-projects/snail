<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Module extends Model
{
    //
    use SoftDeletes;

    public $timestamps = false;

    protected $dates = ['deleted_at'];

    /*
    public function object() {
        return $this->morphTo();
    }
    */

    //依赖模块
    public function dep_modules() {
        return $this->belongsToMany('App\Module', 'module_dep_modules', 'module_id', 'dep_module_id');
    }

    //谁依赖我
    public function be_dep_modules() {
        return $this->belongsToMany('App\Module', 'module_dep_modules', 'dep_module_id', 'module_id');
    }

    public function dep_modules_ids() {
        $data = [];
        foreach($this->dep_modules as $module) {
            $data[] = $module->id;
        }
        return $data;
    }
}
