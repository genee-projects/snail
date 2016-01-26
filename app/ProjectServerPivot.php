<?php

namespace App;
use Illuminate\Database\Eloquent\Relations\Pivot;


class ProjectServerPivot extends Pivot {

    protected $dates = [
        'deploy_time',
    ];
}