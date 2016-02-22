<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use SoftDeletes;

    public $timestamps = false;

    protected $casts = [
        'signed_time' => 'date',         //签约时间
        'cancelled_time' => 'date',      //解约时间
        'vip' => 'bool',
        'official' => 'bool',
    ];

    //需要注意, 项目的 product 为 SubProduct, 不为的 Product
    public function product()
    {
        return $this->belongsTo('App\SubProduct', 'product_id');
    }

    public function comments()
    {
        return $this->morphMany('App\Comment', 'object');
    }

    public function client()
    {
        return $this->belongsTo('App\Client', 'client_id');
    }

    public function servers()
    {
        return $this->belongsToMany('App\Server', 'project_servers')->withPivot('deploy_time');
    }

    public function modules()
    {
        return $this->belongsToMany('App\Module', 'project_modules')->withPivot('type');
    }

    public function items()
    {
        return $this->morphMany('App\Item', 'object');
    }

    public function params()
    {
        return $this->belongsToMany('App\Param', 'project_params')
            ->withPivot('value')
            ->withPivot('manual'); //是否手动修改了该参数
    }

    public function hardwares()
    {
        return $this->belongsToMany('App\Hardware', 'project_hardwares')
            ->withPivot('deployed_count')
            ->withPivot('plan_count')
            ->withPivot('description');
    }

    public function logs()
    {
        return $this->morphMany('App\Clog', 'object');
    }

    public function newPivot(Model $parent, array $attributes, $table, $exists)
    {
        if ($parent instanceof \App\Server) {
            return new \App\ProjectServerPivot($parent, $attributes, $table, $exists);
        }

        return parent::newPivot($this->parent, $attributes, $this->table, $exists);
    }

    public function save(array $options = [])
    {
        $to_init_nfs = false;

        //save 的时候, 检查是否包含了 ID, 如果 ID 不存在, 需初始化 nfs
        if (!$this->id) {
            $to_init_nfs = true;
        }

        $result = parent::save($options);

        if ($to_init_nfs && $result) {
            $this->init_nfs();
        }

        return $result;
    }

    public function init_nfs()
    {
        \App\NFS::nfs_init($this);
    }
}
