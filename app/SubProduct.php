<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubProduct extends Model
{
    //
    use SoftDeletes;

    public $timestamps = false;

    protected $dates = ['deleted_at'];

    //属于某个 product
    public function product() {
        return $this->belongsTo('App\Product', 'parent_id');
    }

    //可包含多个 module
    public function modules() {
        //关系是, belongsToMany, 包含多个 module 的关系
        return $this->belongsToMany('App\Module', 'product_modules')->withPivot('type');
    }

    //可设置 params
    public function params() {
        return $this->belongsToMany('App\Param', 'product_params')->withPivot('value');
    }
}