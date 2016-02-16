<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Hardware extends Model
{
    //
    use SoftDeletes;

    public $timestamps = false;

    protected $dates = ['deleted_at'];

    protected $casts = [
        'self_produce'=> 'bool',
    ];

    public function product() {
        return $this->belongsTo('App\Product', 'product_id');
    }
}
