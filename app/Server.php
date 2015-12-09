<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Server extends Model
{

    use SoftDeletes;

    public $timestamps = false;

    protected $dates = ['deleted_at'];

    public function comments() {
        return $this->morphMany('App\Comment', 'object');
    }
}
