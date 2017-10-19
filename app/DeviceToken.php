<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeviceToken extends Model
{
    protected $table = 'device_tokens';
    public $timestamps = true;

    public function store()
    {
    	return $this->belongTo('App\Stores', 'store_id');
    }
}
