<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ProjectServerPivot extends Pivot
{
    protected $casts = [
        'deploy_time' => 'date',
    ];
}
