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
        'self_produce' => 'bool',
    ];

    public function product()
    {
        return $this->belongsTo('App\Product', 'product_id');
    }

    public function items()
    {
        return $this->morphMany('App\Item', 'object');
    }

    public function fields()
    {
        return $this->hasMany('\App\HardwareField', 'hardware_id');
    }

    public function hardware_items()
    {
        return $this->hasMany('App\HardwareItem', 'hardware_id');
    }
}
