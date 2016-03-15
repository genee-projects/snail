<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HardwareItem extends Model
{
    //

    use SoftDeletes;

    public $timestamps = false;

    protected $casts = [
        'extra' => 'array',
        'time' => 'date',
    ];

    const STATUS_STOCK = 0;     //库存
    const STATUS_ON_THE_WAY = 1; //在途
    const STATUS_DELIVERED = 2; //已经交付
    const STATUS_DEPLOYED = 3;   //已部署
    const STATUS_WASTED = 4;   //废弃了的

    public static $status = [
        self::STATUS_ON_THE_WAY => '在途',
        self::STATUS_DELIVERED => '硬件交付',
        self::STATUS_DEPLOYED => '部署完成',
        self::STATUS_WASTED => '回收',
    ];

    public function hardware()
    {
        return $this->belongsTo('\App\Hardware', 'hardware_id');
    }

    public function project()
    {
        return $this->belongsTo('\App\Project', 'project_id');
    }
}
