<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use SoftDeletes;

    public $timestamps = false;

    protected $dates = ['deleted_at'];

    public function product() {
        return $this->belongsTo('App\Product', 'product_id');
    }

    public function comments() {
        return $this->morphMany('App\Comment', 'object');
    }

    public function client() {
        return $this->belongsTo('App\Client', 'client_id');
    }

    public function servers() {
        return $this->belongsToMany('App\Server', 'project_servers')->withPivot('usage', 'deploy_time');
    }

    /*
    public function services() {
        return $this->morphMany('App\Service', 'object');
    }
    services 目前不开放
    */


    public function modules() {
        return $this->belongsToMany('App\Module', 'project_modules')->withPivot('type');
    }

    public function items() {
        return $this->morphMany('App\Item', 'object');
    }

    public function params() {
        return $this->belongsToMany('App\Param')->withPivot('value');
    }
}
