<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use SoftDeletes;

    public $timestamps = false;

    protected $dates = ['deleted_at'];

    //需要注意, 项目的 product 为 SubProduct, 不为的 Product
    public function product() {
        return $this->belongsTo('App\SubProduct', 'product_id');
    }

    public function comments() {
        return $this->morphMany('App\Comment', 'object');
    }

    public function client() {
        return $this->belongsTo('App\Client', 'client_id');
    }

    public function servers() {
        return $this->belongsToMany('App\Server', 'project_servers')->withPivot('deploy_time');
    }

    public function modules() {
        return $this->belongsToMany('App\Module', 'project_modules')->withPivot('type');
    }

    public function items() {
        return $this->morphMany('App\Item', 'object');
    }

    public function params() {
        return $this->belongsToMany('App\Param', 'project_params')
            ->withPivot('value')
            ->withPivot('manual'); //是否手动修改了该参数
    }

    public function hardwares() {
        return $this->belongsToMany('App\Hardware', 'project_hardwares')
            ->withPivot('deployed_count')
            ->withPivot('plan_count')
            ->withPivot('description');
    }
}
