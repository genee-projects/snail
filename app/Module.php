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

    public function object() {
        return $this->morphTo();
    }

    public function dep_modules() {
        return $this->belongsToMany('App\Module', 'module_dep_modules', 'module_id', 'dep_module_id');
    }
}
