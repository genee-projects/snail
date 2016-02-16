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
        'change' => 'array',
        'time' => 'date',
    ];

    //此处没有使用 RFC 5424
    //是出于 CRM 中自有的消息变动统计没有那么多

    const LEVEL_INFO = 1;   //基本信息的变动等级
    const LEVEL_NOTICE = 2;     //需要被关注点信息变动等级, 必须
    const LEVEL_WARNING = 3;    //参数\模块等重要信息变动 !

    public static $level_class = [
        self::LEVEL_INFO => 'info',
        self::LEVEL_NOTICE => 'warning',
        self::LEVEL_WARNING => 'danger',
    ];

    public static function add($object, $action, $change = [], $level = self::LEVEL_INFO)
    {
        $clog = new self();

        $clog->action = $action;
        $clog->change = $change;
        $clog->time = \Carbon\Carbon::now();

        $clog->user()->associate(\Session::get('user'));
        $clog->object()->associate($object);

        $clog->level = $level;

        $clog->save();
    }

    public function object()
    {
        return $this->morphTo();
    }

    public function __toString()
    {
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}
