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
        return $this->morphMany('App\Module', 'object');
    }

    public function services() {
        return $this->morphMany('App\Service', 'object');
    }

    public function comments() {
        return $this->morphMany('App\Comment', 'object');
    }
}