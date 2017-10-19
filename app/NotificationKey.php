<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NotificationKey extends Model
{
    protected $table = 'notification_keys';
    public $timestamps = true;

    public function store()
    {
    	return $this->belongTo('App\Stores', 'store_id');
    }
}
