<?php

namespace app;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{

    use SoftDeletes;

    static public $progress = [
        1 => '初步沟通',
        2 => '见面拜访',
        3 => '确定意向',
        4 => '正式报价',
        5 => '商务洽谈',
        6 => '签约成交',
        7 => '售后服务',
        8 => '停滞客户',
        9 => '流失客户',
    ];

    static function progress_label($p) {
        return self::$progress[$p];
    }

    public $timestamps = false;

    protected $dates = ['deleted_at'];

    public function comments() {
        return $this->morphMany('App\Comment', 'object');
    }

    public function children() {
        return $this->hasMany('App\Client', 'parent_id');
    }

    public function parent() {
        return $this->belongsTo('App\Client', 'parent_id');
    }

    public function root() {
        $root = $this;

        while(true) {
            if (! $root->parent) break;
            $root = $root->parent;
        }

        return $root;
    }

    public function projects() {
        return $this->hasMany('App\Project', 'client_id');
    }
}
