<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HardwareField extends Model
{
    //
    use SoftDeletes;

    public $timestamps = false;

    public function hardware() {
        return $this->belongsTo('\App\Hardware', 'hardware_id');
    }
}
