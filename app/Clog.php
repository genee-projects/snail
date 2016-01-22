<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Clog extends Model
{
    //
    use SoftDeletes;

    public $timestamps = false;


    protected $casts = [
        'change'=> 'array',
    ];


    public static function add($object, $action, $change = []) {

        $clog = new CLog;

        $clog->action = $action;
        $clog->change = $change;
        $clog->time = (new \DateTime())->format('Y/m/d H:i:s');

        $clog->user()->associate(\Session::get('user'));
        $clog->object()->associate($object);

        $clog->save();
    }

    public function object() {
        return $this->morphTo();
    }

    public function __toString() {

    }

    public function user() {
        return $this->belongsTo('App\User', 'user_id');
    }
}
