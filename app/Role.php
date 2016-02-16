<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    //
    use SoftDeletes;

    public $timestamps = false;

    protected $casts = [
        'perms' => 'array',
    ];

    public function users()
    {
        return $this->belongsToMany('App\User',  'user_roles', 'role_id', 'user_id');
    }
}
