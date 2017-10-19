<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stores extends Model
{
    protected $table = "stores";
    public $timestamps = true;
    private static $salt = 'dafhsduhicvcxobycovibyodhgsioy39782';

    public static function getSalt()
    {
        return Stores::$salt;
    }

    public function deviceToken()
    {
        return $this->hasMeny('App\DeviceToken', 'store_id');
    }

    public function notificationKey()
    {
        return $this->hasOne('App\NotificationKey', 'store_id');
    }

    public function items() {
        return $this->hasMany('App\Items', 'store_id');
    }

    public function itemsPrices()
    {
        return $this->hasManyThrough('App\ItemPrice', 'App\Items');
    }

    public function histories(){
        return $this->hasMany('App\History', 'store_id');
    }
}
