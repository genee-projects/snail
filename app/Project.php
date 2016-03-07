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
        'check_time' => 'date',      //实际验收时间
        'vip' => 'bool',
    ];

    # 维保单位 日
    const SERVICE_UNIT_DAY = 1;

    # 维保单位 月
    const SERVICE_UNIT_MONTH = 2;

    # 维保单位 年
    const SERVICE_UNIT_YEAR = 3;

    static $service_units = [
        self::SERVICE_UNIT_DAY => '天',
        self::SERVICE_UNIT_MONTH => '月',
        self::SERVICE_UNIT_YEAR => '年',
    ];

    static $service_unit_values = [
        self::SERVICE_UNIT_DAY => 3600,
        self::SERVICE_UNIT_MONTH => 2678400, # 3600 * 31 * 24
        self::SERVICE_UNIT_YEAR => 31536000, # 3600 * 365 * 24
    ];

    # 售前支持
    const SIGNED_STATUS_PENDING = 2;

    # 试用客户
    const SIGNED_STATUS_PROBATIONARY = 0;

    # 正式客户
    const SIGNED_STATUS_OFFICIAL = 1;

    static $signed_status = [
        self::SIGNED_STATUS_PENDING => '售前支持',
        self::SIGNED_STATUS_PROBATIONARY => '试用客户',
        self::SIGNED_STATUS_OFFICIAL => '正式客户',
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

    # 获取计划的验收时间
    # 原计划验收时间为签约时间 + 90 天
    public function getPlannedCheckTimeAttribute($value) {


        if ($this->signed_time) {
            return $this->signed_time->addMonths(3)->format('Y/m/d');
        }

        return '未签约';
    }

    # 获取维保时长
    public function getServiceAttribute() {
        return $this->service_value. self::$service_units[$this->service_unit];
    }

    # 获取维保范围
    public function getServiceDurationAttribute() {

        if ($this->check_time) {
            $start_time = $this->check_time;

            switch($this->service_unit) {
                case self::SERVICE_UNIT_MONTH :
                    $end_time = $start_time->copy()->addMonths($this->service_value);
                    break;
                case self::SERVICE_UNIT_YEAR :
                    $end_time = $start_time->copy()->addYears($this->service_value);
                    break;
                case self::SERVICE_UNIT_DAY :

                    $end_time = $start_time->copy()->addDays($this->service_value);
                    break;
            }

            return $start_time->format('Y/m/d'). ' ~ '. $end_time->format('Y/m/d');
        }

        return '未验收';
    }

    # 获取维保结束时间
    public function getServiceEndTimeAttribute() {

        if ($this->check_time) {

            switch($this->service_unit) {
                case self::SERVICE_UNIT_MONTH :
                    return $this->check_time->copy()->addMonths($this->service_value);
                    break;
                case self::SERVICE_UNIT_YEAR :
                    return $this->check_time->copy()->addYears($this->service_value);
                    break;
                case self::SERVICE_UNIT_DAY :
                    return $this->check_time->copy()->addDays($this->service_value);
                    break;
            }
        }
    }
}
