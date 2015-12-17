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
        return $this->belongsToMany('App\Server')->withPivot('usage', 'deploy_time');
    }

    public function services() {
        return $this->morphMany('App\Service', 'object');
    }

    public function modules() {
        return $this->morphMany('App\Module', 'object');
    }
}
