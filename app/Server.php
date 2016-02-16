<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Server extends Model
{
    use SoftDeletes;

    public $timestamps = false;

    protected $dates = ['deleted_at'];

    const PROVIDER_CUSTOMER = 1;    //客户提供
    const PROVIDER_COMPANY = 2;     //公司提供
    const PROVIDER_AGENT = 3;       //代理商提供

    public static $providers = [
        self::PROVIDER_CUSTOMER => '客户提供',
        self::PROVIDER_COMPANY => '公司提供',
        self::PROVIDER_AGENT => '代理商提供',
    ];

    public function comments()
    {
        return $this->morphMany('App\Comment', 'object');
    }

    public function projects()
    {
        return $this->belongsToMany('App\Project', 'project_servers')
            ->withPivot('deploy_time');
    }

    public function items()
    {
        return $this->morphMany('App\Item', 'object');
    }

    public function newPivot(Model $parent, array $attributes, $table, $exists)
    {
        if ($parent instanceof \App\Project) {
            return new \App\ProjectServerPivot($parent, $attributes, $table, $exists);
        }

        return parent::newPivot($this->parent, $attributes, $this->table, $exists);
    }
}
