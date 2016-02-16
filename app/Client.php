<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use SoftDeletes;

    public $timestamps = false;

    protected $dates = ['deleted_at'];

    public function comments()
    {
        return $this->morphMany('App\Comment', 'object');
    }

    public function children()
    {
        return $this->hasMany('App\Client', 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo('App\Client', 'parent_id');
    }

    public function root()
    {
        $root = $this;

        while (true) {
            if (!$root->parent) {
                break;
            }
            $root = $root->parent;
        }

        return $root;
    }

    public function projects()
    {
        return $this->hasMany('App\Project', 'client_id');
    }

    public function items()
    {
        return $this->morphMany('App\Item', 'object');
    }

    public function path()
    {

        //用于返回的所有的 clients
        $clients = [];

        //当前 client
        $client = $this;

        while (true) {
            $clients[] = (string) view('clients/path', ['client' => $client]);

            if (!$client->parent) {
                break;
            }
            $client = $client->parent;
        }

        return (string) implode(' &#187; ', array_reverse($clients));
    }

    public function logs()
    {
        return $this->morphMany('App\Clog', 'object');
    }
}
