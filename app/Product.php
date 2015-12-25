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
        return $this->hasMany('App\Module', 'product_id');
    }

    public function params() {
        return $this->hasMany('App\Param', 'product_id');
    }

    public function sub_products() {
        return $this->hasMany('App\SubProduct', 'product_id');
    }
}