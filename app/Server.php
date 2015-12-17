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

    public function projects() {
        return $this->belongsToMany('App\Project')
            ->withPivot('usage', 'deploy_time');
    }

    static function root() {

        $query = self::where('deleted_at', '0000-00-00 00:00:00')->withTrashed();

        if ($query->count()) {
            return $query->first();

        }

        $root = new self;
        $root->deleted_at = '0000-00-00 00:00:00';

        $root->save();

        return $root;
    }

    public function services() {
        return $this->morphMany('App\Service', 'object');
    }
}
