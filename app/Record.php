<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Record extends Model
{
    //
    use SoftDeletes;

    public $timestamps = false;

    protected $casts = [
        'time' => 'date',        //配置信息
    ];

    public function project()
    {
        return $this->belongsTo('\App\Project', 'project_id');
    }

    public function user()
    {
        return $this->belongsTo('\App\User', 'user_id');
    }
}
