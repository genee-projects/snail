<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{

    use SoftDeletes;

    public $timestamps = false;

    protected $dates = ['deleted_at'];

    public function modules() {
        //关系是, belongsToMany, 包含多个 module 的关系
        return $this->belongsToMany('App\Module', 'product_modules')->withPivot('type');
    }

    public function comments() {
        return $this->morphMany('App\Comment', 'object');
    }

    public function params() {
        return $this->belongsToMany('App\Param', 'product_params')->withPivot('value');
    }
}