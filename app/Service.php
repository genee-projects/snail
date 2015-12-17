<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    //
    use SoftDeletes;

    public $timestamps = false;

    protected $dates = ['deleted_at'];

    public function object() {
        return $this->morphTo();
    }

    public function items() {
        return $this->morphMany('App\Item', 'object');
    }
}
